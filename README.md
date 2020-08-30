## Steps to run

1. clone the repo
2. run `composer install` to install vendor packages
3. rename .env.example file to .env and update database credentials
```
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
4. run `php artisan migrate` for migrating tables
5. run `php artisan serve`