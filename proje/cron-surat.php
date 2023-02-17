<?
@set_time_limit(0);
@ignore_user_abort(true);

include('include/all.php');
//error_reporting(E_ALL);
$client = new SoapClient("http://webservices.suratkargo.com.tr/services.asmx?WSDL");
$kargoFirma = hq("select ID from kargofirma where name like 'surat%' OR name like 'sürat%' or name like 'SÜRAT%'");
$kapidaID = hq("select ID from banka where paymentModulURL like 'include/payment_Kapida.php' AND active = 1 order by seq limit 0,1");
if(!$kargoFirma)
	exit('Kargo kurulumu bulunamadi.');
$q = mysql_query("select randStr from siparis where durum = 51 AND kargoFirma = '$kargoFirma' order by ID desc ") or die(mysql_error());
$out.= "Toplam : ".mysql_num_rows($q).'<br/>';;
$i = 1;
while($d = mysql_fetch_array($q))
{
	$out.= "Sıra : $i<br />";
	try
	{
		$send = array('GonderenCariKodu'=>siteConfig(($d['odemeID'] == $kapidaID?'kargoSuratKapidaUsername':'kargoSuratApiName')), 'WebSiparisKodu'=>$d['randStr'],'Sifre'=>siteConfig('kargoSuratWebPassword'));
		
		
		$sonuc = $client->WebSiparisKodu($send);
		$out.= debugArray($send);
		$out.= debugArray($sonuc);
		if (!(stristr($sonuc->WebSiparisKoduResult->any,'Teslim edildi') === false))
			mysql_query("update siparis set durum = 81 where randStr='".$d['randStr']."'");
			
		continue;	
		$send = array('GonderenCariKodu'=>siteConfig(($d['odemeID'] != $kapidaID?'kargoSuratKapidaUsername':'kargoSuratApiName')), 'WebSiparisKodu'=>$d['randStr'],'Sifre'=>siteConfig('kargoSuratWebPassword'));
		
		$sonuc = $client->WebSiparisKodu($send);
		echo debugArray($send);
		echo debugArray(y);
		if (!(stristr($sonuc->WebSiparisKoduResult->any,'Teslim edildi') === false))
			mysql_query("update siparis set durum = 81 where randStr='".$d['randStr']."'");
			
	}
	catch(Exception $ex)
	{
		$out.= 'Sürat Kargo Hata : '.$ex;	
	}
}
if($_SESSION['admin_isAdmin'])
	echo $out;
else
	echo "Sürat Kargo Cronjob logu göndermek için lütfen admin girişi yapın.";
?>