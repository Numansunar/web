<?php
if (!ini_get("short_open_tag"))
	exit('<div style="font-family:Tahoma; font-size:16px; text-align:center; padding:100px; font-weight:bolder; color:red;">Hata : Lütfen sunucunuzdan short_open_tag değerini aktif ettirin.');
ini_set('display_errors', '1');
error_reporting(E_ALL);
require('../include/lib-db.php');
require('import-lib.php');

/* */
$v = file_get_contents('v.txt');
/* */
$max_execution_time = ini_get('max_execution_time');
@set_time_limit(0);
$pDir = str_replace('//', '/', str_replace('/doc/' . basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) . '/');
error_reporting('~E_NOTICE & ~E_DEPRICATED % E_ALL');

function dosyayaz($dosyaadi, $data)
{
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	$out = "";
	if (!$dene = fopen($dosyaadi, 'w')) {
		$out = false;
	} else {
		if (fwrite($dene, $data) === false) {
			$out = false;
		} else $out = true;
	}
	return $out;
}

function config()
{
	$_POST['serial'] = str_replace(' ', '', $_POST['serial']);
	global $pDir;
	$config = "<" . "?php
error_reporting('~E_NOTICE & ~E_DEPRICATED % E_ALL'); 
ini_set('display_errors', '0');
" . '$connection_type' . " = '" . $_POST['ext'] . "';	
" . '$baglanti' . " = my_mysql_connect('" . $_POST['server'] . "','" . $_POST['username'] . "','" . $_POST['password'] . "');
my_mysql_select_db('" . $_POST['db'] . "'," . '$baglanti' . ");

" . '$siteDili' . " = 'tr';
" . '$serial' . " = '" . $_POST['serial'] . "';
" . '$shopphp_demo' . " = 0;
" . '$siteDizini' . "='" . $pDir . "';
" . '$yonetimDizini' . " = 'secure/';
" . '$yonetimKoruma' . " = 'SCRIPT'; 
// Hata Gösterimi - Yazılım Geliştirme
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
?" . ">";
	return dosyayaz('../include/conf.php', $config);
}


function sField($label, $name, $value, $title)
{
	return '
	<div class="form-group">
		<label class="col-md-3 control-label" for="inputDefault">' . $label . '</label>
		<div class="col-md-6">
			<input class="form-control mb-md kur-input" name="' . $name . '" value="' . $value . '" type="' . ($name == 'password' ? 'password' : 'text') . '">
			<span class="help-block kur-help-block">' . $title . '</span>
		</div>
	</div>';
}

function kurNotify($type, $content)
{
	return '<div class="alert alert-' . $type . '">' . $content . '</div>';
}

