#!/bin/sh

apk --no-cache --update add icu-dev
docker-php-ext-install intl
