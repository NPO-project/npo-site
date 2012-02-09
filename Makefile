SHELL = /bin/bash

# --------------------
# DIRECTORY PARAMETERS
# --------------------
SRC_DIR = src
BUILD_DIR = build

PREFIX = /var/www/npo-site
HTTPD_CONF_DIR = /etc/httpd/conf.d
DIST_DIR = $(PREFIX)

# ----------------------
# APPLICATION PARAMETERS
# ----------------------
# DB_PREFIX     | The database table prefix
# DB_NAME       | The database name
# DB_USER       | The database's user
# DB_PASS       | The database user's password
# SERVER_ADMIN  | The server admin's email address
# SERVER_NAME   | The server's fully qualified domain name
# HTTPD_USER    | The system's httpd user
# ENV           | Application environment

# --------
# COMMANDS
# --------
ESC_DIST_DIR = `echo '$(DIST_DIR)' | sed 's/\\//\\\\\\//g'`
SQLEXEC = export PGPASSWORD=$(DB_PASS); psql -q --username $(DB_USER) -f
SQLBUILD = sed -i 's/{DB_NAME}/$(DB_NAME)/g;s/{DB_PREFIX}/$(DB_PREFIX)/g'
CONFBUILD = sed -i "s/{ENV}/$(ENV)/g;s/{SERVER_ADMIN}/$(SERVER_ADMIN)/g;s/{SERVER_NAME}/$(SERVER_NAME)/g;s/{DIST_DIR}/$(ESC_DIST_DIR)/g"
PHPBUILD = sed -i 's/{DB_PREFIX}/$(DB_PREFIX)/g;s/{DB_NAME}/$(DB_NAME)/g;s/{DB_USER}/$(DB_USER)/g;s/{DB_PASS}/$(DB_PASS)/g;s/{DB_NAME}/$(DB_NAME)/g;s/{SMTP_USER}/$(SMTP_USER)/g;s/{SMTP_PASS}/$(SMTP_PASS)/g;s/{SMTP_HOST}/$(SMTP_HOST)/g;s/{SMTP_FROM}/$(SMTP_FROM)/g'

# ----------
# MAIN RULES
# ----------
all: check buildconf buildsql buildapp injectzf injectdoctrine
install: installsql installapp installconf
uninstall: uninstallconf uninstallsql uninstallapp

# -----------
# CHECK RULES
# -----------
check:
ifeq (, $(and $(DB_NAME),$(DB_USER),$(DB_PASS),$(SMTP_HOST),$(SMTP_USER),$(SMTP_PASS),$(SERVER_NAME),$(SERVER_ADMIN),$(HTTPD_USER),$(ENV)))
	@@echo 'Please set the environment variables DB_NAME, DB_PASS, SERVER_NAME, SERVER_ADMIN, HTTPD_USER, ENV, SMTP_HOST, SMTP_USER and SMTP_PASS' >&2 
	@@echo 'A example can be found on https://github.com/NPO-project/npo-site/blob/master/tests/travis/setup.sh' >&2
	@@false
