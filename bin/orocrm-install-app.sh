#!/usr/bin/env bash

runuser -s /bin/sh -c '/opt/phing/vendor/bin/phing install-app -f /opt/phing/build.xml -debug' www-data

