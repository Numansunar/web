<?
$dbase="siteConfig";
$title = 'Watermark Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(
				array(isim=>'PNG Logo',
					  db=>'wm_resim',
					  stil=>'file',
					  uploadto=>'images/',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Logo Pozisyonu',
					  db=>'wm_pos',
					  stil=>'simplepulldown',
					  align=>'left',
					  width=>40,
					  simpleValues=>'5|Resmi Ortala,1|Sol Üst,2|Sağ Üst,3|Sol Alt,4|Sağ Alt',
					  gerekli=>'1'),
				/*
				array(isim=>'Logo Ekle',
					  db=>'wm_act',
					  stil=>'simplepulldown',
					  align=>'left',
					  width=>40,
					  simpleValues=>'1|Küçük Resime,2|Büyük Resime,3|Her ikisine',
					  gerekli=>'1'),
				*/	  					  					  
				array(isim=>'Padding (pixel)',
					  db=>'wm_padding',
					  stil=>'normaltext',
					  gerekli=>'0'),				
				array(isim=>'Opacity (0-100)',
					  db=>'wm_opacity',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Watermark Desteği Aktif',
					  db=>'wm_active',
					  stil=>'checkbox',
					  gerekli=>'0'),
			
			 	);
				$tempInfo.= adminInfov3('Watermark logo sadece resize edilen ürün resimlerine uygulanır.');
				$tempInfo.= adminInfov3('100px\'den ufak ürün resimlerine watermark logo uygulanmaz.');				
				admin($dbase,$where,$icerik,$ozellikler);
?>