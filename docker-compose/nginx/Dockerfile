ARG TAG=1.15.12-alpine

FROM nginx:$TAG

LABEL maintainer="Fabrizio Cafolla <info@fabriziocafolla.com>"

# ADD data in image when build
ADD ./nginx/vhosts.conf /etc/nginx/conf.d/default.conf
