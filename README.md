
<h1><p align="center">Instalação do Servidor Laravel <b>5.8</b></p></h1>
<p align="center">Sugestão de instalação no Ubuntu 20.04 LTS
<img src="https://dhx0ny5rxatah.cloudfront.net/lightsail-assets-Prod/ubuntu-d2a08053183d05a1629719331b152a44.png" width=40 height=40></p>


## Apache e Php7.4

```
sudo apt-get update
```
```
sudo apt -y install software-properties-common
```
```
sudo add-apt-repository ppa:ondrej/php
```
```
sudo apt-get update
```
```
apt install apache2 -y
```
```
sudo apt -y install php7.4
```
```
sudo apt-get install -y php7.4-cli php7.4-json php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath
```
```
sudo apt-get install -y php7.4-xmlrpc php7.4-soap php7.4-gd php7.4-xml php7.4-cli php7.4-zip 
```
```
sudo apt-get install -y php7.4-intl php7.4-json php7.4-mbstring php7.4-mysql php7.4-opcache php7.4-readline php7.4-xml php7.4-xsl php7.4-zip php7.4-bz2 libapache2-mod-php7.4

```


## Mariadb / mysql

```
apt install mariadb-server mariadb-client -y
```
```
sudo mysql_secure_installation 
```

## Composer
```
curl -sS https://getcomposer.org/installer | php 
```
```
sudo mv composer.phar /usr/local/bin/composer 
```

## Laravel 5.8

```
cd /var/www/html 
```
```
sudo composer create-project --prefer-dist laravel/laravel blog "5.8.*"
```
```
sudo nano /etc/apache2/sites-available/laravel.conf 
```
```
<VirtualHost *:80>
    ServerName laravel.example.com
    ServerAdmin webmaster@example.com

    DocumentRoot /var/www/html/labeduc/public

    <Directory /var/www/html/labeduc>
        AllowOverride All
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
```
sudo a2ensite laravel.conf
```
```
sudo a2dissite 000-default.conf 
```
```
sudo a2enmod rewrite 
```
```
sudo systemctl restart apache2 
```
```
cd /var/www/html/labeduc>
```
```
cp .env.example .env
```
```
php artisan key:generate
```
```
sudo chown -R www-data:www-data /var/www/html/labeduc/
```

## Clone repositório

```
git clone https://github.com/LabirintoEducacao/webServLabirinto.git
```
```
mv webServLabirinto labeduc
```
dentro da pasta labeduc rodar composer
```
composer install
```
```
composer update
```
Criar banco de dados "labirinto2" depois executar o comando abaixo
```
php artisan migrate:fresh --seed
```

## License

This is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
