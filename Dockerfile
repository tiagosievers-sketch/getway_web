FROM php:8.2.1-apache-bullseye

ARG DEBIAN_FRONTEND=noninteractive
ARG ENVFASE=production
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
#COPY ${CONTEXT}/apache/ssl.conf /etc/apache2/sites-available/default-ssl.conf
#COPY ${CONTEXT}/apache/ports.conf /etc/apache2/ports.conf
#COPY ${CONTEXT}/certificate /etc/certificate


RUN a2enmod headers
RUN a2enmod rewrite && a2enmod ssl && a2enmod socache_shmcb
RUN a2enmod log_forensic
#RUN a2ensite default-ssl
RUN echo "ForensicLog /var/log/apache2/access.log" >> /etc/apache2/apache2.conf

#Install Laravel
COPY . /var/www/html/
#COPY .env .env
#RUN composer install  --ignore-platform-reqs
RUN chown -R www-data:www-data /var/www/html

RUN chown -R $USER:www-data ./storage/*
RUN chmod -R 775 ./bootstrap/cache/
RUN chmod -R 0777 ./storage
