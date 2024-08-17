#!/bin/bash

#sudo chown -R $USER:apache storage
#sudo chown -R $USER:apache bootstrap/cache

#sudo chown -R ec2-user:apache storage
#sudo chown -R ec2-user:apache bootstrap/cache

#chmod -R 775 storage
#chmod -R 775 bootstrap/cache

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan optimize

