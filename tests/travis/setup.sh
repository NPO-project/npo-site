#!/bin/sh
wget http://pear.php.net/go-pear.phar
php go-pear.phar
pear channel-discover zend.googlecode.com/svn
pear install zend/zend
phpenv rehash
