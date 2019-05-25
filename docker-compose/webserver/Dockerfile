ARG TAG=1.15.12-alpine

FROM nginx:$TAG

MAINTAINER Fabrizio Cafolla developer@fabriziocafolla.com

# ADD data in image when build
ADD ./webserver/vhosts.conf /etc/nginx/conf.d/default.conf
