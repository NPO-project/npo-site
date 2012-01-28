#!/bin/sh
pyrus channel-discover packages.zendframework.com
pyrus install zf2/Zend_Framework#Standard
phpenv rehash
