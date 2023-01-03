.PHONY: test
test:
	tools/phpstan --level=7 --autoload-file=vendor/autoload.php analyze src
	tools/phan
	tools/phpunit --verbose src/test/php
