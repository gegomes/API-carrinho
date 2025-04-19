# Usa imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instala extensões necessárias (ex: pdo_mysql)
RUN docker-php-ext-install pdo pdo_mysql

# Copia os arquivos do projeto para dentro do container
COPY . /var/www/html

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permite URL Rewriting (se necessário)
RUN a2enmod rewrite
