# What is readlater?

readlater is a simple self-hosted tool for saving web pages to read later with tagging, powered by ElasticSearch and Symfony 2.7.

Don't expect too much, it was primarily built to suit my personal needs. If you don't like it, consider a pull request.

**Online-Demo**:

http://dev.readlater.de

Username: test

Password: 123

# Requirements

You'll need a LAMP-/LEMP-Stack.

readlater is only supported on PHP 5.3.9 and up, but its recommended using the latest PHP 5.6 with opcache and apcu enabled.

ElasticSearch 1.5.0 and up (1.6.0 is currently not starting after a reboot on Ubuntu, use 1.5.2 instead)

MySQL 5.5 and up.

PHP5 Modules:
- apcu
- curl
- intl
- mysqlnd
- mbstring
- mcrypt
- json
- readline

**Important**: Keep in mind that ElasticSearch listens on Port 9200, you definitely want to restrict public access!

# Installation

Default-Login is demo/demo, if you don't want the demo-Account, skip the "doctrine:fixtures:load"-Command below.

```bash
# Clone
git clone git@github.com:arkste/readlater.git ./readlater

cd readlater

# Install Composer & generate Config (app/config/parameters.yml)
curl -sS https://getcomposer.org/installer | php

export SYMFONY_ENV=prod && php composer.phar install && php composer.phar dump-autoload --optimize

# Create Database
php app/console doctrine:database:create --env=prod

# Create Database-Schema
php app/console doctrine:schema:create --env=prod

# Create demo-User
php app/console doctrine:fixtures:load --env=prod --no-interaction

# Cache Warmup
php app/console cache:warmup --env=prod

# Populate ElasticSearch
php app/console fos:elastica:populate --env=prod
```

If you need help configuring your Webserver for Symfony, read this Guide:
http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html

# Development

readlater is built with Symfony 2.7 LTS, Bootstrap 3.3, jQuery 2.1, Grunt, Bower, Composer and LESS.

# Why ElasticSearch?

Why not? I'm a big fan of ElasticSearch and am using it wherever i can due to its fast filters and aggregations.

Thanks to ElasticSearch readlater is basically able to handle millions of bookmarks.

# Todo

- Replace the Bookmarklet-Popup with a Bookmarklet-Modal (to avoid the Popup-Blocker in Firefox)
- Add a User-Profile-Page (edit username/password)
- PHPUnit-Tests?

# Known Issues

- A deleted Bookmark will still show up after deletion for 1-2 seconds, there's a small delay until it gets deleted in the ElasticSearch-Index.
- There'll be an error page if there's no Index-Mapping in ElasticSearch, this can be fixed with adding a Bookmark (http://your_readlater_path/bookmark/add).