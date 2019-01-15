echo "Step 1/4: workspace chgrp www-data -R /var/www && chmod 775 -R /var/www && chmod g+s /var/www"
docker-compose exec workspace chgrp www-data -R /var/www && chmod 775 -R /var/www && chmod g+s /var/www

echo "Step 2/4: composer install"
docker-compose exec workspace composer install

echo "Step 3/4: cp .env.example .env"
docker-compose exec workspace cp .env.example .env

echo "Step 4/4: php artisan jwt:secret"
docker-compose exec workspace php artisan jwt:secret

echo "Finish setup"