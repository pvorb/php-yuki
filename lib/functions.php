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
 * @param array $array array of strings with path strings relative to 'lib/mod/'.
 */
function load_modules(&$modules) {
	foreach ($modules as $mod) {
		require_once 'mod/'.$mod;
	}
}

/**
 * Sanitizes the HTML contents of a user entry.
 * @param string $html
 * @return string
 */
function sanitize_user_html(&$html) {
	// All block level tags
	$block = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|blockquote|address|p|h[1-6]|hr)';

	// Split at <pre>, <script>, <style> and </pre>, </script>, </style> tags.
	// We don't apply any processing to the contents of these tags to avoid messing
	// up code. We look for matched pairs and allow basic nesting. For example:
	// "processed <pre> ignored <script> ignored </script> ignored </pre> processed"
	$chunks = preg_split('@(</?(?:pre|script|style|object)[^>]*>)@i', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
	// Note: PHP ensures the array consists of alternating delimiters and literals
	// and begins and ends with a literal (inserting NULL as required).
	$ignore = FALSE;
	$ignoretag = '';
	$output = '';
	foreach ($chunks as $i => $chunk) {
		if ($i % 2) {
			// Opening or closing tag?
			$open = ($chunk[1] != '/');
			list($tag) = split('[ >]', substr($chunk, 2 - $open), 2);
			if (!$ignore) {
				if ($open) {
					$ignore = TRUE;
					$ignoretag = $tag;
				}
			}
			// Only allow a matching tag to close it.
			else if (!$open && $ignoretag == $tag) {
				$ignore = FALSE;
				$ignoretag = '';
			}
		}
		else if (!$ignore) {
			$chunk = preg_replace('|\n*$|', '', $chunk) ."\n\n"; // just to make things a little easier, pad the end
			$chunk = preg_replace('|<br />\s*<br />|', "\n\n", $chunk);
			$chunk = preg_replace('|(<'. $block .'[^>]*>)|', "\n$1", $chunk); // Space things out a little
			$chunk = preg_replace('|(</'. $block .'>)|', "$1\n\n", $chunk); // Space things out a little
			$chunk = preg_replace("|\n\n+|", "\n\n", $chunk); // take care of duplicates
			$chunk = preg_replace('|\n?(.+?)(?:\n\s*\n|\z)|s', "<p>$1</p>\n", $chunk); // make paragraphs, including one at the end
			$chunk = preg_replace('|<p>\s*</p>\n|', '', $chunk); // under certain strange conditions it could create a P of entirely whitespace
			$chunk = preg_replace("|<p>(<li.+?)</p>|", "$1", $chunk); // problem with nested lists
			$chunk = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $chunk);
			$chunk = str_replace('</blockquote></p>', '</p></blockquote>', $chunk);
			$chunk = preg_replace('!<p>\s*(</?'. $block .'[^>]*>)!', "$1", $chunk);
			$chunk = preg_replace('!(</?'. $block .'[^>]*>)\s*</p>!', "$1", $chunk);
			$chunk = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $chunk); // make line breaks
			$chunk = preg_replace('!(</?'. $block .'[^>]*>)\s*<br />!', "$1", $chunk);
			$chunk = preg_replace('!<br />(\s*</?(?:p|li|div|th|pre|td|ul|ol)>)!', '$1', $chunk);
			$chunk = preg_replace('/&([^#])(?![A-Za-z0-9]{1,8};)/', '&amp;$1', $chunk);
		}
		$output .= $chunk;
	}
	return $output;
}

$str_replacement = array(
	'<!--'       => '&lt;!--',
	'-->'        => '--&gt;',
	'<![CDATA['  => '&lt;![CDATA[',
	'<?'         => '&lt;?',
	'?>'         => '?&gt;'
);

$regex_replacement = array(
	'javascript\s*:'            => '[removed]',
	'expression\s*(\(|&\#40;)'  => '[removed]',
	'vbscript\s*:'              => '[removed]',
	'Redirect\s+302'            => '[removed]'
);

$disallowed_html_elements = array(
	'alert', 'applet', 'audio', 'basefont', 'base', 'behavior', 'bgsound',
	'blink', 'body', 'embed', 'expression', 'form', 'frameset', 'frame', 'head',
	'html', 'ilayer', 'iframe', 'input', 'isindex', 'layer', 'link', 'meta',
	'object', 'plaintext', 'style', 'script', 'textarea', 'title', 'video',
	'xml', 'xss'
);

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

	return $url;
}

/**
 * Sanitizes a string so that it only accepts email characters.
 * @param string $email
 * @return string
 */
function sanitize_email(&$email) {
	if (!is_string($email))
		$email = strval($email);

	return $email;
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
