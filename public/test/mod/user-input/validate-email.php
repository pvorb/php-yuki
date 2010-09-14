<?php
/**
 * Test for function validate_email().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.2.0
 * @package org.genitis.yuki.mod.user-input.test
 */
?>
<h1>Tests for function <code>validate_email().</code></h1>
<?php
$emails = array(
	'name@domain.com',
	'c__j@domain.tld',
	'näme@heinz.org',
	'a@bö.de',
	'a-@mail.de',
	'-@mail.de',
	'this.is&wrong@domain.com',
	'name@subdomain.domain.com'
);
foreach ($emails as $email) {
	echo validate_email($email) == FALSE ? '<strong>error</strong>: '.$email : 'OK: '.$email;
	echo "<br />\n";
}
