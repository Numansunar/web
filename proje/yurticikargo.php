<?
@session_start();
if(!$_SESSION['admin_isAdmin'])
	exit('Yetkisiz giriş.');
/* EDIT */
$viewArray = array(
'Isim / Soyad'=>'name',
'Adres'=>'address',
	'Il'=>'city',
	'Ilce'=>'semt',
	'Telefon Ev / Is'=>'evtel',
	'Telefon Cep'=>'ceptel',
	'E-Mail Adresi'=>'email',
	'Vergi No'=>'vergiNo',
	'Kargo Turu'=>'kargoTuru',
	'Odeme Tipi'=>'odemeTipi',
	'Irsaliye Numarasi'=>'irsaliyeNo',
	'Referans Numarasi'=>'randStr',
	'Adet'=>'adet',
	'Kargo Icerigi'=>'kargoIcerigi',
	'Tahsilat Tipi'=>'tahsilatTipi',
	'Fatura No'=>'faturaNo',
	'Fatura Tutari'=>'toplamTutarTL'
);
/* EDIT */
$harfArray = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');
include('include/all.php');
@ini_set('memory_limit', '1024M');
@set_time_limit(0);
require_once 'include/3rdparty/PHPExcel.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("ShopPHP by Creamedia Software")
							 ->setLastModifiedBy("ShopPHP - Creamedia Software")
							 ->setTitle("ShopPHP Excel Veri Çıktısı")
							 ->setSubject("ShopPHP Excel Veri Çıktısı")
							 ->setDescription("ShopPHP Excel Veri Çıktısı")
							 ->setKeywords("ShopPHP, PHP E-Ticaret Yazılımı")
							 ->setCategory("ShopPHP Excel Veri Çıktısı");

$i = 0;
foreach($viewArray as $k=>$v)
{
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$i].'1',$k);
	$i++;
}
	
mysql_query("SET NAMES 'utf8'"); 
mysql_query("set SESSION character_set_client = utf8");
mysql_query("set SESSION character_set_connection = utf8");
mysql_query("set SESSION character_set_results = utf8");
$i = 2;
$q = mysql_query("select * from siparis where durum = 2") or die(mysql_error());
while($d = mysql_fetch_array($q))
{
	if(!$d['faturaNo'])
		unset($d['toplamTutarTL']);
		
	$d['name'].=' '.$d['lastname']; 
	$d['semt'] = hq("select name from ilceler where ID='".$d['semt']."'");
	$d['city'] = hq("select name from iller where plakaID='".$d['city']."'");
	$d['evtel'] = str_replace('-','',$d['evtel']);
	$d['istel'] = str_replace('-','',$d['istel']);
	$d['ceptel'] = str_replace('-','',$d['ceptel']);
	if(!$d['evtel'] && $d['istel'])
		$d['evtel'] = $d['istel'];
	$d['kargoTuru'] = '1';
	$d['odemeTipi'] = (hq("select ID from kargofirma where ID='".$d['kargoFirmaID']."' AND alici = 1")?'0':'1');
	$d['adet'] = '1';
	$d['kargoIcerigi'] = $d['randStr'].' nolu siparis';
	$d['tahsilatTipi'] = '0';
	
	$j = 0;
	foreach($viewArray as $k=>$v)
	{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$j].$i, $d[$v]);
		$objPHPExcel->getActiveSheet()->getColumnDimension($harfArray[$j])->setAutoSize(true);
		$j++;
	}
	$i++;
}
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="yurticikargo.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>