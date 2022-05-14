composer-install:
	rm -rf vendor
	rm -f composer.lock
	composer install

init-db:
	rm -f database/database.sqlite
	touch database/database.sqlite

install-xdebug:
	arch -arm64 sudo pecl install xdebug

jwt-secret:
	php artisan jwt:secret

run:
	php -S localhost:8000 -t public
