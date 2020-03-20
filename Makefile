dev: vendor
	docker-compose build
	docker-compose up -d
	make database
	@echo "Application démarrée : http://localhost:8000/"
dev-stop:
	docker-compose stop

database:
	docker-compose exec php php bin/console doctrine:database:drop --force
	docker-compose exec php php bin/console doctrine:database:create
	docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
	docker-compose exec -T db mysql -uroot -proot 2fs < dev/database.sql

vendor: composer.lock
	docker-compose exec php composer install