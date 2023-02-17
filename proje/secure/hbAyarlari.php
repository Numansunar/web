<?
$dbase="siteConfig";
$title = 'HepsiBurada Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);
if(!file_exists('../include/mod_HepsiBurada.php'))
	$tempInfo.=adminWarnv3('Paketinize HepsiBurada Entegrasyon Modülü bulunmamaktadır.');
else
{
	$tempInfo.=adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <strong>http://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron-hb.php</strong> URL adresinin, en az 5dk, en fazla 15dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null http://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron-hb.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
	$tempInfo.=adminInfov3('HepsiBurada Otomatik Oran Ekle (Ör: 0.2 = %20) girişi, ilgili kategoride, "Varsayılan Çıkış Kar Marjı" girilmeyen ürünller için geçerlidir. Bir kategoriye "Varsayılan Çıkış Kar Marjı" tanımlıysa, o geçerli olur.');
}
$icerik = array(
	/*
				array(isim=>'API Panel Kullanıcı Adı',
					  db=>'hb_username',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'API Panel Şifre',
					  db=>'hb_password',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
	*/				  
				array(isim=>'API Merchant ID',
					  db=>'hb_mID',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Fiyat Tablosu',
					  db=>'hb_fiyatAlani',
					  stil=>'simplepulldown',
					  align=>'left',
					  info=>'Üründe, seçime ait bir fiyat girilmemişse ana fiyat geçerli olur.',
					  width=>80,
					  simpleValues=>'0|Normal Fiyat,1|Fiyat 1,2|Fiyat 2,3|Fiyat 3,4|Fiyat 4,5|Fiyat 5',
					  gerekli=>'1'),
				array(isim=>'Otomatik Fiyat Ekleme için Azami Ürün Tutarı',
					  db=>'hb_azami',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Otomatik Fiyat Ekle (TL)',
					  db=>'hb_fiyat',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Otomatik Oran Ekle (Ör: 0.2 = %20)',
					  db=>'hb_oran',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0')
			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>