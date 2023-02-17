<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo generateTemplateHead(); ?>  
<!-- css -->
<link rel="stylesheet" href="templates/clickblue/css/style.css" />
<link rel="stylesheet" href="templates/clickblue/css/slider.css" />
<!-- #css -->
<!-- javascript start -->
<script type="text/javascript" src="templates/clickblue/js/jquery18.js"></script>
<script type="text/javascript" src="templates/clickblue/js/easySlider1.7.js"></script>
<script type="text/javascript">
		$(document).ready(function(){	
			$("#slider").easySlider({
				auto: true, 
				continuous: true
			});
		});	
</script>
	
<script type="text/javascript">
		$(document).ready(function() {
	$("#tabs").tabs();
	});
</script>
<!-- javascript end -->
</head>
<body>
<!-- CONTAINER START -->
<div id="container">
	<!-- HEADER START -->
	<div id="header">
		<!-- LOGO START -->
		<div id="logo"><a href="index.php"><img src="<?php echo slogoSrc('templates/clickblue/resimler/logo.png')?>" alt="<?php echo $siteConfig['seo_title']?>"/></a></div>
		<!-- LOGO END -->
		<!-- TOP MENU START -->
		<div id="top-menu" style="background:none; margin-top:-10px; margin-right:5px;">
			<ul>
				<li class="customer-service"><a href="<?php echo slink('iletisim')?>">Müşteri Hizmetleri</a></li>
				<li class="my-account"><a href="<?php echo slink('login')?>">Hesabım</a></li>
				<li class="my-basket" id="imgSepetGosterOcean"><a href="<?php echo slink('sepet')?>">Sepetim</a></li>
			</ul>
            			<!-- SEARCH START -->
			<div id="search">
				<form action="page.php?act=arama" method="post" name="search">
					<input type="text" class="search-box detailSearchKey"  name="str" value="<?php echo ($_POST['kelime']?$_POST['kelime']:'Hızlı arama...') ?>" onclick="this.value=''" />
					<input type="submit" class="search-button" value="" /> 
				</form>
			</div>
			<!-- SEARCH END -->
		</div>
		<!-- TOP MENU END -->
		<div style="clear:both;"></div>
		<!-- MENU START -->
		<div id="menu">
			<?php echo twoLevelTopMenu()?>

		</div>
		<!-- MENU END -->
	</div>
	<!-- HEADER END -->
    <? if ($_GET['act']) echo "<div class='inner-content'>";?>
	<? 
    $leftMenuArray = array('kategoriGoster');
    if(in_array($_GET['act'],$leftMenuArray)) 
    { ?>
        <div class="left-menu">
	    <?php echo generateMenuBlocks(0,'CatList','LeftBlock');?>
            <?php echo ($_GET['catID'] ? generateTableBox('Seçim Daraltın',generateFilter('MenuList'),'LeftBlock') : '');?>
            <?php echo generateTableBox('Karşılaştırma',karsilastirmaList('hit',20,0,'TopList'),'LeftBlock');?>
            <?php echo generateTableBox('Bilgi Sayfaları',generatePages('left'),'LeftBlock');?>				
            <?php echo generateTableBox('Anket',anket('#dddddd'),'LeftBlock');?>
            <?php echo insertBanner('spsol');?>
        </div>
        <style>div.innertitle { width:705px; } div.innercontent { }</style>
        <? 
    } ?>
    <div style="float:left;  <?php echo (in_array($_GET['act'],$leftMenuArray)?'width:732px':'');?>">
        <?php echo $PAGE_OUT?>
    </div>
    <div style="clear:both"></div>
    <? if ($_GET['act']) echo "</div>";?>
        </div>
    <!-- CONTAINER END -->
