FROM php:8.0-apache

# 1. Instala dependências do sistema
# git: necessário para o composer baixar pacotes de repositórios git
# unzip: necessário para descompactar pacotes
# libzip-dev: dependência para a extensão zip do PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) zip pdo pdo_mysql mysqli && docker-php-ext-enable mysqli

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# 2. Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Habilita o mod_rewrite do Apache
RUN a2enmod rewrite
