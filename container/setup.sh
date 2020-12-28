#!/usr/bin/bash

# composer
composer update
composer install
composer dump-autoload

# db
php command migrate:init

# other
cp .env.sample .env
