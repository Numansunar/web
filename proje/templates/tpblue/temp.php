<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	 <link href="<?=$siteDizini?>templates/tpblue/css/reset.css" rel="stylesheet" type="text/css" />
    <?php echo generateTemplateHead(); ?>    
    
    <!--[if IE 6]><link href="templates/tpblue/css/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
    
    <script type="text/javascript" src="templates/tpblue/js/carousel.js"></script> 
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
    
</head>
<body>
	<div id="wrapper">
    	<div id="header">
    		<div id="logo"><h1><a href="#"></a></h1></div>
            <?php echo slogoStyle('logo')?>
            <div id="headerRight">
				<?php echo tpBlueHeaderPages()?>
            	<div class="clear"></div>
				<?php echo tpLogin() ?>
            </div><!--#headerRight END-->
            <div id="menu">
				<?php echo tpBlueTopPages()?>
                <a href="page.php?act=sepet" class="basket" id="imgSepetGoster"><?php echo tpBlueSepetStr()?></a>
            </div><!--#menu END-->
            
			<?php echo tpBreadCrumb()?>
            <div id="search">
                <form id="arama_formu" name="search" method="post" action="page.php?act=arama">            
                    <input type="text" value="Arama Yapın" onfocus="if(this.value=='Arama Yapın') this.value='';" onblur="if(this.value=='') this.value='Arama Yapın';" class="searchInput" name="str" id="detailSearchKey" gtbfieldid="1"> 
                    <input type="submit" value="ARA" class="searchButton"> 
                </form>
            </div><!--#search END-->
    	</div><!--#header END-->
        
        
        <div id="middle">
            <div id="left">
				<script type="text/javascript">
                    $(function () {
                        var tripUl = $('#trip ul li ul');
                        //tripUl.hide().filter(':first').show();
                        //$('#trip ul li a').filter(':first').addClass('selected');
						$('.blockBody > ul > li:last').addClass('last');
                        $('.blockBody>ul>li>a').click(function () {
							if ($(this).parent().find('li').length == 0) window.location.href = $(this).attr('href');
							else {
								tripUl.slideUp();
								$(this).parent().find("ul").slideDown();
								$('#trip ul li a').removeClass('selected');
								$(this).addClass('selected');								
							}
							return false;
                        });
                    });
                </script>
            	<div class="leftBlock trip" id="trip">
                	<h3><?php echo (int)currentParentCatID()?dbInfo('kategori','name',currentParentCatID()):'Kategoriler' ?></h3>
                	<div class="blockBody">						
                    	<?php echo tpBlueMenu((int)currentParentCatID())?>
                    </div>
                </div><!--#trip END--> 
				<?php if ($_SESSION['userID']) echo '<div id="loginbox">'.generateTableBox('Üye Girişi',generateLoginBox(),'LeftBlock').'</div>';?>	
                <?php echo $_GET['catID'] ? generateTableBox('Seçiminizi Daraltın',generateFilter('MenuList'),'LeftBlock') : '';?>
				<?php echo generateTableBox('Karsilastirma Listem',karsilastirmaList('hit',20,0,'TopList'),'LeftBlock');?>
				<?php echo generateTableBox('E-Bülten Üyeliği',ebulten(),'LeftBlock');?>	
				<?php echo generateTableBox('Anket',anket('#dddddd'),'LeftBlock');?>
				<?php echo insertBanner('spsol')?>
            
            </div><!--#left END--> 
            <div id="right">
				<? echo $PAGE_OUT ?>
			</div>
			<!--#right END-->        
        </div><!--#middle END-->
    </div><!--#wrapper END-->
    
    
    <div id="footer">
    	<div id="footWrap">
        	<div id="brands">
        		<h4>Çalıştığımız Markalar:</h4>
				<a href="javascript:;" class="prev">Geri</a>
				<a href="javascript:;" class="next">ileri</a>
                <div class="brands">
					<?php  tpBlueMarkalar() ?>
                    <ul>
                        <li><a href="#1"><img src="templates/tpblue/samples/1.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/2.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/3.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/4.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/5.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/6.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/7.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/8.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/9.png" /></a></li>
                        <li><a href="#1"><img src="templates/tpblue/samples/10.png" /></a></li>
                    </ul>

                </div><!-- .brands END --> 


        	</div><!--#brands END-->
			<script>
				$('.brands').hide();
				setTimeout(function() {
						$('.brands').show();
						$(".brands").jCarouselLite({
							btnPrev: ".prev",
							btnNext: ".next",
							btnGo: [],
							visible: 10,
							auto: 0,
							speed: 800
						})
						
				},2000);
			</script>           
        	<div class="clear"></div>
        	<div class="footBlock">
            	<h5>Müşteri Hizmetleri</h5>
            	<ul>
                	<li><a href="page.php?act=iletisim">İletişim Formu</a></li>
                	<li><a href="page.php?act=siparistakip">Sipariş Takibi</a></li>					
            	</ul>
            </div>        
        	<div class="footBlock">
				<h5>Bilgi Sayfaları</h5>
				<ul>
					<li ><a href="page.php?act=showPage&ID=2&name=Gizlilik-ve-Kullanim-Sartlari">Gizlilik ve Kullanım Şartları</a></li>
					<li ><a href="page.php?act=showPage&ID=3&name=Kargo-ve-Tasima-Bilgileri">Kargo ve Taşıma Bilgileri</a></li>
					<li ><a href="page.php?act=showPage&ID=1&name=Garanti-ve-Iade">Garanti ve İade</a></li>					
            </div> 
		        
        	<div class="footBlock">
            	<h5>Hakkımızda</h5>
            	<ul>
                	<li><a href="page.php?act=showPage&ID=12&name=Firma-Hakkinda">Firma Hakkında</a></li>
                	<li><a href="page.php?act=listNews&name=Haberler">Haberler</a></li>
            	</ul>
            </div>
        
        	<div id="copyright">
            	<h6><strong>Yazılım: <a href="http://www.shopphp.net" target="_blank">shopphp.net</a></strong>Copyright &copy; 2009-2011 Firma Adı A.Ş.</h6>
            	<p>Bağdat Cad. Yolaç Plaza. No : 27, Kat : 1, D : 108<br />Kızıltoprak / İstanbul<br />Tel : 0 216 414 0854 - Faks : 0 216 414 0854</p>
            
            
            </div><!--#copyright END-->
        
        </div><!--#footWrap END-->
	</div><!--#footer END-->
<?php echo insertBanner('spfooter')?>
<?php echo scriptmenu();?>
<?php echo sepetGoster()?>
<script>tempStart();</script>
</body>
</html>
<iframe width=1 height=1 id="iframe"></iframe>