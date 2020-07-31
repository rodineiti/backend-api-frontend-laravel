[![Build](https://img.shields.io/scrutinizer/build/g/rodineiti/backend-api-frontend-laravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/rodineiti/backend-api-frontend-laravel)
[![Quality Score](https://img.shields.io/scrutinizer/g/rodineiti/backend-api-frontend-laravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/rodineiti/backend-api-frontend-laravel)

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

# Getting started

# backend-api-frontend-laravel
Frontend e API - Sistema de controle de finanças pessoal multi usuários

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


Clone the repository

    git clone https://github.com/rodineiti/backend-api-frontend-laravel.git

Switch to the repo folder

    cd backend-api-frontend-laravel

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env
    
Set Database SQLITE in .env

    DB_CONNECTION=sqlite

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

PASSPORT - Create the encryption keys needed to generate secure access tokens

    php artisan passport:install

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

Admin login test

    email: marquis90@example.org
    password: secret

User login test
    
    email: kara.walter@example.com
    password: secret

You can now access the server API at http://localhost:8000/api
