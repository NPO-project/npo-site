<<<<<<< HEAD
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
=======
# README for a newly created project.

There are a couple of things you should do first, before you can use all of Git's power:

  * Add a remote to this project: in the Cloud9 IDE command line, you can execute the following commands
    `git remote add [remote name] [remote url (eg. 'git@github.com:/ajaxorg/node_chat')]` [Enter]
  * Create new files inside your project
  * Add them to to Git by executing the following command
    `git add [file1, file2, file3, ...]` [Enter]
  * Create a commit which can be pushed to the remote you just added
    `git commit -m 'added new files'` [Enter]
  * Push the commit the remote
    `git push [remote name] master` [Enter]

That's it! If this doesn't work for you, please visit the excellent resources from [Github.com](http://help.github.com) and the [Pro Git](http://http://progit.org/book/) book.
If you can't find your answers there, feel free to ask us via Twitter (@cloud9ide), [mailing list](groups.google.com/group/cloud9-ide) or IRC (#cloud9ide on freenode).

Happy coding!
>>>>>>> 4ad8823f0f7b1437ea66eaf4e365a55185b040d7
