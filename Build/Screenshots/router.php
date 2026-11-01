<?php

// Router for the PHP built-in web server: files that exist are served as
// they are, every other request goes through the TYPO3 entry point.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// The installer compares the host with the server name, which the built-in
// web server takes from the address that it listens on
if (is_file($_SERVER['DOCUMENT_ROOT'] . '/FIRST_INSTALL')) {
    $_SERVER['SERVER_NAME'] = 'localhost';
}
if ($path !== '/' && is_file($_SERVER['DOCUMENT_ROOT'] . $path)) {
    return false;
}
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $_SERVER['DOCUMENT_ROOT'] . '/index.php';
require $_SERVER['SCRIPT_FILENAME'];
