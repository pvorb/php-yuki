<?php
/**
 * Tests for function validate_ip().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki.mod.user-input.test
 */
?>
<h1>Tests for function <code>validate_ip()</code></h1>
<p>Checks, whether a given string is an ip adress.</p>
<?php
$ips = array(
	// true ones
	'121.121.121.0',
	'18.11.1.255',
	'1...18',

	// false ones
	'abc.def.geh.ijk'
);

foreach ($ips as $ip) {
	echo $ip.', '.(validate_ip($ip) ? 'true' : 'false')."<br/>\n";
}
