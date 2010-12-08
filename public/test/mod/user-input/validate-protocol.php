<?php
/**
 * Tests for function validate_protocol().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package org.genitis.yuki.mod.user-input.test
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tests for function validate_protocol()</title>
	</head>
	<body>
		<h1>Tests for function <code>validate_protocol()</code></h1>
		<p>Checks for each URL, whether it has got a protocol given.</p>
<?php
$urls = array(
	// true ones
	'http://www.genitis.org/',
	'ssh://user@domain.com/',
	'mailto:user@domain.com',

	'http://',
	'ssh://',
	'mailto:',

	// false ones
	'http:/www.genitis.org',
	'mailto',
	'www.genitis.org',
	'user@domain.com'
);

foreach ($urls as $url) {
	echo $url.', '.(validate_protocol($url) ? 'true' : 'false')."<br/>\n";
}
?>
	</body>
</html>