function readcURL($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$out = curl_exec($ch);
	curl_close($ch);
	return $out;
}
function getMaximumFileUploadSize()
{
	return (min((ini_get('post_max_size')), (ini_get('upload_max_filesize'))));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ShopPHP v
        <?= $v ?>
    </title>

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

    <!-- Theme CSS -->
    <link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../templates/system/admin/template/assets/stylesheets/theme-custom.css" />

    <!-- Head Libs -->
    <script type="text/javascript" src="../templates/system/admin/template/assets/vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="../templates/system/admin/template/assets/vendor/pnotify/pnotify.custom.js"></script>
    <script type="text/javascript" src="../templates/system/admin/template/assets/vendor/modernizr/modernizr.js"></script>
    <style type="text/css">
        .kur-container {
            width: 800px;
            margin: auto;
            margin-top: 30px;
            margin-bottom: 30px;
            border-radius: 10px;
        }

        .kur-input {
            width: 500px;
        }

        .kur-success-container {
            inline-table;
            width: auto;
            margin-left: 300px;
        }

        .kur-success-container .ui-pnotify-icon {
            padding: 30px;
            border-radius: 10px;
            background-color: #47a447;
        }

        .kur-success-container .ui-pnotify-icon span {
            color: white;
            font-size: 60px;
        }

        .kur-tamamlandi input {
            padding: 20px;
            font-size: 20px;
            width: 100%;
        }

        .kur-panel-info {
            font-size: 16px;
        }

        .kur-help-block {
            display: block;
            width: 500px;
        }

        .kur-clear,
        .kur-clear-space {
            clear: both;
        }

        .kur-clear-space {
            height: 15px;
        }
    </style>
</head>

<body>
    <div class="kur-container">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div>
                        <center>
                            <img alt="ShopPHP v4.0" width="200" src="../templates/system/admin/template/assets/images/logo.png" />
                        </center>
                    </div>
                    <div class="kur-clear-space"></div>
                    <hr />
                    <div class="col-xl-6 col-lg-12">
                        <?
												if ($_POST['serial'] && $_POST['username'] && $_POST['db'] && (filesize('../include/conf.php') > 1)) {
													echo kurNotify('danger', '<b>Hata:</b> include/conf.php dosyası zaten dolu durumda.');
												}
												if ($_POST['serial'] && $_POST['username'] && $_POST['db'] && (filesize('../include/conf.php') <= 1)) {
													$baglanti = my_mysql_connect($_POST['server'], $_POST['username'], $_POST['password']);
													my_mysql_select_db($_POST['db'], $baglanti);
													header("Content-Type: text/html; charset=utf-8");
													my_mysql_query("SET NAMES 'utf8'");
													my_mysql_query("set SESSION character_set_client = utf8");
													my_mysql_query("set SESSION character_set_connection = utf8");
													my_mysql_query("set SESSION character_set_results = utf8");

													if (my_mysql_num_rows(my_mysql_query("SELECT * FROM information_schema.tables WHERE table_schema = '" . $_POST['db'] . "' AND table_name = 'adminmenu'"))) {
														echo kurNotify('danger', '<b>Hata:</b> Veritabanı boş değil. Yeni kurulum için tanımlı veritabanının boş olması gerekmektedir.<br><a href="kur.php">Kuruluma geri dönmek için tıklayın</a>.');
													} else if (mysql_import('sql/sql.txt')) {
														echo '<div>
                        	  <center>							
															<div class="kur-success-container">
																<div class="ui-pnotify-icon"><span class="fa fa-check"></span></div>
															</div>
															<div class="kur-clear"></div>
																<h2>Kurulum Tamamlandı !</h2>
														</center>
														<div class="button-box kur-tamamlandi" >
															<input type="submit" target="_blank" name="" value="Siteye Girmek için Tıklayın." class="mb-xs mt-xs mr-xs btn btn-primary" onclick="window.open(\'../\');"/>
														</div>
														<div class="button-box kur-tamamlandi" >
															<input type="submit" target="_blank" name="" value="Yönetim Paneline girmek için Tıklayın." class="mb-xs mt-xs mr-xs btn btn-success" onclick="window.open(\'../secure/\');"/>
														</div>
                        </div>
													<div class="kur-clear-space"></div>';
														if (config()) {
															$password = substr(str_shuffle('_-!,.abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
															my_mysql_query("update user set password = '" . md5($password) . "' where username = 'admin'");
															echo kurNotify('info kur-panel-info', '<a href="../secure/" target="_blank"><h3>Yönetim Paneli Giriş Bilgileri :</h3></a><br><strong>Kullanıcı adı : </strong>admin<br><strong>Şifre : </strong>' . $password . '</a>');
															// echo kurNotify('info','<b>Bilgi:</b> <a target="_blank" href="http://yardim.shopphp.net/">Yönetin paneli bilgileri ve SSS arşivi için tıklayın.</a>');
															echo kurNotify('warning', '<b>Uyarı:</b> <a target="_blank" href="http://yardim.shopphp.net/page.php?act=kategoriGoster&katID=324&autoOpen=5">Siteniz açılmıyorsa olası nedenleri görmek için tıklayın.</a>');
														}
													} else {
														echo kurNotify('danger', '<b>Hata:</b> Veritabanı kurulumunda hata oluştu. Lütfen girdiğiniz giriş bilgilerini kontrol edip tekrar deneyin.');
													}
												} else if (filesize('../include/conf.php') <= 1) {
													?>
                        <div class="rowx">
                            <div>
                                <section class="panel">
                                    <div class="panel-body">
                                        <form method="post" action="" class="form-horizontal form-bordered">
                                            <?= sField('Serial No', 'serial', $_POST['serial'], 'Serial numaranızı bilmiyorsanız, IP ve Domain adınızı <a href=\'mailto:serial@shopphp.net\'><strong>serial@shopphp.net</strong></a> adresine gönderip serial numaranızı alabilirsiniz.'); ?>
                                            <?= sField('Veri Tabanı Tipi', 'ext', ($_POST['ext'] ? $_POST['ext'] : 'mysqli'), ''); ?>
                                            <?= sField('Veri Tabanı Sunucusu', 'server', ($_POST['server'] ? $_POST['server'] : 'localhost'), ''); ?>
                                            <?= sField('Veri Tabanı Adı', 'db', $_POST['db'], ''); ?>
                                            <?= sField('Veri Tabanı Kullanıcı Adı', 'username', $_POST['username'], ''); ?>
                                            <?= sField('Veri Tabanı Şifre', 'password', $_POST['password'], ''); ?>
                                            <?= sField('Kurulum Dizini', 'pDir', ($_POST['pDir'] ? $_POST['pDir'] : $pDir), ''); ?>
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <input type="submit" class="btn btn-primary" value="Kuruluma Başla" />
                                                <input type="reset" class="btn btn-default" value="Geri Al" />
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <?
											} ?>
                        <div class="kur-clear-space"></div>
                        <? if (!($_POST['serial'] && $_POST['username'] && $_POST['db'])) { ?>
                        <div>
                            <div>
                                <?
																$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                                $lisansKontrol = readcURL(str_replace('doc/kur.php', 'testio.php', $actual_link));
                                                                
                                                                if($_GET['hata'] == 'PHP_SURUMU')
                                                                {
																	echo kurNotify('danger', '<b>Hata:</b> Sunucuda PHP Sürümü asgari v7.1 ve üzeri olmalıdır.');
																	exit();
                                                                }

																if (extension_loaded("IonCube Loader") &&  (stristr($lisansKontrol,'TEST OK!') === false) && $lisansKontrol) {
																	echo kurNotify('danger', '<b>Hata:</b> Lisans ve/veya domain adı hatası.');
																	exit();
																}
																if (filesize('../include/conf.php') > 1) {
																	echo kurNotify('danger', '<b>Hata:</b> include/conf.php dosyası kurulu durumda. Kurulum yapmak için include/conf.php dosyasının ve veritabanının boşaltılması gerekmektedir.');
																}

																if (version_compare(phpversion(), '7.1.0', '<')) {
																	echo kurNotify('danger', '<b>Hata:</b> Sunucuda PHP Sürümü asgari v7.1 ve üzeri olmalıdır.');
																} else {
																	echo kurNotify('info', '<b>Başarılı:</b> PHP Sürümü ' . phpversion());
																}

																if (!extension_loaded("IonCube Loader")) {
																	echo kurNotify('danger', '<b>Hata:</b> Sunucunuzda <a href="http://www.ioncube.com" target="_blank">ioncube loader</a> yüklü değil. ShopPHP yazılımını kurmak için, sunucu yöneticinizden ioncube kurulumu talep etmeniz gerekmektedir.');
																} else {
																	echo kurNotify('info', '<b>Başarılı:</b> Sunucunuzda Ioncube yüklü durumda.');
                                                                }
                                                                
																if (!is_writable('../include/')) {
																	echo kurNotify('danger', '<b>Hata:</b> include/conf.php dosyası yazılabilir değil.');
																} else {
																	echo kurNotify('info', '<b>Başarılı:</b> include/conf.php dosyası yazılabilir.');
                                                                }
                                                                

																$checkDirArray = array('banka', 'banner', 'cache', 'custom', 'filitre', 'haberler', 'kampanya', 'makaleler', 'kategoriler', 'markalar', 'swf', 'upload', 'urunler');
																$else = true;
																foreach ($checkDirArray as $check) {
																	if (!is_writable('../images/' . $check) && $else) {
																		$else = false;
																		echo kurNotify('warning', '<b>Uyarı:</b> images/ altındaki tüm klasörler yazılabilir değil.');
																	}
																}
																if ($else) {
																	echo kurNotify('info', '<b>Başarılı:</b> images/ altındaki tüm klasörler yazılabilir.');
																}
																$checkDirArray = array('gallery_data.xml', 'sitemap.xml');
																$else = true;
																foreach ($checkDirArray as $check) {
																	if (!is_writable('../' . $check) && !$else) {
																		$else = false;
																		echo kurNotify('warning', '<b>Uyarı:</b> Ana dizindeki XML uzantılı dosyalar yazılabilir.');
																	}
																}
																if ($else) {
																	echo kurNotify('info', '<b>Başarılı:</b>  Ana dizindeki XML uzantılı dosyalar yazılabilir.');
																}

																if (!is_writable('../secure/backup/')) {
																	echo kurNotify('danger', '<b>Hata:</b> /secure/backup/ klasörü yazılabilir değil.');
																} else {
																	echo kurNotify('info', '<b>Başarılı:</b> /secure/backup/ dosyası yazılabilir.');
																}

																if (!is_writable('../secure/bayiXML/')) {
																	echo kurNotify('danger', '<b>Hata:</b> /secure/bayiXML/ klasörü yazılabilir değil.');
																} else {
																	echo kurNotify('info', '<b>Başarılı:</b> /secure/bayiXML/ klasörü yazılabilir.');
																}


																/*
										$stream = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));
										$read = fopen("https://".$_SERVER['HTTP_HOST'], "rb", false, $stream);
										$cont = stream_context_get_params($read);
										$var = ($cont["options"]["ssl"]["peer_certificate"]);
										$sslresult = (!is_null($var)) ? true : false;	
													 */
																?>
                            </div>
                        </div>
                        <div class="kur-clear-space"></div>
                        <div>
                            <div>
                                <h3>Genel Bilgiler</h3>
                            </div>
                            <div>
                                <ul class="statistics">
                                    <li>Yazılım Sürümü
                                        <p> <span class="green">ShopPHP v
                                                <?= $v ?>
                                            </span> </p>
                                    </li>
                                    <li>PHP Sürümü
                                        <p> <span class="green">PHP v
                                                <?= phpversion() ?>
                                            </span></p>
                                    </li>
                                    <li>Ioncube Sürümü
                                        <p>
                                            <?= (function_exists('ioncube_loader_version') ? '<span class="green">' . ioncube_loader_version() . '</span>' : '<span class="red"><strong>Yüklü değil</strong></span>') ?>
                                        </p>
                                    </li>
                                    <? $gd = gd_info(); ?>
                                    <li>GD Library Sürümü
                                        <p> <span class="green">
                                                <?= $gd['GD Version'] ?></span>
                                        </p>
                                    </li>
                                    <? $curl = curl_version(); ?>
                                    <li>cURL Sürümü
                                        <p> <span class="green">v
                                                <?= $curl['version'] ?></span>
                                        </p>
                                    </li>
                                    <li>SOAP
                                        <p> <?= (class_exists("SOAPClient") ? '<span class="green">Aktif</span>' : '<span class="red"><strong>Pasif</strong></span>') ?>
                                        </p>
                                    </li>
                                    <li>Allow URL Fopen
                                        <p> <?= (ini_get('allow_url_fopen') ? '<span class="green">Aktif</span>' : '<span class="red"><strong>Pasif</strong></span>') ?>
                                        </p>
                                    </li>
                                    <li>Memory Limit
                                        <p> <span class="green">
                                                <?= ini_get('memory_limit') ?>
                                            </span> </p>
                                    </li>
                                    <li>Timeout Limit (Saniye)
                                        <p> <span class="green">
                                                <?= $max_execution_time ?>
                                            </span> </p>
                                    </li>
                                    <li>Upload Size Limit
                                        <p> <span class="green">
                                                <?= getMaximumFileUploadSize() ?>
                                            </span> </p>
                                    </li>
                                    <li>Sunucu IP Adresi
                                        <p> <span class="green">
                                                <?= $_SERVER['SERVER_ADDR'] ?>
                                            </span> </p>
                                    </li>
                                    <!--
								<li>Tam Dizin Yolu
                  <p> <span class="green">
                    <?= @str_replace(array('\\doc', '/doc'), '', getcwd()) ?>
                    </span> </p>
                </li>
								-->
                                </ul>
                            </div>
                        </div>
                        <?
											} ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Theme Base, Components and Settings -->
    <script type="text/javascript" src="../templates/system/admin/template/assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script type="text/javascript" src="../templates/system/admin/template/assets/javascripts/theme.js"></script>

    <!-- Theme Custom -->
    <script type="text/javascript" src="../templates/system/admin/template/assets/javascripts/theme.custom.js"></script>

    <!-- Theme Initialization Files -->
    <script type="text/javascript" src="../templates/system/admin/template/assets/javascripts/theme.init.js"></script>
</body>

</html> 