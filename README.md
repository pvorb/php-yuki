# Yuki Content Management

Yuki is a *very simple* Content Management system. Its intention is to provide basic access to HTML-files on an Apache Web Server running with PHP. You don't need a database to get started, but there will be extensions that provide database access.

## Getting started
All you need is an *Apache HTTP Server* with a *PHP* installation and the Apache module *mod_rewrite*.

1.	You may rename the `public` folder to whatever your document root folder is called. (Usually it is `htdocs`, `html` or `www`.)

2.	Then you may edit the `lib/conf.php` according to the instructions in the file.

Now you are able to add your HTML files and whatever you like.

## Example site
There's a tiny example project available if you `git checkout example-site`. Just have a look.

If you need a real life example look at [genitis.org](http://www.genitis.org) and [the genitis repo](http://github.com/pvorb/genitis) respectively.

## Current development
At the moment I am developing a module for adding commenting functionality to documents. Simply `git checkout mod-comment`

