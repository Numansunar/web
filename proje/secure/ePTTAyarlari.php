<?
$dbase="siteConfig2";
$title = 'E-PTT Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);
if(!file_exists('../include/mod_ePTTAvm.php'))
	$tempInfo.=adminWarnv3('Paketinize ePTT Avm Entegrasyon Modülü bulunmamaktadır.');
else
{
	$tempInfo.=adminInfov3('Entegrasyonun sürekli çalışabilmesi için, sunucunuz cron-job servisine <strong>http://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron-ePTT.php</strong> URL adresinin, en az 5dk, en fazla 15dk da bir çağrılacak şekilde eklenmesi gerekir. Ör : <strong>wget -O /dev/null http://'.$_SERVER['HTTP_HOST'].$siteDizini.'cron-n11.php</strong>. Eğer sunucunuzda cronjob servisi yoksa, ücretsiz olarak <a href="https://cron-job.org/" target="_blank">https://cron-job.org/</a> adresini kullanabilirsiniz.');
	$tempInfo.=adminInfov3('ePTT Avm Otomatik Oran Ekle (Ör: 0.2 = %20) girişi, ilgili kategoride, "Varsayılan Çıkış Kar Marjı" girilmeyen ürünller için geçerlidir. Bir kategoriye "Varsayılan Çıkış Kar Marjı" tanımlıysa, o geçerli olur.');
}
$icerik = array(
				array(isim=>'API Kullanıcı Adı',
					  db=>'eptt_username',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'API Şifre',
					  db=>'eptt_password',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 
				array(isim=>'Fiyat Tablosu',
					  db=>'eptt_fiyatAlani',
					  stil=>'simplepulldown',
					  align=>'left',
					  info=>'Üründe, seçime ait bir fiyat girilmemişse ana fiyat geçerli olur.',
					  width=>80,
					  simpleValues=>'0|Normal Fiyat,1|Fiyat 1,2|Fiyat 2,3|Fiyat 3,4|Fiyat 4,5|Fiyat 5',
					  gerekli=>'1'),
				array(isim=>'Otomatik Fiyat Ekleme için Azami Ürün Tutarı',
					  db=>'eptt_azami',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Otomatik Fiyat Ekle (TL)',
					  db=>'eptt_fiyat',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Otomatik Oran Ekle (Ör: 0.2 = %20)',
					  db=>'eptt_oran',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'Zorunlu Olmayan Ürün Seçimlerini de Getir',
					  db=>'eptt_zorunlu',
					  stil=>'checkbox',
					  width=>29,
					  gerekli=>'0'), 
				array(isim=>'Ürünleri Orijinal Para Birimi ile Gönder',
					  db=>'eptt_fiyatBirim',
					  stil=>'checkbox',
					  width=>29,
					  gerekli=>'0'), 
				array(isim=>'Ürünleri Gerçek Zamanlı Gönder',
					  db=>'eptt_hemen',
					  stil=>'checkbox',
					  width=>29,
					  gerekli=>'0'), 
			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>