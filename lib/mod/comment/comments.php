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
 * Inserts the comments. This function may be used by any html file to add the
 * already posted comments.
 */
function comments() {
	global $is_index, $index, $content;
	if ($is_index)
		include DIR_PUB.'/'.$index.'.comments';
	else
		include DIR_PUB.'/'.$content.'.comments';

	if (isset($_POST['comment-preview'])) {
		sanitize_comment();
		include 'comment_preview.tpl';
	} else if (isset($_POST['comment-new'])) {
		save_comment();
		include 'comment_new.tpl';
	}
}

/**
 * Sanitizes a comment.
 */
function sanitize_comment() {
	global $is_index, $index, $content;
	global $comment_message, $comment_name, $comment_email, $comment_website,
		$comment_date, $comment_time;

	// Sanitize user input
	$comment_message = sanitize_user_html($_POST['comment-message']);
	$comment_name    = sanitize_alphanum($_POST['comment-message']);
	$comment_website = sanitize_url($_POST['comment-website']);
	$comment_email   = sanitize_email($_POST['comment-email']);
	// Get date, time
	$comment_date    = current_date();
	$comment_time    = current_time();
}

/**
 * Writes a new comment to the comments file of the article.
 */
function save_comment() {
	sanitize_comment();

	global $is_index, $index, $content;
	global $comment_message, $comment_name, $comment_email, $comment_website,
		$comment_date, $comment_time;

	// Get contents of template
	$comment = file_get_contents(dirname(__FILE__).'/comment.tpl');
	// Replace patterns with values
	$comment = str_replace('{{{comment_message}}}', $comment_message, $comment);
	$comment = str_replace('{{{comment_by}}}', $comment_website
			? '<a href="'.$comment_website.'">'.$comment_name.'</a>'
			: '<span>'.$comment_name.'</span>', $comment);
	$comment = str_replace('{{{comment_date}}}', $comment_date, $comment);
	$comment = str_replace('{{{comment_time}}}', $comment_time, $comment);

	// Open comments file for writing
	if ($is_index)
		$fwh = fopen($index.'.comments', 'ab');
	else
		$fwh = fopen($content.'.comments', 'ab');

	// Write $comment to the end of the file
	fwrite($fwh, $comment);
	// Close
	fclose($fwh);
}

/**
 * Inserts the comment form. This function may be used by any html file to add
 * an 'add comment' form.
 *
 * Usage:
 *   Simply type <?php comment_form(); ?> wherever you need it.
 */
function comment_form() {
	// Depending on if the user has pressed the commit button or the preview
	// button an empty form will be included or not.
	if (isset($_POST['comment-preview']) || isset($_POST['comment-new']))
		include 'comment_form.tpl';
	else
		include 'comment_form_empty.tpl';
}
