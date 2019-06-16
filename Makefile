DRUN := docker-compose -f docker-compose.yml -f docker-compose.cmd.yml run

init:
	mkdir -p ./.docker-cache/composer
	mkdir -p ./.docker-cache/npm

install-composer: init
	$(DRUN) composer install

install-npm: init
	$(DRUN) npm install

install-dependencies: install-composer install-npm

build-assets:
	$(DRUN) npm run-script build

build: init install-dependencies build-assets

up:
	docker-compose -f docker-compose.yml up --build

down:
	docker-compose -f docker-compose.yml down --remove-orphans

migrate:
	$(DRUN) console doctrine:migrations:migrate -n

test:
	$(DRUN) php-cli ./vendor/bin/phpunit --coverage-text --colors

analyse-php:
	$(DRUN) php-cli ./vendor/bin/phpstan analyse --level=max --configuration=phpstan.neon ./src ./tests

format-php:
	$(DRUN) php-cli ./vendor/bin/php-cs-fixer fix --allow-risky=yes || true

PRETTIER := $(DRUN) node ./node_modules/.bin/prettier
format-client:
	$(PRETTIER) --single-quote --trailing-comma es5 --tab-width 2 --write "./client/**/*.vue" || true
	$(PRETTIER) --single-quote --trailing-comma es5 --tab-width 4 --write "./client/**/*.js" || true
	$(PRETTIER) --single-quote --write "./client/**/*.scss" || true
	$(PRETTIER) --write "./*.md" || true

format-all: format-php format-client

prepare-code: analyse-php test format-all

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
