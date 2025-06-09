BASE_DIRECTORY ?= $(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

.PHONY: install
install:
	composer install

.PHONY: phpcs
phpcs:
	./vendor/bin/phpcs --standard=./vendor/squizlabs/php_codesniffer/src/Standards/PSR12/ruleset.xml --exclude=Generic.Files.LineLength ./src/*

.PHONY: phpcbf
phpcbf:
	./vendor/bin/phpcbf --standard=./vendor/squizlabs/php_codesniffer/src/Standards/PSR12/ruleset.xml --exclude=Generic.Files.LineLength ./src/*

.PHONY: phpcpd
phpcpd:
	./vendor/bin/phpcpd ./src/

.PHONY: phpstan
phpstan:
	./vendor/bin/phpstan analyse ./src/

.PHONY: codeception
codeception:
	./vendor/bin/codecept run

.PHONY: ci
ci: phpcs phpcpd codeception phpstan

.PHONY: clean
clean:
	rm -Rf composer.lock
	rm -Rf ./vendor
	find ./tests/_output/ -not -name .gitignore -delete
	rm -Rf src/Generated/*
