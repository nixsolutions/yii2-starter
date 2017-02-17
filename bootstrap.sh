#!/bin/bash

DB_USER='root'
DB_PORT='3306'
DB_PASSWORD='root'
DB_NAME='yii_starter'
DB_NAME_TEST='yii_starter_tests'
DISPLAY_ERRORS="on"

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
debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password $DB_PASSWORD"
debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password $DB_PASSWORD"
echo vagrant | sudo apt-key adv --keyserver ha.pool.sks-keyservers.net --recv-keys 5072E1F5
echo vagrant | echo "deb http://repo.mysql.com/apt/ubuntu/ trusty mysql-5.7" | sudo tee /etc/apt/sources.list.d/mysql-5.7.list
echo vagrant | sudo apt-get update
echo vagrant | sudo DEBIAN_FRONTEND=noninteractive apt-get install -qy mysql-server
echo vagrant | sudo -S sed -i "s/^bind-address.*127.0.0.1/bind-address=0.0.0.0/" /etc/mysql/my.cnf

echo "Creating DB..."
mysql -uroot -p$DB_PASSWORD -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8 COLLATE utf8_general_ci;" >> /vagrant/vm_build.log 2>&1

echo "Creating DB for test environment"
mysql -uroot -p$DB_PASSWORD -e "CREATE DATABASE IF NOT EXISTS $DB_NAME_TEST CHARACTER SET utf8 COLLATE utf8_general_ci;" >> /vagrant/vm_build.log 2>&1

echo "Installing php 7.0..."
echo vagrant | sudo -S add-apt-repository ppa:ondrej/php
echo vagrant | sudo -S apt-get update
echo vagrant | sudo -S apt-get install php7.0 php7.0-cgi php7.0-fpm  php7.0-curl php7.0-dom php7.0-mysql php7.0-gd php7.0-mbstring -y > /dev/null 2>&1

echo "Installing composer..."
curl -sS https://getcomposer.org/installer | php > /dev/null 2>&1
echo vagrant | sudo mv composer.phar /usr/local/bin/composer > /dev/null 2>&1

echo "Installing app..."
if [ -f /vagrant/set-github-oauth-token.sh ]; then
    /vagrant/set-github-oauth-token.sh
fi
composer global require "fxp/composer-asset-plugin:^1.2.1" > /dev/null 2>&1

cd /vagrant
composer install > /dev/null 2>&1

if [ ! -f /vagrant/config/db.php ]; then
    sudo cp config/db.php.sample config/db.php
fi
if [ ! -f /vagrant/config/params.php ]; then
    sudo cp config/params.php.sample config/params.php
fi
if [ ! -f /vagrant/config/mailer.php ]; then
    sudo cp config/mailer.php.sample config/mailer.php
fi
if [ ! -f /vagrant/config/clients.php ]; then
    sudo cp config/clients.php.sample config/clients.php
fi

echo "Migrating..."
echo y | php yii migrate --migrationPath=@yii/rbac/migrations/
echo y | php yii rbac/init
echo y | php yii migrate/up

sudo sed -i "s/display_errors = .*/display_errors = ${DISPLAY_ERRORS}/" /etc/php/7.0/fpm/php.ini
