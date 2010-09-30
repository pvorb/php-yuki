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

define('COMMENT_MODE_LIST', 0);
define('COMMENT_MODE_PREVIEW', 1);
define('COMMENT_MODE_SAVE', 2);

class comment {
	private $mode = 0, $message = '', $user = '', $email = '', $website = '',
		$date = '', $time = '', $errors = array(), $is_valid = FALSE;

	function __construct() {
		if (isset($_POST['comment-preview'])) {
			$this->mode = COMMENT_MODE_PREVIEW;
		} elseif (isset($_POST['comment-save'])) {
			$this->mode = COMMENT_MODE_SAVE;
		} else {
			$this->mode = COMMENT_MODE_LIST;
		}

		if ($this->mode != COMMENT_MODE_LIST) {
			// Set new comment data.
			$this->message = $_POST['comment-message'];
			$this->user    = $_POST['comment-name'];
			$this->email   = $_POST['comment-email'];
			$this->website = $_POST['comment-website'];

			// Set current date and time.
			$this->date    = current_date();
			$this->time    = current_time();
		}
	}

	/**
	 * Lists the comments. This method may be used by any html file to add the
	 * already posted comments.
	 */
	function print_list() {
		global $is_index, $index, $content;

		if ($is_index)
			include DIR_PUB.'/'.$index.'.comments';
		else
			include DIR_PUB.'/'.$content.'.comments';

		// Comment saving and inclusion logic
		if ($this->mode == COMMENT_MODE_PREVIEW) {
			// If a preview is requested, show it.
			$this->validate();
			$this->sanitize();
			include 'comment_preview.tpl';
		} elseif ($this->mode == COMMENT_MODE_SAVE) {
			// If a save is requested, check validity of the comment.
			$this->validate();
			if ($this->is_valid) {
				// Save, if it is valid and show the new comment.
				$this->save();
				include 'comment_new.tpl';
			} else {
				// Do not save it, if it is not valid and show the preview.
				$this->sanitize();
				include 'comment_preview.tpl';
			}
		}
	}

	/**
	 * Validates the comment.
	 */
	private function validate() {
		$this->errors = array();

		// Validate values.
		if (!validate_name($this->user))
			$this->errors['name'] = TRUE;
		if (!validate_url($this->website))
			$this->errors['website'] = TRUE;
		if (!validate_email($this->email))
			$this->errors['email'] = TRUE;

		if (count($this->errors) == 0)
			$this->is_valid = TRUE;
	}


	/**
	 * Sanitizes a comment.
	 */
	private function sanitize() {
		global $is_index, $index, $content;

		// Sanitize user input
		$this->message = sanitize_html($_POST['comment-message']);
		$this->name    = sanitize_string($_POST['comment-name']);
		$this->email   = $_POST['comment-email'];
		$this->website = sanitize_url($_POST['comment-website']);

		// Get date, time
		$this->date    = current_date();
		$this->time    = current_time();
	}

	/**
	 * Writes a new comment to the comments file of the article.
	 */
	private function save() {
		global $is_index, $index, $content;

		$this->sanitize();

		// Get contents of template
		$comment = file_get_contents(dirname(__FILE__).'/comment.tpl');
		// Replace patterns with values
		$comment = str_replace('{{{comment_message}}}', $this->message, $comment);
		$comment = str_replace('{{{comment_by}}}', $this->website
				? '<a href="'.$this->website.'">'.$this->name.'</a>'
				: '<span>'.$this->name.'</span>', $comment);
		$comment = str_replace('{{{comment_date}}}', $this->date, $comment);
		$comment = str_replace('{{{comment_time}}}', $this->time, $comment);

		// Open comments file for writing
		if ($is_index)
			$f = fopen($index.'.comments', 'ab');
		else
			$f = fopen($content.'.comments', 'ab');

		// Write $comment to the end of the file
		fwrite($f, $comment);
		// Close
		fclose($f);
	}

	/**
	 * Inserts the comment form. This function may be used by any html file to add
	 * an 'add comment' form.
	 *
	 * Usage:
	 *   Simply type <?php comment_form(); ?> wherever you need it.
	 */
	function print_form() {
		include 'comment_form.tpl';
	}
}