endif
	@@[ -d $(BUILD_DIR)/www ] && rm -Rf $(BUILD_DIR)/www/* || mkdir -p $(BUILD_DIR)/www
	@@[ -d $(BUILD_DIR)/conf ] && rm -Rf $(BUILD_DIR)/conf/* || mkdir -p $(BUILD_DIR)/conf
	@@[ -d $(BUILD_DIR)/sql ] && rm -Rf $(BUILD_DIR)/sql/* || mkdir -p $(BUILD_DIR)/sql
	@@[ -d $(BUILD_DIR)/dl ] || mkdir -p $(BUILD_DIR)/dl

# -----------
# BUILD RULES
# -----------
buildconf:
	@@echo 'Building HTTPD configuration...'
	@@cp -R httpd/* $(BUILD_DIR)/conf/
	@@find $(BUILD_DIR)/conf/ -name "*.conf" -exec $(CONFBUILD) '{}' \;

buildsql:
	@@echo 'Building database metaschema...'
	@@cp -R sql/* $(BUILD_DIR)/sql/
	@@find $(BUILD_DIR)/sql/ -name "*.sql" -exec $(SQLBUILD) '{}' \;

buildapp:
	@@echo 'Building NPO-site...'
	@@cp -R src/* $(BUILD_DIR)/www/
	@@find $(BUILD_DIR)/www/ -name "*.*" -exec $(PHPBUILD) '{}' \;

# --------------------
# ZEND FRAMEWORK RULES
# --------------------
injectzf: unpackzf
	@@echo 'Injecting Zend Framework Library...'
	@@cp -R $(BUILD_DIR)/dl/ZendFramework-1.11.11/library/Zend $(BUILD_DIR)/www/library/

unpackzf: $(BUILD_DIR)/dl/ZendFramework-1.11.11.tar.gz
	@@[ -d $(BUILD_DIR)/dl/ZendFramework-1.11.11/library/Zend ] || ( echo 'Unpacking Zend Framework...'; cd $(BUILD_DIR)/dl && tar -xzf ZendFramework-1.11.11.tar.gz )

$(BUILD_DIR)/dl/ZendFramework-1.11.11.tar.gz:
	@@echo 'Downloading Zend Framework...'
	@@wget --output-document $(BUILD_DIR)/dl/ZendFramework-1.11.11.tar.gz http://framework.zend.com/releases/ZendFramework-1.11.11/ZendFramework-1.11.11.tar.gz

# --------------
# DOCTRINE RULES
# --------------
injectdoctrine: unpackdoctrine
	@@echo 'Injecting Doctrine Library...'
	@@cp -R $(BUILD_DIR)/dl/DoctrineORM-2.2.0/Doctrine $(BUILD_DIR)/www/library/

unpackdoctrine: $(BUILD_DIR)/dl/Doctrine-2.2.0-full.tar.gz
	@@[ -d $(BUILD_DIR)/dl/DoctrineORM-2.2.0/Doctrine ] || ( echo 'Unpacking Doctrine...'; cd $(BUILD_DIR)/dl && tar -xzf Doctrine-2.2.0-full.tar.gz )

$(BUILD_DIR)/dl/Doctrine-2.2.0-full.tar.gz:
	@@echo 'Downloading Doctrine...'
	@@wget --output-document $(BUILD_DIR)/dl/Doctrine-2.2.0-full.tar.gz http://www.doctrine-project.org/downloads/DoctrineORM-2.2.0-full.tar.gz

# -------------
# INSTALL RULES
# -------------
installapp:
	@@echo 'Installing NPO-site...'
	@@mkdir -p $(DIST_DIR)
	@@cp -R $(BUILD_DIR)/www/* $(DIST_DIR)
	@@chown -R $(HTTPD_USER) $(DIST_DIR) 
	@@chmod -R a-w+rx $(DIST_DIR)
	@@chmod -R u+w $(DIST_DIR)

installsql:
	@@echo 'Installing database...'
	@@$(SQLEXEC) $(BUILD_DIR)/sql/create.sql

installconf:
	@@echo 'Installing configuration...'
	@@cp $(BUILD_DIR)/conf/vhost.conf $(HTTPD_CONF_DIR)/$(SERVER_NAME).conf
	@@chmod -R a-w+rx $(HTTPD_CONF_DIR)/$(SERVER_NAME).conf

# ---------------
# UNINSTALL RULES
# ---------------
uninstallapp:
	@@echo 'Removing NPO-site...'
	@@rm -Rf $(DIST_DIR)

uninstallsql:
	@@echo 'Removing database...'
	@@$(SQLEXEC) $(BUILD_DIR)/sql/drop.sql

uninstallconf:
	@@echo 'Removing configuration...'
	@@[ -f $(HTTPD_CONF_DIR)/$(SERVER_NAME).conf ] && rm -Rf $(HTTPD_CONF_DIR)/$(SERVER_NAME).conf || true

# ----------
# TEST RULES
# ----------
test: all
	@@cd tests && phpunit --colors
