<?
@set_time_limit(0);
@ignore_user_abort(true);

include('include/all.php');
//error_reporting(E_ALL);
$client = new SoapClient("http://service.mngkargo.com.tr/musterikargosiparis/musterikargosiparis.asmx?WSDL");
$kargoFirma = hq("select ID from kargofirma where name like 'mng%'");
$kapidaID = hq("select ID from banka where paymentModulURL like 'include/payment_Kapida.php' AND active = 1 order by seq limit 0,1");
if (!$kargoFirma)
	exit('Kargo kurulumu bulunamadi.');

$q = my_mysql_query("select * from siparis where kargoSeriNo = '' AND durum = 2 AND (kargoFirma = '$kargoFirma' OR (kargoFirmaID='$kargoFirma')) order by ID desc ") or die(mysql_error());
$out .= "Toplam Gönderilmeyi Bekleyen : " . mysql_num_rows($q) . '<br/>';
$i = 1;
while ($d = mysql_fetch_array($q)) {
	$out .= "Sıra : $i<br />";

	$sonuc = mngKargoGonder($d);
	if ($sonuc->SiparisGirisiDetayliV3Result == 1) {
		my_mysql_query("update siparis set kargoSeriNo = randStr where ID='" . $d['ID'] . "'");
		$out .= debugArray($out);
	}
}


$q = my_mysql_query("select * from siparis where (durum = 51 OR durum = 2) AND  (kargoFirma = '$kargoFirma' OR (kargoFirmaID='$kargoFirma')) order by ID desc ") or die(mysql_error());
$out .= "Toplam Kargoya Teslim Edilen : " . mysql_num_rows($q) . '<br/>';
$i = 1;
while ($d = mysql_fetch_array($q)) {
	$out .= "Sıra : $i<br />";
	try {
		$d['durum'] = (int)$d['durum'];

		$send = array("pKullaniciAdi" => siteConfig('kargo_mngMusteriNo'), "pSifre" => siteConfig('kargo_mngSifre'), "pSiparisNo" => $d['randStr']);
		$sonuc = $client->FaturaSiparisListesi($send);
		$out .= debugArray($send);
		$out .= debugArray($sonuc);

		$siparis = $sonuc->FaturaSiparisListesiResult;
		$xml = simplexml_load_string($siparis->any);
		$dataset = $xml->NewDataSet;
		$table1 = $dataset->FaturaSiparisListesi;
		if($table1->KARGO_TAKIP_URL)
		{	
			my_mysql_query("update siparis set kargoSeriNo = '".addslashes($table1->MNG_SIPARIS_NO)."', kargoURL = '".addslashes($table1->KARGO_TAKIP_URL)."' where randStr='".$d['randStr']."' limit 1");
			if(!$d['kargoURL'] && strlen($d['ceptel']) > 6) 
			{
				sendSMS($d['randStr'].' nolu siparisinizin '.$table1->MNG_SIPARIS_NO.' numarali kargo durumunu '.$table1->KARGO_TAKIP_URL.' adresinden takip edebilirsiniz.', $d['ceptel']);
			}
		}
		foreach ($table1 as $transfer) {
			$kargoSonDurum = (int)utf8fix($transfer->KARGO_STATU);
		}
		if ($kargoSonDurum == 5) {
			if ($d['durum'] != 81) {
				$_GET['paytype'] = $d['odemeID'];
				$odemeDurum = 81;
				$Spayment = new spPayment();
				$Spayment->siparisID = $d['randStr'];
				$Spayment->EmailMergeArray = array();
				$Spayment->processPaymentFinalisation();
				$out .= 'MNG Kargo Sipariş ID  ' . $d['randStr'] . ': Başarılı.<br />';
				my_mysql_query("update siparis set durum = 81 where randStr='" . $d['randStr'] . "'");
			}
		} else {
			if ($kargoSonDurum > 0 && $kargoSonDurum < 5) {
				if ($d['durum'] != 51) {
					$_GET['paytype'] = $d['odemeID'];
					$odemeDurum = 51;
					$Spayment = new spPayment();
					$Spayment->siparisID = $d['randStr'];
					$Spayment->EmailMergeArray = array();
					$Spayment->processPaymentFinalisation();
					$out .= 'MNG Kargo Sipariş ID  ' . $d['randStr'] . ': Başarılı.<br />';
					mysql_query("update siparis set durum = 51 where randStr='" . $d['randStr'] . "'");
				}
			}
		}

	} catch (Exception $ex) {
		$out .= 'MNG Kargo Hata : ' . $ex;
	}
}
if ($_SESSION['admin_isAdmin'])
	echo $out;
else
	echo "Sürat Kargo Cronjob logu göndermek için lütfen admin girişi yapın.";
?>