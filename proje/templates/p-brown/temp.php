<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo generateTemplateHead(); ?>
    <link href="templates/p-brown/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="templates/p-brown/css/style.css" rel="stylesheet" type="text/css" />
    <link href="templates/p-brown/css/jqtransform.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="templates/p-brown/js/jquery.jqtransform.js" ></script> 
    <script type="text/javascript" src="templates/p-brown/js/bezoom.js" ></script>
    <script type="text/javascript" src="js/jquery.countdown.pack.js"></script>
    <script type="text/javascript" src="js/jquery.countdown-tr.js"></script>
    <script type="text/javascript" src="templates/p-brown/js/hoverIntent.js"></script>
    <script type="text/javascript" src="templates/p-brown/js/mega.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){ 
			var tabContainers = $('div.productBig > div');
			tabContainers.hide().filter(':first').show();			
			$('div.productSmall ul li a').click(function () {
				tabContainers.hide();
				tabContainers.filter(this.hash).show();
				return false;
			}).filter(':first').click();
			$(".zoom").bezoom(); 
			$('#content .longPro:nth-child(3n)').addClass('third');
		}); 
		$(function(){
			$('.selection').jqTransform();
		});
	</script>
</head>
<body>
	<div id="header">
		<div class="wrap">
			<div id="logo"><h1><a href="index.php">logo</a></h1></div>
			<?php echo slogoStyle('logo')?>
			<?php echo pbLoginScreen()?>
			<div class="clear"></div>
			
			
			<div id="menu">
				<div class="basket" id="imgSepetGoster" onclick="window.location.href='page.php?act=sepet';" style="cursor:pointer;">
					Sepetinizde <span id="toplamUrun"><?php echo basketInfo('toplamUrun','');?></span> Adet ürün bulunuyor.
				</div><!--.basket END-->
				
				
				<ul class="mleft">
					<li <?php if (strtolower(basename($_SERVER['SCRIPT_FILENAME'])) == 'index.php') echo 'class="selected"'; ?>><a href="#"><span>Tüm Kampanyalar</span></a><div class="sub">
								<ul>
									<?php echo markaList('')?>
								</ul>
							</div></li><li>|</li>
					 <?php echo kategoriList()?>
				</ul>
			</div><!--#menu END-->
			
		</div><!--.wrap END-->
    </div><!--#header END-->
	
	
	
	<div id="content">
		<div class="wrap">
			<div id="mainContent"><?php echo $PAGE_OUT; ?><div style="clear:both"></div></div>
            <div style="clear:both"></div>
		</div><!--.wrap END-->
	</div><!--#content END-->
    <?
		$nullArray = array('urunDetay','kategoriGoster','arama');
		if(isset($_GET['act']) && !in_array($_GET['act'],$nullArray))
		{
			?>
			<style>
				#mainContent { border:1px solid #FEFEFE; background-color:#F4F4F4; margin-top:15px; padding:15px; }
			</style>
            <?
		}
	?>
	<div id="footer">
		<div class="wrap">
			<div class="footMenu">
				<h6>Private Shopping.com</h6>
				<ul>
					<?php echo pbFooterPages()?>
				</ul>
			</div><!--.footMenu END-->
			<div class="footMenu">
				<h6>Sosyal Paylaşım</h6>
				<ul>
					<li><a href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['HTTP_HOST'] ?>">Facebook</a></li>
					<li><a href="http://twitter.com/home?status=<?php echo $siteConfig['seo_title'].' http://'.$_SERVER['HTTP_HOST']?>">Twitter</a></li>
					<li><a href="http://friendfeed.com/share?url=http://<?php echo $_SERVER['HTTP_HOST'] ?>">FriendFeed</a></li>
				</ul>
			</div><!--.footMenu END-->
			
			
			<div class="fRight">
				<ul>
					<li><a href="garanti-ve-iade-sID1.html">Garanti ve İade</a></li>
					<li>|</li>
					<li><a href="kargo-ve-tasima-bilgileri-sID3.html">Kargo ve Taşıma Bilgileri</a></li>
					<li>|</li>
					<li><a href="gizlilik-ve-kullanim-sartlari-sID2.html">Gizlilik ve Kullanım Şartları</a></li>
					<li>|</li>
					<li><a href="<?php echo ($siteConfig['seoURL'] ? 'siparistakip_sp.html':'page.php?act=siparistakip'); ?>">Sipariş Takibi</a></li>
				</ul>
				<div class="clear"></div>
				<div class="cards">
					<a href="#"><img src="templates/p-brown/samples/c1.png" alt="" /></a>
					<a href="#"><img src="templates/p-brown/samples/c2.png" alt="" /></a>
					<a href="#"><img src="templates/p-brown/samples/c3.png" alt="" /></a>
					<a href="#"><img src="templates/p-brown/samples/c4.png" alt="" /></a>
					<a href="#"><img src="templates/p-brown/samples/c5.png" alt="" /></a>
					<a href="#"><img src="templates/p-brown/samples/c6.png" alt="" /></a>
					<a href="#"><img src="templates/p-brown/samples/c7.png" alt="" /></a>
					<a href="#"><img src="templates/p-brown/samples/c8.png" alt="" /></a>
				</div><!--.cards END-->
			</div><!--.fRight END-->
			<div class="clear"></div>
			
			<div class="copyright">
				<div class="power">Powered by <a href="http://www.shopphp.net/" title="PHP E-Ticaret Yazılımı">Shopphp</a></div>
				<div class="rights">Tüm hakları saklıdır.</div>
				&copy; 2011 Siteadı.com Tüm haklari saklidir. Bu sayfayi ziyaret ettiginizde Kullanim Kosullari'ni okumus ve kabul etmis sayilirsiniz. 
			</div>
			
		
		</div><!--.wrap END-->
	</div><!--#footer END-->
<?php echo insertBanner('spfooter')?>
<?php echo scriptmenu();?>
<?php echo sepetGoster()?>
<script>tempStart();</script>
</body>
</html>