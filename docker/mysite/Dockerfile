FROM ubuntu

ENV LANGUAGE=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8

# Set to noninteractive so that apt-get won't wait for user input
ENV DEBIAN_FRONTEND=noninteractive

# base packages
RUN apt-get update \
    &&  apt-get install -y make less lsof vim htop dnsutils iputils-ping mysql-client sudo curl nmap iproute2 procps gpg \
    software-properties-common wget build-essential autoconf libtool net-tools

# set timezone
RUN ln -fs /usr/share/zoneinfo/Asia/Bangkok /etc/localtime \
    && apt-get -y install tzdata \
    && dpkg-reconfigure --frontend noninteractive tzdata

### install php
RUN apt-get install -y php8.1-fpm php8.1-curl php8.1-dev php8.1-mbstring php8.1-mysql php8.1-readline php8.1-sqlite3  \
    php8.1-bcmath php8.1-dba php8.1-mongodb php8.1-msgpack php8.1-oauth php8.1-ps php8.1-redis php8.1-uuid  \
    php8.1-xdebug php8.1-yaml php8.1-zip

# set uid and guid for www-data to 1000 (to avoid conflict with host machine)
RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

### install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

### install Nginx
RUN apt-get install -y nginx

### install MySQL
RUN apt-get install -y mysql-server mysql-client
# allow listen all interfaces
RUN grep -rl bind-address /etc/mysql | xargs sed -i "s/bind-address.*/bind-address = 0.0.0.0/"

# create user and grant privileges
ARG MYSQL_USER=user
ARG MYSQL_PASSWORD=userpass
RUN service mysql start && \
        { \
            echo "CREATE USER '${MYSQL_USER}'@'%' IDENTIFIED BY '${MYSQL_PASSWORD}';"; \
            echo "GRANT ALL PRIVILEGES ON  *.* to '${MYSQL_USER}'@'%' WITH GRANT OPTION;"; \
            echo "FLUSH PRIVILEGES;"; \
        } | mysql -uroot

# install Redis
RUN apt-get install -y redis-server

WORKDIR /app

# start services and run init script
CMD service php8.1-fpm start \
    && service nginx start \
    && service mysql start \
    && service redis-server start \
    && php ./docker/mysite/runscript.php
