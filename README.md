# Creative Writer Companion

A creative write helper developed nin Symfony

## Installation

## Clone the repository

```bash
    git clone git@github.com:devaneando/characterManager.git
```

## Create the database

```sql
CREATE DATABASE cwc CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE DATABASE cwc_test CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE USER 'luke_skywalker'@'%' IDENTIFIED BY 'starwars';
CREATE USER 'anakin_skywalker'@'%' IDENTIFIED BY 'starwars';

GRANT ALL PRIVILEGES ON cwc.* TO 'luke_skywalker'@'%';
GRANT ALL PRIVILEGES ON cwc_test.* TO 'anakin_skywalker'@'%';

FLUSH PRIVILEGES;
```

## Download the vendors

```bash
composer install --ignore-platform-reqs
bower install
```

## Vulnerabilities check

Install Symfony security checker

```bash
php -r "copy('https://get.sensiolabs.org/security-checker.phar', 'bin/security-checker');"
chmod 700 bin/security-checker
```

Check for vulnerabilities

```bash
bin/security-checker security:check ./composer.lock
```

## Important

CMM suffers from the [Symfony Issue #29347](https://github.com/symfony/symfony/issues/29347), and won't execute properly if you have the PHP OPCache extension enabled.

Since, at least in Ubuntu and Linux Mint, the `php7.2-opcache` package is required by the `libapache2-mod-php7.2` package, the simplest workaround is to edit the `/etc/php/7.2/mods-available/opcache.ini` file and add the line below:

```bash
opcache.enable=0
```
