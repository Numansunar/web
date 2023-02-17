<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $siteTipi == 'GRUPSATIS'; echo generateTemplateHead(); ?>  
	<link rel="stylesheet" type="text/css" href="templates/mgroup/css/all.css" />
	<script type="text/javascript" src="js/jquery.countdown.pack.js"></script>
	<script type="text/javascript" src="js/jquery.countdown-tr.js"></script>
	<script type="text/javascript" src="templates/mgroup/js/main.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div class="wrapper">
				<h1 class="logo" id="logo"><a href="index.php">DEMOFIRSAT HER GÜN YENI FIRSATLAR!</a></h1>
				<?php echo slogoStyle('logo')?>
				<div class="top-menu-holder">
					<div class="top-menu-frame">
						<ul class="top-menu">
							<li><a href="<?php echo slink('siparistakip')?>">Sipariş Takip</a></li>
							<li><a href="<?php echo slink('havaleBildirim')?>">Havale Bildirimi</a></li>
							<li><a href="<?php echo ($siteConfig['seoURL'] ? 'hakkimizda-sID12.html':'page.php?act=showPage&ID=12')?>">Hakkımızda</a></li>
							<li><a href="<?php echo ($siteConfig['seoURL'] ? 'iletisim_sp.html':'page.php?act=iletisim')?>">İletişim</a></li>
						</ul>
					</div>
					<div class="top-menu-after"></div>
				</div>
			</div>
			<div class="nav-holder">
				<ul class="nav">
					<li class="active"><a href="index.php" class="nav-deal">Günün Fırsatı</a></li>
					<li><a href="<?php echo slink('kacanFirsatlar')?>" class="nav-opportunities">Kaçan Fırsatlar</a></li>
					<li><a href="<?php echo slink('basvuru')?>" class="nav-how">Firmanı Ekle</a></li>
				</ul>
				<div class="aside-box">
					<div class="social-holder">
						<div class="buttons">
							<?php echo loginButtons() ?>
						</div>
						<div class="wrapper">
							<ul class="social">
								<li><a target="_blank" href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['HTTP_HOST'] ?>" class="facebook">facebook</a></li>
								<li><a target="_blank" href="http://twitter.com/home?status=<?php echo $siteConfig['seo_title'].' http://'.$_SERVER['HTTP_HOST']?>" class="twitter">twitter</a></li>
								<li><a href="javascript:void(window.open('http://www.myspace.com/Modules/PostTo/Pages/?u='+encodeURIComponent(document.location.toString()),'ptm','height=450,width=550').focus())" class="myspace">mySpace</a></li>
								<li><a target="_blank" href="http://www.diggita.it/submit.php?url=http://<?php echo $_SERVER['HTTP_HOST'] ?>&title=<?php echo $siteConfig['seo_title']?>" class="diggita">Diggita</a></li>
								<li><a target="_blank" href="http://friendfeed.com/share?url=http://<?php echo $_SERVER['HTTP_HOST'] ?>" class="friendfeed">FriendFeed</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="main">
        	<? $siteTipi = 'GRUPSATIS';?>
			<div id="content"><?php if ($_GET['urunID']) { echo urunTemplateReplace($_GET['urunID'],$PAGE_OUT); echo myUrunSayac($_GET['urunID']); }
			else echo $PAGE_OUT;?>
			
			</div>
			<div id="sidebar">
				<div class="blue-block">
					<p>Her gün en iyi fırsatları yakalamanızı saglayacak firsat duyuruları en az <strong>%50 indirimle</strong> e-postanızda!</p>
				</div>
				<form action="" class="email-form" onsubmit="return ebultenSubmit('email')">
					<input type="hidden" name="ebultensent" value="true">
					<fieldset>
						<div id="ebulteninfo" style="height:60px;">
							<h3>Fırsatları Kaçırmamak Için</h3>
							<label for="email">Hemen E-Postanı yaz!</label>
						</div>
						<div class="row">
							<input type="text" name="email" class="text" placeholder="e-posta@adresiniz.com" id="email"/>
							<input type="submit" value="Gönder" class="submit"/>
						</div>
					</fieldset>
				</form>
				<div class="gray-block">
					<div class="holder">
						<h3>Arkadasini davet et, kazan!</h3>
						<p>Buraya çağırdığın her arkadaşın sana <span class="mark">100 Puan kazandırıyor!</span></p>
						<a href="<?php echo ($siteConfig['seoURL'] ? 'modDavet_sp.html':'page.php?act=modDavet')?>" class="btn-invite">Davet Gönder</a>
					</div>
				</div>
				<div class="green-block">
					<div class="holder">
						<div class="title">
							<h2 class="text-deal-day">Günün Diger Fırsatı</h2>
						</div>
						<?php 
							if(grupDigerUrunID() > 0) echo urunlist("select * from urun where ID='".grupDigerUrunID()."'",'UrunList_Empty','UrunGosterDiger'); 
						?>
					</div>
				</div>
				<div class="green-block gray-container">
					<div class="holder">
						<div class="title">
							<h2 class="text-opportunities">Diger Fırsatlar</h2>
						</div>
						<div class="frame">
							<?php echo mGroupDigerFirsatlar() ?>
						</div>
					</div>
				</div>
				<?php echo insertBanner('spsag')?>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="holder">
			<div class="frame">
				<div class="nav-holder">
					<ul class="nav">
						<li class="active"><a href="index.php" class="nav-deal">Günün Fırsatı</a></li>
						<li><a href="<?php echo ($siteConfig['seoURL'] ? 'kacanFirsatlar_sp.html':'page.php?act=kacanFirsatlar')?>" class="nav-opportunities">Kaçan Fırsatlar</a></li>
						<li><a href="<?php echo ($siteConfig['seoURL'] ? 'basvuru_sp.html':'page.php?act=basvuru')?>" class="nav-how">Firmanı Ekle</a></li>
					</ul>
					<div class="aside-box">
						<div class="social-holder">
							<p>Günün Fırsatlarını Hemen Paylaşın!</p>
							<ul class="social">
								<li><a target="_blank" href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['HTTP_HOST'] ?>" class="facebook">facebook</a></li>
								<li><a target="_blank" href="http://twitter.com/home?status=<?php echo $siteConfig['seo_title'].' http://'.$_SERVER['HTTP_HOST']?>" class="twitter">twitter</a></li>
								<li><a href="javascript:void(window.open('http://www.myspace.com/Modules/PostTo/Pages/?u='+encodeURIComponent(document.location.toString()),'ptm','height=450,width=550').focus())" class="myspace">mySpace</a></li>
								<li><a target="_blank" href="http://www.diggita.it/submit.php?url=http://<?php echo $_SERVER['HTTP_HOST'] ?>&title=<?php echo $siteConfig['seo_title']?>" class="diggita">Diggita</a></li>
								<li><a target="_blank" href="http://friendfeed.com/share?url=http://<?php echo $_SERVER['HTTP_HOST'] ?>" class="friendfeed">FriendFeed</a></li>
							</ul>
						</div>
					</div>
				</div>
				<strong class="logo"><a href="index.php">DEMOFIRSAT HER GÜN YENI FıRSATLAR!</a></strong>
				<div class="text">
					<?php echo mGroupFooterPages() ?>
					<p>&copy; <?php echo date('Y')?> Demofırsat Tüm hakları saklıdır.</p>
				</div>
			</div>
		</div>
	</div>
<?php echo insertBanner('spfooter')?>
<?php echo scriptmenu();?>
<?php echo sepetGoster()?>
<script>tempStart();</script>
</body>
</html>