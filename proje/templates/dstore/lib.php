<?php

function myurunDetay()
{
	global $seo;
	if (!hq("select ID from urun where ID='".$_GET['urunID']."'"))
		exit("<script>window.location.href ='index.php';</script>");
	$out .= generateTableBox(urun('name'),showItem($_GET['urunID']),tempConfig('urundetay'));
	$out .= paketIndirim($_GET['urunID'],'UrunListLite','UrunListLiteShow',tempConfig('urunliste'));
	return $out;	
}

function dstoreilgiliUrunList()
{	
	return ilgiliUrunList('UrunListIndex','UrunListDetayShow');
}

function dstorecaprazPromosyonUrunList()
{
	return caprazPromosyonUrunList('UrunListIndex','UrunListDetayShow');
}

function dstoreLogin()
{
	if(!$_SESSION['userID'])
	{
		$out='<a class="btn-registration" href="'.($siteConfig['seoURL'] ? 'register_sp.html':'page.php?act=register').'">Kayıt ol</a>
						<a class="btn-enter" href="'.($siteConfig['seoURL'] ? 'login_sp.html':'page.php?act=login').'">Üye girişi</a>
						<span>Hoşgeldin, <a href="#">ziyaretçi</a> <br />Siteye <a href="'.($siteConfig['seoURL'] ? 'register_sp.html':'page.php?act=register').'">üye ol</a> yada <a href="'.($siteConfig['seoURL'] ? 'login_sp.html':'page.php?act=login').'">giriş yap</a></span>';
	}
	else
	{
		$out='<span>Hoşgeldin, <a href="'.($siteConfig['seoURL'] ? 'profile_sp.html':'page.php?act=profile').'">'.$_SESSION['name'].' '.$_SESSION['lastname'].'</a> <br /><a href="login_sp.html">Üye İşlemlerim</a> | <a href="modDavet_sp.html">Site Davet Formu</a> | <a href="sepet_sp.html">Alışveriş Sepetim</a> | <a href="showOrders_sp.html">Önceki Siparişlerim</a> | <a href="havaleBildirim_sp__status-1.html">Havale Bildirim Formu</a> | <a href="alarmList_sp.html">Alarm Listem</a> | <a href="logout_sp.html">Çıkış</a></span>';
	
	}
	return $out;
}

function dstroreTopMenu()
{
	$cacheName= __FUNCTION__;
	$cache = cacheout($cacheName);
	if ($cache) return $cache;
	global $siteConfig;
	$out='<ul id="nav">';
	$q = my_mysql_query("select * from kategori where active =1 AND parentID='$parentID' order by seq,name");
	while($d = my_mysql_fetch_array($q))
	{
		$link= kategoriLink($d['ID'],$d['name']);
		if(catCheck($d['ID']))
			$out.='<li><a id="a'.$d['ID'].'" href="'.$link.'">'.$d['name'].'</a><div style="clear:both"></div>'."\n";
		if (hq("select name from kategori where parentID='".$d['ID']."'"))
		{
			$q2 = my_mysql_query("select * from kategori where active = 1 AND parentID='".$d['ID']."' order by seq,name");
			if (my_mysql_num_rows($q2))
			{
				$out.='<div class="navinner"><ul id="ul'.$d['ID'].'">'."\n";
				while ($d2 = my_mysql_fetch_array($q2))
				{
					$linkSub= kategoriLink($d2['ID'],$d2['name']);
					if(catCheck($d2['ID']))
						$out.='<li><a id="a'.$d2['ID'].'"  href="'.$linkSub.'">'.$d2['name'].' &raquo; </a></li>'."\n";
				}
				$out.='</ul></div>'."\n";
				
			}
		}
		$out.='</li>';		
	}
	$out.='<li><a href="#">Markalar</a><div class="navinner"><ul>'.simpleBrandNames().'</ul></div></li>';
	$out.='</ul>';
	return cachein($cacheName,$out);	
}

function dstoreVitrin()
{
	$q = my_mysql_query("select * from kampanyaJSBanner order by seq");
	$out= '<ul>';
	while ($d=my_mysql_fetch_array($q))
	{		
		$out.="				<li>
                            	<a href='".$d['link']."'><img src='images/kampanya/".$d['resimJS']."' /></a>
                    			<div class='slideNav'>
                                	<strong>".$d['title']."</strong>
                                    <h4><a href='".$d['link']."'>".$d['info']."</a></h4>
                                </div>
                            </li> \n";
	}
	$out.='</ul>';
	return $out;
}
function dstoreHaber()
{
	$out.='<ul>'."\n";
	$q = my_mysql_query("select * from haberler order by Tarih desc limit 0,10");
	while ($d = my_mysql_fetch_array($q)) 
	{
		$href = ($siteConfig['seoURL'] ? seoFix($d['Baslik']).'-hID'.$d['ID'].'.html':'page.php?act=showNews&ID='.$d['ID'].'&name='.seoFix($d['Baslik']));
		if ($tarih) $d['Baslik'].=' ('.mysqlTarih($d['Tarih']).')';
		$out.="<li><span><a href='$href'>".$d['Baslik']."</a></span></li>\n";		
	}
	$out.='</ul>'."\n";
	return $out;
}
?>