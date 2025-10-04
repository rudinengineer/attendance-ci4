# Stage 1: Composer (untuk install dependencies)
FROM composer:2.8.12 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-intl --ignore-platform-req=ext-gd

# Stage 2: Base PHP Apache untuk CI4
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan CI4 + MySQL
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    mariadb-client \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl mysqli pdo pdo_mysql zip mbstring gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Aktifkan rewrite module
RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy semua file project
COPY . .

# Copy vendor hasil install composer dari stage pertama
COPY --from=vendor /app/vendor ./vendor

# Pastikan folder writable ada dan punya permission
RUN mkdir -p writable && chown -R www-data:www-data writable \
    && chmod -R 777 writable

# Set DocumentRoot ke folder /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80