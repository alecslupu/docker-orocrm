# docker-orocrm
Containers for OroCRM bundle development

[![Build Status](https://travis-ci.org/hellosworldos/docker-orocrm.svg?branch=master)](https://travis-ci.org/hellosworldos/docker-orocrm)

## Dev environment Installation

* Pull the repository
* Copy `.env.dev` to `.env` and adjust your project specific params
* Run containers `docker-compose up -d`
* Install Orocrm in your directory if not installed with commamd: `docker-compose exec orocrm orocrm-install-app.sh` (This will clean up previous OroCRM installation if exists)
* Mount your new module with command: `docker-compose exec orocrm orocrm-mount-bundle.sh`
* Adjust `/etc/hosts` add the following line:
```
127.0.0.1   orocrm.dev
```

## .env variables you must change

* `GITHUB_OAUTH_TOKEN` - used to download source code, please setup your key [here](https://github.com/settings/tokens)
* `HOST_OROCRM_ROOT_DIR` - your directory for symfony application sources
* `HOST_OROCRM_BUNDLE_DIR` - your directory for your custom new bundle
* `DEV_USER_ID` and `DEV_GROUP_ID` - check if your local user has id 1000 with `id -u $USER`

## default admin credentials

Admin email: johndoe@example.com
Admin password: admin1111