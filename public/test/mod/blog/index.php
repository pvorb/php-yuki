<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Blog index</title>
		<style>
			#title { font-size: 1.5em; border-bottom: 1px solid #000; }
		</style>
	</head>
	<body>
		<div id="title">Blog index</div>
<?php
require dirname(__FILE__).DIR_SEP.'conf.php';

$blog->print_index();
?>
	</body>
</html>