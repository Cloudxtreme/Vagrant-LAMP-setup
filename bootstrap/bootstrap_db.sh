#!/usr/bin/env bash
echo mysql-server mysql-server/root_password select "vagrant" | debconf-set-selections
echo mysql-server mysql-server/root_password_again select "vagrant" | debconf-set-selections

apt-get update
apt-get install -y mysql-server

# Allow unsecured remote access to MySQL.
mysql -u root -p"vagrant" -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '' WITH GRANT OPTION; FLUSH PRIVILEGES;"
sed -e 's#127.0.0.1#0.0.0.0#g' -i '/etc/mysql/my.cnf'
mysql -u root -p"vagrant" -e "CREATE USER 'vagrant_web'@'localhost' IDENTIFIED BY 'connect'; GRANT ALL PRIVILEGES ON *.* TO 'vagrant_web'@'localhost' WITH GRANT OPTION; CREATE USER 'vagrant_web'@'%' IDENTIFIED BY 'connect'; GRANT ALL PRIVILEGES ON *.* TO 'vagrant_web'@'%' WITH GRANT OPTION;"

# create testdatabase and import testdata
mysql -u root -p"vagrant" -e "CREATE DATABASE vagrant_db;"
mysql -u root -p"vagrant" vagrant_db < /vagrant/db/vagrant_db.sql 

# Restart MySQL service for changes to take effect.
service mysql restart

apt-get clean