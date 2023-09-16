init-config:
	@if [ ! -f .env.local ]; then cp .env .env.local; fi
	@if [ ! -f docker-compose.override.yml ]; then cp docker-compose.override.yml.dist docker-compose.override.yml; fi

composer-install:
	docker compose run --rm app composer install --ignore-platform-reqs


docker-up:
	docker compose up -d

migrationsApp:
	docker compose run --rm app php bin/console doctrine:migrations:migrate --no-interaction

migrationsTest:
	docker compose run --rm app php bin/console doctrine:migrations:migrate --no-interaction --env=test

reload:
	docker compose down
	docker compose up -d

init: init-config composer-install migrationsApp migrationsTest docker-up
