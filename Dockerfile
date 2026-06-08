FROM php:8.4-cli-alpine

# نصب ابزارهای مورد نیاز و افزونه‌های PHP
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml-dev \
    zip \
    unzip \
    sqlite-dev \
    supervisor

RUN docker-php-ext-install pdo pdo_sqlite bcmath gd opcache unzip

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نصب RoadRunner
COPY --from=spiralscout/roadrunner:latest /usr/bin/rr /usr/bin/rr

WORKDIR /var/www

# کپی کردن کدهای پروژه
COPY . .

# نصب دپندنس‌ها
RUN composer install --no-dev --optimize-autoloader

# تنظیم دسترسی‌ها برای SQLite و کش لاراول
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000 8080

CMD ["/usr/bin/rr", "serve", "-c", ".rr.yaml"]
