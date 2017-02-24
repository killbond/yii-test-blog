#!/usr/bin/env bash

composer global require "fxp/composer-asset-plugin:^1.2.0"
composer global require "codeception/codeception"

echo "export PATH="$PATH:$HOME/.config/composer/vendor/bin"" > ~/.bashrc

cd /var/www
composer install