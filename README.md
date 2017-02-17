# NIX Solutions presents Demo Yii2 application

[![Build Status](https://travis-ci.org/nixsolutions/yii2-starter.svg?branch=master)](https://travis-ci.org/nixsolutions/yii2-starter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nixsolutions/yii2-starter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nixsolutions/yii2-starter/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/nixsolutions/yii2-starter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/nixsolutions/yii2-starter/?branch=master)

[![GitHub license](https://img.shields.io/github/license/nixsolutions/yii2-starter.svg)](https://github.com/nixsolutions/yii2-starter/license)
[![Github All Releases](https://img.shields.io/github/downloads/nixsolutions/yii2-starter/total.svg)](https://github.com/nixsolutions/yii2-starter/downloads)
[![GitHub release](https://img.shields.io/github/release/nixsolutions/yii2-starter.svg)](https://github.com/nixsolutions/yii2-starter/release)

## Requirements for development

- [Vagrant](https://www.vagrantup.com/) (1.8.5)
- [VirtualBox](https://www.virtualbox.org/wiki/Downloads)

##Application works with PHP 5.4 or later and MySQL 5.6 or later

## Installation

Get Demo Yii2 application source files from Git repository:
```
git clone git@github.com:nixsolutions/yii2-starter.git %path%
```

Copy file set-github-oauth-token.sh.sample without .example extension into root project directory and put your github token inside

Run virtual machine
```
vagrant up
```
After some provisioning you will have access the application through it's IP address - [192.168.10.11:80](http://192.168.10.11)

Put email credential in file config/mailer.php
## License

The project is developed by [NIX Solutions](http://nixsolutions.com) PHP team and distributed under MIT LICENSE
