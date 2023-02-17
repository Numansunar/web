<?
@set_time_limit(0);
@ignore_user_abort(true);

include('include/all.php');

$url = 'http://webservices.yurticikargo.com:8080/KOPSWebServices/ShippingOrderDispatcherServices?wsdl';
	
$soapClient = new SoapClient($url,array(
						"trace"      => 1,
						"exceptions" => 1,
						'encoding'=>'utf-8'));
$kargoFirma = hq("select ID from kargofirma where name like 'yurt%'");

if (!$kargoFirma)
	exit('Kargo kurulumu bulunamadi.');

$q = my_mysql_query("select * from siparis where durum >= 2 AND durum <= 80 AND (kargoFirma = '$kargoFirma' OR (kargoFirmaID='$kargoFirma')) order by ID desc ",1);
$out .= "Toplam Gönderilmeyi Bekleyen : " . mysql_num_rows($q) . '<br/>';
$i = 1;
while ($d = mysql_fetch_array($q)) {
	parse_str(hq("select fields from kargoapi where siparisID='".$d['ID']."'"),$fields);	
	yurticiAccountFix($fields);

	$out .= "Sıra : $i<br />";

	$sonuc = $soapClient->queryShipment(
		array('wsUserName'=>siteConfig('kargo_yiKullanici'),
			  'wsPassword'=>siteConfig('kargo_yiSifre'),
			  'wsLanguage'=>'TR','keys'=>array($d['randStr'].''),
			  'keyType'=>0,'addHistoricalData'=>1,
			  'onlyTracking'=>0
			  ));

	require_once($yonetimDizini.'include/lib-template.php');
	switch((string)$sonuc->ShippingDeliveryVO->shippingDeliveryDetailVO->operationStatus) 
	{
		
		case 'DLV':			
			changeOrderStatus($d['ID'], 81);
			my_mysql_query("update siparis set durum=81 where ID='" . $d['ID'] . "'");
			my_mysql_query("update sepet set durum=81 where randStr='" . $d['randStr'] . "'");
		break;
		
		case 'IND':
		case 'ISR':
			changeOrderStatus($d['ID'], 51);
			my_mysql_query("update siparis set durum=51, kargoSeriNo = '".$sonuc->ShippingDeliveryVO->shippingDeliveryDetailVO->shippingDeliveryItemDetailVO->invoiceNumber."', kargoURL = '".$sonuc->ShippingDeliveryVO->shippingDeliveryDetailVO->shippingDeliveryItemDetailVO->trackingUrl."' where ID='" . $d['ID'] . "'");
			my_mysql_query("update sepet set durum=51 where randStr='" . $d['randStr'] . "'");
		break;
	}
	$out .= debugArray($sonuc);
	
}

if ($_SESSION['admin_isAdmin'])
	echo $out;
else
	echo "Yurtiçi Kargo Cronjob logu göndermek için lütfen admin girişi yapın.";
?>