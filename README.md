## REQUIREMENTS

- PHP ^8.1
- MySQL Database


## SETUP INSTRUCTIONS

- Clone the repo
- Run `composer install` from the root directory
- Setup a local MySQL database.
- Set the database details in your `.env` file. You should create one from the `.env.example` if it doesn't exist.
- Run `php artisan key:generate` to generate application key.
- Run `php artisan migrate` to setup the database tables.
- Run `php artisan db:seed` to seed the database with some required seeders.


## TESTING

This project comprises of both unit and feature tests.

- Run `php artisan test` to run the tests.
