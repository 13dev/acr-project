
self::music is a platform build with laravel.

![Logo](https://raw.githubusercontent.com/13dev/acr-project/master/public/images/logo.png)

To Run:
- `cp .env.example .env`
- `docker-compose up -d`
- `docker-compose exec app bash`
- `composer install`
- `npm install`
- `npm run dev`
- `php artisan key:generate`
- `exit`
- `docker-compose down -v`
- `docker-compose exec app bash`
- `php artisan migrate`
- Dont forget to configure the:
    - `DIGITAL_OCEAN_SPACES_KEY`
    - `DIGITAL_OCEAN_SPACES_SECRET`
    - `DIGITAL_OCEAN_SPACES_REGION`
    - `DIGITAL_OCEAN_SPACES_BUCKET`
- `php artisan db:seed`



