<?
/* Yönetim Giriş Bilgileri */ 
$user = '';
$pass = '';

/* XML Güncelleme Bilgileri */ 
$dosya = 'updateXMLv3.php'; // Örnek : updatearenav4.php

$indexKatalog = 0; // Ürün bilgilerini alır, dinamik alanları günceller.
$indexResim = 0; // indexKatalog açıksa, ürün bilgileri ile birlikte resimleri de download eder. Eğer resim zaten download edilmişse, tekrar download edilmez.

$indexFiyat = 1; // Fiyat ve stok güncelleme için.
$indexFSStok = 1; // indexFiyat açıksa fiyatları günceller.
$indexFSFiyat = 1; // indexFiyat açıksa stokları günceller.
$kar = 0.20; // Fiyat güncellerken set edilen kar marjı. 0.20 ile gelen fiyata %20 eklenir. Eğer bir kategoride, XML kar marjı girilmişse, sadece o kategori için bu değer değil, kategoriye girilen değer geçerli olur.

/* Bu satırdan sonrasını düzenlemenize gerek yoktur. */

include('include/all.php');

@set_time_limit(0);
ignore_user_abort(true);
my_mysql_query("SET GLOBAL TRANSACTION ISOLATION LEVEL READ UNCOMMITTED");

if(!$_GET['start'] || $_GET['start'] == '0')
{
	$url = 'https://'.$_SERVER['HTTP_HOST'].$siteDizini;
	for($i = 0;$i<=9;$i++)
	{
		
		$u = $url.'/secure/s.php?username='.$user.'&password='.$pass.'&f=XML/'.$dosya.'&isCron=1&xmlUpdate=1&y=e&kar='.$kar.'&parentID=&indexKatalog='.$indexKatalog.'&indexFiyat='.$indexFiyat.'&indexResim='.$indexResim.'&indexFSStok='.$indexFSStok.'&indexFSFiyat='.$indexFSFiyat.'&dilim='.$i.'&rand='.rand(0,1000);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$u);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 59);
		$x = curl_exec($ch);
		curl_close($ch);

		$durum = (substr($x,-2) == 'OK' ? 'Tamamlandı.':'Hata var.');
		$out.= $i.' '.$dosya.': OK. Size : '.strlen($x).'.'.$ux.'. Durum : '.$durum.'<br>';
		
	}
}
function adminErrorv3($d)
{
	return $d.'<br>';
}

function adminInfov3($d)
{
	return $d.'<br />';
}

if($_SESSION['admin_isAdmin']) 
{	
	include('secure/include/xmlImport.php');
	echo 'Log : <br>'.$out.'<pre>'.utf8_decode(getTemp('xmlLog')).'</pre>';
}
else
	echo 'Detay görmek için yönetici girişi yaptın. <br />Log : <br>'.$out;
?>