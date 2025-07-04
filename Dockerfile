FROM php:fpm

# Arguments defined in docker-compose.yml
#ARG user
#ARG uid

# IF arugment not working
ARG user=laravel
ARG uid=1000


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    autoconf \
    build-essential \
    libtool \
    pkg-config

# Install and configure Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN docker-php-ext-install zip exif pcntl bcmath

# Install Redis extension
#RUN pecl install redis && docker-php-ext-enable redis

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Create xdebug log directory and set permissions
RUN mkdir -p /tmp && chmod 777 /tmp

USER $user

