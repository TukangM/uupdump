# Gunakan image resmi PHP 8 dengan Apache
FROM php:8-apache

# Aktifkan ekstensi PHP yang diperlukan
COPY . .
RUN apt-get update && apt-get install -y libcurl4-openssl-dev && docker-php-ext-install curl

# Expose port 5000 untuk web server
EXPOSE 5000

# Command untuk menjalankan PHP web server
CMD ["php", "-S", "0.0.0.0:5000", "-t", "."]
