<?php
require DIR_MOD.'blog'.DIR_SEP.'blog.php';
$blog = new blog(
	dirname(__FILE__).DIR_SEP,
	dirname(__FILE__).DIR_SEP.'index.txt',
	'body#content',
	'div#comments',
	'h1#',
	5
);
