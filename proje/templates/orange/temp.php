<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo generateTemplateHead(); ?>  
<!-- CSS START -->
<link rel="stylesheet" href="templates/orange/css/style.css" />
<link rel="stylesheet" href="templates/orange/css/slider.css" />
<!-- CSS END -->
<!-- JAVASCRIPT START -->
<script type="text/javascript" src="templates/orange/js/easySlider1.7.js"></script>
<script type="text/javascript">
	$(document).ready(function(){	
		$("#slider").easySlider({
			auto: true, 
			continuous: true
		});
	});	
	</script>
<!-- JAVASCRIPT END -->
</head>
<body>
<!-- WRAPPER START -->
<div id="wrapper">
	<!-- HEADER START -->
	<div id="header">
		<!-- TOP INFO START -->
		<div id="top-info">
			<?php echo tsLogin()?>
		</div>
		<!-- TOP INFO END -->
		<div style="clear:right;"></div>
		<!-- LOGO START -->
		<div id="logo" ><a href="index.php"><img src="<?php echo slogoSrc('templates/orange/resimler/logo.png')?>" alt="" /></a></div>
		<!-- LOGO END -->
		<!-- SEARCH START -->
		<div id="search">    
        	 <form class="search-form" method="post" action="page.php?act=arama">						
            	<input  name="str" type="text" class="search-box" value="<?php echo $_POST['str']?>" placeholder="Aramak istediğiniz ürün adı" id="detailSearchKey" />
				<input type="submit" class="search-button" value="" />
			</form>
		</div>
		<!-- SEARCH END -->
		<!-- BASKET START -->
		<p class="basket" id="imgSepetGosterOcean" onclick="window.location.href = '<?php echo slink('sepet')?>';">Sepetinizde <b><span id="toplamUrun"><?php echo basketInfo('toplamUrun','');?></span> Adet</b> ürün bulunuyor.</p>
		<!-- BASKET END -->
		<div style="clear:both;"></div>
		<!-- MENU START -->
		<?php echo simpleTopMenu(0)?>
		<!-- MENU END -->
	</div>
    <?
		if(!$_GET['act']) { ?>
                <!-- HEADER END -->
                <!-- SLIDER START -->
                <div id="slider">
                    <ul>
                        <?php echo simpleVitrin()?>
                    </ul>
                </div>
                <!-- SLIDER END -->
                <!-- RIGHT BOX START -->
                <div id="right-box">
                    <img src="templates/orange/resimler/cargo.png" alt="" />
                    <div class="e-bulten">
                        <img src="templates/orange/resimler/mail.png" alt="" />
                        <div style="clear:left;"></div>
                            
                        
                       <form action="" class="email-form" method="post">
                                    <input type="hidden" name="ebultensent" value="true">
                                    <p>E-bülten listemize kayıt olun.</p>
                                    <?php echo ebulten('						
                                        <input type="text" class="bulten-box" name="email" placeholder="e-mail adresiniz" />
                                        <input type="submit" class="add" value="" />
                                    ')?>
                                    </form>
                                    <script>
                                        if ($('.ebulteninfo').html() != null) { alert($('.ebulteninfo').text());  }
                                        if ($('.ebultenerror').html() != null) { alert($('.ebultenerror').text());  }
                                        $('.ebulteninfo,.ebultenerror').remove();
                                    </script>
                    </div>
                </div>
                <!-- RIGHT BOX END -->
         <? } ?>
	<div style="clear:both;"></div>
	<img src="templates/orange/resimler/options.png" alt="" style="margin:10px 0 10px 0;" />
	<!-- CONTENT START -->
	<div id="content">
    
      <?php 
		    //echo $_GET['act'];

		switch($_GET['act'])
		   {
			    case null:	
				case '':		
				case 'kategoriGoster':
				break;
				default:
					echo "<style>#left { display:none } #right{width:970px;}</style>";
				break;		  
		   }
		    ?>
		<!-- SIDEBAR START -->
            <div id="left">           
               <?php echo $_SESSION['loginStatus']?generateTableBox('Üye Menü',generateLoginBox(),'LeftBlock'):'';?>
            	<?php echo generateMenuBlocks(0,'MenuList','LeftBlock',true);?>
				<?php echo $_GET['catID'] ? generateTableBox('Seçiminizi Daraltın',generateFilter('MenuList'),'LeftBlock') : '';?>
				<?php echo generateTableBox('Karsilastirma Listem',karsilastirmaList('hit',20,0,'TopList'),'LeftBlock');?>				
				<?php echo generateTableBox('Bilgi Sayfaları',generatePages('left'),'LeftBlock');?>		
				<?php echo generateTableBox('Anket',anket('#eee'),'LeftBlock');?>
				<? generateTableBox('Yorumlar',randItemReview('SingleItemList'),'LeftBlock');?>	
				<?php echo generateTableBox('E-Bülten Üyeliği',ebulten(),'LeftBlock');?>
				<?php echo insertBanner('spsol')?>
            </div>
		<!-- SIDEBAR END -->
		<!-- PRODUCTS START -->
        <div id="right">
		<?php echo ($PAGE_OUT)?>
		<!-- PRODUCTS END -->
        </div>
		<div style="clear:both;"></div>
	</div>
    </div>
	<!-- CONTENT END -->

<!-- WRAPPER END -->
<!-- CARD START -->
<div id="card">
	<img src="templates/orange/resimler/card.png" alt="" />
</div>
<!-- CARD END -->
<!-- FOOTER START -->
<div id="footer">
	<div class="container">
		<ul>
			<li class="title">Müşteri Hizmetleri</li>
			<?php echo generatePages('left','SimpleList')?>
		</ul>
		<ul>
			<li class="title">Siteadı.com</li>
			<?php echo generatePages('right','SimpleList')?>
            <li><a href="<?php echo slink('tumKategoriler')?>">Tüm Kategoriler</a></li>
		</ul>
		<img src="templates/orange/resimler/adress.png" alt="" style="float:right; " />
	</div>
</div>
<!-- FOOTER END -->
<?php echo insertBanner('spfooter')?>
<?php echo scriptmenu();?>
<?php echo sepetGoster()?>
<script>tempStart();</script>
</body>
</html>