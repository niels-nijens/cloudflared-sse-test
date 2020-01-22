FROM nginx:1.15

WORKDIR /var/www

# Add Nginx configuration.
COPY ./.docker/nginx/security.conf /etc/nginx/
COPY ./.docker/nginx/performance.conf /etc/nginx/
COPY ./.docker/nginx/mime.types /etc/nginx/mime.types
COPY ./.docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy source into container.
COPY public /var/www/public
