HOST := $(shell hostname -s)

default: build
dev:     preview

build:
	npm install
	bower install

preview:
	php -S ${HOST}:8088