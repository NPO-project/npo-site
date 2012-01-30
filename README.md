# NPO Site

NPO site covers the web frontend, http API and database backend of the NPO project. The code is developed to run on one server per associated TW World. In order to build the project you need to set some parameters during the make process.

## Installation
The installation of NPO Site should be straightforward using GNU Make, but at the moment some stuff is quickly parameterized. The usual installation procedure should be:
    $ make
    $ sudo make install

And the uninstall procedure would be:
    $ sudo make uninstall

Unfortunately, our installation requires a bunch of parameters, which should be supplied with the make command. The complete command to build, uninstall an old version and install the new version can be done via the following shell script:
    #!/bin/bash
    PARAMS="DB_NAME=npo DB_PREFIX=npo_ DB_USER=postgres DB_PASS=npodev SERVER_NAME=devel.npo.local SERVER_ADMIN=admin@npo.local HTTPD_USER=www-data ENV=development"
    make $PARAMS
    sudo make uninstall $PARAMS
    sudo make install $PARAMS

## Dependencies

### Server
NPO Site`s installation (GNU Make) is targetted at Linux server environments, but can be tweaked to work on other operating systems. The system should run an Apache2 web server, a PHP interpreter (version 5.3 or up) and a PostgreSQL server (version 8.3 or up).

### PHP
The project depends on two large libraries: Zend Framework 1.11 and Doctrine 2.2. The build automatically fetches, unpacks and injects these libraries in the project when using the GNU Make builder.
