FROM php:8.0-apache
RUN a2enmod rewrite
COPY . /var/www/html
RUN chmod -R 777 /tmp
RUN chmod -R 777 /var/www/html/static