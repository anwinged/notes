format:
	./vendor/bin/php-cs-fixer fix --allow-risky=yes || true
	./node_modules/.bin/prettier --single-quote --trailing-comma es5 --tab-width 4 --write "./client/**/*.js" || true
	./node_modules/.bin/prettier --single-quote --write "./client/**/*.scss" || true

deploy-prod:
	dep deploy production

deploy-test:
	dep deploy testing -v
