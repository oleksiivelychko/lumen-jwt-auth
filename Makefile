create-project:
	composer create-project --prefer-dist laravel/lumen lumen-jwt-auth

git-push:
	git push heroku main

init-db:
	rm -f database/database.sqlite
	touch database/database.sqlite

install-xdebug:
	arch -arm64 sudo pecl install xdebug

jwt-secret:
	php artisan jwt:secret

heroku-git:
	heroku git:remote -a oleksiivelychkolumenjwtauth

pg-info:
	heroku pg:info

run:
	php -S localhost:8000 -t public
