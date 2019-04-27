ARG TAG=1.10

FROM nginx:$TAG

LABEL maintainer="Fabrizio Cafolla <info@fabriziocafolla.com>"

# ADD data in image when build
ADD ./nginx/vhosts.conf /etc/nginx/conf.d/default.conf
