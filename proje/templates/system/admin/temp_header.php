<?
$v4Chart = new v4Chart();
$v4Admin = new v4Admin();
$shopPHPBrandType = ($disablehelp ? 'ShopPHP' : '');
?>
<!doctype html>
<html class="fixed" lang="tr">

<head>

	<!-- Basic -->
	<meta charset="utf-8">

	<title>ShopPHP v4 Admin</title>
	<meta name="keywords" content="<?= $shopPHPBrandType ?>, PHP, E-Ticaret, Yazılım" />
	<meta name="description" content="<?= $shopPHPBrandType ?> PHP E-Ticaret Yazılımı v4.0 Yönetim Paneli">
	<? echo (!$disablehelp ? '<meta name="author" content="shopphp.net">' : '') ?>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/bootstrap/css/bootstrap.css" />

	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/morris/morris.css" />
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/pnotify/pnotify.custom.css" />
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
	<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/select2/select2.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/theme-custom.css">
	<link href="secureshare/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" type="text/css">
	<link href="../css/sepet.css" rel="stylesheet" type="text/css">

	<!-- Head Libs -->
	<script src="../templates/system/admin/template/assets/vendor/jquery/jquery.js"></script>
	<script src="../templates/system/admin/template/assets/vendor/pnotify/pnotify.custom.js"></script>
	<script src="../templates/system/admin/template/assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../templates/system/admin/template/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script src="secureshare/flexigrid/flexigrid.js" type="text/javascript"></script>
	<script src="../templates/system/admin/template/assets/vendor/modernizr/modernizr.js"></script>
	<script src="secureshare/CKEditor/ckeditor.js" type="text/javascript"></script>
	<script src="../templates/system/admin/template/js/shopphp.js"></script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
	<section class="body">

		<!-- start: header -->
		<header class="header">
			<div class="logo-container">
				<a href="./" class="logo">
					<? echo (!$disablehelp ? '<img src="../templates/system/admin/template/assets/images/logo.png" height="35" alt="ShopPHP v4 Admin" />' : '') ?>

				</a>
				<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
					<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>

			<!-- start: search & user box -->
			<div class="header-right">

				<form action="s.php" class="search nav-form" method="get">
					<div class="input-group input-search">
						<input type="text" class="form-control shopphp-search" name="f" id="q" placeholder="Arama...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>

				<span class="separator"></span>
				<ul class="notifications">
					<li>
						<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
							<i class="fa fa-tasks"></i>
							<span class="badge"><?= $v4Chart->toplamBekleyenSiparis ?></span>
						</a>

						<div class="dropdown-menu notification-menu large">
							<div class="notification-title">
								<span class="pull-right label label-default"><?= $v4Chart->toplamBekleyenSiparis ?></span>
								TESLİMAT AŞAMASINDAKİ SİPARİŞLER
							</div>

							<div class="content">
								<ul>
									<li>
										<p class="clearfix mb-xs">
											<span class="message pull-left">Ödeme Onayı Bekleyenler</span>
											<span class="message pull-right text-dark"><?= $v4Chart->yuzdeOnayBekleyen ?>%</span>
										</p>
										<div class="progress progress-xs light">
											<div class="progress-bar" role="progressbar" aria-valuenow="<?= $v4Chart->yuzdeOnayBekleyen ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $v4Chart->yuzdeOnayBekleyen ?>%;"></div>
										</div>
									</li>

									<li>
										<p class="clearfix mb-xs">
											<span class="message pull-left">Hazırlanan Siparler</span>
											<span class="message pull-right text-dark"><?= $v4Chart->yuzdeHazirlanan ?>%</span>
										</p>
										<div class="progress progress-xs light">
											<div class="progress-bar" role="progressbar" aria-valuenow="<?= $v4Chart->yuzdeHazirlanan ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $v4Chart->yuzdeHazirlanan ?>%;"></div>
										</div>
									</li>

									<li>
										<p class="clearfix mb-xs">
											<span class="message pull-left">Kargoya Verilen Siparişer</span>
											<span class="message pull-right text-dark"><?= $v4Chart->yuzdeKargolanan ?>%</span>
										</p>
										<div class="progress progress-xs light mb-xs">
											<div class="progress-bar" role="progressbar" aria-valuenow="<?= $v4Chart->yuzdeKargolanan ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $v4Chart->yuzdeKargolanan ?>%;"></div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
							<i class="fa fa-envelope"></i>
							<span class="badge"><?= $v4Chart->iletisimCevapBekleyen ?></span>
						</a>

						<div class="dropdown-menu notification-menu">
							<div class="notification-title">
								<span class="pull-right label label-default"><?= $v4Chart->iletisimToplam ?></span>
								Mesaj
							</div>

							<div class="content">
								<ul>
									<?= $v4Chart->iletisimListe() ?>
								</ul>

								<hr />

								<div class="text-right">
									<a href="s.php?f=iletisim.php" class="view-more">Tümünü Gör</a>
								</div>
							</div>
						</div>
					</li>
					<? if (!$disablehelp) { ?>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-bell"></i>
								<span class="badge"><?= $v4Chart->shopphpHaberOkunmayan ?></span>
							</a>

							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="pull-right label label-default"><?= $v4Chart->shopphpHaberAdet ?></span>
									ShopPHP Haber
								</div>

								<div class="content">
									<ul>
										<?= $v4Chart->shopPHPHaberListe() ?>
									</ul>

									<hr />

									<div class="text-right">
										<a href="s.php?f=shopphpnews.php" class="view-more">Tümünü Gör</a>
									</div>
								</div>
							</div>
						</li>
					<?
					} ?>
				</ul>

				<span class="separator"></span>

				<div id="userbox" class="userbox">
					<?= $v4Chart->loginBox() ?>
				</div>
			</div>
			<!-- end: search & user box -->
		</header>
		<!-- end: header -->

		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left">

				<div class="sidebar-header">
					<div class="sidebar-title">
						Navigasyon
					</div>
					<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>

				<div class="nano">
					<div class="nano-content">
						<nav id="menu" class="nav-main" role="navigation">
							<ul class="nav nav-main">
								<li class="<?= ($_GET['f'] ? '' : 'nav-active') ?>">
									<a href="s.php">
										<i class="fa fa-home" aria-hidden="true"></i>
										<span>Dashboard</span>
									</a>
								</li>
								<?
								/*
										$leftMenu = cacheout('leftMenu');
										if(!$leftMenu)
											$leftMenu = cachein('leftMenu',$v4Admin->leftMenu());
																																			 */
								$leftMenu = $v4Admin->leftMenu();
								?>
								<?= $leftMenu ?>
								<li>
									<a href="../" target="_blank">
										<i class="fa fa-external-link" aria-hidden="true"></i>
										<span>Siteye Git</span>
									</a>
								</li>
							</ul>
							<?
							if (siteConfig('multilang') || $_POST['multilang']) {
							?>
								<center>
									<div id="google_translate_element"></div>
								</center>
								<script type="text/javascript">
									function googleTranslateElementInit() {
										new google.translate.TranslateElement({
											pageLanguage: 'tr'
										}, 'google_translate_element');
									}
								</script>
								<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
							<? } ?>
						</nav>
						<? if (!$disablehelp) { ?>
							<hr class="separator" />
							<div class="sidebar-widget widget-stats">
								<div class="widget-header">
									<h6>Gelecek Sürüm </h6>
									<div class="widget-toggle">+</div>
								</div>
								<div class="widget-content">
									<ul>
										<li>
											<span class="stats-title">v<?= v4Admin::gelecekSurum() ?> Tamamlanma Oranı</span>
											<span class="stats-complete"><?= v4Admin::gelecekOran() ?>%</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="<?= v4Admin::gelecekOran() ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= v4Admin::gelecekOran() ?>%;">
													<span class="sr-only"><?= v4Admin::gelecekOran() ?>% Tamamlandı</span>
												</div>
											</div>
										</li>

									</ul>
								</div>
							</div>
						<? } ?>
					</div>

				</div>

			</aside>
			<!-- end: sidebar -->

			<section role="main" class="content-body">