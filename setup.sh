echo "1. Directory"
docker-compose exec workspace chgrp www-data -R /var/www && chmod 775 -R /var/www && chmod g+s /var/www
echo "2. Composer install"
docker-compose exec workspace composer install
echo "3. Copy file .env"
docker-compose exec workspace cp .env.example .env
echo "4. Create jwt secret key"
docker-compose exec workspace php artisan jwt:secret
echo "Success setup"