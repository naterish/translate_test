echo "Install nginx \n"
apt-get install nginx -y
echo "Nginx installed \n"
echo "Move nginx config"
mv ./nginx/y-translate.conf /etc/nginx/sites-enabled/y-translate.conf
mv ./nginx/g-translate.conf /etc/nginx/sites-enabled/g-translate.conf
nginx -t
service nginx restart
echo "Nginx configurated"
echo "Install php5 fpm"
apt-get install php5-fpm -y
echo "Install php5 fpm installed"
mkdir -p /var/www/php/g-translate
mkdir -p /var/www/php/y-translate
chmod 777 /var/www/php
mv ./g-translate/index.php /var/www/php/g-translate/index.php
mv ./y-translate/index.php /var/www/php/y-translate/index.php

