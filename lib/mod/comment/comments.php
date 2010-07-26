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
 * @version 0.1.1
 * @package org.genitis.yuki.mod.comment
 */

/**
 * Inserts the comment form. This function may be used by any html file to add
 * an 'add comment' form.
 *
 * Usage:
 *   Simply type <?php comment_form(); ?> wherever you need it.
 */
function comment_form() {
	if (isset($_POST['comment-preview'])) {
		include 'comment_preview.tpl';
	} else if (isset($_POST['comment-new'])) {
		include 'comment_new.tpl';
	}
	include 'comment_form.tpl';
}

function comments() {
	global $is_index, $index, $content;
	if ($is_index)
		include DIR_PUB.'/'.$index.'.comments';
	else
		include DIR_PUB.'/'.$content.'.comments';
}
