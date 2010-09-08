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
<h1>Tests for <code>function sanitize_html()</code></h1>
<?php
$html = <<<EOT
This is a small comment.

It has got some paragraphs.<br>
and some nice line breaks, too.

<blockquote>A blockquote</blockquote>
<cite>from Mike</cite>

and many other funny things.
EOT;

echo sanitize_user_html($html);


$html = '<?php echo $sth; ?>';

echo sanitize_user_html($html);
