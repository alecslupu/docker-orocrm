#!/usr/bin/env bash

/opt/phing/orocrm/vendor/bin/phing init-webserver \
    -f /opt/phing/orocrm/build.xml \
    -Dsymfony.env=${SYMFONY_ENV} \
    -Dapp.dir=${OROCRM_ROOT_DIR} \
&& /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
