ENV_FILE ?= .env

# ----------------------------------------------------------------------------
# Definitions
# ----------------------------------------------------------------------------

# Include env vafiables from file (only GNU make)
include ${ENV_FILE}
export $(shell sed 's/=.*//' "${ENV_FILE}")

DCOM := docker-compose -p "${PROJECT_NAME}" -f docker-compose.yml
DRUN := ${DCOM} -f docker-compose.cmd.yml run

ifeq (${APP_ENV}, prod)
	COMPOSER_INSTALL_ARGS := --no-interaction --no-dev --no-scripts --no-suggest --optimize-autoloader
	NPM_BUILD_COMMAND := build-prod
else
	COMPOSER_INSTALL_ARGS :=
	NPM_BUILD_COMMAND := build
endif

# ----------------------------------------------------------------------------
# Commands
# ----------------------------------------------------------------------------

list-env:
	env

init:
	mkdir -p ${DATA_DIR}/mysql/db
	mkdir -p ${DATA_DIR}/mysql/db-search
	mkdir -p ${CACHE_DIR}/composer
	mkdir -p ${CACHE_DIR}/npm

build-docker:
	docker-compose -f docker-compose.yml build

composer: A ?= help
composer:
	${DRUN} composer ${A}

npm: A ?= help
npm:
	${DRUN} npm ${A}

.PHONY: artisan
artisan: A ?= help
artisan:
	${DRUN} artisan ${A}

install-composer: init
	${DRUN} composer install ${COMPOSER_INSTALL_ARGS}

install-npm: init
	${DRUN} npm ci

install-dependencies: install-composer install-npm

build-assets:
	${DRUN} npm run-script ${NPM_BUILD_COMMAND}

build: init build-docker install-dependencies build-assets

up:
	${DCOM} up --detach

down:
	${DCOM} down --remove-orphans

migrate:
	${DRUN} console doctrine:migrations:migrate -n -vv

reindex-search-db:
	${DRUN} console app:search:reindex -n -vv

test:
	${DRUN} php-cli ./vendor/bin/phpunit --coverage-text --colors

analyse-php:
	${DRUN} php-cli ./vendor/bin/phpstan analyse --level=max --configuration=phpstan.neon ./src ./tests

format-php:
	${DRUN} php-cli ./vendor/bin/php-cs-fixer fix --allow-risky=yes || true

format-client: PRETTIER := ${DRUN} node ./node_modules/.bin/prettier
format-client:
	${PRETTIER} --single-quote --trailing-comma es5 --tab-width 2 --write "./client/**/*.vue" || true
	${PRETTIER} --single-quote --trailing-comma es5 --tab-width 4 --write "./client/**/*.js" || true
	${PRETTIER} --single-quote --write "./client/**/*.scss" || true
	${PRETTIER} --write "./*.md" || true

format-all: format-php format-client

prepare-code: analyse-php test format-all

create-ide-helpers:
	${DRUN} artisan ide-helper:generate
	${DRUN} artisan ide-helper:models --write --reset
	${DRUN} artisan ide-helper:meta
	${MAKE} format-php

deploy-prod:
	dep deploy production

deploy-test:
	dep deploy testing -v

crontab-dry-run:
	ansible-playbook \
		--inventory "notes.anwinged.ru," \
		--user=notes_owner \
		--check \
		--diff \
		ansible/crontab.yml

crontab:
	ansible-playbook \
		--inventory "notes.anwinged.ru," \
		--user=notes_owner \
		ansible/crontab.yml
