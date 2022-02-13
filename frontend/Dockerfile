FROM php:7.2-apache

RUN apt-get update && apt-get install -y \
	unzip \
	zip \
	&& rm -rf /var/lib/apt/lists/*

COPY www /var/www/html/