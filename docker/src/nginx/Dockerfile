FROM nginx:stable

ENV DEBIAN_FRONTEND noninteractive

# setup nginx
ADD docker/src/nginx/vhost.conf /etc/nginx/conf.d/default.conf
ADD docker/src/nginx/nginx.conf /etc/nginx/nginx.conf

# add project files
ADD ./ /app
