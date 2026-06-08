FROM php:8.4.7-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    bcmath \
    xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

EXPOSE 8000

COPY start.sh /start.sh

RUN chmod +x /start.sh

CMD ["/start.sh"]