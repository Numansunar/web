<?php 
if(isset($_GET['srr']))
{
	error_reporting(E_ALL);
	ini_set('display_errors',1);
}
if (version_compare(phpversion(), '7.1.0', '<')) {
    header('location:doc/kur.php?hata=PHP_SURUMU');
}
/*
if (!function_exists('ioncube_loader_version'))
{
	header('location:doc/kur.php?hata=IONCUBE');
}
*/


include('include/all.php');
$host = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(!count($_POST) && (@$_SERVER['HTTPS'] =='off' || !@$_SERVER['HTTPS']) &&  siteConfig('httpsAktif') == '2' )
{
	header('location:https://'.$host);
	exit();
}
SEO::setIndexHeader();
include('templates/'.$siteConfig['templateName'].'/index.php');
include('templates/'.$siteConfig['templateName'].'/temp.php');
my_mysql_close($baglanti);
if($showSPError)
	echo $totalQryStr;
exit();
?>