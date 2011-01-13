<?php
/**
 * This file includes requested HTML files.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package org.genitis.yuki
 */

define('DIR_SEP', DIRECTORY_SEPARATOR);
define('DIR_PUB', dirname(__FILE__).DIR_SEP);

// Requires conf.php
require DIR_PUB.'.conf.php';
require DIR_LIB.'functions.php';

$url = $_GET['url']; // request

// Check for GET parameter 'file'
if (isset($_GET['file'])) {
	// Load necessary modules
	load_modules($modules);
	// Include file
	get_file($url);
}
// Check for GET parameter 'dir'
elseif (isset($_GET['dir'])) {
	// Load necessary modules
	load_modules($modules);
	// Include dir
	get_dir($url);
}
// Check for GET parameter 'err'
elseif (isset($_GET['err'])) {
	require_once DIR_PUB.'.redirect.php';

	// If a redirection for $url is defined, make a redirect as defined.
	if (isset($redirections[$url]))
		redirect(301, $redirections[$url]);
	// Otherwise redirect to a 404 error.
	else
		redirect(404, ERROR_404, $url);
}
