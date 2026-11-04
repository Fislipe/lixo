FROM php:8.4-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

RUN echo "upload_max_filesize=2M" > /usr/local/etc/php/conf.d/upload-limit.ini \
    && echo "post_max_size=2M" >> /usr/local/etc/php/conf.d/upload-limit.ini

RUN mkdir -p /var/www/html/uploads /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/uploads /var/www/html/storage

