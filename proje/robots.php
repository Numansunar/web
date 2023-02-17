<?
	require('include/lib-db.php');
	require('include/conf.php');
?>User-agent: *
Disallow: /update.php
Disallow: /secure/
Disallow: /doc/
Disallow: /cache/
Disallow: /affiliate/
Disallow: /files/
Sitemap: https://<?php echo $_SERVER['HTTP_HOST'].$siteDizini ?>sitemap.xml