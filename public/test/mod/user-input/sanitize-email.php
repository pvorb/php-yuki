<?php
/**
 * Test for function sanitize_email().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.2.0
 * @package org.genitis.yuki.mod.user-input.test
 */
?>
<h1>Tests for function <code>sanitize_email().</code></h1>
<?php
$emails = array('name@domain.com', 'c__j@domain.tld', 'näme@heinz.org', 'a@bö.de');
foreach ($emails as $email) {
	echo sanitize_email($email) !== FALSE ? sanitize_email($email) : '<strong>error</strong>: '.$email;
	echo "<br />\n";
}
