#!/usr/bin/env bash
ACTION=$1
COMMAND=$2


if [ $ACTION = "bash" ]; then
docker-compose run app bash
fi

if [ $ACTION = "run" ]; then
docker-compose run -T app $COMMAND
fi

if [ $ACTION = "artisan" ]; then
docker-compose run app php artisan $COMMAND
fi

