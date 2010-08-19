<?php
/**
 * Test for function sanitize_email().
 *
 * @author Paul Vorbach <vorbach@genitis.org>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 0.1.0
 * @package org.genitis.yuki
 */

$html = <<<EOT
This is a small comment.

It has got some paragraphs.<br>
and some nice line breaks, too.

<blockquote>A blockquote</blockquote>
<cite>from Mike</cite>

and many other funny things.
EOT;

echo sanitize_html($html);
