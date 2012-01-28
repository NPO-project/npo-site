#!/bin/sh
wget http://framework.zend.com/releases/ZendFramework-1.11.11/ZendFramework-1.11.11.tar.gz
tar -xf ZendFramework-1.11.11.tar.gz
mkdir ../../libs
mv ZendFramework-1.11.11/library/Zend/ ../../libs 
rm -R ZendFramework-1.11.11*
