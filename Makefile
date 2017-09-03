format:
	vendor/bin/php-cs-fixer fix --allow-risky=yes

deploy-prod:
	dep deploy production -v
