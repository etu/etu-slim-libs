composer-validate:
	composer validate

phpcbf:
	phpcbf --standard=PSR12 src/

phpcs:
	phpcs --standard=PSR12 src/

yamllint:
	yamllint -s -f github .github/workflows/*.yml
