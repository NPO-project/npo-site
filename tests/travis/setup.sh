#!/bin/bash

export DB_NAME=npo
export DB_PREFIX=npo_
export DB_USER=postgres
export DB_PASS=npodev

export SERVER_NAME=test.npo.tribalwars
export SERVER_ADMIN=npo.tribalwars@gmail.com

export SMTP_HOST=smtp.gmail.com
export SMTP_USER=npo.tribalwars@gmail.com
export SMTP_PASS=npodev12
export SMTP_FROM=npo.tribalwars@gmail.com

export HTTPD_USER=apache

export ENV=development

make
#sh tests/travis/setup-zend.sh
