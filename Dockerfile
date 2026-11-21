FROM php:8.2-fpm

# 1. Install dependensi sistem, Nginx, & ekstensi PHP wajib Laravel
RUN apt-get update && apt-get install -y \
    nginx wget \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Konfigurasi Nginx untuk Laravel (DocumentRoot ke /public dan routing index.php)
RUN cat <<'EOF' > /etc/nginx/sites-available/default
server {
    listen 1013;
    listen [::]:1013;
    server_name _;
    root /var/www/html/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Salin kode aplikasi ke container
WORKDIR /var/www/html
COPY . .

# 5. Install library PHP & atur izin folder storage
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 1013

# 6. Jalankan PHP-FPM di background dan Nginx di foreground
CMD php-fpm -D && nginx -g "daemon off;"