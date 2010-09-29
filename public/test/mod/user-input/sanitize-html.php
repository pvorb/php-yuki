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
<h2>Nice input</h2>
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

echo sanitize_html($html)."\n\n";

$html = 'Hallo';

echo sanitize_html($html)."\n\n";


$html = '

<code><?php echo $sth; ?></code>

';

echo sanitize_html($html)."\n\n";
?>
<h2>XSS input</h2>
<?php
$html = <<<EOT
<a onload=alert('XSS')></a>
'';!--"<XSS>=&{()}
<IMG SRC="javascript:alert('XSS');">
<IMG """><SCRIPT>alert("XSS")</SCRIPT>">
<IMG SRC="jav	ascript:alert('XSS');">
<IMG SRC="jav&#x0A;ascript:alert('XSS');">
<IMG
SRC
=
"
j
a
v
a
s
c
r
i
p
t
:
a
l
e
r
t
(
'
X
S
S
'
)
"
>
<<SCRIPT>alert("XSS");//<</SCRIPT>
<SCRIPT SRC=http://ha.ckers.org/xss.js?<B>
<IMG SRC="javascript:alert('XSS')"
<A HREF="h
tt	p://6&#9;6.000146.0x7.147/">XSS</A>
EOT;

echo sanitize_html($html)."\n\n";
