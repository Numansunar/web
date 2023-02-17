<?php
include_once('include/all.php');
if (!$_SESSION['admin_isAdmin'])
	exit('no-access');
;

/* EDIT */
$viewArray = array(
	'Barkod' => 'gtin',
	'Model Kodu' => 'ID',
	'Marka' => 'markaName',
	'Kategori' => 'tycode',
	'Para Birimi' => 'TRY',
	'Ürün Adı' => 'name',
	'Ürün Açıklaması' => 'detay',
	'Piyasa Satış Fiyatı (KDV Dahil)' => 'piyasafiyat',
	'Trendyol\'da Satılacak Fiyat (KDV Dahil)' => 'fiyat',
	'Ürün Stok Adedi' => 'stok',
	'Stok Kodu' => 'tedarikciCode',
	'KDV Oranı' => 'kdv',
	'Desi' => 'desi',
	'Görsel Linki' => 'resimx',
);
/* EDIT */
$harfArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ');


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
foreach ($viewArray as $k => $v) {
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$i] . '1', $k);
	$i++;
}

$i = 2;

$cArray = explode(',', $_GET['catIDs']);
$cs = array();
foreach ($cArray as $c) {
	$c = (int) $c;
	if (!$c)
		continue;
	$cs[] = "(showCatIDs like '%|" . $c . "|%' OR catID='" . $c . "' OR kategori.idPath like '" . $c . "/%')";
}
if (count($cs) > 1) {
	$filter .= " AND (" . implode(' OR ', $cs) . ")";
}

if ($_GET['catID'])
	$filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '" . $catPatern . "/%')";

if ($_GET['catIDstart'])
	$filter .= "AND (catID >= " . (int) $_GET['catIDstart'] . " AND catID <= " . (int) $_GET['catIDfinish'] . ")";

$CargoCompany1 = hq("select name from kargofirma order by ID limit 0,1");
$ShippingAddressLabel = $ClaimAddressLabel = siteConfig('firma_adres');

$q = my_mysql_query("select urun.*,kategori.name as catName,kategori.tycode as tycode,marka.name as markaName from urun,kategori,marka where kategori.noxml != 1 AND urun.noxml != 1 AND urun.markaID = marka.ID AND urun.catID=kategori.ID AND urun.active =1 AND kategori.tycode != '' AND stok >0 AND kategori.active = 1 AND fiyat > 0 $filter  order by urun.seq,kategori.seq",1);

while ($d = my_mysql_fetch_array($q)) {
	if ($d['noxml']) continue;
	$d['TRY'] = 'TRY';

	$d['detay'] = $d['onDetay'] . $d['detay'];
	$d['kargoGun'] = (int) $d['kargoGun'];
	$d['CargoCompany1'] = $CargoCompany1;
	$d['ShippingAddressLabel'] = $ShippingAddressLabel;
	$d['ClaimAddressLabel'] = $ClaimAddressLabel; {
		$d['piyasafiyat'] = YTLfiyat($d['fiyat'], $d['piyasafiyat']);
		$d['fiyat'] = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		//	$d['fiyat'] = ($d['fiyat'] / (1 + $d['kdv']));
		$d['fiyat'] = my_money_format('', $d['fiyat']);
		$d['fiyat'] = str_replace(',', '', $d['fiyat']);
	}
	$d['kdv'] = ((float) $d['kdv'] * 100);

	$dORG = $d;
	for ($j = 1; $j <= 10; $j++) {
		$resimStr = 'resim' . ($j == 1 ? '' : $j);
		if ($d[$resimStr] && filesize('images/urunler/' . $d[$resimStr]) > 3000)
			$d[$resimStr] = 'https://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr];
		else
			unset($d[$resimStr]);
	}

	unset($resim);
	$resim = array();
	for($ri=1;$ri<=5;$ri++)
	{
		$check = 'resim'.($ri > 1?$ri:'');
		if (!(stristr($d[$check],'https://') === false))
			$resim[] = $d[$check];
	}
	$d['resimx'] = implode(',',$resim);

	$j = 0;
	foreach ($viewArray as $k => $v) {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$j] . $i, $d[$v]);
		$objPHPExcel->getActiveSheet()->getColumnDimension($harfArray[$j])->setAutoSize(true);
		$j++;
	}


	if ($d['varID1'] || $d['varID2']) {
		$var1 = (hq("select ozellik from var where ID='" . $d['varID1'] . "'"));
		$var2 = (hq("select ozellik from var where ID='" . $d['varID2'] . "'"));

		$vq = my_mysql_query("select kod,stok,var1,var2,fark from urunvarstok where up = 1 AND urunID='" . $d['ID'] . "'");
		while ($vd = my_mysql_fetch_array($vq)) {
			$i++;
			$vd['stok'] = min($vd['stok'], $d['stok']);
			$price = (hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '" . $vd['var1'] . "'") + hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '" . $vd['var2'] . "'"));
			//$new = $var->addChild('var1');

			$varyantName = str_replace(array('SEÇINIZ'), array(''), $var1);
			$varyantName2 = str_replace(array('SEÇINIZ'), array(''), $var2);

			$d['gtin'] = $vd['kod'];
			$d['stok'] = $vd['stok'];
			$d['name'] .= $vd['var1'] . ' ' . $vd['var2'];

			$d['fiyat'] = ($d['fiyat'] + $price + $vd['fark']);
			$j = 0;
			foreach ($viewArray as $k => $v) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$j] . $i, $d[$v]);
				$objPHPExcel->getActiveSheet()->getColumnDimension($harfArray[$j])->setAutoSize(true);
				$j++;
			}
			$d = $dORG;
		}
		//break;
	}
	$i++;
}
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="trendyol.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
