install:
	composer install --no-interaction --prefer-dist

update:
	composer update

test:
	composer test

analyze:
	composer analyze

lint:
	composer lint

test-frontend:
	composer test-frontend

lint-frontend:
	composer lint-frontend

check:
	composer test && composer analyze && composer lint

check-all:
	composer test && composer analyze && composer lint && composer test-frontend && composer lint-frontend
