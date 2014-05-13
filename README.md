# [weimarnetz.de](http://weimarnetz.de)


## Dependencies / Preparations

One-time:

- install `nodejs` and `npm`
- `$ sudo npm install -g bower`

Once in a while / From time to time:

Checkout assets (for dev and on deploy):
- `$ bower install`


## PHP

- `$ make preview` runs local php server
- php includes starting with `_` are required for every page: `_head` and `_foot`
- all other includes are just content

