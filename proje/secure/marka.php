<? 
$dbase="marka";
$title='Marka Yönetimi';
$listTitle = 'Markalar';
$ozellikler = array(ekle=>'1', 
					baseid=>'ID',
					orderby=>'ID',
					excelLoad=> 1,
					);

$icerik = array(
				array(isim=>'Meta Tag Keywords',
				      disableFilter=>true,
					  unlist=>true,
					  multilang=>true,
					  maxlength=>320,
					  db=>'metaKeywords',
					  stil=>'normaltext'),					  
				array(isim=>'Meta Tag Description',
					  disableFilter=>true,
					  unlist=>true,
					  maxlength=>320,
					  multilang=>true,
					  db=>'metaDescription',
					  stil=>'normaltext'),
				array(isim=>'Marka Adı',
					  db=>'name',
					  stil=>'normaltext',
					  width=>593,
					  gerekli=>'1'),
/*
					  array(
						isim => 'Varsayılan XML Giriş Kar Marjı (0.10 = %10)',
						disableFilter => true,
						db => 'kar',
						unlist => true,
						stil => 'normaltext',
						intab => 'pazaryeri',
						gerekli => '1'
					),
*/

				array(isim=>'SEO URL girişi<br/>(Girilmezse, otomatik oluşturulur.)',
					  db=>'seo',
					  multilang=>true,
					  unlist=>true,
					  stil=>'normaltext',
					  width=>226,
					  gerekli=>'1'),
					  
				array(isim=>'Marka İsim Varyasyonları (XML Entegrasyon İçin)',
					  db=>'tedarikciCode',
					  unlist=>true,
					  stil=>'normaltext',
					  gerekli=>'1'),
					  
				array(isim=>'Sipariş Info Mail',
					  db=>'email',
					  stil=>'normaltext',
					  gerekli=>'1'),
					  
				array(isim=>'Resim',
					  db=>'resim',
					  stil=>'file',
					  uploadto=>'images/markalar/',
					  unlist=>true,
					  gerekli=>'0'), 
					  
				array(isim=>'Promosyon Ürün için Asgari Marka Sipariş Tutarı',
					  db=>'pUrunTutar',
					  unlist=>true,
					  stil=>'normaltext',
					  gerekli=>'1'),	
					  
				array(isim=>'Promosyon Ürün',
					  db=>'pUrunID',
					  width=>369,
					  unlist=>true,
					  stil=>'dbpulldown',
					  dbpulldown_data =>array(db=>'urun',
					  						  base=>'ID',
											  name=>'name',
											  ),
					  gerekli=>'1'),
			
			 	);
				
if ($siteTipi == 'OZELSATIS')
{
	$ozelSatisIcerik = array(		
				array(isim=>'Liste Resim',
					  db=>'private_resim1',
					  stil=>'file',
					  uploadto=>'images/markalar/',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Info',
					  db=>'private_info',
					  stil=>'HTML',
					  en=>'450',
					  boy=>'150',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Marka Listeleme Başlangıç Tarihi',
					  db=>'private_start',
					  stil=>'date',
					  unlist=>true,
					  setTime=>true,
					  gerekli=>'0'),
				 array(isim=>'Marka Listeleme Bitiş Tarihi',
					  db=>'private_tarih',
					  stil=>'date',
					  unlist=>true,
					  setTime=>true,
					  gerekli=>'0'),
				array(isim=>'Öncelik',
					  db=>'seq',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'1'),
				array(isim=>'Ürünleri Otomatik Aktif / Pasif Yap',
					  db=>'auto',
					  stil=>'checkbox',
					  width=>29,
					  gerekli=>'0'), 
	);
	$icerik = array_merge($icerik,$ozelSatisIcerik);
}

if ($_GET['ID'] && file_exists('../include/mod_Trendyol.php'))
{
	require_once('../include/mod_Trendyol.php');
	$trendyolIcerik = array(		
		array(isim=>'Trendyol Marka Karşılığı',
		db=>'ty_markaID',
		stil=>'simplepulldown',
		align=>'left',
		width=>80,
		simpleValues=>Trendyol::getBrands((hq("select name from marka where ID='".$_GET['ID']."'"))),
		gerekli=>'1'),	
	);
	$icerik = array_merge($icerik,$trendyolIcerik);
}

if ($_GET['y'] == 'd') {
	$url = 'http://'.$_SERVER["SERVER_NAME"].markaLink((int)$_GET['ID']);
	$tempInfo.=adminInfov3('Düzenleme yapılan markanın URL adresi :<br /> <a href="'.$url.'" target="_blank"><strong>'.$url.'</strong></a>');
	$tempInfo.=adminInfov3('<a href="s.php?f=pc.php&y=e&catID='.$_GET['ID'].'">Kategoriyi PushCrew ile göndermek için tıklayın.</a>');
}
echo adminInfo('Markaya info mail ekleyerek, ilgili adrese sadece bu markaya gelen sipariş bilgilerinin gönderilmesini sağlayabilirsiniz.');
echo adminInfo('Markaya ait asgari tutarda ürün satın alındığında, ilgili promosyon ürünün otomatik sepete eklenmesini sağlayabilirsiniz.');
setAdminPostSEOField();
admin($dbase,$where,$icerik,$ozellikler);
?>