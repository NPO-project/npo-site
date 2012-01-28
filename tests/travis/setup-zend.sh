#!/bin/sh
cd tests/travis
wget http://framework.zend.com/releases/ZendFramework-1.11.11/ZendFramework-1.11.11.tar.gz
tar -xf ZendFramework-1.11.11.tar.gz
mkdir -p ../../library
mv ZendFramework-1.11.11/library/Zend/ ../../library
rm -R ZendFramework-1.11.11*
