#!/bin/bash

# Migration Reset Script for Laravel Forge
# This script safely resets migrations using consolidated files

echo "🔄 Starting migration reset process..."

# Set maintenance mode
php artisan down

# Clear caches
php artisan config:clear
php artisan cache:clear

# Drop all tables and recreate with consolidated migrations
echo "🗑️ Dropping existing tables..."
php artisan migrate:fresh --force

# Run seeders to populate initial data
echo "🌱 Seeding database..."
php artisan db:seed --force

# Clear and cache configurations
php artisan config:cache
php artisan route:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Bring application back online
php artisan up

echo "✅ Migration reset completed successfully!"
echo "📊 Database now uses consolidated migration structure"
