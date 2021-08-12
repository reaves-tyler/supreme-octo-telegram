run:
	php artisan serve
watch:
	watch php artisan route:list
up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

test:
	XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html reports/