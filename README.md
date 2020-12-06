## Project docker install
* `cd docker/jjtt/docker-compose.yml`
* `cp .env.example .env`
* `docker-compose up`
* `docker-compose exec backend` 
* `php artisan migrate`

Api will be available at http://localhost:8005
Api documentation available here `/api/documentation`