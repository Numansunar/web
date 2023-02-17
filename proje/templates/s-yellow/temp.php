<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Meta Taglar-->
	<?php echo generateTemplateHead(); ?>  
<!-- Meta Taglar Son -->
<link rel="stylesheet" href="css/style.css" type="text/css"  />
<link rel="stylesheet" href="css/box/box.css" type="text/css" />
<script type="text/javascript" src="templates/s-yellow/js/cufon-yui.js"></script>

<script type="text/javascript" src="templates/s-yellow/css/box/box.js"></script>
<script type="text/javascript" src="templates/s-yellow/js/slide.js"></script>
<script type="text/javascript" src="templates/s-yellow/js/cycle.js"></script>
<script type="text/javascript" src="js/jquery.countdown.pack.js"></script>
<script type="text/javascript" src="js/jquery.countdown-tr.js"></script>
<script type="text/javascript" src="templates/s-yellow/js/date.js"></script>
<script type="text/javascript" src="templates/s-yellow/js/datepicker.js"></script>
<script type="text/javascript" src="templates/s-yellow/js/general.js"></script>
<!--[if IE 6]><script type="text/javascript" src="templates/s-yellow/js/unitpngfix.js"></script><![endif]-->
<!--[if IE 8]><style>#ust .kayan_haber .haberler .haber_box{ margin-top:-12px; }</style><![endif]-->
</head>
<style>
#fancybox-tmp,.fancybox-ie,#fancybox-overlay { display:none; }
</style>
<body>
<div id="site">

	<!-- Ust -->
	<div id="ust">
		<div class="icerik">
			<!-- Ust Menu-->
			<div class="ust_menu">
				<?php echo sYellowTopPages() ?>
			</div>
			<!-- Ust Menu Son-->
			
			<!-- Logo -->
			<div class="logo" id="logo">
				<h1><a href="#" title="#">Logo</a></h1>
			</div>
			<?php echo slogoStyle('ust #logo')?>
			<!-- Logo Son-->
								
			<!-- Kayan Haber -->
			<div class="kayan_haber">
				<div class="haberler">
					<?php echo sYellowTopNews()?>
				</div>
			</div>
			<!-- Kayan Haber Son -->
			
			<!-- Menu -->
			<div class="menu">
			<ul id="topmenu">
				<li class="active" rel=""><a href="index.php"><span>Ana Sayfa</span></a></li>
				<li rel="sepet"><a href="page.php?act=sepet"><span>Sepetim</span></a></li>
				<li rel="register"><a href="<?php echo ($siteConfig['seoURL'] ? 'register_sp.html':'page.php?act=register')?>"><span>Üye Ol</span></a></li>
				<li rel="listNews showNews"><a href="<?php echo ($siteConfig['seoURL'] ? 'listNews_sp.html':'page.php?act=listNews')?>"><span>Haberler</span></a></li>
				<li rel="iletisim"><a href="<?php echo ($siteConfig['seoURL'] ? 'iletisim_sp.html':'page.php?act=iletisim')?>"><span>Bize Yazın</span></a></li>
				<li rel="showPage"><a href="<?php echo ($siteConfig['seoURL'] ? 'hakkimizda-sID12.html':'page.php?act=showPage&ID=12')?>"><span>Bizi Tanıyın!</span></a></li>
			</ul>
			<script>topMenu('<?php echo $_GET['act'];?>');</script>
			<div class="giris_yap">Giriş Yap - Üye Ol</div>
			</div>
			<!-- Menu Son -->
			
		</div>
	</div>
	<!-- Ust Son -->
	
	<!-- Orta -->
	<div id="orta">
		<!-- Giriş Paneli -->
		<div class="giris_paneli">
		
			<div class="hosgeldiniz">
				<div class="baslik"><strong>Hoş</strong>geldiniz</div>
				<p>Siteİsmi.com her gün yeni bir ürünü şok fiyattan ziyaretçilerine sunar.</p>

				<p>Günün fırsatından sipariş verebilmek için sağ taraftaki "kullanıcı girişi" alanından üye girişi yapabilir, üye değilseniz hemen <a href="<?php echo ($siteConfig['seoURL'] ? 'register_sp.html':'page.php?act=register')?>">üye olabilirsiniz</a>.</p>
				<p>
				Siteİsmi.com hakkında daha fazla bilgi edinmek için <a href="<?php echo ($siteConfig['seoURL'] ? 'hakkimizda-sID12.html':'page.php?act=showPage&ID=12')?>">buraya tıklayın</a>.</p>
			</div>
			
			<div class="uye_girisi">				
				<?php echo sYellowLogin() ?>
			</div>
			
			<div class="uye_ol">
				<div class="baslik"><strong>Üye</strong> Olun!</div>
				<form method="get" action="page.php" id="uye_girisi" name="uye_girisi">
				<input type="hidden" name="act" value="register" />
					<fieldset>
						<label for="kullanıcı_adi">Kullanici Adı:</label>
						<div class="input">
							<input type="text" name="username" value=""/>
						</div>
						<br />
						<label for="eposta">E-Posta Adresi:</label>
						<div class="input">
							<input type="text" name="email" value=""/>
						</div>
						<input type="submit" name="test" value=""  class="submit_uyeol"/>
					</fieldset>
				</form>
			</div>
			
			<div class="giris_paneli_kapat" id="kapat">Kapat</div>
		</div>
		<!-- Giriş Paneli Son -->
			
		<!-- İçerik Sol -->
		<div class="icerik_sol" style="width:610px;">
			<? echo $PAGE_OUT; ?>
		</div>
		<!-- İçerik Sol Son -->
		
		<!-- İçerik Sağ -->
		<div class="icerik_sag">
		<? if (basename($_SERVER['SCRIPT_FILENAME']) == 'index.php') 
		   { 
		?>
				<div class="sayac" id="sayac"></div>
				
		<?
			    echo urunSayac($_GET['urunID']);
			}
			else 
			{	
				echo "<script>innerPageStart();</script>";
			}			
		?>
			<div class="diger_firsatlar">
				<div class="baslik"><strong>Günün</strong> Fırsatları</div>
				<? echo gununFirsatlari() ?>
				<br class="clear" /><br />
			</div>
			
			<div class="nediyolar" <?php echo(basename($_SERVER['SCRIPT_FILENAME']) == 'index.php'?'':'style="display:none;"') ?>>
				<div class="baslik"><strong>Ne</strong> Diyorlar</div>
				<div id="yorumlarList">
					<?php echo sYellowYorumlar(); ?>
				</div>	
				<script>$('#yorumlarList').css('overflowX','hidden');</script>				
				<div class="yorum_sonuc"><p>Toplam <strong><?php echo yorumSayisi($_GET['urunID']) ?></strong> yorum yapılmış, sende <a href="#Yorum"><strong>yorum yap</strong></a></p></div>
				<br class="clear" /><br />
			</div>
			
			<div class="istatistik">
				<div class="baslik"><strong>Kısa</strong> İstatistikler</div>
					<div class="enler">
	
						<div class="ilbaslik"><strong>En Çok Sipariş Veren 3 Şehir</strong></div>
						<?php echo sYellowIstatistikIL() ?>
						<div class="ilbaslik" style="margin-left:174px;"><strong>Kaçar tane aldılar</strong></div>
						<?php echo sYellowIstatistikAdet() ?>
						
						<div class="ilbaslik2" style="display:none"><strong><a href="#">Detaylı İstatistikleri İncele</a></strong></div>
					</div>
				<br class="clear" /><br />
			</div>
			
			<div class="neler_kacirdiniz" style="background:none;">
				<div class="baslik"><strong>Neler</strong> Kaçırdınız?</div>
					<p>Görmek İstediğiniz Tarihi Seçiniz<br /><br /></p>
					
					<form method="post" action="#" id="uye_girisi" name="uye_girisi">
						<fieldset>
							<div class="inputn">
								<input type="text" name="date" value="" class="s1 date-pick" />
							</div>
						</fieldset>
						</form>
					<div id="neleriKacirdiniz">	
						<?php echo sYellowNeleriKacirdiniz(); ?>
					</div>
							
				<br class="clear" /><br />
			</div>
			<?php echo insertBanner('spsag')?>		
		</div>
		<!-- İçerik Sağ Son -->
		
	</div>
	<!-- Orta Son -->
	
	<!-- Alt -->
	<div id="alt">
		<div class="alt_ust"></div>
		<div class="icerik">
		
			<div class="alt_menu">
				<?php echo sYellowTopPages() ?>
			</div>
			
			<div class="copyright_adres">
				<p>Creamedia Software - Bağdat Cad. No : 2 Yolaç Plaza Kızıltoprak/İstanbul/Türkiye<br />  Tel: 0 (216) 414 0854 Fax: 0 (216) 414 0854 satis@shopphp.net</p>
			</div>
			
			<div class="alt_logo"></div>
						
		</div>
	</div>
	<!-- Alt Son -->
	<?php echo insertBanner('spfooter')?>
	<?php echo scriptmenu();?>
	<?php echo sepetGoster()?>
	<script>tempStart();</script>
</div>
</body>
</html>