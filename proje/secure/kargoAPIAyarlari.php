<?
include_once('../include/3rdparty/UPS.php');
$dbase="siteConfig";
$title = 'Kargo API Entegrasyon Ayarları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);
$tempInfo.=adminInfov3('Kargo API entegrasyonu için, firma yönetim panelinden XML engtegrasyın kısmındaki bilgilerin aktif edilip girilmesi gerekir. Kullanıcılar, sipariş yönetiminde tanımlanan kargo takip numarasından sonra, önceki siparişleri detaylarında kargo durumunu gerçek zamanlı inceleyeyebilir.');
$tempInfo.=adminInfov3('Kargo API entegrasyon bilgileri elinizde yoksa, buradan rastgele bir seçim veya hatalı bir giriş yapmayın. Hatalı bir giriş, sipariş aşamasında hata oluşmasına neden olabilir.');
if(!$disablehelp)
	$tempInfo.=adminInfov3('Bu giriş hakkında kısa bir bilgiyi <a href="//yardim.shopphp.net/page.php?act=kategoriGoster&katID=329&autoOpen=122" target="_blank"><strong>buraya tıklayarak</strong></a> alabilirsiniz.');
if(!class_exists("SOAPClient"))
	$tempInfo.=adminErrorv3('Sunucunuzda SOAP yüklü veya aktif değil. Kargo API entegrasyonu kullanabilmek için SOAP özelliğinin aktif olması gerekiyor. Sunucu yöneticinize bunu ileterek SOAP desteğini aktif edebilirsiniz.');	

$tempInfo.=adminInfov3('Aras Kargo entegrasyonu için <a href="https://' . $_SERVER["SERVER_NAME"] . $siteDizini.'cron-aras.php" target="_blank"><strong>https://' . $_SERVER["SERVER_NAME"] . $siteDizini.'cron-aras.php</strong></a> adresi, sunucu cron servisine 15dk \'da bir çağrılacak şekilde eklenmedilir.');
$tempInfo.=adminInfov3('MNG Kargo entegrasyonu için <a href="https://' . $_SERVER["SERVER_NAME"] . $siteDizini.'cron-mng.php" target="_blank"><strong>https://' . $_SERVER["SERVER_NAME"] . $siteDizini.'cron-mng.php</strong></a> adresi, sunucu cron servisine 15dk \'da bir çağrılacak şekilde eklenmedilir.');
$tempInfo.=adminInfov3('Sürat Kargo entegrasyonu için <a href="https://' . $_SERVER["SERVER_NAME"] . $siteDizini.'cron-surat.php" target="_blank"><strong>https://' . $_SERVER["SERVER_NAME"] . $siteDizini.'cron-surat.php</strong></a> adresi, sunucu cron servisine 15dk \'da bir çağrılacak şekilde eklenmedilir.');


