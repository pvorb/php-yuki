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
	echo validate_email($email) === FALSE ? '<strong>error</strong>: '.$email : sanitize_email($email);
	echo "<br />\n";
}
