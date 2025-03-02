# Usar una imagen base de PHP con Apache
FROM php:7.4.33-apache

# Instalar extensiones necesarias para Laravel/Slim/Symfony
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql gd

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto
COPY . .

# Instalar las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto 80 para Apache
EXPOSE 80

# Comando de inicio del contenedor
CMD ["apache2-foreground"]

