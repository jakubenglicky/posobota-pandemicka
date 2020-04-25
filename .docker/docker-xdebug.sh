#!/bin/bash

exists=$(docker-compose exec web [ -f /usr/local/etc/php/conf.d/xdebug.ini ] && echo 1 || echo 0)

docker-compose kill web

if [ "$exists" == 1 ] ; then
	echo "Spouštím kontejner web bez xdebugu"
	docker-compose -f docker-compose.yml -f docker-compose.override.yml up -d web
else
	echo "Spouštím kontejner web s xdebugem"
	docker-compose -f docker-compose.yml -f docker-compose.override.yml -f docker-compose.xdebug.yml up -d web
fi
