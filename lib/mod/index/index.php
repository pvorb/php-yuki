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

	function __construct($root, $pattern) {
		$this->root = $root;
		$this->pattern = explode('/', $pattern);
		$this->use_pattern = count($this->pattern) > 1;
	}

	private function make(&$index) {
		$index = array();

		$this->go_into($this->root, $index);
		$this->level = 0;
	}

	function go_into($root, &$index) {
		global $file_ext;

		if (($dir = opendir($root)) != FALSE) {
			while(($file = readdir($dir)) !== FALSE) {
				if ($file != '.' && $file != '..') {
					if (is_dir($root.DIRECTORY_SEPARATOR.$file)) {
						if ($this->use_pattern && preg_match('#^'.$this->pattern[$this->level].'$#i', $file)) {
							$this->level++;
							$this->go_into($root.DIRECTORY_SEPARATOR.$file, $index);
							$this->level--;
						} elseif (!$this->use_pattern) {
							$this->go_into($root.DIRECTORY_SEPARATOR.$file, $index);
						}
					} else {
						foreach ($file_ext as $ext) {
							if (strripos($file, $ext) !== FALSE) {
								if ($this->use_pattern
										&& preg_match('#^'.$this->pattern[$this->level].'\\'.$ext.'$#i', $file)
										|| !$this->use_pattern)
									$index[] = $root.DIRECTORY_SEPARATOR.$file;

								break;
							}
						}
					}
				}
			}
		} else {
			return FALSE;
		}
	}

	function print_list() {
		echo '<ul>'."\n";
		$this->make($index);
		foreach ($index as $entry) {
			echo "\t".'<li><code>'.$entry.'</code></li>'."\n";
		}
		echo '</ul>'."\n\n";
	}
}
