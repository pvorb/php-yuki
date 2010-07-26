<?php
/**
 * This file grabs needed html files.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki
 */

// Requires conf.php
require_once '../lib/conf.php';

// Set $_GET['q'] as $path, default is ''.
$path = '';
if (isset($_GET['q'])) {
	$path = $_GET['q'];
	unset($_GET['q']);
}

// Requires functions.php
require_once '../lib/functions.php';

// Set $content and $index
if ($path == '') {
	$content = '.'; // does never exist
	$index = 'index';
} elseif (strrpos($path, 'index/') === 0) {
	// Redirect to a 404 error, no content file has been found
	redirect(404, ERROR_PAGE_404, $path);
} else {
	$index = $path.'index';
	$content = rtrim($path, '/'); // remove trailing slash
}

if (USES_MULTIPLE_LANGUAGES) {
	// Set a language
	$lang = 'de';
	if (isset($_GET['lang'])) {
		$lang = $_GET['lang'];
		unset($_GET['lang']);
	}

	// Append .$lang to $file_path
	$content .= '.'.$lang;
	$index .= '.'.$lang;
} elseif (isset($_GET['lang'])) {
	redirect(301, $path);
}

// Load all modules.
load_modules();

// Try to include the file with different file endings with the order that was
// specified in lib/conf.php in variable $file_ext.
for ($i = 0; $i < sizeof($file_ext); $i++) {
	// Append file extension
	$content_path = $content.$file_ext[$i];
	$index_path = $index.$file_ext[$i];


	// Include content
	if (file_exists($content_path)) {
		include $content_path;
		exit;
	} elseif (file_exists($index_path)) {
		include $index_path;
		exit;
	}
}

// Redirections
include '../lib/redirections.php';
if (isset($redirections[$path]))
	redirect(301, $redirections[$path]);

// Redirect to a 404 error, no content file has been found
redirect(404, ERROR_PAGE_404, $path);
