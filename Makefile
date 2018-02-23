install-dependencies:
	composer install
	npm install -y

migrate:
	bin/console doctrine:migrations:migrate

test:
	./vendor/bin/phpunit --coverage-text --colors

analyse-php:
	./vendor/bin/phpstan analyse --level=max --configuration=phpstan.neon ./src ./tests

format-php:
	./vendor/bin/php-cs-fixer fix --allow-risky=yes || true

format-client:
	./node_modules/.bin/prettier --single-quote --trailing-comma es5 --tab-width 2 --write "./client/**/*.vue" || true
	./node_modules/.bin/prettier --single-quote --trailing-comma es5 --tab-width 4 --write "./client/**/*.js" || true
	./node_modules/.bin/prettier --single-quote --write "./client/**/*.scss" || true

format-md:
	./node_modules/.bin/prettier --write "./*.md" || true

format-all: format-php format-client format-md

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
