dev-first-build:
	docker-compose -f docker-compose-dev.yml up -d --build
	docker exec 2easy-ede-gateway composer install
	npm install
	npm run build
dev-build:
	docker-compose -f docker-compose-dev.yml up -d --build
	npm run build
dev-up:
	docker-compose -f docker-compose-dev.yml up -d
dev-down:
	docker-compose -f docker-compose-dev.yml down
first-build:
	docker-compose up -d --build
	docker exec 2easy-ede-gateway composer install
	npm install
	npm run build
build:
	docker-compose up --build
	npm run build
stop:
	docker-compose stop
up:
	docker-compose up -d
down:
	docker-compose down -v
laravel-install:
	docker exec 2easy-ede-gateway composer install
laravel-migrate:
	docker exec 2easy-ede-gateway php artisan migrate
laravel-seed:
	docker exec 2easy-ede-gateway php artisan migrate:refresh --seed
laravel-config:
	docker exec 2easy-ede-gateway php artisan config:clear
	docker exec 2easy-ede-gateway php artisan config:cache
laravel-config-clear:
	docker exec 2easy-ede-gateway php artisan config:clear
laravel-config-cache:
	docker exec 2easy-ede-gateway php artisan config:cache
laravel-route:
	docker exec 2easy-ede-gateway php artisan route:clear
	docker exec 2easy-ede-gateway php artisan route:cache
laravel-route-clear:
	docker exec 2easy-ede-gateway php artisan route:clear
laravel-route-cache:
	docker exec 2easy-ede-gateway php artisan route:cache
laravel-schedule:
	docker exec 2easy-ede-gateway php artisan schedule:work
laravel-optimize:
	docker exec 2easy-ede-gateway php artisan optimize:clear
prod-build:
	docker compose up -d --build
	docker exec 2easy-ede-gateway composer install
	npm install
	npm run build
prod-up:
	docker compose up -d
prod-down:
	docker compose down -v
prod-permissions:
	docker exec -it 2easy-ede-gateway /bin/bash -c "chgrp -R www-data bootstrap/ storage/ storage/logs/ && chmod -R 755 bootstrap/ storage/ storage/logs/ && chmod -R g+w bootstrap/ storage/ storage/logs/ && find bootstrap/ -type d -exec chmod g+s {} + && find storage/ -type d -exec chmod g+s {} + && find storage/logs/ -type d -exec chmod g+s {} +"
prod-terminal:
	docker exec -it 2easy-ede-gateway bash
