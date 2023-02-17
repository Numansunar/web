<?php
try{
	$VeritabaniBaglantisi = new PDO("mysql:host=localhost;dbname=fitpowertea;charset=UTF8","root","");
}catch(PDOException $Hata){
	//echo"Bağlantı Hatası<br/>", $Hata->getMessage(); //bu alanı kapatın çünkü site hata yaparsa kullanıcılar hata değerini görmesin.
	die();
}
$AyarlarSorgusu 	=	$VeritabaniBaglantisi->prepare("SELECT*FROM ayarlar LIMIT 1");
$AyarlarSorgusu->execute();
$AyarSayisi			= 	$AyarlarSorgusu->rowCount();
$Ayar = $AyarlarSorgusu->fetch(PDO::FETCH_ASSOC);
if($AyarSayisi>0){
$SiteAdi 			=	$Ayarlar["SiteAdi"];
$SiteTitle		    =	$Ayarlar["SiteTitle"];
$SiteDescription    =	$Ayarlar["SiteDescription"];
$SiteKeywords 		=	$Ayarlar["SiteKeywords"];
$SiteCopyrightMetni =	$Ayarlar["SiteCopyrightMetni"];
$SiteLogosu		    =	$Ayarlar["SiteLogosu"];
$SiteEmailAdresi    =	$Ayarlar["SiteEmailAdresi"];
$SiteEmailSifresi   =	$Ayarlar["SiteEmailSifresi"];
$SosyalLinkFacebook =	$Ayarlar["SosyalLinkFacebook"];
$SosyalLinkTwitter	=	$Ayarlar["SosyalLinkTwitter"];
$SosyalLinkLinkedin	=	$Ayarlar["SosyalLinkLinkedin"];
$SosyalLinkInstagram=	$Ayarlar["SosyalLinkInstagram"];
$SosyalLinkPinterest=	$Ayarlar["SosyalLinkPinterest"];
$SosyalLinkYouTube	=	$Ayarlar["SosyalLinkYouTube"];
}else{
	//echo "Site Ayar Sorgusuhatalı"; //Kullanıcı Görmesin sen hata alınca aç
	die();
}
$MetinlerSorgusu 	=	$VeritabaniBaglantisi->prepare("SELECT*FROM sozlesmelervemetinler LIMIT 1");
$MetinlerSorgusu->execute();
$MetinlerSayisi		= 	$MetinlerSorgusu->rowCount();
$Metinler			= $MetinlerSorgusu->fetch(PDO::FETCH_ASSOC);
if($AyarSayisi>0){
$HakkimizdaMetni 				=	$Metinler["HakkimizdaMetni"];
$UyelikSozlesmesiMetni		    =	$Metinler["UyelikSozlesmesiMetni"];
$KullanimKosullariMetni   		=	$Metinler["KullanimKosullariMetni"];
$GizlilikSozlesmesiMetni 		=	$Metinler["GizlilikSozlesmesiMetni"];
$MesafeliSatisSozlesmesiMetni 	=	$Metinler["MesafeliSatisSozlesmesiMetni"];
$TeslimatMetni		    		=	$Metinler["TeslimatMetni"];
$IptalIadeDegisimMetni    		=	$Metinler["IptalIadeDegisimMetni"];
}else{
	//echo "Site Metinler Sorgusuhatalı"; //Kullanıcı Görmesin sen hata alınca aç
	die();
}
?>