$icerik = array(	
				array(isim=>'Aras Kargo Firma',
					  db=>'kargo_arasID',
					  width=>94,
					  stil=>'dbpulldown',
					  unlist=>true,
					  dbpulldown_data =>array(db=>'kargofirma',
					  						  base=>'ID',
											  name=>'name',
											  order=>'ID'
											  ),
					  gerekli=>'1'),
				array(isim=>'Aras Kargo Kullanıcı adı',
					  db=>'kargo_arasUsername',
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'Aras Kargo Şifre',
					  db=>'kargo_arasPassword',
					  stil=>'normaltext',
					  gerekli=>'1'),					  				
				array(isim=>'Aras Kargo Müşteri Kodu',
					  db=>'kargo_arasCustomerCode',
					  stil=>'normaltext',
					  gerekli=>'1'),	
				array(isim=>'Aras Kargo Takip AccountID',
					  db=>'kargo_arasTakipAccountID',
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'Aras Kargo Takip Şifre',
					  db=>'kargo_arasTakipSifre',
					  stil=>'normaltext',
					  gerekli=>'1'),				  
				array(isim=>'MNG Kargo Firma',
					  db=>'kargo_mngID',
					  width=>94,
					  stil=>'dbpulldown',
					  unlist=>true,
					  dbpulldown_data =>array(db=>'kargofirma',
					  						  base=>'ID',
											  name=>'name',
											  order=>'ID'
											  ),
					  gerekli=>'1'),
				array(isim=>'MNG Kargo Müşteri No',
					  db=>'kargo_mngMusteriNo',
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'MNG Kargo Şifre',
					  db=>'kargo_mngSifre',
					  stil=>'normaltext',
					  gerekli=>'1'),
					  
				array(isim=>'UPS Kargo Firma',
					  db=>'kargo_upsID',
					  width=>94,
					  stil=>'dbpulldown',
					  unlist=>true,
					  dbpulldown_data =>array(db=>'kargofirma',
					  						  base=>'ID',
											  name=>'name',
											  order=>'ID'
											  ),
					  gerekli=>'1'),	  
				array(isim=>'UPS Kargo Müşteri No',
					  db=>'kargo_upsMusteriNo',
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'UPS Kargo Kullanıcı Adı',
					  db=>'kargo_upsKullanici',
					  stil=>'normaltext',
					  gerekli=>'1'),
					  
				array(isim=>'UPS Kargo Şifre',
					  db=>'kargo_upsSifre',
					  stil=>'normaltext',
					  gerekli=>'1'),

				array(isim=>'UPS Kargo Gönderen Adres',
					  db=>'kargo_upsAdres',
					  stil=>'textarea',
					  gerekli=>'1'),
				
				array(
						isim => 'UPS Kargo Gönderen Adres Semt / Şehir',
						db => 'kargo_upsSemtSehir',
						stil => 'simplepulldown',
						align => 'left',
						width => 40,
					//	simpleValues => UPSMapper::getUPSCityTownList(),
						gerekli => '1'
				),
					  					  
				array(isim=>'Yurtiçi Kargo Firma',
					  db=>'kargo_yiID',
					  width=>94,
					  stil=>'dbpulldown',
					  unlist=>true,
					  dbpulldown_data =>array(db=>'kargofirma',
					  						  base=>'ID',
											  name=>'name',
											  order=>'ID'
											  ),
					  gerekli=>'1'),	  
				array(isim=>'Yurtiçi Kargo Kullanıcı Adları (, ile ayırın.)<br />1. Gön. Ödemeli Normal<br />2. Gön. Ödemeli Tahsilatlı<br />3. Alıcı Ödemeleri Normal<br />4. Alıcı ödemeli tahsilatlı',
					  db=>'kargo_yiKullanici',
					  stil=>'normaltext',
					  gerekli=>'1'),
					  
				array(isim=>'Yurtiçi Kargo Şifreleri <br />(, ile ayırın.)<br />1. Gön. Ödemeli Normal<br />2. Gön. Ödemeli Tahsilatlı<br />3. Alıcı Ödemeleri Normal<br />4. Alıcı ödemeli tahsilatlı',
					  db=>'kargo_yiSifre',
					  stil=>'normaltext',
					  gerekli=>'1'),
                                
                                					  
				array(isim=>'Sürat Kargo Firma',
					  db=>'kargoSuratID',
					  width=>94,
					  stil=>'dbpulldown',
					  unlist=>true,
					  dbpulldown_data =>array(db=>'kargofirma',
					  						  base=>'ID',
											  name=>'name',
											  order=>'ID'
											  ),
					  gerekli=>'1'),	
					  /*
				array(isim=>'Sürat Kargo Cari Kodu (Kredi Kartı)',
					  db=>'kargoSuratApiCariKredi',
					  stil=>'normaltext',
					  gerekli=>'1'),  
					  
				array(isim=>'Sürat Kargo Cari Kodu (Kapıda Ödeme)',
					  db=>'kargoSuratApiCariKapi',
					  stil=>'normaltext',
					  gerekli=>'1'),  
					 */ 
				array(isim=>'Sürat Kargo API Adı',
					  db=>'kargoSuratApiName',
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'Sürat Kargo API Şifre',
					  db=>'kargoSuratApiPassword',
					  stil=>'normaltext',
					  gerekli=>'1'),
				array(isim=>'Sürat Kargo WebService Şifre',
					  db=>'kargoSuratWebPassword',
					  stil=>'normaltext',
					  gerekli=>'1'),
					  
				array(isim=>'Sürat Kargo Kapıda Ödeme Adı',
					  db=>'kargoSuratKapidaUsername',
					  stil=>'normaltext',
					  gerekli=>'1'),
                                
                array(isim=>'Sürat Kargo Kapıda Ödeme Şifre',
					  db=>'kargoSuratKapidaPassword',
					  stil=>'normaltext',
					  gerekli=>'1'),
					  
				array(isim=>'Sürat WebServis Şifre',
					  db=>'kargoSuratWebPassword',
					  stil=>'normaltext',
					  gerekli=>'1'),
			 	);
				admin($dbase,$where,$icerik,$ozellikler);
?>