# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql

# Habilita mod_rewrite en Apache
RUN a2enmod rewrite

# Copia el código de tu proyecto Laravel
COPY . /var/www/html

# Configura el directorio de trabajo y permisos
WORKDIR /var/www/html

# Instala las dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-interaction

# Expone el puerto 80
EXPOSE 80