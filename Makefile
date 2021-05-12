composer-validate:
	composer validate

phpcbf:
	phpcbf --standard=PSR12 src/

phpcs:
	phpcs --standard=PSR12 src/

phpstan:
	phpstan analyze --level 8 src/

security-advisories:
	composer require --dev "roave/security-advisories:dev-latest"

yamllint:
	yamllint -s -f github .github/workflows/*.yml
