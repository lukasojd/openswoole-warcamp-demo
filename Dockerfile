FROM ubuntu:22.04

ARG DEBIAN_FRONTEND=noninteractive


RUN apt-get update &&  \
    apt-get -y install apt-transport-https lsb-release ca-certificates software-properties-common unzip && \
    add-apt-repository ppa:ondrej/php

RUN apt-get update && apt-get install -y  \
    libz-dev  \
    brotli  \
    libzip-dev  \
    php8.2-cli  \
    php8.2-dev  \
    php8.2-mysql  \
    php8.2-sqlite3  \
    php8.2-pgsql  \
    php8.2-redis  \
    php8.2-mbstring  \
    php8.2-xml  \
    php8.2-curl  \
    php8.2-zip  \
    php8.2-bcmath  \
    php8.2-gd  \
    php8.2-intl  \
    php8.2-imagick  \
    php8.2-opcache  \
    php8.2-imap && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install swoole
RUN pecl install openswoole && \
    echo "extension=openswoole.so" > /etc/php/8.2/cli/conf.d/20-swoole.ini

ADD ./run.sh /run.sh
RUN chmod +x /run.sh

WORKDIR /app

ENTRYPOINT ["/run.sh"]