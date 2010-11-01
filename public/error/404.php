<html>
	<head>
		<title>Error 404<?php if (isset($_GET['s'])) echo ': '.$_GET['s']; ?></title>
	</head>
	<body>
		<h1>File not found.</h1>
<?php if (isset($_GET['s'])): ?>
		<p>The file ‘<?php echo str_replace(' ', '/', $_GET['s']); ?>’ could not be found.</p>
<?php endif; ?>
	</body>
</html>
