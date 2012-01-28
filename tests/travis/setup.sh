#!/bin/sh
pear channel-discover zend.googlecode.com/svn
pear install zend/zend
phpenv rehash
