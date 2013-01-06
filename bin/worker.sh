#!/bin/sh

# Yoinked from here:
# http://stackoverflow.com/questions/13309416/zend-framework-console-application

PHP_BIN=`which php`
WDIR=`dirname "${0}"`
if test -x "${PHP_BIN}"; then
    cd "${WDIR}"
    "${PHP_BIN}" "../public/index.php" work
    exit "${?}"
fi
echo "php binary not found, please install php-cli"
exit 1;