<!-- CONTAINER 2 START -->
<div class="container-2">
	<!-- BOTTOM INFO START -->
	<div id="bottom-info">
	buraya bilgi gelecek
	</div>
	<!-- BOTTOM INFO END -->
	<!-- FOOTER START -->
	<div id="footer">
		<!-- FOOTER LEFT START -->
		<div id="footer-left">
			<ul>
				<li><b>KURUMSAL</b></li>
				<li><a href="<?php echo ($siteConfig['seoURL'] ? 'hakkimizda-sID12.html':'page.php?act=showPage&ID=12')?>">Hakkımızda</a></li>
				<li><a href="<?php echo ($siteConfig['seoURL'] ? 'gizlilik-ve-kullanim-sartlari-sID2.html':'page.php?act=showPage&ID=2')?>">Gizlilik ve Kullanım Şartları</a></li>
				<li><a href="<?php echo ($siteConfig['seoURL'] ? 'iletisim-sID4.html':'page.php?act=showPage&ID=4')?>">İletişim</a></li>
			</ul>
			<ul>
				<li><b>YARDIM VE İLETİŞİM</b></li>
				<li><a href="<?php echo slink('iletisim')?>">Bize Ulaşın</a></li>
				<li><a href="<?php echo slink('sss')?>">Sıkça Sorulan Sorular</a></li>
			</ul>
			<ul>
				<li><b>MÜŞTERİ HİZMETLERİ</b></li>
				<li><a href="<?php echo ($siteConfig['seoURL'] ? 'kargo-ve-tasima-bilgileri-sID3.html':'page.php?act=showPage&ID=3')?>">Kargo ve Teslimat</a></li>
				<li><a href=<?php echo slink('siparistakip')?>"">Sipariş Takibi</a></li>
				<li><a href="<?php echo slink('havaleBildirim')?>">Havale Bildirim Formu</a></li>
			</ul>
			<div style="clear:left;"></div>
			<p>Bu sitede yer alan görseller ve içerik izinsiz olarak kopyalanamaz ve kullanılamaz.Aksi durumlarda yasal işlem uygulanacaktır.</p>
			<p>
				Bağdat Cad. Yolaç Plaza No:36/108 Kızıltoprak<br/>
				Kadıköy / İstanbul<br/>
				Tel : 0(216) 000 00 00<br/><br />
                <div style="float:right; font-size:10px; color:#ccc;">powered by <a href="http://www.shopphp.net/" target="_blank" style="color:#aaa; font-weight:bold;" title="PHP E-Ticaret Yazılımı">shoppphp</a></div>
			</p>
		</div>
		<!-- FOOTER LEFT END -->
		<!-- FOOTER RİGHT START -->
		<div id="footer-right">
			<h1>E-bülten listemize katılın.</h1>
			<p>E-Bülten Hizmetine katılın haberler, kampanya ve indirimlerden ilk siz haberdar olun</p>
           <form action="" class="bulten-box" method="post">
            <input type="hidden" name="ebultensent" value="true">
            <?php echo ebulten('						
                <input type="text" class="bulten-box" name="email" placeholder="e-mail adresiniz" />
                <input type="submit" class="bulten-button" value="" />
            ')?>
            </form>
            <script>
                if ($('.ebulteninfo').html() != null) { alert($('.ebulteninfo').text());  }
                if ($('.ebultenerror').html() != null) { alert($('.ebultenerror').text());  }
                $('.ebulteninfo,.ebultenerror').remove();
            </script>
			<p>Site.com müşterilerinin bilgilerinin gizliliğine saygı duyar,özel bilgileriniz hiçbir şekilde paylaşılmayacaktır.</p>
			<div id="bank"><img src="templates/clickblue/resimler/banka.png" alt="" /></div>
		</div>
		<!-- FOOTER RİGHT END -->
		<div style="clear:left;"></div>
	</div>
	<!-- FOOTER END -->
</div>
<!-- CONTAINER 2 END -->
<?php echo insertBanner('spfooter');?>
<?php echo scriptmenu();?>
<?php echo sepetGoster()?>
<script>tempStart();</script>
</body>
</html>