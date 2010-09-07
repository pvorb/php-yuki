<?php
/**
 * Some useful functions.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.3.0
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
 * @param array $array array of strings with path strings relative to 'lib/mod/'.
 */
function load_modules(&$modules) {
	foreach ($modules as $mod) {
		require_once 'mod/'.$mod;
	}
}

$san_str_replacement = array(
	'<!--'       => '&lt;!--',
	'-->'        => '--&gt;',
	'<![CDATA['  => '&lt;![CDATA[',
	'<?'         => '&lt;?',
	'?>'         => '?&gt;'
);

$san_regex_replacement = array(
	'javascript\s*:'            => '[removed]',
	'expression\s*(\(|&\#40;)'  => '[removed]',
	'vbscript\s*:'              => '[removed]',
	'Redirect\s+302'            => '[removed]'
);

define('PREG_EMAIL', '#^(mailto:)?[._-[:alphanum:]]+@([[:alphanum:]]+\.)*[[:alphanum:]]\.[[:alphanum:]]+$#i');
define('PREG_URL', '');

/**
 * Sanitizes the HTML contents of a user entry.
 * @param string $html
 * @return string
 */
function sanitize_user_html(&$html) {
}

/**
 * Sanitizes a string so that it only accepts alpha-numeric characters.
 * @param string $string
 * @return string
 */
function sanitize_alphanum(&$string) {
	if (!is_string($string))
		$string = strval($string);

	return $string;
}

/**
 * Sanitizes a string so that it only accepts url characters.
 * @param string $url
 * @return string
 */
function sanitize_url(&$url) {
	if (!is_string($url))
		$url = strval($url);

	// if there’s no protocol given
	if (!match_protocol($url)) {
		// if it’s an email adress
		if (strpos($url, '@'))
			$url = sanitize_email($url);
		else
			$url = 'http://'.$url;
	}

	return htmlspecialchars($url);
}

/**
 * Sanitizes a string so that it only accepts email characters.
 * @param string $email
 * @return string
 */
function sanitize_email(&$email) {
	if (!is_string($email))
		$email = strval($email);

	if (stripos($email, 'mailto:') !== 0)
		$email = 'mailto:'.$email;

	return htmlspecialchars($email);
}

function match_protocol(&$protocol) {
	return preg_match('#^([[:alpha:]]+://|mailto:)#i', $protocol) ? TRUE : FALSE;
}

/**
 * Matches strings that contain an IP adress.
 * @param $ip IP adress string
 * @return TRUE or FALSE
 */
function match_ip(&$ip) {
	return preg_match('#(\d{0,3}\.){3}\d{0,3}#i', $ip) ? TRUE : FALSE;
}

/**
 * Returns the current date as defined in DATE_FORMAT.
 * @return string
 */
function current_date() {
	return date(DATE_FORMAT);
}

/**
 * Return the current time as defined in TIME_FORMAT.
 * @return string
 */
function current_time() {
	return date(TIME_FORMAT);
}
