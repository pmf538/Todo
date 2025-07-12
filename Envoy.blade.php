@servers(['web' => 'user@your-server.com'])

@task('deploy', ['on' => 'web'])
    cd /var/www/todo
    
    # Pull latest changes
    git pull origin main
    
    # Install/update dependencies
    composer install --no-dev --optimize-autoloader
    
    # Clear caches
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear
    
    # Run migrations
    php artisan migrate --force
    
    # Optimize for production
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Set proper permissions
    sudo chown -R www-data:www-data /var/www/todo
    sudo chmod -R 755 /var/www/todo
    sudo chmod -R 775 /var/www/todo/storage
    sudo chmod -R 775 /var/www/todo/bootstrap/cache
    
    # Restart services
    sudo systemctl restart nginx
    sudo systemctl restart php8.2-fpm
    
    echo "Deployment completed successfully!"
@endtask

@task('backup', ['on' => 'web'])
    cd /var/www/todo
    
    # Create database backup
    php artisan backup:run
    
    echo "Backup completed successfully!"
@endtask

@task('rollback', ['on' => 'web'])
    cd /var/www/todo
    
    # Rollback last migration
    php artisan migrate:rollback --step=1
    
    echo "Rollback completed successfully!"
@endtask 