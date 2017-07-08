#!/usr/bin/env bash

if [ -z $1 ]; then
    echo "Command line: orocrm-mount-module.sh vendor/module-name"
    exit
fi

runuser -s /bin/sh -c "/opt/phing/vendor/bin/phing orocrm-mount-module -f /opt/phing/orocrm/build.xml -Dbundle.dir=${OROCRM_BUNDLE_DIR} -Dbundle.name=${1} -debug" www-data

