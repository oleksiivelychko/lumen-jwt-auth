composer-install:
	rm -rf vendor
	rm -f composer.lock
	composer install

jwt-secret:
	php artisan jwt:secret

run:
	php -S localhost:8000 -t public
