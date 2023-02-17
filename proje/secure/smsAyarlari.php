<?
$dbase="siteConfig";
$title = 'SMS Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(
				array(isim=>'SMS Gönderimi Aktif',
					  db=>'SMS_kullan',
					  stil=>'checkbox',
					  gerekli=>'0'),
				array(isim=>'SMS No',
					  db=>'SMS_no',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),
				array(isim=>'SMS Firma',
					  db=>'SMS_Firma',
					  stil=>'simplepulldown',
					  align=>'left',
					  width=>40,
					  simpleValues=>'9|Turkiye SMS,1|Figensoft,2|Alo/Mutlu SMS,3|Net GSM,4|Ucuz SMS Al,5|Avea Kurumsal,6|Ucuz SMS Gönder,7|Barabut,8|Setafon (SMS Kutusu),10|SMS Origin,11|Toplu SMS API (İleti Merkezi),12|Dakik SMS,13|Kurecell SMS,14|InfoBip,15|Tescom,16|Verimor,17|Nida Telekom,18|DataPort,19|Nac.com.tr,20|Mas GSM',
					  gerekli=>'1'),
				array(isim=>'SMS Originator (Gönderen)',
					  db=>'SMS_originator',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 						  							  
				array(isim=>'SMS Kullanıcı Adı',
					  db=>'SMS_username',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 					  
				array(isim=>'SMS Şifre',
					  db=>'SMS_password',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'), 	
				array(isim=>'SMS Footer Info',
					  db=>'SMS_footer',
					  stil=>'normaltext',
					  unlist=>true,
					  gerekli=>'0'),	  
			
			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>