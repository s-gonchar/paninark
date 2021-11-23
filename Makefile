app-init:
	composer install
	vendor/bin/doctrine-migrations migrations:migrate --no-interaction --allow-no-migration
	vendor/bin/doctrine orm:schema-tool:update --force

md:
	vendor/bin/doctrine-migrations migrations:diff --no-interaction --allow-no-migration