<?
@set_time_limit(0);
@ignore_user_abort(true);

include('include/all.php');
error_reporting(E_ALL);
$client = new SoapClient("http://customerservicestest.araskargo.com.tr/arascargoservice/arascargoservice.asmx?wsdl");
$kargoFirma = hq("select ID from kargofirma where name like 'aras%'");
$kapidaID = hq("select ID from banka where paymentModulURL like 'payment_kapida.php' order by seq limit 0,1");


//  AND kargoFirma = '$kargoFirma'
$q = mysql_query("select * from siparis where durum=51 AND kargoFirma = '$kargoFirma'");
echo "Toplam : ".mysql_num_rows($q).'<br/>';;
$i = 1;
while($d = mysql_fetch_array($q))
{
	echo "Sıra : $i<br />";
	try
	{
		//$send = array('GonderenCariKodu'=>siteConfig(($d['odemeID'] == $kapidaID?'kargoSuratApiCariKapi':'kargoSuratApiCariKredi')), 'WebSiparisKodu'=>$d['randStr'],'Sifre'=>siteConfig(($d['odemeID'] == $kapidaID?'kargoSuratKapidaPassword':'kargoSuratApiPassword')));
		$send = array('userName'=>siteConfig('kargo_arasUsername'),'password'=>siteConfig('kargo_arasPassword'), 'integrationCode'=>'YT'.$d['randStr']);
		
		
		$sonuc = $client->GetOrderWithIntegrationCode($send);
		echo debugArray($send);
		echo debugArray($sonuc);
		exit();
		if (!(stristr($sonuc->WebSiparisKoduResult->any,'Teslim edildi') === false))
			mysql_query("update siparis set durum = 81 where randStr='".$d['randStr']."'");
			
			
		$send = array('GonderenCariKodu'=>siteConfig(($d['odemeID'] != $kapidaID?'kargoSuratKapidaUsername':'kargoSuratApiName')), 'WebSiparisKodu'=>$d['randStr'],'Sifre'=>'Yargi!!17');
		
		$sonuc = $client->WebSiparisKodu($send);
		echo debugArray($send);
		echo debugArray(y);
		if (!(stristr($sonuc->WebSiparisKoduResult->any,'Teslim edildi') === false))
			mysql_query("update siparis set durum = 81 where randStr='".$d['randStr']."'");
			
	}
	catch(Exception $ex)
	{
		echo 'Sürat Kargo Hata : '.$ex;	
	}
}
?>