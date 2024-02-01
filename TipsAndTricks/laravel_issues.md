# Laravel showing "Failed to clear cache. Make sure you have the appropriate permissions"
## 1.
Calling the following 4 commands should fix most of the permission issues on laravel.
````sh
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
````
## 2.
Check if there is a "data" folder inside "storage/framework/cache/". If there is not, then create it manually. (create a new folder with name "data")

## 3.
If there is a "data" folder inside "storage/framework/cache/". Remove ALL existing folders inside there.

## 4.
Then final, running this:
````sh
php artisan cache:clear
````
