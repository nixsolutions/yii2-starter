# NIX Solutions presents Demo Yii2 application

[![Build Status](https://secure.travis-ci.org/nixsolutions/yii2-starter.png?branch=master)](https://travis-ci.org/nixsolutions/yii2-starter)

[![Coverage Status](https://coveralls.io/repos/github/nixsolutions/yii2-starter/badge.svg?branch=develop)](https://coveralls.io/nixsolutions/LizaZmievskaya/yii2-starter?branch=develop)
[![Dependency Status](https://www.versioneye.com/user/projects/53a1549983add72cb9000014/badge.svg)](https://www.versioneye.com/user/projects/53a1549983add72cb9000014)

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
