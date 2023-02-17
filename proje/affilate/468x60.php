<? include('../include/all.php'); $siteConfig['captchaClose'] = 0; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $siteConfig['seoURL'] = 0;?> 
    <title><?=$siteConfig['title']?></title>
    <script src="//<?=$_SERVER['HTTP_HOST'].$siteDizini?>js/jquery.js" type="text/javascript"></script> 
	<link href="//<?=$_SERVER['HTTP_HOST'].$siteDizini?>/affilate/css/aff468.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//<?=$_SERVER['HTTP_HOST'].$siteDizini?>js/jquery.tinycarousel.js"></script>
</head> 
<body>
<div id="wrapper">
<div class="next"><img src="//<?=$_SERVER['HTTP_HOST'].$siteDizini?>/affilate/images/affilate/next_300x250.png" width="22" height="64" /></div>
<div class="prev"><img src="//<?=$_SERVER['HTTP_HOST'].$siteDizini?>/affilate/images/affilate/prev_300x250.png" width="22" height="64" /></div>

<!-- repater -->
<div class="viewport">
	<ul class="overview">
		<?=urunlist('select * from urun where active =1 AND anasayfa=1 order by rand() limit 0,5','../../../affilate/ItemList468','../../../affilate/468x60_temp');?> 
    </ul>
    </div>
</div>
<script>
	$("#wrapper").tinycarousel({
		interval: true,
		intervaltime: 4000
	});
</script>
