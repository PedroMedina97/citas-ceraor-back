FROM php:8.2-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev

# Extensiones PHP necesarias
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    mbstring \
    xml \
    fileinfo

# GD (clave para Excel y PDF)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Apache
RUN a2enmod rewrite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Cache de dependencias
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader

# Copiar proyecto
COPY . .

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80