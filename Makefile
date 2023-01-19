.PHONY: test
test:
	tools/phpstan --level=7 --autoload-file=vendor/autoload.php analyze src
	tools/phan
	tools/phpunit --bootstrap vendor/autoload.php --verbose src/test/php
