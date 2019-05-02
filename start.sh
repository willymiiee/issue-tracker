#!/bin/bash

php artisan migrate \
 && php artisan db:seed \
 && php -S localhost:8000 -t public