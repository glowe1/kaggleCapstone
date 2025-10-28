#!/bin/bash

# Fresh Deployment Script for Production
echo "🔄 Starting fresh deployment..."

# Pull latest code
echo "📥 Pulling latest code from repository..."
git pull origin master

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Build assets
echo "🎨 Building frontend assets..."
npm ci
npm run build

# Drop all tables and run fresh migrations
echo "🗄️ Running fresh migrations (this will delete all data)..."
php artisan migrate:fresh --force

# Seed the database
echo "🌱 Seeding database..."
php artisan db:seed --force

# Clear and cache configuration
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear application cache
php artisan cache:clear

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
sudo service php8.3-fpm restart

# Restart queue workers
echo "🔄 Restarting queue workers..."
php artisan queue:restart

echo "✅ Fresh deployment completed successfully!"
