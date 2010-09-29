<?php
/**
 * This file provides a function, which may be used by any html file to add an
 * 'add comment' form.
 *
 * Usage:
 *   Simply type <?php comment_form(); ?> wherever you need it.
 *
 * There is the comments() function, too, which provides a possibility to
 * include every comment into the page that has been postet.
 *
 * Usage:
 *   Simply type <?php comments(); ?> wherever you need it.
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
	global $comment_message, $comment_name, $comment_email, $comment_website,
		$comment_date, $comment_time, $comment_errors;
	if ($is_index)
		include DIR_PUB.'/'.$index.'.comments';
	else
		include DIR_PUB.'/'.$content.'.comments';

	// Comment saving and inclusion logic
	if (isset($_POST['comment-preview'])) {
		// If a preview is requested, show it
		validate_comment();
		sanitize_comment();
		include 'comment_preview.tpl';
	} else if (isset($_POST['comment-new'])) {
		// If a save is requested, check validity of the comment
		if (validate_comment()) {
			// Save, if it is valid and show the new comment.
			sanitize_comment();
			save_comment();
			include 'comment_new.tpl';
		} else {
			// Do not save it, if it is not valid and show the preview.
			sanitize_comment();
			include 'comment_preview.tpl';
		}
	}
}

/**
 * Validates a comment.
 */
function validate_comment() {
	global $is_index, $index, $content;
	global $comment_errors;

	if (!validate_name($_POST['comment-name']))
		$comment_errors['name'] = TRUE;
	if (!validate_url($_POST['comment-website']))
		$comment_errors['website'] = TRUE;
	if (!validate_email($_POST['comment-email']))
		$comment_errors['email'] = TRUE;

	if (isset($comment_errors))
		return FALSE;
	else
		return TRUE;
}


/**
 * Sanitizes a comment.
 */
function sanitize_comment() {
	global $is_index, $index, $content;
	global $comment_message, $comment_name, $comment_email, $comment_website,
		$comment_date, $comment_time, $comment_errors;

	// Sanitize user input
	$comment_message = sanitize_html($_POST['comment-message']);
	$comment_name    = sanitize_string($_POST['comment-name']);
	$comment_email   = $_POST['comment-email'];
	$comment_website = sanitize_url($_POST['comment-website']);

	// Get date, time
	$comment_date    = current_date();
	$comment_time    = current_time();
}

/**
 * Writes a new comment to the comments file of the article.
 */
function save_comment() {
	global $is_index, $index, $content;
	global $comment_message, $comment_name, $comment_email, $comment_website,
		$comment_date, $comment_time, $comment_errors;

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
	global $comment_message, $comment_name, $comment_email, $comment_website,
		$comment_date, $comment_time, $comment_errors;

	include 'comment_form.tpl';
}
