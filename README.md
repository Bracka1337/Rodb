# RoDB

## Project setup

```
composer install
```

### Migrate DB and create keys

```
php artisan migrate
php artisan key:generate
php artisan passport:client --personal
php artisan passport:keys
```

### Run development

```
php artisan serve
```