#!/usr/bin/env bash

/opt/phing/orocrm/vendor/bin/phing init-daemon \
    -f /opt/phing/orocrm/build.xml \
    -Dsupervisor.daemon=cron \
    -Dsymfony.env=${SYMFONY_ENV} \
    -Dapp.dir=${OROCRM_ROOT_DIR} \
    -debug \
&& /opt/phing/orocrm/vendor/bin/phing init-cron \
    -f /opt/phing/orocrm/build.xml \
    -Dsymfony.env=${SYMFONY_ENV} \
    -Dapp.dir=${OROCRM_ROOT_DIR} \
     -debug || exit

while [ -z "$(grep -P "installed\:\s\'\d{4}\-\d{2}\-\d{2}T\d{2}:\d{2}:\d{2}" ${OROCRM_ROOT_DIR}/app/config/parameters.yml)" ]; do
    echo "Cron: waiting for symfony installed"
    sleep 1
done

cron -f -L 15