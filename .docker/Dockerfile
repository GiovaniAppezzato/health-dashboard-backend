FROM php:8.4-fpm

ARG user
ARG uid
ARG gid

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libfreetype6-dev \
    libxml2-dev \
    libjpeg62-turbo-dev \
    libicu-dev \
    python3

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN groupadd -g ${gid} ${user} && \
    useradd -u ${uid} -g ${user} -m -s /bin/bash ${user}

WORKDIR /var/www/html

RUN chown -R ${user}:${user} /var/www/html

USER $user

EXPOSE 9000
