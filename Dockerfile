FROM php:7.1-cli

# Install dependencies

RUN apt-get update && apt-get install -y \
        libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install app
COPY . /usr/src/dataminer
WORKDIR /usr/src/dataminer

CMD [ "bash"]