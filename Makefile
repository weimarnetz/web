HOST := $(shell hostname -s)

default: preview

preview:
	php -S ${HOST}:8088