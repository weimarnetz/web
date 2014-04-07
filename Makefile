HOST := $(shell hostname -s)

default: build
dev:     preview

build:
#	npm install
	bower install

preview:
	php -S localhost:8088 #${HOST}:8088
