#! /bin/bash
# Copyright Peri Labs, Inc. 2012

# NOTICE
# To send emails to people outside your organization, you will need to configure 
# postfix or sendmail to relay messages through your email system. 

# VARIABLES
VERSION=perilabs-2.0.7

# TOOLS
command -v iptables >/dev/null 2>&1 || { echo >&2 "Iptables is required but it's not installed.  Aborting."; exit 1; }
command -v sed >/dev/null 2>&1 || { echo >&2 "Sed is required but it's not installed.  Aborting."; exit 1; }
command -v hostname >/dev/null 2>&1 || { echo >&2 "Hostname is required but it's not installed.  Aborting."; exit 1; }
command -v grep >/dev/null 2>&1 || { echo >&2 "Grep is required but it's not installed.  Aborting."; exit 1; }
command -v mv >/dev/null 2>&1 || { echo >&2 "Mv is required but it's not installed.  Aborting."; exit 1; }
command -v cp >/dev/null 2>&1 || { echo >&2 "Cp is required but it's not installed.  Aborting."; exit 1; }
command -v tar >/dev/null 2>&1 || { echo >&2 "Tar is required but it's not installed.  Aborting."; exit 1; }
command -v bzip2 >/dev/null 2>&1 || { echo >&2 "Bzip2 is required but it's not installed.  Aborting."; exit 1; }

# PREP OS
echo "Preparing installation"
yum -y -q install ./packages/epel-release-6-7.noarch.rpm ./packages/pgdg-centos90-9.0-5.noarch.rpm 1>>/tmp/peri_install_log 2>>/tmp/peri_install_log || (echo "Failed to install epel/pgdg packages"; exit 1)
sleep 10

