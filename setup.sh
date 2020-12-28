#!/usr/bin/bash

# composer
composer update
composer install

# db
php command migrate:init
