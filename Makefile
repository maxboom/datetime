.PHONY: init run-integration-tests remove-media-cache-tests

install-database:
	php bin/console d:m:m --no-interaction
	php bin/console app:generate-random-post
	php bin/console app:generate-random-post
	php ./bin/console app:generate-random-post --summary-title -p 1
