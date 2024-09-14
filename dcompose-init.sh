docker compose exec app composer install \
	&& docker compose exec app php artisan l5-swagger:generate
	&& docker compose exec app php artisan migrate

