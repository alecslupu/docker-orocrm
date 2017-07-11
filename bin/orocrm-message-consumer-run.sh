#!/usr/bin/env bash

/opt/phing/orocrm/vendor/bin/phing init-daemon \
    -f /opt/phing/orocrm/build.xml \
    -Dsupervisor.daemon=message-consumer \
    -Dsymfony.env=${SYMFONY_ENV} \
    -Dapp.dir=${OROCRM_ROOT_DIR} \
    -debug || exit

while [ -z "$(grep -P "installed:\s'\d{4}\-\d{2}\-\d{2}T\d{2}:\d{2}:\d{2}" ${OROCRM_ROOT_DIR}/app/config/parameters.yml)" ]; do
    echo "Message consumer: waiting for symfony installed"
    sleep 1
done

/usr/bin/supervisord -c /etc/supervisor/supervisord.conf