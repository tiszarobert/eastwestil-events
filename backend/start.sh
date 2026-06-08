#!/bin/sh

echo "Waiting for database..."
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
  echo "Database not ready, retrying..."
  sleep 2
done

echo "Database ready!"
php artisan migrate --force --seed

php artisan serve --host=0.0.0.0 --port=8000