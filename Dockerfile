FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    nodejs \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Get latest Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy dependency manifests first for Docker layer caching
COPY composer.json composer.lock package.json package-lock.json ./

# Install Composer and Node dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
RUN npm install

# Copy application files
COPY . .

# Build frontend assets with Vite & remove node_modules to keep image lightweight
RUN npm run build && rm -rf node_modules

# Optimize Composer autoloader with the complete application codebase
RUN composer dump-autoload --optimize --no-dev

# Configure Apache document root to Laravel public/ and ensure AllowOverride All for .htaccess
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Setup startup script with CRLF fix (for Windows compatibility) and executable permissions
COPY start.sh /usr/local/bin/start
RUN sed -i 's/\r$//' /usr/local/bin/start && chmod +x /usr/local/bin/start

# Set initial permissions for storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose web ports (80 standard, 10000 Render dynamic port)
EXPOSE 80 10000

# Run start script
CMD ["/usr/local/bin/start"]
