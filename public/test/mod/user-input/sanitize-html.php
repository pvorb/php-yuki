<?php
/**
 * Tests for function sanitize_html().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.2.0
 * @package org.genitis.yuki.mod.user-input.test
 */
?>
<h1>Tests for function <code>sanitize_html()</code></h1>
<?php
$html = <<<EOT
This is a small comment.

It has got some paragraphs.<br>
and some nice line breaks, too.

<blockquote>
	<p>A blockquote<p>
	<cite>from Mike</cite>
</blockquote>

and many other funny things.

This is a paragraph with a hyperlink http://github.com. And this hyperlink
"http://github.com/abc" is not detected.<unallowed tag />

This is <code>inline code</code>.

<code>Code block</code>

<code>
<html>
	<head>
		<title></title>
	</head>

	<body>
	</body>
</html>
</code>

<p>This is a small<br><br> paragraph with tags.</p>

EOT;

echo sanitize_user_html($html);

$html = 'Hallo';

echo sanitize_user_html($html);


$html = '

<code><?php echo $sth; ?></code>

';

echo sanitize_user_html($html);
