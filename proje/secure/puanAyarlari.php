<?
$dbase="siteConfig";
$title = 'Puan Ayaları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(					  
				array(isim=>'Puan TL Karşılığı',
					  db=>'puanTL',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Üyelik Kazanlılan Puan',
					  db=>'puanUyelik',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Onaylanan Site Daveti Puan',
					  db=>'puanTavsiye',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Onaylı Yorum Puan',
					  db=>'puanYorum',
					  stil=>'normaltext',
					  gerekli=>'0'),					  
				array(isim=>'Onaylanan Ödeme Puan Oranı',
					  db=>'puanSatis',
					  stil=>'normaltext',
					  gerekli=>'0'),					  
				array(isim=>'Puan Kullanabilmek İçin Gerekli Asgari Puan',
					  db=>'puanMin',
					  stil=>'normaltext',
					  gerekli=>'0'),	
				array(isim=>'Puan Kullanabilmek/Harcayabilmek için Gerekli Asgari Alışveriş Tutarı',
					  db=>'puanSepetLimit',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Tek Alışverişte Kullanılabilecek Azami Puan',
					  db=>'puanTekSefer',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Tek Alışverişte Kullanılabilecek Azami Puan / Alışveriş Oranı<br/> Ör : 0.25 = Alışverişin %25 \i kadar puan.',
					  db=>'puanoran',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Puan Sistemi Aktif',
					  db=>'puanAktif',
					  stil=>'checkbox',
					  gerekli=>'0'),	  
			
			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>