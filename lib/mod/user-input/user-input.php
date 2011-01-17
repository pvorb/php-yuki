<?php
/**
 * Descriptive Text goes here...
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package org.genitis.yuki.mod.user-input
 */

define('PREG_IP', '#(\d{0,3}\.){3}\d{0,3}#i');
define('PREG_PROTOCOL', '#^([[:alpha:]]+://|mailto:)#i');
define('PREG_NAME', '#^[^[:cntrl:]<>]+$#');
define('PREG_EMAIL', '#^[[:alnum:]\\.!\#\%&\'*+-/=?\^_`{|}\~" ]+@([[:alnum:]äöü\-]+\.)+[[:alpha:]]+$#i'); // not very strict
define('PREG_URL', '#^(((https?:)?//)?([[:alnum:]äöü\-]+.)+[[:alpha:]]+(/[^[:cntrl:]<>]*)?)?$#i');

/**
 * Matches strings that begin with a protocol.
 * @param string $protocol
 * @return int
 */
function validate_protocol($protocol) {
	return preg_match(PREG_PROTOCOL, $protocol);
}

/**
 * Matches strings that are allowed as names.
 * @param string $name
 * @return int
 */
function validate_name($name) {
	return preg_match(PREG_NAME, $name);
}

/**
 * Matches strings that seem to be an email address.
 * @param string $email
 * @return int
 */
function validate_email($email) {
	return preg_match(PREG_EMAIL, $email);
}

/**
 * Matches strings that seem to be a URL.
 * @param string $url
 * @return int
 */
function validate_url($url) {
	return preg_match(PREG_URL, $url);
}

/**
 * Sanitizes a string so that html characters are replaced by their entities.
 * @param string $string
 * @return string
 */
function sanitize_string(&$string) {
	return htmlspecialchars($string, ENT_QUOTES);
}

/**
 * Sanitizes a string to a (valid) URL.
 * @param string $url
 * @return string
 */
function sanitize_url(&$url) {
	if (preg_match('#^[[:space:]]*$#', $url)) {
		return '';
	}

	// if there’s no protocol given
	if (!validate_protocol($url)) {
		// if it’s an email adress
		if (strpos($url, '@'))
			$url = 'mailto://'.$url;
		else
			$url = 'http://'.$url;
	}

	return htmlspecialchars($url);
}

/**
 * Sanitizes inline HTML.
 * @param string $html
 */
function sanitize_html_inline($html) {
	// Replace multible <br /> tags with a single one.
	return preg_replace('#(<br />)+[[:space:]]*#i', "<br />\n", $html);
}

if (!defined('SAN_BLOCK_ALLOWED'))
	define('SAN_BLOCK_ALLOWED', 'blockquote|ul|ol|p|pre');
if (!defined('SAN_INLINE_ALLOWED'))
	define('SAN_INLINE_ALLOWED', 'a|em|strong|code|br|li|cite');
if (!defined('SAN_ATTR_ALLOWED'))
	define('SAN_ATTR_ALLOWED', 'class');

/**
 * Sanitizes paragraphs of the given HTML.
 * @param string $html
 */
function sanitize_html_paragraphs(&$html) {
	// Sanitize every paragraph at its own
	$paragraphs = explode("\n\n", $html);
	foreach ($paragraphs as &$p) {
		// Remove blank lines.
		if (preg_match('#^[[:blank:]]*$#', $p))
			$p = null;
		// Surround a paragraph with <p> tags if it isn't already surr. by one
		// of the allowed HTML block elements.
		elseif (!preg_match('#^<('.SAN_BLOCK_ALLOWED.')>#i', $p))
			$p = '<p>'.$p.'</p>';
	}
	$html = implode("\n\n", $paragraphs);

	// Sanitize line breaks: <br> and <br/> become <br />.
	$html = preg_replace('#(<br/?>)+(\n)*[ ]*#i', '<br />'."\n", $html);
}

/**
 * Sanitizes plain code for use in HTML.
 * @param string $code
 */
function sanitize_html_code($code) {
	$code = trim($code, "\n");
	$code = htmlspecialchars($code);
	return $code;
}

/**
 * Sanitize blocks of code for use in HTML.
 * @param string $html
 */
