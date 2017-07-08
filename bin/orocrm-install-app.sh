#!/usr/bin/env bash

runuser -s /bin/sh -c '/opt/phing/orocrm/vendor/bin/phing install-app -f /opt/phing/orocrm/build.xml -debug' www-data

