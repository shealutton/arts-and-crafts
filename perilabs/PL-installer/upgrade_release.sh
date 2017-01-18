#!/bin/bash
# Shea Lutton
# Peri Labs, 2012

### USAGE
# ./upgrade.release.sh perilabs-x.y.z 
# As always it is a very good idea to run the .backup.script.bsh before running the upgrade

echo "Please run backups before running the upgrade script."

command -v grep >/dev/null 2>&1 || { echo >&2 "grep is required but it's not installed.  Aborting."; exit 1; }
command -v chmod >/dev/null 2>&1 || { echo >&2 "chmod is required but it's not installed.  Aborting."; exit 1; }
command -v chown >/dev/null 2>&1 || { echo >&2 "chown is required but it's not installed.  Aborting."; exit 1; }

NEW=$1
NEWVERSION=`echo $NEW |sed -e s/.tar.bz2//` # Remove .tar.bz2 if present
OLDVERSION=`stat /var/www/current |grep File |awk '{print $4}' |sed -e 's/\// /g' |awk '{print $4}' |cut -d "'" -f1`
echo "Replacing ${OLDVERSION} with ${NEWVERSION}"

if [ -z "$NEWVERSION" ]
then
        echo "USAGE: ${0} perilabs-x.y.z (where perilabs.x.y.z is the new version to be installed)"
        exit 1
fi

test "$(whoami)" != 'root' && (echo "You are using a non-privileged account, please run as root."; exit 1)

### Locate the DB password from the current config file
if [ -e /var/www/${OLDVERSION}/protected/config/main.php ]; then
	PASS=`grep "'password'" /var/www/${OLDVERSION}/protected/config/main.php`
else
	echo "Failed to find the current config file and DB password."
	exit 1
fi

### Upgrade process
cd ./perilabs || (echo "Failed to find the perilabs directory"; exit 1)
tar -xjf ${NEWVERSION}.tar.bz2
chown root:root ${NEWVERSION}
mv ${NEWVERSION} /var/www/
cd /var/www/${NEWVERSION} || (echo "Can't cd to /var/www/${NEWVERSION}"; exit 1)
find . -name .svn -exec rm -rf {} \;
rm -f /var/www/${NEWVERSION}/.gitignore
chown -R apache:apache /var/www/${NEWVERSION}/*
chmod -R ugo-w /var/www/${NEWVERSION}/*
chmod -R u+w /var/www/${NEWVERSION}/runtime
chmod -R u+w /var/www/${NEWVERSION}/perilabs/assets
chmod -R o-rx /var/www/${NEWVERSION}/perilabs /var/www/${NEWVERSION}/protected /var/www/${NEWVERSION}/runtime

FILE="/var/www/${NEWVERSION}/perilabs/index.php"
if grep "define('YII_DEBUG',true)" $FILE >/dev/null; then 
	sed -i "s/define('YII_DEBUG',true)/define('YII_DEBUG',false)/" $FILE
fi
if grep "define('YII_TRACE_LEVEL',5)" $FILE >/dev/null; then 
	sed -i "s/define('YII_TRACE_LEVEL',5)/define('YII_TRACE_LEVEL',0)/" $FILE
fi
FILE=/var/www/${NEWVERSION}/protected/config/main.php
if grep "define('YII_DEBUG',true)" $FILE >/dev/null; then 
        sed -i "s/define('YII_DEBUG',true)/define('YII_DEBUG',false)/" $FILE
fi
#sed -i "s/define('HOSTED',false)/define('HOSTED',true)/" $FILE
sed -i "/'password' => 'devel89PONDER',/ c\
${PASS}" /var/www/${NEWVERSION}/protected/config/main.php || (echo "Failed to set app password"; exit 1)

rm -rf /var/www/${NEWVERSION}/perilabs/assets/*

ln -s -nf /var/www/${NEWVERSION} /var/www/current
/etc/init.d/httpd reload

