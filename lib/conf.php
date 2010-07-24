<?php
/**
 * Configuration file
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
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki
 */

define('ERROR_PAGE_404', 'error/404/');
define('USES_MULTIPLE_LANGUAGES', FALSE);
define('DEFAULT_LANG', 'de');

$file_ext = array(
	'.html',
	'.php'
);
