FROM occitech/cakephp:5-apache
MAINTAINER Jan <scheideggerj@gmail.com>

COPY . /var/www/html
RUN chown www-data:www-data /var/www/html/*
