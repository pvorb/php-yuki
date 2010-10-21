<?php
/**
 * Indexing module.
 *
 * Provides functionality for dynamically creating an index over HTML documents.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package org.genitis.yuki.mod.index
 */

class index {
	private $root = '';
	private $pattern = array();
	private $use_pattern = FALSE;
	private $level = 0;
	private $index = null;

	/**
	 * Creates a new index object.
	 * @param string $root
	 * @param string $pattern
	 */
	function __construct($root, $pattern) {
		$this->root = $root;
		$this->pattern = explode('/', $pattern);
		$this->use_pattern = count($this->pattern) > 1;
	}

	/**
	 * Generate the new index.
	 * @return array
	 */
	private function make_all() {
		$this->index = array();

		$this->go_into($this->root, $this->index);
		$this->level = 0;
		return $this->index;
	}

	/**
	 * Recursively walk through all subfolders of $root and match against a pattern,
	 * if one was given.
	 * @param string $root
	 * @param array $index
	 */
	function go_into($root, &$index) {
		global $file_ext;
		$max_level = count($this->pattern);

		// Open root directory
		if (($dir = opendir($root)) != FALSE) {
			// Read files/directories
			while(($file = readdir($dir)) !== FALSE) {
				if ($file != '.' && $file != '..') {
					if (is_dir($root.DIR_SEP.$file)) {
						if ($this->use_pattern && preg_match('#^'.$this->pattern[$this->level].'$#i', $file)) {
							$this->level++;
							$this->go_into($root.DIR_SEP.$file, $index);
							$this->level--;
						} elseif (!$this->use_pattern) {
							$this->go_into($root.DIR_SEP.$file, $index);
						}
					} else {
						foreach ($file_ext as $ext) {
							if (strripos($file, $ext) !== FALSE) {
								if ($this->use_pattern && $this->level < $max_level
										&& preg_match('#^'.$this->pattern[$this->level].'\\'.$ext.'$#i', $file)) {
									$file = basename($file, $ext);
									if ($file != 'index')
										$index[] = $root.DIR_SEP.$file;
									break;
								} elseif (!$this->use_pattern) {
									$index[] = $root.DIR_SEP.$file;
									break;
								}
							}
						}
					}
				}
			}
		} else {
			return FALSE;
		}
	}

	private function make() {
		$this->index = array();


	}

	/**
	 * Prints all items in the index to a HTML list.
	 */
	function print_file_list() {
		echo '<ul>'."\n";
		if ($this->index == NULL)
			$this->make_all();

		foreach ($this->index as $entry) {
			echo "\t".'<li><code>'.$entry.'</code></li>'."\n";
		}

		echo '</ul>'."\n\n";
	}

	function save($file) {
		if (($f = fopen($file)) != NULL) {
			// TODO add missing files to index file.
		} else {
			// TODO create new file with complete index.
		}
	}
}
