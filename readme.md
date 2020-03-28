# Expiry

## Requirements

Neliserp is built with Laravel 7, so to use the software your system should meet Laravel 7 requirements. Please refer to [Laravel Installation](https://laravel.com/docs/7.x/installation) for more details.

## Installation

run `git clone` the software.

```console
$ git clone https://github.com/neliserp/neliserp
```

run `composer install` the required packages

```console
$ composer install
```

create file `.env` by copy from example configuration

```console
$ cp .env.example .env
```

edit database configuration in file `.env`

```console
$ vi .env
DB_DATABASE=expiry
DB_USERNAME=expiry
DB_PASSWORD=secret
```

run `artisan` to generate application key

```console
$ php artisan key:generate
```

run `artisan` to migrate and seed testing data

```console
$ php artisan migrate:fresh --seed
```

run `npm` to compile css, js files

```console
$ npm install
```

```console
$ npm run dev
```

run local testing web server

```console
$ php artisan serve
```

The default email and password, is `admin@example.com/admin1234`.

## License

Neliserp is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
