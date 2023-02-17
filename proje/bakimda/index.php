<?
	include('../include/all.php');		
	list($tarih,$saat) = explode(' ',siteConfig('salterTarih'));	
	list($yil,$ay,$gun) = explode('-',$tarih);
?><!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?=$siteConfig['title']?></title>
	
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width">
	<meta name="robots" content="noindex">

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,600italic,600,400italic,300,300italic,700italic,800,800italic">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic">
	<link rel="stylesheet" href="css/style.css">
	
	<script src="js/libs/jquery-1.7.2.min.js"></script>
	<script src="js/libs/modernizr-2.5.3.min.js"></script>
    <script src="../include/langJS.php" type="text/javascript"></script>

	<!-- !> 
	/*************************************************************************/
	Configure your settings:
	/*************************************************************************/
	<! -->
		
	<script>
		var twitter_username = '<?=siteConfig('twitter_Username')?>';
		var ajax_form = true;
		var countdown_year = <?=(int)$yil?>; 
		var countdown_month = <?=(int)$ay?>;
		var countdown_day = <?=(int)$gun?>;
		var timeTo = new Date(parseInt(countdown_year), parseInt(countdown_month-1), parseInt(countdown_day));		
	</script>

<style type="text/css">
body,td,th {
	font-family: "Open Sans", sans-serif;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
	
<body class="text-white">

	  <div class="container-comming-soon">
			
			<!-- Begin timer -->
			<div class="timer-background">
				<p><span class="days"><i>0</i></span>g / <span class="hours"><i>0</i></span> s <span class="minutes-count"><span class="minutes"><i>0</i></span><span class="min-text"> dak. /</span> <span class="seconds"><i>0</i></span><span class="sec-text"> san.</span></span></p>
			</div>
			<!-- End timer -->
			
			
			<!-- Begin header -->
			<header class="clearfix comming-soon">
				<h1><?=$_SERVER['HTTP_HOST']?></h1>
			</header>
			<!-- End header -->
			
			<div role="main" class="main comming-soon">

				<section class="content">
					
					<!-- Main Title -->
					<h3><?=siteConfig('seo_title')?></h3>
					
					<!-- Main Text -->
					<p>
						<?=siteConfig('salterInfo')?>
					</p>
					
					<!-- Subscription Form -->
					<form action="form.php" method="post">
						<input name="email" class="email" type="text" placeholder="<?=_lang_formEpostaAdresiniz?>">
						<button type="submit" class="btn_email">
							<?=_lang_gonder?>
						</button>
					</form>
					<!-- End Subscription Form -->
					
					<div class="clearfix"></div>
					
					<p class="small spam"><?=_lang_formEpostaSpam?></p>

					<section class="contact-list clearfix">

						<p class="contacts"><?=siteConfig('firma_adi')?></p>
						
						<div class="float-left contact-address">
							
							<p class="address"><?=_lang_adres?>:</p>
							
							<!-- Contact details: Address -->
							<p class="address-text ">
								<?=siteConfig('firma_adres')?>
							</p>
							
							
						</div>
						<div class="float-left  contact-numbers">
							
							<!-- Contact details -->
							
							<p class="address-text" >
								<span class="address margin-right-10">Telefon:</span> <?=siteConfig('firma_tel')?>
							</p>
							<p class="address-text" >
								<span class="address margin-right-26">Fax:</span> <?=siteConfig('firma_faks')?>
							</p>
							<p class="address-text" >
								<span class="address margin-right-13">E-Posta:</span><a href="mailto:<?=siteConfig('firma_email')?>"><?=siteConfig('firma_email')?></a>
							</p>
							
							<!-- End Contact details -->
							
						</div>
					</section>
					
					<div class="clearfix"></div>

				</section>

			</div>

		</div>

		<footer>
			<div class="wrapper-comming-soon">
				<div class="clearfix"></div>

				<section class="bottom-elements" >
					
					<!-- Social Icons  -->
					<!-- Add/Remove your social profiles  -->
					<ul class="social">                        
                       	<li class="rss">
							<a href="../xml.php?c=rss"><img src="img/icons/social/rss.png" alt=""></a>
						</li>
						
						<li class="youtube">
							<a href="<?=siteConfig('youtube_URL')?>"><img src="img/icons/social/youtube.png" alt=""></a>
						</li>
						
						<li class="gplus">
							<a href="<?=siteConfig('google_URL')?>"><img src="img/icons/social/gplus.png" alt=""></a>
						</li>
						
						<li class="twitter">
							<a href="<?=siteConfig('twitter_URL')?>"><img src="img/icons/social/twitter.png" alt=""></a>
						</li>
						
						<li class="facebook">
							<a href="<?=siteConfig('facebook_URL')?>"><img src="img/icons/social/facebook.png" alt=""></a>
						</li>
						
					</ul>
					
					<!-- END Social Icons  -->
					
					<section class="twitter-feed clearfix"></section>

					<div class="clearfix"></div>
					
					<!-- Copyright / Footer info  -->
					<p class=" margin-124 rights-reserved">
						&copy; <?=date('Y')?> <?=siteConfig('firma_adi')?>.<br>Tüm hakları saklıdır.
					</p>
					<!-- End Copyright / Footer info  -->

				</section >
				
				
				
				<div class="clearfix"></div>
				
			</div>
		</footer>

		<div id="progress-back" class="load-item"><div id="progress-bar"></div></div>

		
		<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script>

		<script src="js/plugins.js"></script>
		<script src="js/script.js"></script>
		
		<?=siteConfig('google_analytics')?>
		
	</body>

</html>