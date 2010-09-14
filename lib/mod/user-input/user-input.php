<?php
/**
 * Descriptive Text goes here...
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki.mod.user-input
 */

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

define('PREG_IP', '#(\d{0,3}\.){3}\d{0,3}#i');
define('PREG_PROTOCOL', '#^([[:alpha:]]+://|mailto:)#i');
define('PREG_EMAIL', '#^(mailto:)?[._\-[:alnum:]]+@([[:alnum:]]+\.)*[[:alnum:]]+\.[[:alnum:]]+$#i');
//define('PREG_URL', '');

/**
 * Matches strings that begin with a protocol.
 * @param string $protocol
 * @return boolean
 */
function validate_protocol(&$protocol) {
	return preg_match('#^([[:alpha:]]+://|mailto:)#i', $protocol) ? TRUE : FALSE;
}

/**
 * Matches strings that seem to be an email address.
 * @param string $email
 * @return boolean
 */
function validate_email(&$email) {
	return preg_match(PREG_EMAIL, $email);
}

/**
 * Sanitizes the HTML contents of a user entry.
 * @param string $html
 * @return string
 */
function sanitize_user_html(&$html) {
	if (!is_string($html))
		$string = strval($html);

	return $html;
}

/**
 * Sanitizes a string so that it only accepts alpha-numeric characters.
 * @param string $string
 * @return string
 */
function sanitize_alphanum(&$string) {
	if (!is_string($string))
		$string = strval($string);

	return htmlspecialchars($string);
}

/**
 * Sanitizes a string to an email adress.
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

/**
 * Sanitizes a string to a (valid) URL.
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
