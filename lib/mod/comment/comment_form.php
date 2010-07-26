<?php
/**
 * This file provides a function, which may be used by any html file to add an
 * 'add comment' form.
 *
 * Usage:
 *   Simply type <?php comment_form(); ?> wherever you need it.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki.mod.comment
 */

function comment_form() {
	include 'comment_form.tpl';
}
