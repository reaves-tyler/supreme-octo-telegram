# Laravel Api Rest

[![Build and Test](https://github.com/reaves-tyler/supreme-octo-telegram/actions/workflows/laravel.yml/badge.svg)](https://github.com/reaves-tyler/supreme-octo-telegram/actions/workflows/laravel.yml)

Simple example of a REST API with Laravel 8.x

## Install with Composer

```
    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install or composer install
```

## Set Environment

```
    $ cp .env.example .env
```

## Set the application key

```
   $ php artisan key:generate
```

## Run migrations and seeds

```
   $ php artisan migrate --seed
```

## Getting with Curl

```
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X GET http://127.0.0.1:8000/api/books
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X GET http://127.0.0.1:8000/api/books/:id
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X POST -d '{"title":"Foo bar","price":"19.99","author":"Foo author","editor":"Foo editor"}' http://127.0.0.1:8000/api/books
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X PUT -d '{"title":"Foo bar","price":"19.99","author":"Foo author","editor":"Foo editor"}' http://127.0.0.1:8000/api/books/:id
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X DELETE http://127.0.0.1:8000/api/books/:id
```

## Pagination with Curl

```
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X GET http://127.0.0.1:8000/api/books?page=:number_page  -H 'Authorization:Basic username:password or email:password'
```

## User Authentication with Curl with middleware auth.basic.username

```
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X GET http://127.0.0.1:8000/api/books  -H 'Authorization:Basic username:password'
```

## User Authentication with Curl using middleware auth.basic

```
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X GET http://127.0.0.1:8000/api/books  -H 'Authorization:Basic email:password'
```

## Testing with phpunit (php 8.x)

```
    $ pecl install xdebug
```

Uncomment line in `php.ini`
`[xdebug] zend_extension="/Applications/MAMP/bin/php/php8.0.3`

```
    $ XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html reports/
```

## Connect with mongodb (php 8.x)

```
    $ pecl install mongodb
```

Add line in `php.ini`
`extension="mongodb.so"`