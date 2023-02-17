<?php
error_reporting('~E_NOTICE & ~E_DEPRICATED % E_ALL'); 
ini_set('display_errors', '0');
$connection_type = 'mysqli';	
$baglanti = my_mysql_connect('localhost','mfkitap_shop','l*Tp2MBQuh!%');
my_mysql_select_db('mfkitap_shop',$baglanti);

$siteDili = 'tr';
$serial = '42c84de609-9266956abb62-547';
$shopphp_demo = 0;
$siteDizini='/';
$yonetimDizini = 'secure/';
$yonetimKoruma = 'SCRIPT'; 
// Hata Gösterimi - Yazılım Geliştirme
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
?>