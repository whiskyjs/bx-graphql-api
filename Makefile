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

check: test analyze lint

check-frontend: test-frontend lint-frontend

check-all: check check-frontend
