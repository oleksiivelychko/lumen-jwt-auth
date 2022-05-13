composer-install:
	rm -rf vendor
	rm -f composer.lock
	composer install

run:
	php -S localhost:8000 -t public
