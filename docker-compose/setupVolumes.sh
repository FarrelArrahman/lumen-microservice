echo "Step 1/2: create redis volume"
docker volume create --driver local \
--opt type=nfs \
redis_dump

echo "Step 2/2: mysql volume"
docker volume create --driver local \
--opt type=nfs \
mysql_dump

echo "Finish setup volumes"