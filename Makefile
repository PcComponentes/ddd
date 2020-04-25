UID=$(shell id -u)
GID=$(shell id -g)
DOCKER_PHP_SERVICE=php

start: erase cache-folders build composer-install bash

erase:
	docker-compose down -v

build:
	docker-compose build && \
	docker-compose pull

cache-folders:
	mkdir -p ~/.composer && chown ${UID}:${GID} ~/.composer

composer-install:
	docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} composer install

bash:
	docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} sh

logs:
	docker-compose logs -f ${DOCKER_PHP_SERVICE}
