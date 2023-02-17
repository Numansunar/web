<?php
$IPAdresi =$_SERVER['REMOTE_ADDR'];
$ZamanDamgasi = time();
$TarihSaat = date("d.m.y H.i.s",$ZamanDamgasi);

function RakamlarHariciTumKarakterleriSil($Deger){
	$Islem = preg_replace("/[^0-9]/","",$Deger);
	$Sonuc = $Islem;
	return $Sonuc;
}
function DönüsümleriGeriDöndür(){
	$EtkisizYap = htmlspecialchars_decode($Deger,ENT_QUOTES);
	$Sonuc = $GeriDondur;
	return $Sonuc;
	
}

function Guvenlik($Deger){
	$BoslukSil =trim($Deger);
	$TaglariTemizle =strip_tags($BoslukSil);
	$EtkisizYap = htmlspecialchars($TaglariTemizle);
	$Sonuc = $EtkisizYap;
	return $Sonuc;
	
}

function SayiliIcerikleriFiltrele($Deger){
	$BoslukSil =trim($Deger);
	$TaglariTemizle =strip_tags($BoslukSil);
	$EtkisizYap = htmlspecialchars($TaglariTemizle);
	$Temizle = RakamlarHariciTumKarakterleriSil($EtkisizYap);
	$Sonuc = $Temizle;
	return $Sonuc;
	
}
?>