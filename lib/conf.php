<?php
/**
 * Configuration file.
 *
 * The following definitions are possible:
 * ERROR_PAGE_404               path to the 404 error page
 * USES_MULTIPLE_LANGUAGES      TRUE if HTML/PHP files shall be available in
 *                              multiple languages. (for example 'index.en.html'
 *                              and 'index.de.html'
 * DEFAULT_LANG                 any language string (for example 'en')
 *
 * The following variables are possible:
 * $file_ext                    array of strings with all file extensions that
 *                              will be looked up
 * $modules                     array of strings with all file names that shall
 *                              be included relative to the 'lib/mod' folder.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.3
 * @package org.genitis.yuki
 */

// Define important directories.
define('DIR_LIB', dirname(__FILE__));
define('DIR_MOD', DIR_LIB.DIRECTORY_SEPARATOR.'mod');

define('DIR_SEP', DIRECTORY_SEPARATOR);

define('ERROR_PAGE_404', 'error/404/');
define('USES_MULTIPLE_LANGUAGES', FALSE);
define('DEFAULT_LANG', 'en');

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
