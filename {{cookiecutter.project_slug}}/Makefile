# HELP
# This will output the help for each task
.PHONY: help
 
help: ## This help.
    @awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
 
.DEFAULT_GOAL := help
 
THIS_FILE := $(lastword $(MAKEFILE_LIST))
 
%:
	@echo ""
all:
	@echo ""
start:
	$(MAKE) stop
	docker network create $$(basename "`pwd`")
	docker run --rm -it -d \
        -e MYSQL_ROOT_PASSWORD=888888 \
        -e MYSQL_USER=mydata \
        -e MYSQL_PASSWORD=888888 \
        -e MYSQL_DATABASE=mydata \
        -v $$(pwd)/mysql_data:/var/lib/mysql \
        -v $$(pwd)/init_db:/docker-entrypoint-initdb.d \
        --user $$(id -u):$$(id -g) \
        --name $$(basename "`pwd`")_mysql \
        --network $$(basename "`pwd`") \
    mysql:5.7
	docker run --rm -it -d \
        -p 127.0.0.1:8080:80 \
        -e APACHE_RUN_GROUP="#$$(id -g)" \
        -v $$(pwd)/$$(basename "`pwd`"):/var/www/html \
        -v $$(pwd)/etc/apache2/sites-enabled:/etc/apache2/sites-enabled \
        --name $$(basename "`pwd`")_httpd \
        --network $$(basename "`pwd`") \
    php:7.2-apache /bin/bash -c "docker-php-ext-install mysqli pdo pdo_mysql; a2enmod rewrite; source /etc/apache2/envvars; apache2 -D FOREGROUND"
stop:
	docker stop $$(basename "`pwd`")_httpd || true 
	docker stop $$(basename "`pwd`")_mysql || true
		docker network rm $$(basename "`pwd`") || true
composer-install:
	docker run --rm -it \
        -v $$(pwd)/$$(basename "`pwd`"):/srv/$$(basename "`pwd`") \
        -w /srv/$$(basename "`pwd`") \
        -e COMPOSER_HOME="/srv/$$(basename "`pwd`")/.composer" \
        --user $$(id -u):$$(id -g) \
    composer composer install --no-plugins --no-scripts --no-dev --prefer-dist -v --ignore-platform-reqs
composer-update:
	docker run --rm -it \
        -v $$(pwd)/$$(basename "`pwd`"):/srv/$$(basename "`pwd`") \
        -w /srv/$$(basename "`pwd`") \
        -e COMPOSER_HOME="/srv/$$(basename "`pwd`")/.composer" \
        --user $$(id -u):$$(id -g) \
    composer composer update -v --no-dev
composer:
	docker run --rm -it \
        -v $$(pwd)/$$(basename "`pwd`"):/srv/$$(basename "`pwd`") \
        -w /srv/$$(basename "`pwd`") \
        -e COMPOSER_HOME="/srv/$$(basename "`pwd`")/.composer" \
        --user $$(id -u):$$(id -g) \
    composer composer $(filter-out $@,$(MAKECMDGOALS))
