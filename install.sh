#!/bin/bash

curl -sS https://getcomposer.org/installer | php \
 && php composer.phar install \
 && cp .env.example .env \
 && php artisan key:generate \
 && php artisan jwt:secret