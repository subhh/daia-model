.PHONY: test
test: test.phan test.phpstan test.phpunit

.PHONY: test.phan
test.phan: tools/phan
	PHAN_DISABLE_XDEBUG_WARN=1 tools/phan --allow-polyfill-parser

.PHONY: test.phpstan
test.phpstan: tools/phpstan
	tools/phpstan --level=7 analyze src/main

.PHONY: test.phpunit
test.phpunit: tools/phpunit
	tools/phpunit --bootstrap vendor/autoload.php --verbose src

tools/phan:
	phive install $%

tools/phpstan:
	phive install $%

tools/phpunit:
	phive install $%
