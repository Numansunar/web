<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<?php echo generateTemplateHead(); ?>
    <link rel="stylesheet" type="text/css" href="templates/dstore/css/all.css" media="all" />
    <script type="text/javascript" src="templates/dstore/js/carousel.js"></script> 
</head>
<body>
<script type="text/javascript">
		$(document).ready(function () {
			$(".slide").jCarouselLite({
				btnGo: [".p1", ".p2", ".p3", ".p4", ".p5"],
				visible: 1,
				auto: 2000,
				speed: 800
			});
		});    
    </script> 
	<div id="wrapper">
		<div id="header">
			<div class="bar">
				<div class="bar-holder">
					<div class="enter">
						<?php echo dstoreLogin()?>
					</div>
					<div class="cart">
						<a class="btn-cart" href="<?=slink('sepet')?>" id="imgSepetGoster">sepet</a>
						<span>Sepetinizde  <a href="<?=slink('sepet')?>" id="toplamUrun"><?php echo basketInfo('toplamUrun','');?></a> Adet <br /> ürün bulunuyor.</span>
					</div>
				</div>
			</div>
			<div class="header-holder">
				<div class="block">
					<a href="index.php" class="logo" id="logo">shopphp.net | PHP e-ticaret yazılımı</a>
                    <?php echo slogoStyle('logo')?>
					<div class="search">
						<div class="free"><span class="green">Yeni!</span><span class="blue">100 TL ve üzeri alışverişlerde</span><span class="orange">ücretsiz kargo!</span></div>
						<form class="search-form" method="post" action="page.php?act=arama">
							<fieldset>
								<div class="text">
									<input type="text" name="str" onfocus="if(this.value=='Arama Yapın') this.value='';" onblur="if(this.value=='') this.value='Arama Yapın';" id="detailSearchKey" value="Arama Yapın" />
								</div>
								<input class="btn-serch" type="submit" value="serch" />
							</fieldset>
						</form>
					</div>
				</div>
				<?php echo dstroreTopMenu()?>
				<div class="action">
					<span>Şimdi üye ol</span>
					<strong>20 TL indirim kuponunu  hemen kullan!</strong>
				</div>
			</div>
		</div>
		<div id="main">
        	<? 
			$leftMenuArray = array('kategoriGoster','arama');
			if(in_array($_GET['act'],$leftMenuArray)) 
			{ ?>
                <div class="left-menu">
                	<?php echo generateMenuBlocks(0,'CatList','LeftBlock');?>
                    <?php echo $_GET['catID']? generateTableBox('Seçim Daraltın',generateFilter('MenuList'),'LeftBlock') : '';?>
                    <?php echo generateTableBox('Son Gezdikleriniz',lastViewedProducts(5),'LeftBlock');?>
                    
                    
                    <?php echo generateTableBox('Bilgi Sayfaları',generatePages('left'),'LeftBlock');?>
                    <?php echo generateTableBox('Haberler',generateLastNews(10),'LeftBlock');?>
                    <?php echo generateTableBox('Blog',makaleCatList(0),'LeftBlock');?>
                    <?php echo generateTableBox('Resim Galeri',simpleGalleryCatList(),'LeftBlock');?>
                    
                    <?php echo generateTableBox('Karsilastirma',karsilastirmaList('hit',20,0,'TopList'),'LeftBlock');?>	
					<?php echo generateTableBox('Anket',anket('#dddddd'),'LeftBlock');?>
                    <?php echo insertBanner('spsol');?>
                </div>
                <style>div.innertitle { width:772px; } div.innercontent { width:792px; }</style>
                <? 
			} ?>
            <div style="float:left;">
				<?php echo $PAGE_OUT?>
            </div>
		</div>
		<div id="footer">
			<div class="footer-holder">
				<div class="block">
					<div class="col-holder">
						<div class="col">
							<h2>KURUMSAL</h2>
							<ul>
								<?=simplePageList(1)?>
							</ul>
						</div>
						<div class="col">
							<h2>YARDIM VE İLETİŞİM</h2>
							<ul>
								<li><a href="<?=slink('iletisim')?>">Müşteri Destek</a></li>
								<li><a href="<?=slink('sss')?>">Sıkça Sorulan Sorular</a></li>
							</ul>
						</div>
						<div class="col">
							<h2>MÜŞTERİ HİZMETLERİ</h2>
							<ul>
                           		<?=simplePageList(2)?>
							</ul>
						</div>
					</div>
					<p>Bu sitede yer alan görseller ve içerik izinsiz olarak kopyalanamaz ve kullanılamaz. Aksi durumlarda yasal işlem uygulanacaktır.</p>
                    <p><?=modSocial()?></p>
				</div>
				<div class="container">
					<h2>Demostore</h2><span class="slogan">slogan buraya</span>
					<address>Bağdat Cad. Yolaç Plaza No:36/108 Kızıltoprak Kadıköy / İstanbul</address>
					<dl><dt>Tel :</dt><dd> 0(212) 414 08 54</dd></dl>
					<ul class="sponsors">
						<li>
							<a href="#"><img src="templates/dstore/images/img2.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
						<li>
							<a href="#"><img src="templates/dstore/images/img3.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
						<li>
							<a href="#"><img src="templates/dstore/images/img4.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
						<li>
							<a href="#"><img src="templates/dstore/images/img5.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
						<li>
							<a href="#"><img src="templates/dstore/images/img6.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
						<li>
							<a href="#"><img src="templates/dstore/images/img7.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
						<li>
							<a href="#"><img src="templates/dstore/images/img8.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
						<li>
							<a href="#"><img src="templates/dstore/images/img9.jpg" width="60" height="20" alt="descriptions" /></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php echo insertBanner('spfooter');?>
<?php echo scriptmenu();?>
<?php echo sepetGoster()?>
<script>tempStart();</script>
</body>
</html>