To Run:

- `docker-compose up -d`
- `docker-compose exec app bash`
- `composer install`
- `php artisan key:generate`
- Dont forget to configure the:
    - `DIGITAL_OCEAN_SPACES_KEY`
    - `DIGITAL_OCEAN_SPACES_SECRET`
    - `DIGITAL_OCEAN_SPACES_REGION`
    - `DIGITAL_OCEAN_SPACES_BUCKET`
- `php artisan migrate`
- `php artisan db:seed`



