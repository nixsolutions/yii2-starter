#!/usr/bin/env bash
service mysql start
mysql -h localhost --user=root --password=root -e "CREATE DATABASE IF NOT EXISTS yii_starter_tests CHARACTER SET utf8 COLLATE utf8_general_ci;"
mysql -h localhost --user=root --password=root yii_starter_tests < tests/_data/dump.sql
composer global require "fxp/composer-asset-plugin:^1.2.1"
composer install
cp config/params.php.sample config/params.php
cp config/db.php.sample config/db.php
cp config/mailer.php.sample config/mailer.php
cp config/clients.php.sample config/clients.php