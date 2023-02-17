<?php
$siteConfig['cacheSuresi'] = 0;
if (!$_GET['urunID']) $_GET['urunID'] = mGrupAnaUrunID();
$out.=showItem($_GET['urunID']);
if ($_SESSION['groupCity']) $cityFilter = 'AND urun.data4 = \''.$_SESSION['groupCity'].'\'';
if (!hq("select ID from urun where ID='".$_GET['urunID']."' AND stok > 0 AND start < now() AND finish > now() $cityFilter order by seq desc,start asc limit 0,1")) 
{
	$out.="<style>.siparis_ver { display:none; }</style>";
}
$PAGE_OUT = $out;
?>