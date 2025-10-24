FROM php:8.0-apache

# Instala a extensão mysqli para conectar ao MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

RUN a2enmod rewrite
