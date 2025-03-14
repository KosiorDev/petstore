Requirements:
- docker-compose

How to run the project:
- clone the repository
- run: `docker compose up`
- run: `docker compose exec backend bash`
From inside the container
- run: `cp .env.example .env`
- run: `php artisan key:generate`
- run: `php artisan migrate` (when prompt to create database, select "yes")
- run: `chown -R www-data:www-data .`
