#!/bin/bash

php artisan migrate \
 && php -S localhost:8000 -t public