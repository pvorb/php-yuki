<?php
/**
 * Tests for class index.
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package org.genitis.yuki.mod.index.test
 */
?>
<h1>Tests for class <code>index</code></h1>
<h2>Contents of folder <code>/public</code></h2>
<?php
$index = new index(DIR_PUB, '');
$index->print_file_list();
?>
<h2>Contents of folder <code>/public</code> matched against a pattern</h2>
<p>The pattern used is <code>test/mod/[[:alpha:]\-]+/[[:alpha:]\-]+</code></p>
<?php
$index = new index(DIR_PUB, 'test/mod/[[:alpha:]\-]+/[[:alpha:]\-]+');
$index->print_file_list();
