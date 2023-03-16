### php requirements
sudo apt install php8.1-common php8.1-mysql php8.1-xml php8.1-xmlrpc php8.1-curl php8.1-gd php8.1-cli php8.1-dev php8.1-imap php8.1-mbstring php8.1-opcache php8.1-soap php8.1-zip php8.1-redis php8.1-intl -y

### 404 not found
#
sudo a2enmod rewrite

# edit apache config file /etc/apache2/apache2.conf
<Directory /var/www/sitefolder/public>
  AllowOverride All
  allow from all
  Options +Indexes
</Directory>

