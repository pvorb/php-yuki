<?php
/**
 * Test for function sanitize_email().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki
 */

include dirname(__FILE__).'/../functions.php';

$emails = array('name@domain.com', 'c_j@domain.tld', 'näme@heinz.org', 'a@bö.de');
foreach ($emails as $email) {
	echo sanitize_email($email) !== FALSE ? sanitize_email($email) : 'error: '.$email;
	echo "\n";
}
