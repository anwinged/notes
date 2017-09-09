format:
	vendor/bin/php-cs-fixer fix --allow-risky=yes

deploy-prod:
	dep deploy production

deploy-test:
	dep deploy testing -v
