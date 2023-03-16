### How To Install and Use Composer on Ubuntu 20.04

# First, update the package manager cache
sudo apt update

# Next, run the following command to install the required packages:
sudo apt install wget php-cli php-zip unzip -y

# Composer provides an installer script written in PHP. We’ll download it, verify that it’s not corrupted, and then use it to install Composer.
# Make sure you’re in your home directory, then retrieve the installer using curl:
cd ~
# 
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
# or
wget -O composer-setup.php https://getcomposer.org/installer

# Once the installer is downloaded, run the following command to install Composer globally:
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# You will get the following output:

All settings correct for using Composer
Downloading...

Composer (version 2.2.6) successfully installed to: /usr/local/bin/composer
Use it: php /usr/local/bin/composer

# Once the installation is completed, verify the Composer version with the following command:
composer -V

# You will get the following output:
Composer version 2.2.6 2022-02-04 17:00:38

### How can I resolve "Your requirements could not be resolved to an installable set of packages" error?
composer install --ignore-platform-reqs
