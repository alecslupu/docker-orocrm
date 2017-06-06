FROM hellosworldos/webserver:xenial
MAINTAINER Yury Ksenevich <yury@spadar.com>

# Add init scripts
ADD bin/orocrm-webserver-run.sh /usr/local/bin/orocrm-webserver-run.sh
ADD bin/orocrm-install-app.sh /usr/local/bin/orocrm-install-app.sh

RUN chmod +x /usr/local/bin/orocrm-*.sh

#Initialize phing
ADD phing /opt/phing

RUN cd /opt/phing \
    && composer update

# Install node.js
RUN curl -sL https://deb.nodesource.com/setup_${NODEJS_VERSION} | bash - \
    && apt-get -y update --fix-missing \
    && apt-get -y upgrade \
    && apt-get install -y nodejs

ADD etc/nginx/conf.d/orocrm.conf /etc/nginx/conf.d/orocrm.conf.dist

CMD orocrm-webserver-run.sh