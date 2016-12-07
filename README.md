# NIX Solutions presents Demo Yii2 application

## Installation

Demo Yii2 application works with PHP 5.6 or later and MySQL 5.4 or later vagrant 1.8.5

### From repository

Get Bluz skeleton source files from GitHub repository:
```
git clone git@bitbucket.org:nixsolutions/npr-310.git %path%
```

Download `composer.phar` to the project folder:
```
cd %path%
curl -s https://getcomposer.org/installer | php
```

Install composer dependencies with the following command:
```
php composer.phar install
```
Run virtual machine 
```
vagrant up
```

Visit 192.168.10.11 you see working project
## License

The project is developed by [NIX Solutions](http://nixsolutions.com) PHP team and distributed under [MIT LICENSE](https://raw.github.com/bluzphp/skeleton/master/LICENSE.md)
