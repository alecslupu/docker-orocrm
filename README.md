# docker-orocrm
Containers for OroCRM bundle development

[![Build Status](https://travis-ci.org/hellosworldos/docker-orocrm.svg?branch=master)](https://travis-ci.org/hellosworldos/docker-orocrm)

## Dev environment Installation

* Pull the repository
* Copy `.env.dev` to `.env` and adjust your project specific params
* Run containers `docker-compose up -d`
* Install Orocrm in your directory if not installed with commamd: `docker-compose exec orocrm orocrm-install-app.sh`

