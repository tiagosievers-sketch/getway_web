FROM php:8.2.1-apache-bullseye

ARG DEBIAN_FRONTEND=noninteractive
ARG ENVFASE=production
ENV CONTEXT=infrastructure/environments/production

RUN apt-get update \
    && apt-get install -y \
        software-properties-common \
        build-essential \
        libaio1 \
        wget \
        curl \
        libmemcached-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libzip-dev \
        memcached \
        libmemcached-tools \
        libxml2-dev \
        unzip \
        zip \
        libldap2-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2.2.0 /usr/bin/composer /usr/local/bin/composer

# PHP extensions
RUN docker-php-ext-install gettext intl pdo_mysql

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install redis && docker-php-ext-enable redis

# Apache (port set at runtime via entrypoint from $PORT)
COPY ${CONTEXT}/apache/default.conf /etc/apache2/sites-available/000-default.conf

# Only one MPM allowed (fix "More than one MPM loaded")
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true; a2enmod mpm_prefork

RUN a2enmod headers rewrite ssl socache_shmcb log_forensic
RUN echo "ForensicLog /var/log/apache2/access.log" >> /etc/apache2/apache2.conf

# App Laravel
COPY . /var/www/html/

WORKDIR /var/www/html

# Composer: install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Vite: build frontend assets (generates public/build/manifest.json)
RUN npm install && npm run build

# Laravel storage: create dirs that may be missing (sessions, cache, views)
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache/data} \
    && chown -R www-data:www-data /var/www/html/storage

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage

# Entrypoint: set Apache to listen on $PORT (Railway)
COPY infrastructure/scripts/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]
