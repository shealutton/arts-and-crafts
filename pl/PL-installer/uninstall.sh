#!/bin/bash

/etc/init.d/postgresql-9.0 stop
/etc/init.d/httpd stop

yum -y -q remove epel-release pgdg-centos90 postgresql90 postgresql90-devel postgresql90-libs postgresql90-plperl postgresql90-server php php-cli php-devel mod_xsendfile 

rm -rf /var/lib/pgsql/9.0
rm -rf /etc/httpd/conf.d/perilabs.conf
rm -rf /opt/yii
rm -rf /var/www/perilabs*
rm -f /var/www/current

echo "Services stopped and components removed."
