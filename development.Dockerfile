FROM php:8.2.1-apache-bullseye

ARG DEBIAN_FRONTEND=noninteractive
ENV CONTEXT infrastructure/environments/production

RUN apt-get update

RUN apt-get update \
    && apt-get -y install software-properties-common \
    && apt-get -y install build-essential \
    && apt-get -y install libaio1 \
    && apt-get -y install wget \
    && apt-get -y install curl\
    && apt-get -y install libmemcached-dev \
    && apt-get -y install libfreetype6-dev \
    && apt-get -y install libjpeg62-turbo-dev \
    && apt-get -y install libzip-dev\
    && apt-get -y install memcached libmemcached-tools\
    && apt-get -y install libxml2-dev\
    && apt-get -y install unzip zip \
    && apt-get -y install libldap2-dev

#INSTALL COMPOSER
COPY --from=composer:2.2.0 /usr/bin/composer /usr/local/bin/composer

# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install redis && docker-php-ext-enable redis

COPY ${CONTEXT}/apache/default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod headers
RUN a2enmod rewrite
RUN a2enmod log_forensic
RUN echo "ForensicLog /var/log/apache2/access.log" >> /etc/apache2/apache2.conf

#Install Laravel
COPY . /var/www/html/
#COPY .env.example .env
#RUN composer install  --ignore-platform-reqs
RUN chown -R www-data:www-data /var/www/html

RUN chown -R $USER:www-data ./storage/*
RUN chmod -R 775 ./bootstrap/cache/
RUN chmod -R 0777 ./storage
