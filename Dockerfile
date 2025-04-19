FROM php:8.2-apache

# Habilita o mod_rewrite
RUN a2enmod rewrite

# Instala PDO MySQL (ajuste se necessário)
RUN docker-php-ext-install pdo pdo_mysql

# Define a pasta correta como DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Altera o VirtualHost padrão para usar a pasta /public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copia o projeto
COPY . /var/www/html

# Permissões (ajuste conforme necessário)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
