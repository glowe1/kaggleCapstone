#!/bin/bash

# Laravel Forge Deployment Script
# This script handles the deployment with consolidated migrations

echo "🚀 Starting deployment process..."

# Set application to maintenance mode
echo "📝 Setting maintenance mode..."
php artisan down

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Install/update dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Run database migrations with fresh approach
echo "🗄️ Running database migrations..."

# Check if we need to reset the database
if [ "$RESET_DATABASE" = "true" ]; then
    echo "🔄 Resetting database with consolidated migrations..."
    php artisan migrate:fresh --seed --force
else
    echo "📊 Running standard migrations..."
    php artisan migrate --force
fi

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Bring application back online
echo "✅ Bringing application online..."
php artisan up

echo "🎉 Deployment completed successfully!"
