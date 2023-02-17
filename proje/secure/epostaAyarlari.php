<?
$dbase = "siteConfig";
$title = 'E-Posta Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Gönderen E-Posta Başlığı',
		db => 'mailFrom',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Yönetici E-Posta Ad.',
		db => 'adminMail',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Sipariş Bilgi E-Posta Ad.',
		db => 'siparisMail',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'İletişim Bilgi E-Posta Ad.',
		db => 'iletisimMail',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'E-Postalar için SMTP Sunucusu Kullan',
		db => 'SMTP_kullan',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'SMTP Sunucu',
		db => 'SMTP_server',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Port',
		db => 'SMTP_port',
		defaultValue => '25',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Kullanıcı Adı',
		db => 'SMTP_username',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Şifre',
		db => 'SMTP_password',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'SMTP Sunucu Güvenliği',
		db => 'SMTP_secure',
		stil => 'simplepulldown',
		simpleValues => '|Normal,ssl|SSL,tls|TLS',
		gerekli => '1'
	),
	array(
		isim => 'MadMimi API Kullanıcı Adı',
		db => 'madmimi_username',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'MadMimi API Şifre',
		db => 'madmimi_password',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'E-Posta Şablon Footer Info',
		db => 'footer',
		multilang => true,
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Tek IP için Günlük E-Posta Limiti',
		db => 'mailiplimit',
		info =>'Boş bırakırsak sınır olmaz. 20 girersek x IP üzerinden o gün site içerisinde en fazla 20 e-posta gönderimi yapılabilir. (Yönetici girişi yapanlarda bu limit uygulanmaz.)',
		multilang => true,
		stil => 'normaltext',
		gerekli => '0'
	),

	array(
		isim => 'PHP Mailer Sürüm',
		db => 'phpMailer',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '0|v6,5|v5',
		gerekli => '1'
	),

	array(
		isim => 'Toplu E-Posta Gönderimi',
		db => 'gonderilenEpostaSayisi',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '50|Bir Seferde 50 E-Posta,100|Bir Seferde 100 E-Posta,250|Bir Seferde 250 E-Posta,500|Bir Seferde 500 E-Posta,0|Tümü Tek Seferde',
		gerekli => '1'
	),

);

$tempInfo .= adminInfov3('Yandex ve Google gibi e-posta sunucularını kullanabilmek için, sunucunuzda "SMTP Restrictions" pasif durumda olmalıdır. Bu ayarı Tweak Settings altındaki Mail Fonksiyonu Ayarlarından kişiselleştirebilirsiniz.');
$tempInfo .= adminInfov3('MadMimi API Entegrasyonu sadece e-bülten gönderimlerinde kullanılmaktadır.');


echo adminv3($dbase, $where, $icerik, $ozellikler);
