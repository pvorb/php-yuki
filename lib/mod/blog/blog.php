<?php
/**
 * Blogging module.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license MIT license <http://www.genitis.org/mit-license>
 * @package org.genitis.yuki
 */

class blog {
	private $dir;
	private $index_file;

	private $entries_per_page;

	private $content_element;
	private $content_id;

	private $comment_element;
	private $comment_id;

	private $title_element;
	private $title_id;

	private $hide_comments;

	function __construct($dir, $index_file, $content, $comment, $title, $entries_per_page, $hide_comments = TRUE) {
		$this->dir = $dir;
		$this->index_file = $index_file;

		// FIXME Strings without a '#' don't work.

		// Split $content into element and id.
		$content = explode('#', $content);
		$this->content_element = $content[0];
		$this->content_id = $content[1];

		// Split $comment into element and id.
		$comment = explode('#', $comment);
		$this->comment_element = $comment[0];
		$this->comment_id = $comment[1];

		// Split $title into element and id.
		$title = explode('#', $title);
		$this->title_element = $title[0];
		$this->title_id = $title[1];

		$this->hide_comments = $hide_comments;
	}

	function print_index($atom = false) {
		// Open index file
		if ($file = fopen($this->index_file, 'r')) {
			$i = 1;
			// For each line
			while (($line = fgets($file)) !== FALSE) {
				// If line is not empty and is not a comment
				if ($line != '' && $line[0] != '#') {
					if (!$atom)
						$this->print_entry_html(rtrim($line));
					else
						$this->print_entry_atom(rtrim($line));
					$i++;
				}
			}
			fclose($file);
		}
	}

	private function print_entry_html($entry) {
		// Open file
		if ($file = fopen($this->dir.$entry.'.html', 'r')) {
			// Counter for $content_elements that were read.
			$tags_open = 0;
			// Counter for $comment_elements that were read.
			$hidden_tags = 0;
			// Read file line by line
			while (($line = fgets($file)) !== FALSE) {
				// Fix the references
				self::fix_refs($line, $entry);

				// If a content_element tag with id content_id is reached.
				if (preg_match('#<'.$this->content_element.' [^<>]*id=["|\']'.$this->content_id.'["|\'][^<>]*>#', $line)) {
					$tags_open++;

					// Continue reading lines.
					while ($line = fgets($file)) {

						// Make lowercase
						$lower_line = strtolower($line);

						// Count opening tags <content_element> and add to $tags_open.
						$tags_open += substr_count($lower_line, '<'.$this->content_element);

						// Count closing tags </content_element> and subtract from $tags_open.
						$tags_open -= substr_count($lower_line, '</'.$this->content_element);

						// Add a permalink to the title of the entry
						self::add_permalink($file, $line, $entry, $this->title_element, $this->title_id);

						// Look for comments if comment hiding is enabled.
						if ($this->hide_comments) {
							self::hide_comments($file, $line, $entry, $hidden_tags, $this->comment_element, $this->comment_id);
						}

						// If $tags_open == 0, break the loop.
						if ($tags_open == 0) {
							break;
						}
						// If $tags_open < 0, echo missing closing tags and break the loop.
						elseif ($tags_open < 0) {
							echo str_repeat('</'.$this->comment_element.'>', -$hidden_tags);
							break;
						}
						// Otherwise print the $line.
						else {
							echo $line;
						}
					}
					break;
				}
			}
			fclose($file);
		}
	}

	private static function fix_refs(&$html, $entry) {
		// fix links and references

		// Match links (either href="..." or src="...") and correctly replace them.
		if (strpos($html, 'href="') !== FALSE && strpos($html, '://') === FALSE) {
			$html = str_replace('href="', 'href="'.dirname($entry).'/', $html);
		}
		if (strpos($html, 'src="') !== FALSE && strpos($html, '://') === FALSE) {
			$html = str_replace('src="', 'src="'.dirname($entry).'/', $html);
		}
	}

	private static function add_permalink(&$file, &$line, $entry, $title_element, $title_id) {
		// If the line contains the title, add permalink.
		if (preg_match('#<'.$title_element.($title_id ? ' [^<>]*id=["\']'.$title_id.'["|\'][^<>]*>#' : '>#'), $line, $match)) {
			$line = str_replace($match[0], $match[0].'<a href="'.$entry.'">', $line);
			$lower_line = strtolower($line);

			// Close tags
			do {
				if (strpos($lower_line, '</'.$title_element) !== FALSE) {
					$line = str_ireplace('</'.$title_element, '</a></'.$title_element, $line);
					return;
				} else {
					echo $line;
				}
			} while ($line = fgets($file));
		}
	}

	private  static function hide_comments(&$file, &$line, $entry, &$hidden_tags, $comment_element, $comment_id) {
		if (preg_match('#<'.$comment_element.' [^<>]*id=["|\']'.$comment_id.'["|\'][^<>]*>#', $line)) {
			$hidden_tags++;

			// Continue reading lines.
			while ($line = fgets($file)) {
				// Make lowercase
				$lower_line = strtolower($line);

				// Count opening tags <comment_element> and add to $hidden_tags.
				$hidden_tags += substr_count($lower_line, '<'.$comment_element);

				// Count closing tags </comment_element> and subtract from $hidden_tags.
				$hidden_tags -= substr_count($lower_line, '</'.$comment_element);

				// If $hidden_tags <= 0, get the next line and break the loop.
				if ($hidden_tags <= 0) {
					return;
				}
			}
		}
	}

	private function print_entry_atom($entry) {

	}
}
