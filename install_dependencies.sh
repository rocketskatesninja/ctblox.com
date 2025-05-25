#!/bin/bash

# Exit on error
set -e

echo "Installing CTBlox Training Platform dependencies..."

# Update package list
apt-get update

# Install Apache2
echo "Installing Apache2..."
apt-get install -y apache2

# Install PHP and required extensions
echo "Installing PHP and extensions..."
apt-get install -y php php-mysql php-mbstring php-xml php-curl

# Install MariaDB
echo "Installing MariaDB..."
apt-get install -y mariadb-server

# Install Git
echo "Installing Git..."
apt-get install -y git

# Enable Apache modules
echo "Configuring Apache..."
a2enmod rewrite
a2enmod headers

# Create Apache virtual host
echo "Creating virtual host configuration..."
cat > /etc/apache2/sites-available/ctblox.conf << 'EOL'
<VirtualHost *:80>
    ServerName training.corporatetools.local
    DocumentRoot /var/www/ctblox.com/public

    <Directory /var/www/ctblox.com/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/ctblox_error.log
    CustomLog ${APACHE_LOG_DIR}/ctblox_access.log combined

    <IfModule mod_headers.c>
        Header always set X-Frame-Options "SAMEORIGIN"
        Header always set X-XSS-Protection "1; mode=block"
        Header always set X-Content-Type-Options "nosniff"
    </IfModule>

    <Location "/admin">
        Require ip 192.168.1.0/24
    </Location>
</VirtualHost>
EOL

# Enable the site
a2ensite ctblox.conf

# Restart Apache
systemctl restart apache2

# Set directory permissions
echo "Setting directory permissions..."
chown -R www-data:www-data /var/www/ctblox.com
chmod -R 755 /var/www/ctblox.com

echo "Dependencies installed successfully!"
echo
echo "Next steps:"
echo "1. Run: mysql < database/create_database.sql"
echo "2. Update config/config.php with your database credentials"
echo "3. Add training.corporatetools.local to your hosts file"
echo "4. Access the site at http://training.corporatetools.local"
echo "5. Login with default credentials: admin / admin123"
echo
echo "Default admin credentials (CHANGE THESE):"
echo "Username: admin"
echo "Password: admin123"
