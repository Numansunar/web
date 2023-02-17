<?php
$dbase = "siteConfig";
$title = 'Sosyal Medya Ayaları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Sosyal Medya Tanıtım Resmi',
		db => 'ogimage',
		stil => 'file',
		uploadto => 'images/',
		info => 'Sosyal medyada share edildiğiniz bu resim gözükür.',
		gerekli => '0'
	),
	array(
		isim => 'Facebook Page URL',
		db => 'facebook_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Site Girişinde Facebook Page Like Popup Ekle',
		db => 'facebook_Popup',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Siteye Facebook Float Button Ekle',
		db => 'facebook_Floating',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Facebook Page ID<br /><a href="http://www.findmyfacebookid.com" target="_blank">findmyfacebookid.com</a>',
		db => 'facebook_ID',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Facebook AppID',
		db => 'facebook_appID',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Facebook Secret Key',
		db => 'facebook_secret',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Twitter Page URL',
		db => 'twitter_URL',
		stil => 'normaltext',
		gerekli => '0'
	),

	/*
				array(isim=>'Twitter Username',
					  db=>'twitter_Username',
					  stil=>'normaltext',
					  gerekli=>'0'),				  
				array(isim=>'Twitter Consumer Key<br /><a href="http://www.pontikis.net/blog/auto_post_on_twitter_with_php" target="_blank">pontikis.net</a>',
					  db=>'twitter_ckey',
					  stil=>'normaltext',
					  gerekli=>'0'),	
				array(isim=>'Twitter Consumer Secret',
					  db=>'twitter_csecret',
					  stil=>'normaltext',
					  gerekli=>'0'),
				array(isim=>'Twitter Access Token',
					  db=>'twitter_akey',
					  stil=>'normaltext',
					  gerekli=>'0'),	
				array(isim=>'Twitter Access Token Secret',
					  db=>'twitter_asecret',
					  stil=>'normaltext',
					  gerekli=>'0'),
					  */
	array(
		isim => 'Youtube Page URL',
		db => 'youtube_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram Feed Access Token<br /><a href="http://services.chrisriversdesign.com/how-to-instagram-graph-api-token/" target="_blank">Instagram Access Token</a>',
		db => 'instagram_token',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram UserID <br /><a href="https://www.instafollowers.co/find-instagram-user-id" target="_blank">Find Instagram User ID</a>',
		db => 'instagram_UserID',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram Username',
		db => 'instagram_Username',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Instagram Page URL',
		db => 'instagram_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Google + Page URL',
		db => 'google_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'LinkedIn Page URL',
		db => 'linkedin_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Pinterest Page URL',
		db => 'pinterest_URL',
		stil => 'normaltext',
		gerekli => '0'
	),
);
$tempInfo .= adminInfov3('Facebook ayarları sadece Facebook App desteği aktif paketlerde geçerlidir.');
$tempInfo .= adminInfov3('Facebook Page URL tanımlandığında, kullanıcıya like edebileceği page, her session\da bir defa kullanıcıya POP-UP ile gösterilir. Spalsh Screen desteği aktifken, 2. popup olarak bunu aktif edilmesi tavsiye edilmez.');
$tempInfo .= adminInfov3('Sosyal medya URL adresleri https:// ile başlayarak girilmelidir.');
if ($_POST['facebook_URL'])
	$_SESSION['facebookPopup'] = 0;
admin($dbase, $where, $icerik, $ozellikler);
