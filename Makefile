include config.mk

SRC_DIR = src
BUILD_DIR = build

PREFIX = /var/www/npo-site
DIST_DIR = $(PREFIX)


DB_WORLDPREFIX = $(TW_SERVER)_$(TW_WORLD)_

conf: checkconf buildconf
install: check buildapp injectzf installapp 
uninstall:
	@@rm -R $(DIST_DIR)

checkconf:
ifeq (, $(and $(SERVER_ADMIN),$(SERVER_NAME)))
	@@echo 'incomplete config.mk' >&2 
	@@false
endif
	@@mkdir -p $(BUILD_DIR)/httpd

check:
ifeq (, $(and $(TW_WORLD),$(TW_SERVER),$(HTTPD_USER),$(ENV)))
	@@echo 'incomplete config.mk' >&2 
	@@false
endif
	@@mkdir -p $(BUILD_DIR)/dl
	@@mkdir -p $(BUILD_DIR)/out

buildconf:
	@@cp -R httpd/* $(BUILD_DIR)/httpd/
	@@find $(BUILD_DIR)/httpd/ -name "*.*" -exec sed -i "s/{ENV}/$(ENV)/g;s/{SERVER_ADMIN}/$(SERVER_ADMIN)/g;s/{SERVER_NAME}/$(SERVER_NAME)/g;s/{DIST_DIR}/$(echo $(DIST_DIR) | sed -e 's/\\/\\\\/g' -e 's/\//\\\//g' -e 's/&/\\\&/g')/g" '{}' \;

buildapp:
	@@echo 'Building NPO-site...'
	@@cp -R src/* $(BUILD_DIR)/out/
	@@find $(BUILD_DIR)/out/ -name "*.*" -exec sed -i 's/{DB_PREFIX}/$(DB_PREFIX)/g;s/{DB_NAME}/$(DB_NAME)/g;s/{DB_USER}/$(DB_USER)/g;s/{DB_PASS}/$(DB_PASS)/g;s/{DB_NAME}/$(DB_NAME)/g;s/{DB_WORLDPREFIX}/$(DB_WORLDPREFIX)/g' '{}' \; 

injectzf: $(BUILD_DIR)/dl/ZendFramework-1.11.11/bin/zf.sh
	@@echo 'Injecting Zend Framework Library...'
	@@mkdir -p $(BUILD_DIR)/out/library
	@@cp -R $(BUILD_DIR)/dl/ZendFramework-1.11.11/library/Zend $(BUILD_DIR)/out/library/

$(BUILD_DIR)/dl/ZendFramework-1.11.11.tar.gz:
	@@echo 'Downloading Zend Framework...'
	@@wget --output-document $(BUILD_DIR)/dl/ZendFramework-1.11.11.tar.gz http://framework.zend.com/releases/ZendFramework-1.11.11/ZendFramework-1.11.11.tar.gz

$(BUILD_DIR)/dl/ZendFramework-1.11.11/bin/zf.sh: $(BUILD_DIR)/dl/ZendFramework-1.11.11.tar.gz
	@@[ -d $(BUILD_DIR)/dl/ZendFramework-1.11.11/library/Zend ] || ( echo 'Unpacking Zend Framework...'; cd $(BUILD_DIR)/dl && tar -xzf ZendFramework-1.11.11.tar.gz )

installapp:
	@@echo 'Installing NPO-site...'
	@@mkdir -p $(DIST_DIR)
	@@cp -R $(BUILD_DIR)/out/* $(DIST_DIR)
	@@rm -R $(BUILD_DIR)/out
	@@chown -R $(HTTPD_USER) $(DIST_DIR) 
	@@chmod -R a-rwx $(DIST_DIR)
	@@chmod -R u+rx $(DIST_DIR)
