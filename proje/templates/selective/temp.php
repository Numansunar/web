<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<?php echo generateTemplateHead(); ?>
	<link rel="stylesheet" type="text/css" href="templates/selective/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="templates/selective/css/style.css" />
	<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="css/ie.css" />
	<![endif]-->
	<script type="text/javascript" src="templates/selective/js/arnoTab.js"></script>
	<script type="text/javascript" src="templates/selective/js/jquery.tinycarousel.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#slider').tinycarousel({ fadeInOut: false, pager: true, duration: 0});
			$('.productTabs').arnoTab({mouseover: false});
			$('.others').arnoTab({mouseover: false});
			$('.proImg').tinycarousel({ fadeInOut: false, pager: true, duration: 0});
		});
	</script>
    <?
	if(!$_GET['act'])
	{?>
   		<style type="text/css">
			.middle { width:566px; }
			.productList { width:550px; }
		</style>
	<?}
	?>
    <?php echo slogoStyle('logo')?>	
</head>
<body>
	<div class="wrap">
		<div class="shadow"></div><!-- /.shadow -->
		<div class="container">
			<div id="header" style="position:relative">
				<div id="logo">
					<h1><a href="index.php"><?=$siteConfig['title'];?></a></h1>
				</div><!-- /#logo -->
				<ul class="topMenu">
					<li><a href="index.php">ANASAYFA İçerik</a></li>
					<li><a href="<?php echo slink('listNews')?>">HABERLER</a></li>
					<?
						if($_SESSION['userID'])
						{
							?>
                            	<li><a href="<?php echo slink('login')?>">ÜYE HESABIM</a></li>
								<li class="last"><a href="<?php echo slink('logout')?>">ÇIKIŞ</a></li>
                            <?	
						}
						else
						{
							?>
                            	<li><a href="<?php echo slink('login')?>">ÜYE GİRİŞİ</a></li>
								<li class="last"><a href="<?php echo slink('register')?>">ÜYE KAYIT</a></li>
                            <?	
						}
					?>
				</ul><!-- /.topMenu -->
				<div class="clear"></div><!-- /.clear -->
				<div class="menu">
					<ul>                    	
						<li><a href="<?php echo slink('yeniUrunler')?>">YENİ ÜRÜNLER</a></li>
						<li><a href="<?php echo slink('cokSatanlar')?>">ÇOK SATANLAR</a></li>
                        			<li><a href="<?php echo slink('onerilenler')?>">SİZİN İÇİN SEÇTİKLERİMİZ</a></li>
						<li><a href="<?php echo slink('stokaz')?>">KRİTİK STOKLAR</a></li>
                        
					</ul>
				</div><!-- /.menu -->
				<div class="search">
					<form  method="post" action="page.php?act=arama">
						<input type="text" onfocus="if(this.value=='aranacak ürün') this.value='';" onblur="if(this.value=='') this.value='aranacak ürün';" value="aranacak ürün" class="inputText detailSearchKey" name="str" />
						<input type="submit" value="" class="submit" />
					</form>
				</div><!-- /.search -->
			</div><!-- /#header -->
			<div class="subHeader">
				<a href="<?php echo slink('sepet')?>" class="basket" id="imgSepetGoster">
					Sepetim (<span id="toplamUrun"><?php echo basketInfo('toplamUrun','');?></span> ürün)
				</a><!-- /.basket -->
				<div class="ads1">
					<img src="templates/selective/sample/1.png" alt="" />
				</div><!-- /.ads1 -->
				<div class="ads2">
					<img src="templates/selective/sample/2.png" alt="" />
				</div><!-- /.ads2 -->
			</div><!-- /.subHeader -->
			<div class="content">
				<?
					$singleColumnArray = array('urunDetay');
					if(in_array($_GET['act'],$singleColumnArray))
					{
						echo $PAGE_OUT;
					}
					else
					{
						?>
						<div class="left">
                            <?
								if (tpBlueMenu((int)currentCat())) $pID =  currentCat();
								else $pID = currentParentCatID();
							?>
                        	<?php echo generateTableBox(trupper((int)$pID?dbInfo('kategori','name',$pID):'Kategoriler'),tpBlueMenu((int)$pID),'LeftBlock');?>
                            <?php echo $_GET['catID'] ? generateTableBox('Seçiminizi Daraltın',generateFilter('MenuList'),'LeftBlock') : '';?>
							<?php echo generateTableBox('Karsilastirma Listem',karsilastirmaList('hit',20,0,'TopList'),'LeftBlock');?>
                            	
                            <?php echo generateTableBox('Anket',anket('#dddddd'),'LeftBlock');?>
                            <?php echo generateTableBox('Döviz Bilgileri',doviz(),'LeftBlock');?>
                            
                            <?php echo canliDestekResim()?>
							<div class="instalment">
								<img src="templates/selective/img/instalment.jpg" alt="" />
							</div><!-- /.instalment -->
			    <?php echo insertBanner('spsol')?>
						</div><!-- /.left -->
						<div class="middle">                
							<?php echo $PAGE_OUT?>
						</div><!-- /.middle -->
                        <?
							if(!$_GET['act'])
							{
								?>
                                    <div class="right">
                                        <div class="customerServices">
                                            <span class="telefon"><span>0 216</span> 000 00 00</span>
                                            <a href="<?php echo slink('iletisim')?>"><img src="templates/selective/img/customerServices.jpg" alt="" /></a>
                                        </div><!-- /.customerServices -->
                    
                                        <div class="monthly">
                                            <h3 class="heading">AYIN FIRSAT ÜRÜNÜ</h3><!-- /.heading -->
                                            <?php echo urunlist("select * from urun where yeni = 1 AND video = '' order by seq desc,ID desc limit 0,1",'','UrunListShowFirsat')?>
                                        </div><!-- /.monthly -->
                    
                                        <div class="video">
                                            <h3 class="heading">ÜRÜN VIDEO</h3><!-- /.heading -->
                                            <?php echo urunlist("select * from urun where yeni = 1 AND video != '' order by seq desc,ID desc limit 0,1",'','UrunListShowVideo')?>
                                        </div><!-- /.video -->
					<?php echo insertBanner('spsag')?>
                                    </div><!-- /.right -->
                                <?
							}
							
					}
				?>
			</div><!-- /.content -->




			<div class="news">
				<h3>Bizden Haberler</h3>
				<div class="newsHeading">
					<?php echo generateLastNews(1,'SimpleList',false)?>
				</div><!-- /.newsHeading -->
			</div><!-- /.news -->


			<div class="footer">
				<div class="footLeft">
					<a href="#" class="footLogo"><img src="templates/selective/img/footLogo2.png" alt="" /></a>
					<div class="clear"></div><!-- /.clear -->
					<p>Adres Burada Sitesi<br />
					1. Blok No: 00 30000<br />
					Semt / Şehir</p>
				</div><!-- /.footLeft -->
				<div class="footBlock">
					<h3>Hakkımızda</h3>
					<ul>
						<li><a href="<?php echo ($siteConfig['seoURL'] ? 'hakkimizda-sID12.html':'page.php?act=showPage&ID=12')?>">Hakkımızda</a></li>
						<li><a href="<?php echo slink('sss')?>">Soru / Cevap</a></li>
						<li><a href="<?php echo slink('iletisim')?>">Müşteri Destek</a></li>
					</ul>
				</div><!-- /.footBlock -->
				<div class="footBlock">
					<h3>Bilgilendirme</h3>
					<ul>
						<li><a href="<?php echo ($siteConfig['seoURL'] ? 'siparistakip_sp.html':'page.php?act=siparistakip')?>">Sipariş Takibi</a></li>
						<li><a href="<?php echo ($siteConfig['seoURL'] ? 'garantiveiade-sID1.html':'page.php?act=showPage&ID=1')?>">İade ve Değişim</a></li>
						<li><a href="<?php echo ($siteConfig['seoURL'] ? 'kargoveteslimat-sID3.html':'page.php?act=showPage&ID=3')?>">Kargo ve Teslimat</a></li>
					</ul>
				</div><!-- /.footBlock -->
				<div class="footBlock">
					<h3>E-bülten Kaydı</h3>
					<div class="ebulten" id="ebulteninfo">
                    	<form action="" class="email-form" method="post">
                        <input type="hidden" name="ebultensent" value="true" />
						<?php echo ebulten('						
							<input type="text" onfocus="if(this.value==\'e-mail adresiniz\') this.value=\'\';" onblur="if(this.value==\'\') this.value=\'e-mail adresiniz\';" value="e-mail adresiniz" class="inputText" name="email" />
							<input type="submit" class="submit" value="" />
						')?>
						</form>
                        <script type="text/javascript">
							if ($('.ebulteninfo').html() != null) { alert($('.ebulteninfo').text());  }
							if ($('.ebultenerror').html() != null) { alert($('.ebultenerror').text());  }
							$('.ebulteninfo,.ebultenerror').remove();
						</script>
						<div class="clear"></div><!-- /.clear -->
					</div><!-- /.ebulten --> 
				</div><!-- /.footBlock -->
				<div class="footBlock last">
					<img src="templates/selective/img/credit.png" alt="" />
				</div><!-- /.footBlock -->
			</div><!-- /.footer -->

		</div><!-- /.container -->
		<div class="copyright">
			<p>Bu sitede bulunan tüm yazılı ve görsel materyaller shopphp.net'e aittir izinsiz kullanılamaz, kopyalanamaz ve hiçbir şekilde dağıtılamaz.</p>
		</div><!-- /.copyright -->
	</div><!-- /.wrap -->
<?php echo insertBanner('spfooter')?>
<?php echo scriptmenu();?>
<?php echo sepetGoster()?>
<script type="text/javascript">tempStart();</script>
</body>
</html>