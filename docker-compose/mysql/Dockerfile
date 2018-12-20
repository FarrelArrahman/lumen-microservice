ARG TAG

FROM mysql:$TAG

LABEL maintainer="Fabrizio Cafolla <info@fabriziocafolla.com>"

# ADD data in image when build
VOLUME ./docker-compose/volumes/mysql/ /var/lib/mysql
