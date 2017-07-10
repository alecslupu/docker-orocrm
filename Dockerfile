FROM hellosworldos/webserver:xenial
MAINTAINER Yury Ksenevich <yury@spadar.com>

# Add init scripts
ADD bin/orocrm-*.sh /usr/local/bin/

RUN chmod +x /usr/local/bin/orocrm-*.sh

#Initialize phing
ADD phing /opt/phing/orocrm

RUN cd /opt/phing/orocrm \
    && composer update

# Install node.js
RUN curl -sL https://deb.nodesource.com/setup_${NODEJS_VERSION} | bash - \
    && apt-get -y update --fix-missing \
    && apt-get -y upgrade \
    && apt-get install -y nodejs

ADD etc/nginx/conf.d/orocrm.conf /etc/nginx/conf.d/orocrm.conf.dist
ADD etc/supervisor/conf.d/orocrm-websocket.conf /etc/supervisor/conf.d/orocrm-websocket.conf.dist
ADD etc/supervisor/conf.d/orocrm-message-consumer.conf /etc/supervisor/conf.d/orocrm-message-consumer.conf.dist
ADD etc/supervisor/conf.d/orocrm-cron.conf /etc/supervisor/conf.d/orocrm-cron.conf.dist
ADD etc/cron.d/orocrm.crontab /etc/cron.d/orocrm.crontab.dist

WORKDIR /var/www/orocrm

CMD orocrm-webserver-run.sh