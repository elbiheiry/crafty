#!/bin/bash

php artisan migrate

php artisan optimize:clear

php artisan storage:link


