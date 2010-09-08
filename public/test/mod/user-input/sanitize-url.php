<?php
/**
 * Tests for function sanitize_url().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki.mod.user-input.test
 */
?>
<h1>Tests for function <code>sanitize_url()</code></h1>
<?php
$urls = array(
	// true ones
	'http://www.genitis.org/',
	'ssh://user@domain.com/',
	'mailto:user@domain.com',

	'http://',
	'ssh://',
	'mailto:',
	'www.genitis.org',

	// false ones
	'http:/www.genitis.org',
	'mailto',
	'user@domain.com'
);

foreach ($urls as $url) {
	echo $url.', '.sanitize_url($url)."<br/>\n";
}
