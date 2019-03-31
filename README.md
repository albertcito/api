Assets
=======================

Introduction
------------
Miaum project to create app to Android or iOS.

## To install:
- Clone this project
- Run `composer install` (Installs all the dependencies for your project)
- Create .env file `cp .env.example .env`  (remember update the database password and `DB_HOST=127.0.0.1`)
- Run `php artisan migrate` (Creates all of the database tables)
- Run `php artisan passport:install --force` (passport encryption keys)
- Run your project `php artisan serve` (Runs the server)
- Go to [http://127.0.0.1:8000/graphiql](http://127.0.0.1:8000/graphiql) (Add /admin to this URL in order to see private data)

###  To run in Develop Mode and execute the tests ###
- `composer dump-autoload`
- `php artisan db:seed` (Generates fake data in the database for testing purposes)
- `vendor/bin/phpunit` (to debug `--debug` and for Windows users use `vendor\bin\phpunit`)

###  To execute the Code Standard test ###
 - `phpcs --standard=phpcs.xml --extensions=php app` (Ensures that code follows the same coding conventions for all developers)

###  To use the queries and mutations that request authentication:  ###

```
{
  login(
    email:"support.dev@devicepixel.com",
    password:"123456"
  ) {
    idUser
    email
    company {
      name
      email
    }
  }
}
```
- Now you can access the [admin area](http://127.0.0.1:8000/graphiql/admin)
