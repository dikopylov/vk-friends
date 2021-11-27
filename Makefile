up:
	./vendor/bin/sail up -d

build:
	composer install
	cp .env.example .env
	./vendor/bin/sail build
	./vendor/bin/sail up -d
	./vendor/bin/sail artisan key:generate --ansi
	./vendor/bin/sail yarn
	./vendor/bin/sail yarn dev
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail stop

down:
	./vendor/bin/sail down -v && rm -r vendor/
