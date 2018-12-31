FROM php:7.2-fpm

# Override Sources list to avoid availability failures from debian default repository.
RUN rm -rf /etc/apt/sources.list
RUN echo "deb http://ftp.cl.debian.org/debian/ stretch main contrib non-free" >> /etc/apt/sources.list
RUN echo "deb-src http://ftp.cl.debian.org/debian/ stretch main contrib non-free" >> /etc/apt/sources.list

# Set working directory
WORKDIR /var/www

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mysql-client \
    libpng-dev \
    libxml2-dev \
    libxslt-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath xml xsl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Configure Laravel permissions
COPY . /var/www
RUN chmod -R uog+rwx /var/www/storage /var/www/bootstrap
RUN chown -R www:www /var/www/*

# Change current user to www
USER www

# Copy composer.lock and composer.json
COPY composer.json /var/www/

# Execute compose install
RUN php /usr/local/bin/composer install

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

# Clear local data
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan route:clear
RUN php artisan config:clear
RUN php artisan clear-compiled

# Install Telescope
RUN php artisan telescope:install