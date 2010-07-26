<?php
/**
 * Some useful functions.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.2.0
 * @package org.genitis.yuki
 */

/**
 * Redirects to the URL given in $location where $type is the HTTP status code
 * and $search is a string which contains keywords that will be sent in
 * $_GET['s'].
 *
 * This function always ends the execution of the current script.
 *
 * @param int $type HTTP status code
 * @param string $location URL that will be redirected to
 * @param string $search string with keywords. Slashes and '%20' serve as
 *     seperators.
 */
function redirect($type, $location, $search = FALSE) {
	switch ($type) {
		case 301: header('HTTP/1.1 301 Moved Permanently'); break;
		case 307: header('HTTP/1.1 307 Temporary Redirect'); break;
		case 404: header('HTTP/1.1 404 Not Found'); break;
	}
	header('Location: /'.$location.($search != FALSE ? '?s='.trim(strtr($search, array('/' => '+', '%20' => '+')), '+') : ''));
	exit;
}

/**
 * Loads the modules in the given array.
 *
 * @param &array array of strings with path strings relative to 'lib/mod/'.
 */
function load_modules(&$modules) {
	foreach ($modules as $mod) {
		require_once 'mod/'.$mod;
	}
}

///**
// * This class enables you to get real uuids using the OSSP library.
// * Note you need php-uuid installed.
// *
// * @author Marius Karthaus, Paul Vorbach
// */
//class uuid {
//
//	protected $uuidobject;
//
//	/**
//	 * On long running deamons i've seen a lost resource. This checks the resource and creates it if needed.
//	 */
//	protected function create() {
//		if (!is_resource($this->uuidobject)) {
//			uuid_create(&$this->uuidobject);
//		}
//	}
//
//	/**
//	 * Return a type 5 (SHA-1 hash) uuid
//	 *
//	 * @return string
//	 */
//	public function uuid_v5() {
//		$this->create();
//		uuid_make($this->uuidobject, UUID_MAKE_V5);
//		uuid_export($this->uuidobject, UUID_FMT_STR, &$uuidstring);
//		return trim($uuidstring);
//	}
//}
