FROM phpdockerio/php80-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN  apt-get update
RUN  apt-get install -y curl
RUN  curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN  apt-get -y --no-install-recommends install git wget php-memcached php-xdebug php-yaml
RUN  apt-get -y --no-install-recommends install php-mysql
RUN  apt-get -y --no-install-recommends install php8.0-mysql
RUN  apt-get -y --no-install-recommends install php8.1-mysql
RUN  apt-get -y --no-install-recommends install php-curl
RUN  apt-get -y --no-install-recommends install php8.0-bcmath
RUN  apt-get -y --no-install-recommends install php8.1-bcmath
RUN  apt-get -y --no-install-recommends install php-bcmath php-mbstring php-gmp php-gd php-intl

#    && apt-get -y --no-install-recommends install git wget php-memcached php7.2-mbstring php7.2-dom php7.2-curl php7.2-memcache php7.2-mysql php-xdebug php7.2-bcmath php7.2-gd php7.2-gmp php7.2-zip php7.2-intl php-yaml \
#    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

