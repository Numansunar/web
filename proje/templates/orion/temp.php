<?php //print_r($_GET['act']);
	if($_GET['act'] == 'satinal') {echo "<style type='text/css'>#content {padding-top:15px!important;}</style>";}
	$cleanPages = array('satinal','register','iletisim','profile','siparistakip'); 
	if(in_array($_GET['act'],$cleanPages)) { $PAGE_OUT = str_replace(array('&nbsp;','<br>','this.value=this.value.replace'),array('','',''),$PAGE_OUT); }
	$checkoutVisible = ($_GET['act'] == 'satinal' && !isReallyMobile()) ? 'hidden' : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<?php echo generateTemplateHead(); ?> 
		<meta charset="utf-8">
		<meta name="HandheldFriendly" content="True" /> 
		<meta name="MobileOptimized" content="320" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="dns-prefetch" href="//www.google-analytics.com">
		<link rel="dns-prefetch" href="//www.googletagmanager.com">
		<link rel="dns-prefetch" href="//www.facebook.com">
		<link rel="dns-prefetch" href="//stats.g.doubleclick.net">
		<link rel="dns-prefetch" href="//googleads.g.doubleclick.net">
		<link rel="dns-prefetch" href="//bid.g.doubleclick.net">
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link rel="dns-prefetch" href="//fonts.googleapis.com">
		<link rel="stylesheet" type="text/css" href="templates/orion/assets/lib/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="templates/orion/assets/lib/font-awesome/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="templates/orion/assets/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="templates/orion/assets/css/style.css" />
		<link rel="stylesheet" type="text/css" href="templates/orion/assets/css/responsive.css" />
		<link rel="stylesheet" type="text/css" href="templates/orion/assets/lib/owl.carousel/owl.carousel.css" />
		<link rel="stylesheet" type="text/css" href="templates/orion/assets/lib/jquery-ui/jquery-ui.css" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<?php if(isReallyMobile()) { ?>
			<link rel="stylesheet" type="text/css" href="templates/orion/assets/css/jquery.mmenu.all.css" />
		<?php } ?>
	</head>
	<body class="<?php if(!$_GET['act']) { echo "home"; } else { echo "page".$_GET['act'];} ?>"> 

		<div id="header" class="header">
			<div class="headerTop-discount <?=$checkoutVisible;?>">
				<div class="container">
					<div class="colgroup">
						<div class="column">Seçili Ürünlerde %15'e Varan İndirim Fırsatı!</div>
					</div>
				</div>				
			</div> 
			<div class="top-header hidden-xs <?=$checkoutVisible;?>">
				<div class="container">
					
					<div class="pull-left support-link hidden-sm hidden-md">
						<a href="./ac/iletisim"><i class="material-icons">phone</i> Tel : <?=siteConfig('firma_tel')?></a>
					</div>
					
					<div class="support-link">
						<? if(!$_SESSION['userID']) { ?>
							<a href="<?=slink('login')?>"><i class="material-icons">person</i> Üye Girişi</a>
							<a class="hidden-xs" href="<?=slink('register')?>"><i class="material-icons">person_add</i> Kayıt Ol</a>
							<a href="/ac/siparistakip"><span class="material-icons"> local_shipping </span> Sipariş Takibi</a>
							<a href="ac/iletisim"><i class="material-icons">phone</i> İletişim</a>
							
							<? } else { ?>
							
							<a href="<?=slink('login')?>"><i class="material-icons">person</i> Hesabım</a>
							<a href="/ac/siparistakip"><span class="material-icons"> local_shipping </span> Sipariş Takibi</a>
							<a class="hidden-xs" href="ac/iletisim"><i class="material-icons">phone</i> İletişim</a>
							<a href="<?=slink('logout')?>" class="btn-signout"><i class="material-icons">keyboard_tab</i> Çıkış Yap</a>
							
						<? } ?>
					</div>
					
				</div>
			</div>
			
			<div id="main-header" class="container main-header">
				<div class="row">

					<?php if(isReallyMobile()) { ?>
					<div class="col-xs-4 col-sm-3 hidden-lg mobileMenuLeft">
						<div class="mobileMenu"><a href="#menu"><i class="material-icons">menu</i><span>menü</span></a></div>
						<div class="btnSearch"><i class="material-icons">search</i></div>
					</div>
					<?php } ?>

					<div class="col-lg-3 col-sm-5 col-xs-4 logo">
						<a href="./"><img alt="<?=siteConfig('seo_title')?>" src="<?=slogoSrc('templates/orion/images/logo.png')?>" /></a>
					</div>
					
					<?php if(!isReallyMobile()) { ?>
					<div class="col-lg-6 hidden-xs header-search-box <?=$checkoutVisible;?>">
						<form class="form-inline" action="page.php?act=arama" method="post">
							<div class="form-group input-serach">
								<input type="text" id="detailSearchKey" name="str" placeholder="Aranacak Kelime...">
								<button type="submit" class="pull-right btn-search"><i class="material-icons">search</i></button>
							</div>
						</form>
					</div>
					<?php } ?>

					<div class="col-lg-3 col-sm-4 col-xs-4 user-block <?=$checkoutVisible;?>">
					    <div class="user-navigation-container">
					        <ul class="user-navigation">

					        	<? if(!$_SESSION['userID'] & !isReallyMobile()) { ?>

					            <li class="login-register-button-container">
					                <div class="icon-container"><i class="material-icons">person</i></div>
					                <div class="login-container hidden-xs hidden-sm">
					                    <span>Giriş Yap</span>
					                    <div class="login-panel-container">
					                        <a href="<?=slink('login')?>"><div class="account-button login"> Giriş Yap</div></a>
					                        <a href="<?=slink('register')?>"><div class="account-button register">Üye Ol</div></a>
					                    </div>
					                </div>
					            </li>
					        <? } else { ?>
					        	<li class="login-register-button-container">
								    <a href="<?=slink('login')?>">
								        <div class="icon-container"><i class="material-icons">person</i></div>
								        <div class="login-container hidden-xs hidden-sm"><span>Hesabım</span></div>
								    </a>
								</li>

					        <? } ?>

					            <li class="hidden-xs">
					                <a href="./ac/alarmList">
					                    <div class="icon-container"><i class="material-icons">favorite_border</i></div>
					                    <div class="nav-span hidden-sm">Favorilerim</div>
					                </a>
					            </li>

					            <li id="imgSepetGoster" class="basket-button-container">
					                <div class="icon-container"><i class="material-icons">shopping_cart</i></div>
					                <div class="nav-span hidden-xs hidden-sm">Sepetim</div>
					                <div class="basket-item-count"><span id="toplamUrun"><?=basketInfo('toplamUrun')?></span></div>
					            </li>

					        </ul>
					    </div>
					</div>
					
					<?php if(isReallyMobile()) { ?>
						<div class="clearfix"></div>
						<div class="search-box">
							<form class="form-inline" action="page.php?act=arama" method="post">
								<div class="input-search">
									<input type="text" id="detailSearchKey" name="str" placeholder="Aranacak Kelime..." autocomplete="off">
									<button type="submit" class="btn-search"><i class="material-icons">search</i></button>
								</div>
							</form>
						</div>
					<?php } ?>

				</div>    
			</div>
		
		<?php if(!isReallyMobile()) { ?>

			<div id="nav-top-menu" class="nav-top-menu <?=$checkoutVisible;?>">
				<div class="container">
					<div class="row">

						<div id="main-menu" class="col-sm-12 main-menu">
							<nav class="navbar navbar-default">
								<div class="container-fluid">
									<div id="navbar" class="navbar-collapse collapse">
										<ul class="nav navbar-nav">
											<?=orionTopMenu(false,12)?>
										</ul>
										</div>
								</div>
							</nav>
						</div>						
					</div>
				</div>
			</div>
		<?php } ?>

		</div>
		
		<?php if(isReallyMobile()) { ?>
			<div class="menufix hidden-lg">
				<a class="home" href="./"><i class="fa fa-home"></i>Anasayfa</a>
				<? if(!$_SESSION['userID']) { ?>
					<a href="<?=slink('login')?>"><i class="fa fa-user"></i>Üye Girişi</a>
					<? } else { ?>
					<a href="<?=slink('login')?>"><i class="fa fa-user"></i>Hesabım</a>
				<? } ?>
				<?php if (basketInfo('toplamUrun') > 0) { ?>
					<a href="./ac/sepet"><span id="toplamUrun" class="cart_total"><?=basketInfo('toplamUrun')?></span><i class="fa fa-shopping-bag"></i>Sepetim</a>
					<?php } else { ?>
					<a href="./ac/sepet"><i class="fa fa-shopping-bag"></i>Sepetim</a>
				<?php } ?>
				<a href="./ac/siparistakip"><i class="fa fa-truck"></i>Sipariş Takibi</a>
				<a href="./ac/iletisim"><i class="fa fa-phone-square"></i>İletişim</a>
			</div>
		<?php } ?>
		
		<?php if(!$_GET['act']) { ?>
		
		<div class="content-wrap">	
			<div class="container">
				<div class="row">
					<div class="col-lg-9">
						<div class="vitrinSlider">
							<?=mainSlider(0)?>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="urunFirsatSlider">
							<h2 class="page-heading">
								<span class="page-heading-title"><span class="material-icons"> notification_important </span> Günün Fırsatları</span>
							</h2>
							<ul class="product-list">
								<?php echo urunlist('select * from urun where active=1 AND stok > 0 AND indirimde=1 order by ID,seq desc limit 0,5','UrunList','UrunListFirsat'); ?>
							</ul>
						</div>
					</div>
				</div>

					<div class="service">
						<?php if(isReallyMobile()) { ?><div class="serviceMobile"><?php } ?>
						<div class="service-item">
							<div class="icon"><i class="fa fa-expeditedssl"></i></div>
							<div class="info"><a href="#"><h3>GÜVENLİ ALIŞVERİŞ</h3></a></div>
						</div>

						<div class="service-item">
							<div class="icon"><i class="fa fa-truck"></i></div>
							<div class="info"><a href="#"><h3>ÜCRETSİZ KARGO</h3></a></div>
						</div>
						
						<div class="service-item">
							<div class="icon"><i class="fa fa-credit-card"></i></div>
							<div class="info"><a href="#"><h3>TAKSİT İMKANI</h3></a></div>
						</div>
						
						<div class="service-item">
							<div class="icon"><i class="fa fa-truck"></i></div>
							<div class="info"><a href="#"><h3>KAPIDA ÖDEME İMKANI</h3></a></div>
						</div>

						<div class="service-item">
							<div class="icon"><i class="fa fa-recycle"></i></div>
							<div class="info"><a href="#"><h3>İADE İMKANI</h3></a></div>
						</div>
						<?php if(isReallyMobile()) { ?></div><?php } ?>
						<div class="clearfix"></div>
					</div>
				<div class="clearfix"></div>

				<div class="page-product-box UrunSliderWrap">
					<h2 class="page-heading"><span class="page-heading-title"><span class="material-icons"> alarm_on </span> Yeni Gelenler</span></h2>
					<ul class="product-list">
						<?php echo urunlist('select * from urun where active=1 AND stok > 0 AND yeni=1 order by ID,seq desc limit 0,12','UrunList','UrunListBenzer'); ?>
					</ul>
				</div>
				 
				<div class="clearfix"></div>

				<div class="banner-bottom">
					<div class="bannerSlider">
						<div class="col-lg-4 col-xs-12">
							<div class="banner-boder-zoom">
								<?=insertBannerx('banner1')?>
							</div>
						</div>
						<div class="col-lg-4 col-xs-12">
							<div class="banner-boder-zoom">
								<?=insertBannerx('banner2')?>
							</div>
						</div> 
						<div class="col-lg-4 col-xs-12">
							<div class="banner-boder-zoom">
								<?=insertBannerx('banner3')?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div>

				<div class="page-product-box">
					<h2 class="page-heading">
						<span class="page-heading-title"><span class="material-icons"> grade </span> Sizin İçin Seçtiklerimiz</span>
					</h2>
					<div class="product-tab home-tab home_prod">
						<div class="tab-container">
							
							<div id="tab-1" class="tab-panel active">
								<ul class="row product-list grid">
									<?php echo urunlist('select * from urun where active=1 AND stok > 0 AND anasayfa=1 order by ID,seq desc limit 0,8','UrunList','UrunListOnecikan'); ?>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="banner-bottom">
					<div class="col-lg-12">
						<div class="banner-boder-zoom">
							<?=insertBannerx('banner4')?>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div>	

				<div class="banner-bottom">
					<div class="bannerSlider">
						<div class="col-lg-3 col-xs-12">
							<div class="banner-boder-zoom">
								<?=insertBannerx('banner5')?>
							</div>
						</div>
						<div class="col-lg-3 col-xs-12">
							<div class="banner-boder-zoom">
								<?=insertBannerx('banner6')?>
							</div>
						</div> 
						<div class="col-lg-3 col-xs-12">
							<div class="banner-boder-zoom">
								<?=insertBannerx('banner7')?>
							</div>
						</div>
						<div class="col-lg-3 col-xs-12">
							<div class="banner-boder-zoom">
								<?=insertBannerx('banner8')?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div>
				
				<div class="blog-list">
					<div class="blog-list-wapper home_icerik">
						<?php if(siteConfig('footerText')) { ?> <p><?=siteConfig('footerText');?></p>
							<?php } else { ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut mollis mi. Donec condimentum mauris quis eleifend elementum. Phasellus commodo cursus mi, id sagittis nisl pretium quis. Praesent sit amet cursus turpis. Pellentesque egestas ipsum sit amet nunc posuere maximus. Duis ac egestas orci, eu efficitur risus. Etiam condimentum urna nisi, non molestie dui tincidunt vel. Aenean facilisis orci est, quis mollis turpis elementum id. Nullam vitae accumsan risus…Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut mollis mi. Donec condimentum mauris quis eleifend elementum. Phasellus commodo cursus mi, id sagittis nisl pretium quis. 
								
							Praesent sit amet cursus turpis. Pellentesque egestas ipsum sit amet nunc posuere maximus. Duis ac egestas orci, eu efficitur risus. Etiam condimentum urna nisi, non molestie dui tincidunt vel. Aenean facilisis orci est, quis mollis turpis elementum id. Nullam vitae accumsan risus…Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut mollis mi. Donec condimentum mauris quis eleifend elementum. Phasellus commodo cursus mi, id sagittis nisl pretium quis. Praesent sit amet cursus turpis. Pellentesque egestas ipsum sit amet nunc posuere maximus. Duis ac egestas orci, eu efficitur risus. Etiam condimentum urna nisi, non molestie dui tincidunt vel. Aenean facilisis orci est, quis mollis turpis elementum id. Nullam vitae accumsan risus…</p>
						<?php } ?>
					</div>
				</div>

				<div class="fadeText"></div>

				<div class="clearfix"></div>	

				<div class="blog-list">
					<h2 class="page-heading">
						<span class="page-heading-title"><span class="material-icons"> book </span> Blog & Haberler</span>
					</h2>
					
					<div class="blog-list-wapper">
						<ul class="owl-carousel" data-dots="false" data-loop="false" data-nav = "true" data-margin = "30" data-autoplayTimeout="1000" data-autoplayHoverPause = "true" data-responsive='{"0":{"items":1},"600":{"items":2},"1000":{"items":4}}'>
							<?php echo makaleList(8); ?>
						</ul>
					</div>
				</div>

				<div class="clearfix"></div>

			</div>
			
			<?php }
			$singleBlockArray = array('kategoriGoster');
			if(in_array($_GET['act'],$singleBlockArray)) { ?>
			
			<div class="columns-container">
				<div class="container" id="columns">

					<div class="breadcrumb clearfix">
						<li class="home"><a href="./"><i class="fa fa-home"></i> Anasayfa</a></li> 
						<?php echo myBreadCrumb(); ?> 			  			  
					</div>

					<div class="row">
						<div class="column col-xs-12 col-lg-3" id="left_column">
							<div class="block left-module">
								<p class="title_block">Alt Kategoriler <span class="downicon pull-right fa fa-caret-down"></span></p>
								<div class="block_content">
									<div class="layered layered-category">
										<div class="layered-content">
											<ul class="tree-menu">
												<?php echo simpleCatList(hq('select ID from kategori where parentID=\''.currentCat().'\'')?currentCat():currentParentCatID());  ?>
											</ul>
										</div>
									</div>
								</div>
							</div>

							<div class="block left-module">
								<p class="title_block">Detaylı Filtre <span class="downicon pull-right fa fa-caret-down"></span></p>
								<div class="block_content">
									<div class="layered layered-filter-price">
										<?php echo generateTableBox('SEÇİMİ DARALTIN',generateFilter('FilterLists'),'FilterLeft'); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="center_column category_prod col-xs-12 col-lg-9" id="center_column">
							<div id="view-product-list" class="view-product-list">
								<ul class="product-list grid">
									<?=$PAGE_OUT?>
								</ul>
							</div>
						</div>	

					</div>
				</div>
			</div>

			<?php } if($_GET['act'] == 'urunDetay') { ?>

			<div class="columns-container">
				<div class="container" id="columns">
					<div class="breadcrumb clearfix">
						<li class="home"><a href="./"><i class="fa fa-home"></i> Anasayfa</a></li> 
						<?php echo myBreadCrumb(); ?> 			  
					</div>
					
					<div class="row">
						<div class="center_column col-xs-12 col-sm-12" id="center_column">
							<div id="product">
								<?=$PAGE_OUT?>
							</div>
						</div>
					</div>
					
				</div>
			</div>

			<?php } 
			if($_GET['act'] == 'galleryList') { ?>

			<div class="columns-container">
				<div class="container" id="columns">
					<div class="breadcrumb clearfix">
						<li class="home"><a href="./"><i class="fa fa-home"></i> Anasayfa</a></li> 
						<?php echo myBreadCrumb(); ?> 			  
					</div>
					<div class="row">
						
						<div class="center_column col-xs-12 col-sm-12">
							<div id="content">
								<?=$PAGE_OUT?>
								<div class="galleryList">
									<h2 class="page-heading clearfix"> <span class="page-heading-title">Tüm Galeri Listesi</span> </h2>
									<?=simpleGalleryCatList()?>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>

		<?php }
			$singleBlockArray = array('sepet','login','register','profile','bakiye','modDavet','modDavet-liste','satinal','havaleBildirim','showBlog','sss','sifre','iletisim','siparistakip','tumKategoriler','adres','urunlerim','showOrders','hataBildirim','iptal','showPage','shows','qregister','galeri','smsOnay','procark','ticket','showNews','haber','siparisYorum','affilate','affbasvuru','showCodes','markaList','teknik','instagram','makale','paketler','logout','404','fList');
			if(in_array($_GET['act'],$singleBlockArray)) {
			?>
			
			<div class="columns-container">
				<div class="container" id="columns">
					<div class="breadcrumb clearfix <?=$checkoutVisible;?>">
						<li class="home"><a href="./"><i class="fa fa-home"></i> Anasayfa</a></li> 
						<?php echo myBreadCrumb(); ?> 			  
					</div>
					<div class="row">
						
						<div class="center_column col-xs-12 col-sm-12">
							<div id="content">
								<?=$PAGE_OUT?>
							</div>
						</div>
						
					</div>
				</div>
			</div>

		<?php } $singleBlockArray = array('makaleListe','blog');
			if(in_array($_GET['act'],$singleBlockArray)) { ?>
			<div class="columns-container">
				<div class="container" id="columns">
					<div class="row">
						<div class="center_column col-xs-12 col-sm-12 blog-listx">
							<div id="content" class="blog-list-wapper">
								<?=$PAGE_OUT?>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } $singleBlockArray = array('alarmList','yeni','indirimde','showKeyResult','cokSatanlar');
			if(in_array($_GET['act'],$singleBlockArray)) { ?>

			<div class="columns-container">
				<div class="container" id="columns">
				
					<div class="breadcrumb clearfix">
						<li class="home"><a href="./"><i class="fa fa-home"></i> Anasayfa</a></li> 
						<?php echo myBreadCrumb(); ?> 			  			  
					</div>

					<div class="row">
						<div class="column col-xs-12 col-lg-3" id="left_column">
							<div class="block left-module">
								<p class="title_block">Kategoriler <span class="downicon pull-right fa fa-caret-down"></span></p>
								<div class="block_content">
									<div class="layered layered-category">
										<div class="layered-content">
											<ul class="tree-menu">
												<?php echo simpleCatList(hq('select ID from kategori where parentID=\''.currentCat().'\'')?currentCat():currentParentCatID());  ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="center_column category_prod col-xs-12 col-lg-9" id="center_column">
							<div id="view-product-list" class="view-product-list">
								<ul class="product-list grid">
									<?=$PAGE_OUT?>
								</ul>
							</div>
						</div>	

					</div>
				</div>
			</div>

			<?php } 
			$singleBlockArray = array('arama'); if(in_array($_GET['act'],$singleBlockArray)) {
			?>

			<div class="columns-container">
				<div class="container" id="columns">
					<div class="row">
						<div class="center_column col-xs-12 col-sm-12">
							<div id="content">
								<div class="product-list grid aramaPage">
									<?=$PAGE_OUT?>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>
		
		</div>

		<div id="footer" class="footer">
			<div class="container">
				<div id="introduce-box">

					<div class="col-md-9 col-xs-12">
						<div class="row">
							
							<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
								<div class="introduce-title">Kurumsal</div>
								<ul id="introduce-company"  class="introduce-list">
									<?=simplePageList(1)?>
								</ul>
							</div>
							
							<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
								<div class="introduce-title">Müşteri Hizmetleri</div>
								<ul id="introduce-company"  class="introduce-list">
									<?=simplePageList(2)?>
								</ul>
							</div>
							
							<div class="col-lg-3 col-md-4 col-sm-4 hidden-xs">
								<div class="introduce-title">Hızlı Erişim</div>
								<ul id="introduce-company" class="introduce-list">
									<li><a href="./">Anasayfa</a></li>
									<li><a href="<?=slink('yeni')?>">Yeni Ürünler</a></li>
									<li><a href="<?=slink('indirimde')?>">İndirimdeki Ürünler</a></li>
									<li><a href="./ac/siparistakip">Sipariş Takip</a></li>
									<li><a href="./ic/hakkimizda">Hakkımızda</a></li>
								</ul>
							</div>
							
							
							<div class="col-lg-3 hidden-md hidden-sm hidden-xs">
								<div class="introduce-title">Popüler Kategoriler</div>
								<ul id="introduce-company" class="introduce-list">
									<?=populerCats(false,5);?>
								</ul>
							</div>
						</div>

					</div>

					<?php if(isReallyMobile()) { ?><div class="hr clearfix"></div><?php } ?>

					<div class="col-lg-3">
						<div id="contact-box">
							<div class="introduce-title hidden-xs">E-Bülten Aboneliği</div>
							<form class="hidden-xs" action="" onSubmit="ebultenSubmit('ebulten'); return false;">
								<div class="input-group" id="mail-box">
									<input type="text" id="ebulten" placeholder="e-mail adresiniz.."/>
									<span class="input-group-btn">
										<input type="submit" value="GÖNDER" class="btn btn-default" />
									</span>
								</div>
							</form>
							<div class="introduce-title">Sosyal Medya</div>
							<div class="social-link">
								<a href="<?=siteConfig('facebook_URL')?>" target="_blank"><i class="fa fa-facebook"></i></a>
								<a href="<?=siteConfig('instagram_URL')?>" target="_blank"><i class="fa fa-instagram"></i></a>
								<a href="<?=siteConfig('twitter_URL')?>" target="_blank"><i class="fa fa-twitter"></i></a>
								<a href="<?=siteConfig('youtube_URL')?>" target="_blank"><i class="fa fa-youtube"></i></a>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
				
				<div id="trademark-box">
					<div class="col-sm-12">
						<div class="row">
							<ul id="trademark-list">
								<li>
									<a href="#"><img src="templates/orion/images/creditcardlogos-1.jpg" alt="banka logoları"/></a>
								</li>
							</ul> 
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div id="footer-menu-box">
					<p class="text-center">Copyrights © <?=date('Y')?> <?=siteConfig('firma_adi')?></p>
				</div>
				
			</div> 
		</div>
		
		<?php if(isReallyMobile()) { ?>
			<nav id="menu" class="hidden-lg">
				<ul><?=orionMobileMenu(false,50)?></ul>
			</nav>
		<?php } ?>
		<div class="loadingoverlay" style="display:none;"><div class="loadingoverlay_text"><div class="spinner"></div><span>Lütfen Bekleyiniz..</span></div></div>
		<script type="text/javascript" src="templates/orion/assets/lib/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="templates/orion/assets/lib/bootstrap/js/jquery.cookie.js"></script>
		<script type="text/javascript" src="templates/orion/assets/lib/owl.carousel/owl.carousel.min.js"></script>
		<script type="text/javascript" src="templates/orion/assets/js/jquery.actual.min.js"></script>
		<script type="text/javascript" src="templates/orion/assets/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="templates/orion/assets/js/lozad.min.js"></script>
		<?php if(isReallyMobile()) { ?><script type="text/javascript" src="templates/orion/assets/js/jquery.mmenu.all.min.js"></script><?php } ?>
		<script type="text/javascript" src="templates/orion/assets/js/custom.js"></script>
		<?php echo generateTemplateFinish();?>
		<?php if(isReallyMobile()) { ?>
			<script type="text/javascript">
				$('nav#menu').mmenu({ extensions : [ 'effect-slide-menu', 'shadow-page', 'shadow-panels' ], keyboardNavigation : false, screenReader : true, counters : false, navbar : { title : 'KATEGORİLER' }, navbars : [ { position : 'top', content : [ 'prev', 'title', 'close' ] }, { position : 'bottom', 
					<? if($_SESSION['userID']) { ?>
						content : [ '<a href="<?=slink('login')?>">HESABIM</a><a href="<?=slink('logout')?>">ÇIKIŞ YAP</a>' ] <?php } else { ?>
					content : [ '<a href="./ac/register">KAYIT OL</a><a href="./ac/login">GİRİŞ YAP</a>' ] <?php } ?>
				} ], "extensions": [ "pagedim-black", "shadow-page", "shadow-panels", "effect-menu-slide", "theme-light", "effect-listitems-fade" ] });
			</script>
		<?php } ?>
	</body>
</html>