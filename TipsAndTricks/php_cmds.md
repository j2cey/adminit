### Ubuntu 20 + Install php 8.1

sudo apt install software-properties-common
sudo apt update
sudo add-apt-repository ppa:ondrej/php
````shell
sudo apt install php8.1
````

````shell
sudo apt install php8.1-common php8.1-mysql php8.1-xml php8.1-xmlrpc php8.1-curl php8.1-gd php8.1-imagick php8.1-cli php8.1-dev php8.1-imap php8.1-mbstring php8.1-opcache php8.1-soap php8.1-zip php8.1-redis php8.1-intl -y --fix-missing
sudo apt-get install -y php-tokenizer
````

````shell
sudo apt install openssl php-bcmath php-curl php-json php-mbstring php-mysql php-tokenizer php-xml php-zip
sudo apt install openssl php8.1-bcmath php8.1-curl php8.1-json php8.1-mbstring php8.1-mysql php8.1-tokenizer php8.1-xml php8.1-zip --fix-missing
````

## fpm

sudo apt install php8.1-fpm
php-fpm8.1 -v

sudo a2enmod php8.1
sudo systemctl restart apache2
