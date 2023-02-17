<?
	// Kullanım : <a class="loginbox fancybox.iframe" href="templates/<aktf temp>/login/login.php">Giriş</a>
?>
	<link rel="stylesheet" type="text/css" href="templates/<?=$siteConfig['templateName']?>/login/css/style.css" media="screen" />
	<script type="text/javascript" src="templates/<?=$siteConfig['templateName']?>/login/js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="templates/<?=$siteConfig['templateName']?>/login/js/jquery.fancybox.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.loginbox').fancybox({
			closeBtn	: true,
			width: 602,
			height: 550
		});
	});
	</script>