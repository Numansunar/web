<?php
if($_GET['act'] == 'kategoriGoster')
{
	require_once('include/mod_CatSlider.php');
	$actHeaderArray['kategoriGoster'] = modCatSlider('708');
}

function simpleVitrinDemo()
{
	return '<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>
			<li><img src="templates/mcshop/img/slider.png" alt="" /></li>';	
}

function myurunDetay()
{
	if (!hq("select ID from urun where ID='".$_GET['urunID']."'"))
		exit("<script>window.location.href ='index.php';</script>");
	if ($siteTipi == 'TEKURUN' || $siteTipi == 'GRUPSATIS')
	{
		header('location:index.php?urunID='.$_GET['urunID']);
		exit();
	}
	$out .= showItem($_GET['urunID']);
	// $caprazSonra = 1;
	$out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler,caprazPromosyonUrunList(),tempConfig('urunliste'));	
	$out .= paketIndirim($_GET['urunID'],'UrunListLite','UrunListLiteShow',tempConfig('urunliste'));	
	return $out;	
}

function mcbenzer($d)
{
	return ilgiliUrunList('empty','UrunListSliderShow');	
}

function mcrubs($d)
{
	if($d['ucretsizKargo']) $out.='<img src="templates/mcshop/img/ucretsizkargo.png" alt="" />';
	if($d['anindaGonderim']) $out.='<img src="templates/mcshop/img/hizliteslimat.png" alt="" />';
	return $out;
}
?>