<!DOCTYPE HTML>
<html lang="tr-TR">
	<head>
	<?php echo generateTemplateHead(); ?>

	<!-- css -->
	<link rel="stylesheet" href="templates/mcshop/css/style.css" />
	<link href='//fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- //css -->
	<!-- javascript -->
	<script type="text/javascript" src="templates/mcshop/js/easySlider1.7.js"></script>
	<script type="text/javascript" src="templates/mcshop/js/jquery.bxslider.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){	
			$("#main-slider").easySlider({
				auto: true, 
				continuous: true,
				numeric: true
			});
		});	
	</script>
	<!-- //javascript -->
	</head>
	<body>
<!-- header -->
<div class="header">
      <div class="wrapper"> 
    <!-- logo -->
    <div class="logo"><a href=""><img src="<?=slogoSrc('templates/mcshop/img/logo.png')?>" alt="<?=$_SERVER['HTTP_HOST']?>" /></a></div>
    <!-- //logo --> 
    <!-- head user -->
    <div class="head-user">
          <div class="head-user-top">
        <div class="head-phone">
              <?=siteConfig('firma_tel')?>
            </div>
        <div class="head-user-menu">
              <ul>
            <?=simplePageList(2)?>
          </ul>
            </div>
        <div class="clear"></div>
      </div>
          <div class="user-menu" style="display:none"> <a href="" class="profile-link"><img src="templates/mcshop/img/user.png" alt="" /></a>
        <ul>
              <li><a href="<?=slink('login')?>">
                <?=_lang_titleLogin?>
                </a></li>
              <li><a href="<?=slink('register')?>">
                <?=_lang_uyeOlmakIstiyorum?>
                </a></li>
            </ul>
      </div>
        </div>
    <!-- //head user -->
    <div class="clear"></div>
    <!-- mobile user menu -->
    <div class="mobile-user-menu">
          <ul>
        <li><a href="<?=slink('login')?>">??ye Giri??i</a></li>
        <li><a href="<?=slink('register')?>">Kay??t Ol</a></li>
      </ul>
          <div class="clear"></div>
        </div>
    <!-- //mobile user menu --> 
    <!-- mobile search -->
    <div class="mobile-search">
          <form action="page.php">
          	<input type="hidden" name="act" value="arama">
        <input type="text" class="mobile-box" name="str" placeholder="Aramak istedi??iniz ??r??n"/>
        <input type="submit" class="mobile-btn" value="" />
      </form>
        </div>
    <!-- //mobile search --> 
    <!-- all category -->
     <div class="all-category"> <a href="<?=slink('tumKategoriler')?>" onclick="$('.all-categories').toggle()" class="all-link">
      <?=_lang_tumKategoriler?>
      </a>
          <div class="all-categories"> <img src="templates/mcshop/img/menuarrow.png" class="menu-arrow" alt="" />
        <ul>
              <?=simpleCatList2()?>
            </ul>
        <div class="clear-space"></div>
        <div class="all-cat-bar"> En be??endi??iniz markalar??n en iyi ??r??nlerine en uygun fiyatlarla hemen sahip olabilirsiniz.
              <div class="view-btn"><a href="<?=slink('indirimde')?>">??ndirimlere ??r??nlere g??zat??n</a></div>
            </div>
      </div>
        </div>
    <!-- //all category --> 
    <!-- search -->
    <div class="search">
          <form action="page.php" method="get">
        <input type="hidden" name="act" value="arama" />
        <input type="text" class="s-box" name="str" placeholder="<?=_lang_arama?>" id="detailSearchKey" />
      </form>
        </div>
    <!-- //search --> 
    <!-- basket -->
    <div class="basket"> <a href="<?=slink('sepet')?>" id="imgSepetGoster"> <span class="span1">
      <?=_lang_titleSepet?>
      </span> <span class="span2">
      <?=basketInfo('toplamUrun')?>
      </span> </a> </div>
    <!-- //basket --> 
  </div>
    </div>
