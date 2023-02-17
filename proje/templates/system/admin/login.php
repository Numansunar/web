<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<meta name="keywords" content="ShopPHP, PHP, E-Ticaret, yazılım" />
		<meta name="description" content="ShopPHP v4 Login">
		<meta name="author" content="shopphp.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->


		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
        <link rel="stylesheet" href="../templates/system/admin/template/assets/vendor/pnotify/pnotify.custom.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
        <script src="../templates/system/admin/template/assets/vendor/jquery/jquery.js"></script>
		<script src="../templates/system/admin/template/assets/vendor/modernizr/modernizr.js"></script>
        <script src="../templates/system/admin/template/assets/vendor/pnotify/pnotify.custom.js"></script>
		<script type="text/javascript">
			var shopPHPLoginSubmit = false;
			$(document).ready(function() 
			{
				<?
				
					if($_POST['username'] && $_POST['password'])
					{
						?>
							new PNotify({
								title: 'Hata',
								text: 'Hatalı kullanıcı adı veya Şifre.',
								type: 'error'
							});
						<?						
					}
				?>
			});
		</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<!-- start: page -->
  <section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo pull-left">
					<? echo (!$disablehelp?'<img src="../templates/system/admin/template/assets/images/logo.png" height="54" alt="ShopPHP Admin" />':'')?>
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Yönetici Girişi</h2>
					</div>
					<div class="panel-body">
						<form action="" method="post" id="shopphpLogin">
							<div class="form-group mb-lg">
								<label>Kullanıcı Adı</label>
								<div class="input-group input-group-icon">
									<input name="username" type="text" class="form-control input-lg" id="username" value="<?=($_POST['username'] ? $_POST['username'] : $_COOKIE['username'])?>" autofocus />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="form-group mb-lg">
								<div class="clearfix">
									<label class="pull-left">Şifre</label>
								</div>
								<div class="input-group input-group-icon">
									<input name="password" type="password" id="password" class="form-control input-lg" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
									<div class="checkbox-custom checkbox-default">

									</div>
								</div>
								<div class="col-sm-4 text-right">
									<button type="submit" class="btn btn-primary hidden-xs">Giriş</button>
									<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Giriş</button>
								</div>
							</div
						></form>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright <?=date('Y')?>. Tüm Hakları Saklıdır.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->		
		<script src="../templates/system/admin/template/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="../templates/system/admin/template/assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="../templates/system/admin/template/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="../templates/system/admin/template/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="../templates/system/admin/template/assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="../templates/system/admin/template/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="../templates/system/admin/template/assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="../templates/system/admin/template/assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="../templates/system/admin/template/assets/javascripts/theme.init.js"></script>

	</body>
</html>