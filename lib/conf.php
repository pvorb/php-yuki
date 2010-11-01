<?php
/**
 * Configuration file.
 *
 * The following definitions are needed:
 * DOMAIN		URL to the domain of the site. Errors will redirect to
 * 				‘DOMAIN/ERROR_404?s=…’.
 * DEFAULT_FILE	default file in a directory that is included.
 * ERROR_404	path to the 404 error page
 * ENDL			character(s) that will be used when inserting a line break.
 * INDENT		character(s) that will be used for indentation.
 * DATE_FORMAT	default date format used by function date.
 * TIME_FORMAT	default time format used by function date.
 *
 * The following variables are needed:
 * $file_ext                    array of strings with all file extensions that
 *                              will be looked for.
 * $modules                     array of strings with all file names that shall
 *                              be included relative to the 'lib/mod' folder.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package org.genitis.yuki
 */
define('DIR_LIB', dirname(__FILE__).DIR_SEP); // Don’t change!

// -----------------
// User definitions:
// -----------------
define('DOMAIN', 'http://localhost');

define('DEFAULT_FILE', 'index');
define('ERROR_404', 'error/404');
define('ENDL', "\n");
define('INDENT', "\t");

define('DATE_FORMAT', 'M d, Y');
define('TIME_FORMAT', 'g:m a');

$file_ext = array(
	'.html',
	'.php'
);

$modules = array(
	'user-input/user-input.php',
	'comment/comment.php',
	'indexing/index.php'
);

require_once 'functions.php';
