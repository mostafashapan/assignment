#!/bin/bash

# Wait for MySQL to be available
/wait-for-it.sh db:3306 --timeout=30 --strict -- echo "MySQL is up - executing command"

# Run the SQL initialization script
php /var/www/html/init-db.php

# Start Apache server
exec apache2-foreground