function sanitize_html_code_blocks(&$html) {
	$offset = 0;
	while (($pos1 = stripos($html, "\n\n".'<code>', $offset)) !== FALSE) {
		$offset = $pos1 + 7;
		if (($pos2 = stripos($html, '</code>'."\n\n", $offset)) !== FALSE) {
			$offset = $pos2 + 9;

			// Calculate search string
			$search = substr($html, $pos1, $offset - $pos1);

			// Sanitize code
			$code = substr($search, 8, strlen($search) - 17);
			$code = str_replace("\n\n", "\n \n", $code);
			$code = sanitize_html_code($code);

			// Add tags around it
			$replace = "\n\n".'<pre><code>';
			$replace .= $code;
			$replace .= '</code></pre>'."\n\n";

			// Replace $search with $replace
			$html = str_replace($search, $replace, $html);
		}
	}
}

/**
 * Sanitizes inline code for use in HTML.
 * @param string $html
 */
function sanitize_html_code_inline(&$html) {
	if (preg_match_all('#<code>(.*)</code>#i', $html, $matches, PREG_SET_ORDER)) {
		foreach ($matches as $match) {
			$html = str_replace($match[0], '<code>'.sanitize_html_code($match[1]).'</code>', $html);
		}
	}
}

/**
 * Sanitizes HTML anchors and detects URLs in the text.
 * @param string $html
 */
function sanitize_html_anchors(&$html) {
	// Match all URLs
	if (preg_match_all('#.([[:alpha:]]{2,8}://([[:alnum:]]+.)*[[:alnum:]]+\.[[:alpha:]]{2,10}(/[^ ]*)*).#i', $html, $matches, PREG_SET_ORDER))
		foreach ($matches as $match) {
			$first = $match[0][0];
			$last = $match[0][strlen($match[0]) - 1];
			// Check if anchor is surrounded by spaces, new lines or followed by a dot.
			if (($first == ' ' || $first == "\n") && ($last == ' ' || $last == "\n" || $last == '.')) {
				// Trim spaces, new lines and dots
				$repl = trim($match[0], " \n.");

				// Replacement: <a href="URL">URL</a>
				$repl = str_replace($repl, '<a href="'.htmlspecialchars($repl, ENT_QUOTES).'">'.htmlspecialchars($repl).'</a>', $match[0]);

				// Replace the whole match including spaces, new lines or dots.
				// This is important if you want to avoid the replacement of
				// multiple occurences of the same URL and one of them is not
				// surrounded by these characters.
				$html = str_replace($match[0], $repl, $html);
			}
		}
}

/**
 * Filters unwanted HTML elements and removes them from markup.
 * Also replaces some tags by more reasonable ones.
 * @param string $html
 */
function sanitize_html_filter(&$html) {
	// Replace <b> by <strong> and <i> by <em>
	$search = array('<b>', '</b>', '<i>', '</i>');
	$replace = array('<strong>', '</strong>', '<em>', '</em>');
	$html = str_ireplace($search, $replace, $html);

	// Filter out unwanted elements and remove them from the markup.
	preg_match_all('#</?[^<>]+/?>#i', $html, $matches);
	foreach ($matches[0] as &$match) {
		$pattern = '#^<('.SAN_BLOCK_ALLOWED.'|'.SAN_INLINE_ALLOWED.')( ('
			.SAN_ATTR_ALLOWED.'="[^"<>]*"))*>|<a href="[^"<>]*">|<br />|</('
			.SAN_BLOCK_ALLOWED.'|'.SAN_INLINE_ALLOWED.'|)>$#i';
		if (!preg_match($pattern, $match))
			$html = str_replace($match, '', $html);
	}
}

/**
 * Sanitizes the HTML contents of a user entry.
 * @param string $html
 * @return string
 */
function sanitize_html($html) {
	// Remove Unicode BOM and SUB.
	$html = preg_replace('#^\xEF\xBB\xBF|\x1A#', '', $html);

	// Remove multiple spaces at line endings and convert line endings to UNIX.
	$html = preg_replace('#[ ]+(\r\n?|\n)#', "\n", $html);

	// Trim new lines from beginning and end.
	$html = trim($html, "\n");

	// Sanitize code blocks.
	sanitize_html_code_blocks($html);
	// Sanitize inline code.
	sanitize_html_code_inline($html);
	// Sanitize paragraphs.
	sanitize_html_paragraphs($html);
	// Sanitize html anchors.
	sanitize_html_anchors($html);
	// Filter out everything that is not allowed.
	sanitize_html_filter($html);

	$html .= "\n"; // Add a final new line.

	return $html;
}
