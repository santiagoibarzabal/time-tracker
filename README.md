# Task Timer

This project provides a full stack solution to track tasks and uses [Laravel](https://laravel.com/docs/11.x) framework. 

## Focus
- The project has been developed with Hexagonal Archictecture and DDD, focusing on the backend and providing the minimum front-end necessary.

## Tools
- [Docker](https://docs.docker.com/engine/reference/commandline/docker/) and [Docker compose](https://docs.docker.com/compose/)
- [Laravel 11](https://laravel.com/docs/11.x)
- [PHP 8.2](https://www.php.net/releases/8.2/en.php)
- [MSQL:8.0.31](https://dev.mysql.com/doc/refman/8.0/en/)
- [NGINX](https://www.nginx.com/)
- [PHP-FPM](https://www.php.net/manual/en/install.fpm.php)
- [Pest](https://pestphp.com/)
- [Tailwind](https://tailwindcss.com/)

## Running the app

### Requirements
- Docker CLI and Docker compose are necessary to serve the API and the Database locally.

### Build and run docker containers
```
docker compose build
docker compose up -d
```
- All interactions via CLI with the application will need to be executed within Docker. The following command executes bash within the php container.
```
docker compose exec api bash
```

### Setup Laravel and Environment Variables.
- Execute composer install within the container:
```
 docker compose exec api composer install
```
- Copy the .env.example file to .env
```
 cp .env.example .env
```
- Generate the project key.
```
 docker compose exec api php artisan key:generate
```

### Execute database migrations
```
docker compose exec api php artisan migrate
```

### Listen to Events with Queue (Necessary for Events/Listeners)
```
docker compose exec api php artisan queue:work
```

### Seed database
```
docker compose exec api php artisan db:seed
```

## Running the tests
```
docker compose exec api php artisan test
```

## Local development
- Please execute migrations and seeders as detailed above in order.
