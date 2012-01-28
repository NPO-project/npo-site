#!/bin/sh
pyrus.phar . channel-discover packages.zendframework.com
pyrus.phar . install zf2/Zend_Framework#Standard
phpenv rehash