# SET DB PASSWORD IN CONFIG FILE AND IN DB
MATCH=0 && PASS1=0
until [ ${MATCH} == 1 ] && [ ${#PASS1} -gt 9 ] ; do
	echo "Create a password for the database user (at least 10 characters) for the config file:"
	read -sp " " PASS1
	echo ""
	echo "Verify the password:"
	read -sp " " PASS2
	if [ ${PASS1} == ${PASS2} ] ; then MATCH=1; else echo "Passwords did not match or were too short. Please retry: "; fi
done
PASS=\'${PASS1}\'

# FUNCTIONS
function load_postgres {
  # Grant temp trusted access for install
  command -v psql >/dev/null 2>&1 || { echo >&2 "The psql is required but it can't be found.  Aborting."; exit 1; }
  sed -i.bak '1i local all postgres trust # PeriLabs_Installer_TEMP' /var/lib/pgsql/9.0/data/pg_hba.conf 
  /etc/init.d/postgresql-9.0 reload
  # Load the Peri Labs DB
  psql -q -U postgres -f ./postgres/peri_users.sql >/tmp/peri_users_msg.txt || (echo "Failed to load database users"; exit 1)
  psql -q -U postgres -d peri -f ./postgres/peri_database.sql >/tmp/peri_db_msg.txt || (echo "Failed to load database schema"; exit 1)
  psql -q -U postgres -c "ALTER ROLE peri WITH PASSWORD ${PASS};" || (echo "Failed to set database password"; exit 1)
  # Remove trusted access
  grep -v "# PeriLabs_Installer_TEMP" /var/lib/pgsql/9.0/data/pg_hba.conf >/var/lib/pgsql/9.0/data/pg_hba.conf.PL_temp
  mv /var/lib/pgsql/9.0/data/pg_hba.conf /var/lib/pgsql/9.0/data/pg_hba.conf.backup && mv /var/lib/pgsql/9.0/data/pg_hba.conf.PL_temp /var/lib/pgsql/9.0/data/pg_hba.conf
  chown postgres:postgres /var/lib/pgsql/9.0/data/pg_hba.conf
  sed -i '/^local/a \
host    peri    peri    127.0.0.1/32    md5 # Authenticated local access for peri user' /var/lib/pgsql/9.0/data/pg_hba.conf
  /etc/init.d/postgresql-9.0 reload
}

function load_httpd {
  HOST=`hostname`
  sed -i "s/ServerName localhost.localdomain/ServerName ${HOST}/g" perilabs/perilabs.conf
  cp perilabs/perilabs.conf /etc/httpd/conf.d/ || (echo "Failed to copy httpd conf file" ; exit 1)
  /etc/init.d/httpd start || (echo "Failed to start httpd" ; exit 1)
}


# Requirements
test "$(whoami)" != 'root' && (echo "You are using a non-privileged account, please run as root."; exit 1)
if grep -q "SELINUX=enforcing" /etc/selinux/config ; then
	echo "Selinux is set to enforcing. Disable selinux in /etc/selinux/config" 
	echo "by setting SELINUX=disabled and rebooting the server."
	exit 1
fi
if ! grep -q "6." /etc/centos-release ; then
	echo "Centos 6.0 or greater is required."
	exit 1
fi

# OS package installs
echo "Installing packages"
sleep 5
yum -y -q install `cat ./packages/package_list` 1>>/tmp/peri_install_log 2>>/tmp/peri_install_log || (echo "Failed to install required packages"; exit 1)

# POSTGRES
echo "Installing database"
# Sanity check for the postgres init script and that the port is not in use:"
if [ ! -e /etc/init.d/postgresql-9.0 ]; then (echo "Postgres init script not in expected path"; exit 1); fi
if [ `ss -an |awk '{print $4}'| grep ":5432$"` ]; then echo "WARNING: The Postgres network port (5432) is already in use."; fi
# If postgres is installed:
if [ `rpm -qa | grep postgresql90-server` ]; then
	# If postgres is stopped
	PGSTATUS=`/etc/init.d/postgresql-9.0 status` 
	if [ "$PGSTATUS" == " is stopped" ] ; then
		/etc/init.d/postgresql-9.0 initdb 1>>/tmp/peri_install_log 2>>/tmp/peri_install_log # Could already have data
                /etc/init.d/postgresql-9.0 start || (echo "Failed to start Postgres due to a problem with an existing installation" ; exit 1)
		if [ ! -d /var/lib/pgsql/9.0/data ]; then (echo "Postgres directory not in expected path"; exit 2); fi
		if [ ! -e /var/lib/pgsql/9.0/data/pg_hba.conf ]; then (echo "Postgres pg_hba.conf not in expected path"; exit 1); fi
		load_postgres || (echo "Failed to load postgres data"; exit 1)
	else 
		# If running, load data
		if [ ! -d /var/lib/pgsql/9.0/data ]; then (echo "Postgres directory not in expected path"; exit 2); fi
                if [ ! -e /var/lib/pgsql/9.0/data/pg_hba.conf ]; then (echo "Postgres pg_hba.conf not in expected path"; exit 1); fi
		load_postgres || (echo "Failed to load postgres data"; exit 1)
	fi
else 
	echo "Postgresql-9.0 is not installed. Please check error logs."
	exit 1
fi

# APPLICATION
echo "Installing application"
mkdir -p /var/www/data /opt/yii/ /var/www/data/uploads/experiments /var/www/data/uploads/trials || (echo "Failed to create dirs"; exit 1)
tar -xjf ./perilabs/${VERSION}.tar.bz2 -C /var/www/ || (echo "Failed to untar application"; exit 1)
tar -xjf ./packages/framework.tar.bz2 -C /opt/yii/ || (echo "Failed to untar framework"; exit 1)
ln -s /var/www/${VERSION} /var/www/current || (echo "Failed to link current application"; exit 1)
chown -R apache:apache /var/www/${VERSION} /var/www/data /opt/yii || (echo "Failed to set permissions"; exit 1)
chmod 500 /var/www/${VERSION} /var/www/data /opt/yii/ /var/www/${VERSION}/protected || (echo "Failed to set permissions"; exit 1)
chmod 700 /var/www/data/uploads/experiments /var/www/data/uploads/trials /var/www/${VERSION}/runtime /var/www/${VERSION}/perilabs/assets || (echo "Failed to set permissions"; exit 1)
sed -i "s/devel89PONDER/${PASS1}/" /var/www/${VERSION}/protected/config/main.php || (echo "Failed to set app password"; exit 1) # PASS1 is the unquoted version
>/var/www/${VERSION}/runtime/application.log
rm -rf /var/www/current/sql

# SET PHP TIMEZONE
source /etc/sysconfig/clock || (echo "Failed to source timezone"; exit 1)
if [ -z "${ZONE+xxx}" ]; then # VAR is not set at all
	ZONE="America/Chicago" # set a reasonable default
fi
if [ -z "$ZONE" ] && [ "${ZONE+xxx}" = "xxx" ]; then # VAR is set but empty
	ZONE="America/Chicago" # set a reasonable default
fi
FIXEDZONE=`echo $ZONE | sed -e 's/ /_/g'`

if grep -q "^date.timezone" /etc/php.ini ; then # if date.timezone is uncommented:
        PHPTIME=`grep "^date.timezone" /etc/php.ini`
        if [ "${PHPTIME}" == "date.timezone =" ] ; then # if uncommented but a blank string:
                sed -i "/date.timezone =/ c\
date.timezone = \'${FIXEDZONE}\'" /etc/php.ini || (echo "Failed to set php timezone" ; exit 1)
        fi
else
        # If commented out, set date.timezone to local timezone
        sed -i "/;date.timezone =/ c\
date.timezone = \'${FIXEDZONE}\'" /etc/php.ini || (echo "Failed to set php timezone" ; exit 1)
fi
# SET PHP variables post_max_size, upload_max_filesize = 128M, max_execution_time, memory_limit, max_input_time
# PHP post_max_size = 20M
if grep -q "post_max_size" /etc/php.ini ; then # Set or commented out
        sed -i "/post_max_size =/ c\
upload_max_filesize = 20M" /etc/php.ini || (echo "Failed to set php post_max_size" ; exit 1)
else # Not set
	echo "post_max_size = 20M" >> /etc/php.ini
fi
# PHP upload_max_filesize = 20M
if grep -q "upload_max_filesize" /etc/php.ini ; then # Set or commented out
        sed -i "/upload_max_filesize =/ c\
upload_max_filesize = 20M" /etc/php.ini || (echo "Failed to set php upload_max_filesize" ; exit 1)
else # Not set
        echo "upload_max_filesize = 20M" >> /etc/php.ini
fi
# PHP max_execution_time = 600
if grep -q "max_execution_time" /etc/php.ini ; then # Set or commented out
        sed -i "/max_execution_time =/ c\
max_execution_time = 600" /etc/php.ini || (echo "Failed to set php max_execution_time" ; exit 1)
else # Not set
        echo "max_execution_time = 600" >> /etc/php.ini
fi
# PHP max_input_time = 600
if grep -q "max_input_time" /etc/php.ini ; then # Set or commented out
        sed -i "/max_input_time =/ c\
max_input_time = 600" /etc/php.ini || (echo "Failed to set php max_input_time" ; exit 1)
else # Not set
        echo "max_input_time = 600" >> /etc/php.ini
fi
# PHP memory_limit
if grep -q "memory_limit" /etc/php.ini ; then # Set or commented out
        sed -i "/memory_limit =/ c\
memory_limit = 512M" /etc/php.ini || (echo "Failed to set php memory_limit" ; exit 1)
else # Not set
        echo "memory_limit = 256M" >> /etc/php.ini
fi



# HTTPD
echo "Installing web configuration"
if [ `rpm -qa |grep httpd-2` ]; then
	HSTATUS=`/etc/init.d/httpd status`
	if [ "$HSTATUS" == "httpd is stopped" ] ; then
		load_httpd || (echo "Failed to load httpd" ; exit 1)
	else
		cp packages/perilabs.conf /etc/httpd/conf.d/ || (echo "Failed to copy httpd conf file" ; exit 1)
		/etc/init.d/httpd reload || (echo "Failed to reload httpd" ; exit 1)
	fi
else
	load_httpd || (echo "Failed to load httpd" ; exit 1)
fi
# Add firewall rules to the running config
iptables -D INPUT -j REJECT --reject-with icmp-host-prohibited 1>>/tmp/peri_install_log 2>>/tmp/peri_install_log # Remove the block all default rule
iptables -A INPUT -p tcp --dport 80 -j ACCEPT 1>>/tmp/peri_install_log 2>>/tmp/peri_install_log # Add the port 80 allow
iptables -A INPUT -p tcp --dport 443 -j ACCEPT 1>>/tmp/peri_install_log 2>>/tmp/peri_install_log # Add the port 80 allow
ip6tables -A INPUT -p tcp --dport 80 -j ACCEPT
ip6tables -A INPUT -p tcp --dport 443 -j ACCEPT
/etc/init.d/iptables save 1>>/tmp/peri_install_log 2>>/tmp/peri_install_log

# Restart after reboot	
chkconfig httpd on || (echo "Failed to chkconfig httpd" ; exit 1)
chkconfig postgresql-9.0 on || (echo "Failed to chkconfig postgresql-9.0" ; exit 1)

echo "Installation is finished"
echo "Log in to the application here: http://${HOST}"
echo "username = admin"
echo "password = celebrity743hounds"
echo "Remember to change your password after first log in."


