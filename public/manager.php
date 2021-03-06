<?php
/**
 * This file includes requested HTML files.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package org.genitis.yuki
 */

// Requires conf.php
require 'conf.php';
require DIR_LIB.'functions.php';

// Exit, if GET parameter 'url' is not set
if (!isset($_GET['url']))
	exit;

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
	require 'redirect.php';

	// If a redirection for $url is defined, make a redirect as defined.
	if (isset($redirections[$url]))
		redirect(301, $redirections[$url]);
	// Otherwise redirect to a 404 error.
	else
		redirect(404, ERROR_404, $url);
}