<!-- //header --> 
<!-- content -->
<div class="content">
<div class="wrapper">
<? 
			$singleBlockArray = array('sepet','urunDetay','login','satinal'); 
			if($_GET['act'] && !in_array($_GET['act'],$singleBlockArray))
			{
				$cID = hq('select ID from kategori where parentID=\''.currentCat().'\'')?currentCat():currentParentCatID();
				$cName = hq("select name from kategori where ID='$cID'");
				?>
<div class="category-page">
      <div class="sidebar"> 
    <!-- sidebar menu -->
    <div class="sidebar-menu">
          <div class="sidebar-menu-title"><?php echo $cName?$cName:'Kategoriler' ?></div>
          <ul>
        <?=simpleCatList($cID)?>
      </ul>
        </div>
    
    <!-- //sidebar menu --> 
    <!-- category filter -->
    <? if($_GET['act'] == 'kategoriGoster') echo generateTableBox('Se??imi Daralt??n',generateFilter('FilterLists'),'LeftBlockUL');?>
    <?=generateTableBox('Anket',anket(),'LeftBlock');?>
    <?=generateTableBox('Haberler',generateLastNews(5),'LeftBlockUL');?>
    <?=generateTableBox('Blog',makaleCatList(0),'LeftBlockUL');?>
    <?=generateTableBox('Galeri',simpleGalleryCatList(),'LeftBlockUL');?>
    <div class="clear-space">&nbsp;</div>
    <div class="support"><a href="<?=slink('iletisim')?>"><img src="templates/mcshop/img/supportbtn.png" alt="" /></a></div>
  </div>
      <div class="category-content">
    <?	
			}
		?>
    <?=$PAGE_OUT?>
    <? if($_GET['act'] && !in_array($_GET['act'],$singleBlockArray)) echo '</div></div>';?>
    <!-- showcase --> 
  </div>
      <div class="clear"></div>
    </div>
<!-- //content --> 
<!-- footer -->
<div class="footer">
      <div class="wrapper"> 
    <!-- footer top -->
    <div class="footer-top">
          <div class="footer-top-title">Haberdar Olun!</div>
          <div class="footer-top-text">
        <?=$_SERVER['HTTP_HOST']?>
        b??ltenlerine ??ye olup yeniliklerden ve ??zel fiyatl?? ??r??nlerden haberdar olun.</div>
          <div class="ebulten">
        <form action="" onSubmit="ebultenSubmit('ebulten'); return false;">
              <input type="text" placeholder="<?=_lang_formEpostaAdresiniz?>" id="ebulten" class="e-box" />
              <input type="submit" value="" class="e-btn" />
            </form>
      </div>
        </div>
    <!-- //footer top -->
    <div class="clear"></div>
    <!-- footer left -->
    <div class="footer-left">
          <div class="footer-adress">
        <div>
              <?=$_SERVER['HTTP_HOST']?>
            </div>
        <?=siteConfig('firma_adi')?>
        <br>
        <?=siteConfig('firma_tel')?>
        <br>
        <?=siteConfig('firma_adres')?>
        <br>
        E-Posta : <a href="mailto:<?=siteConfig('firma_email')?>">
            <?=siteConfig('firma_email')?>
            </a> </div>
        </div>
    <!-- //footer left --> 
    <!-- footer menu -->
    <div class="footer-menu last">
          <div class="footer-title">??YE ????LEMLER??</div>
          <ul>
        <li><a href="<?=slink('register')?>">??ye Kay??t</a></li>
        <li><a href="<?=slink('login')?>">??ye Giri??</a></li>
        <li><a href="<?=slink('siparis')?>">Sipari?? Takibi</a></li>
        <li><a href="<?=slink('sifre')?>">??ifre Hat??rlatma</a></li>
        <li><a href="<?=slink('sepet')?>">Al????veri?? Listem</a></li>
        <li><a href="<?=slink('profile')?>">Bilgilerimi De??i??tir</a></li>
      </ul>
        </div>
    <!-- //footer menu --> 
    <!-- footer menu -->
    <div class="footer-menu">
          <div class="footer-title">KURUMSAL</div>
          <ul>
        <?=simplePageList(1)?>
      </ul>
        </div>
    <!-- //footer menu --> 
    <!-- footer menu -->
    <div class="footer-menu">
          <div class="footer-title">YARDIM</div>
          <ul>
        <?=simplePageList(2)?>
      </ul>
        </div>
    <!-- //footer menu -->
    <div class="clear"></div>
    <!-- footer bottom -->
    <div class="footer-bottom">
          <div class="bank"><img src="templates/mcshop/img/bank.png" alt="" /></div>
          <div class="footer-copyright"> Bu sitede yer alan t??m ??r??n ve g??rsellerin izinsiz kullan??m?? ve payla????m?? kesinlikle yasakt??r.
        ??zinsiz kullan??m??nda t??m yasal sorumlulu??u kabul etmi?? say??l??rs??n??z. </div>
        </div>
    <!-- //footer bottom --> 
  </div>
    </div>
<!-- //footer --> 
<?php echo generateTemplateFinish();?>
</body>
</html>