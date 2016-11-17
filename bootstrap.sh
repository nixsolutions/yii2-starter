#!/bin/bash

DB_USER='root'
DB_PORT='3306'
DB_PASSWORD='root'
DB_NAME='yii_starter'

GIT_TOKEN='your_token'


echo "Updating packages..."
echo vagrant | sudo -S apt-get update

echo "Installing mc..."
apt-get install -y mc 2> /dev/null

echo "Installing git..."
echo vagrant | sudo apt-get install git -y > /dev/null 2>&1

echo "Installing sendmail..."
echo vagrant | sudo apt-get install sendmail -y > /dev/null 2>&1

echo "Installing nginx..."
echo vagrant | sudo apt-get install -y nginx > /dev/null 2>&1

echo "Setting nginx..."
echo vagrant | sudo rm -rf /usr/share/nginx/html
echo vagrant | sudo ln -s /vagrant/web /usr/share/nginx/html
echo vagrant | sudo -S cp /vagrant/nginx.config /etc/nginx/sites-available/default
echo vagrant | sudo -S service nginx restart

echo "Installing mysql 5.7..."
debconf-set-selections <<< "mysql-server mysql-server/root_password password $DB_PASSWORD"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $DB_PASSWORD"
echo vagrant | sudo apt-get install software-properties-common
echo vagrant | sudo add-apt-repository -y ppa:ondrej/mysql-5.7 2> /dev/null
echo vagrant | sudo apt-get update
echo vagrant | sudo apt-get install -y mysql-server 2> /dev/null
echo vagrant | sudo -S sed -i "s/^bind-address.*127.0.0.1/bind-address=0.0.0.0/" /etc/mysql/my.cnf

echo "Creating DB..."
mysql -uroot -p$DB_PASSWORD -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8 COLLATE utf8_general_ci;" >> /vagrant/vm_build.log 2>&1

echo "Installing php 7.0..."
echo vagrant | sudo -S add-apt-repository ppa:ondrej/php
echo vagrant | sudo -S apt-get update
echo vagrant | sudo -S apt-get install php7.0 php7.0-cgi php7.0-fpm php7.0-mysql php7.0-gd php7.0-mbstring -y > /dev/null 2>&1

echo "Installing composer..."
curl -sS https://getcomposer.org/installer | php > /dev/null 2>&1
echo vagrant | sudo mv composer.phar /usr/local/bin/composer > /dev/null 2>&1

echo "Installing app..."
composer config github-oauth.github.com $GIT_TOKEN
composer global require "fxp/composer-asset-plugin:^1.2.1" > /dev/null 2>&1

cd /vagrant
composer install > /dev/null 2>&1

echo "Migrating..."
echo y | php yii migrate --migrationPath=@yii/rbac/migrations/
echo y | php yii migrate/up
echo y | php yii rbac/init

sudo mv config/db.php.sample config/db.php