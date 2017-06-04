#!/usr/bin/env bash

/opt/phing/vendor/bin/phing init-webserver -f /opt/phing/build.xml && /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
