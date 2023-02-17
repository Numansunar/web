<?
$dbase="siteConfig";
$title = 'Affiliate Ayaları';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					editID=>1,
					);

$icerik = array(
				array(isim=>'Tıklama Zamanaşımı',
					  db=>'aff_timeout',
					  stil=>'normaltext',
					  gerekli=>'0'),				  	
				array(isim=>'Tıklama Başına Ödeme (TL)',
					  db=>'aff_click',
					  stil=>'normaltext',
					  gerekli=>'0'),			
				array(isim=>'Onaylanmış Sipariş Başına Ödeme (TL)',
					  db=>'aff_siparis',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Onaylanmış Sipariş Başına Ödeme (Oran)',
					  db=>'aff_oran',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Kazanç Tutar Yöntemi',
					  db=>'aff_type',
					  unlist=>true,
					  stil=>'simplepulldown',
					  align=>'left',
					  width=>50,
					  simpleValues=>'0|Alışveriş Tutarı Üzerinden,1|Alışveriş Kârı Üzerinden'),
				array(isim=>'Asgari Ödeme Talebi (TL)',
					  db=>'aff_min',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Asgari Aylık Ciro (TL)',
					  db=>'aff_minciro',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Banlı IP\'ler (Ör : 192.100.*)',
					  db=>'aff_ban',
					  stil=>'textarea',
					  style=>'width:510px; height:100px;',
					  gerekli=>'0'),
				array(isim=>'Affiliate Üyelik Kuralları',
					  db=>'aff_kural',
					  stil=>'textarea',
					  style=>'width:510px; height:100px;',
					  gerekli=>'0'),
				array(isim=>'Affiliate Aktif',
					  db=>'aff_active',
					  stil=>'checkbox',
					  gerekli=>'0'),	
				
				);
				


if (file_exists('../include/lib-affilate.php'))
{
	//if ($_GET['y'] == 'd' || $_GET['y'] == 'e') 
	{
		$tempInfo.=adminInfov3('<strong>"Onaylanmış Sipariş Başına Ödeme"</strong> veri oranlarını virgül ile ayırarak zincirleme davet desteğini kullanabilirsiniz.<br /><br /><strong>Ör :</strong> <strong>"Onaylı Sipariş Başına Ödeme (Oran)"</strong> için <strong>0.25,0.15,0.05</strong> girilirse;<br> sipariş vereni davet eden X kullanıcı %25,<br/> sipariş vereni davet eden X kullanıcısını davet eden Y kullanıcı %15,<br/> Y kullanıcısını davet eden Z kullanıcısı %5 komisyon alır. <br/> ');
	}
	admin($dbase,$where,$icerik,$ozellikler);
}
else
{
	echo v3Admin::adminHeader();
	echo "<div style='clear:both'></div>";	
	echo adminWarnv3('Paketinizde affilate desteği bulunmuyor.');
	echo v3Admin::adminFooter();
}


?>