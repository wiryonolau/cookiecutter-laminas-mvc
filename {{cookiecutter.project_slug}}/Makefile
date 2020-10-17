# HELP
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

THIS_FILE := $(lastword $(MAKEFILE_LIST))

start:
	docker run --rm -d \
		-p 127.0.0.1:8080:80 \
		-e APACHE_RUN_GROUP="#$$(id -g)" \
		-v $$(pwd)/$$(basename "`pwd`"):/var/www/html \
		-v $$(pwd)/etc/apache2/sites-enabled:/etc/apache2/sites-enabled \
		--name $$(basename "`pwd`") \
	php:7.2-apache /bin/bash -c "a2enmod rewrite; source /etc/apache2/envvars; apache2 -D FOREGROUND"
stop:
	docker stop $$(basename "`pwd`")
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

