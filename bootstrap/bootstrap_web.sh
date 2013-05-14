#!/usr/bin/env bash

apt-get update
apt-get install -y apache2 php5 libapache2-mod-php5 php5-mysql

# Allow modules for Apache.
a2enmod actions rewrite fastcgi suexec

# Replace the default Apache site.
a2dissite default default-ssl 000-default

# Create apache vhost
VHOST="NameVirtualHost *:80\n\n

<VirtualHost *:80>\n
    DocumentRoot \"/vagrant/htdocs\"\n
    ServerName vagrant_web.dev\n
    ServerAlias www.vagrant_web.dev\n
    #ErrorLog \"logs/vagrant_web/error_log\"\n
    #CustomLog \"logs/vagrant_web/access_log\" common\n
</VirtualHost>\n\n"
echo -e $VHOST > /etc/apache2/sites-enabled/vagrant_web

# Replace the default Apache site.
a2ensite vagrant_web

apt-get install -y memcached
memcached -d -m 512 -l 127.0.0.1 -p 11211 -u nobody
apt-get install -y php5-memcached

service apache2 restart