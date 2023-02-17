<?php
$jsLoad['countdown'] = 1;
function pbLoginScreen()
{
	if($_SESSION['userID'])
	{
		$out.='<div id="top">
				<ul>
					<li><a href="'.($siteConfig['seoURL'] ? 'profile_sp.html':'page.php?act=profile').'">Hesabım</a></li>
					<li>|</li>
					<li><a href="'.($siteConfig['seoURL'] ? 'showOrders_sp.html':'page.php?act=showOrders').'">Önceki Siparişlerim</a></li>
					<li>|</li>
					<li><a href="'.($siteConfig['seoURL'] ? 'puan_sp.html':'page.php?act=puan').'">Puanlarım</a></li>
					<li>|</li>
					<li><a href="'.($siteConfig['seoURL'] ? 'modDavet_sp.html':'page.php?act=modDavet').'">Arkadaşını davet et</a></li>
					<li>|</li>
					<li><a href="page.php?act=logout">Çıkış</a></li>
				</ul>
				<div class="welcome">Sn. '. hq("select concat(name,' ',lastname) from user where ID='".$_SESSION['userID']."'").'</div>
			</div><!--#top END-->';	
	}
	else
	{
		$out.='<div id="top">
				<ul>
					<li><a href="'.($siteConfig['seoURL'] ? 'login_sp.html':'page.php?act=login').'">Üye Girişi</a></li>
					<li>|</li>
					<li><a href="'.($siteConfig['seoURL'] ? 'register_sp.html':'page.php?act=register').'">Üye Olun </a></li>
					<li>|</li>
					<li><a href="'.($siteConfig['seoURL'] ? 'sifre_sp.html':'page.php?act=sifre').'">Şifremi Unuttum</a></li>
					<li>|</li>
					<li><a href="'.($siteConfig['seoURL'] ? 'siparistakip_sp.html':'page.php?act=siparistakip').'">Sipariş Takibi</a></li>
				</ul>
			</div><!--#top END-->';	
	}
	return $out;
}

function pbFooterPages()
{
	global $siteConfig;	
	$out = '<ul>';
	//$out.= '<li '.(strtolower(basename($_SERVER['SCRIPT_FILENAME'])) == 'index.php'?'class="selected"':'').'><a href="./index.php">Ana Sayfa</a></li>';			
	$q = my_mysql_query('select * from pages where showLeft=1 order by seq limit 0,5');
	while ($d = my_mysql_fetch_array($q)) {
		$link = ($siteConfig['seoURL'] ? seoFix($d['title']).'-sID'.$d['ID'].'.html':'page.php?act=showPage&ID='.$d['ID']);
		$href=($d['redirect']?$d['redirect']:$link);
		if ($d['redirect'] && !(stristr($d['redirect'],'|') === false)) {
			list($seo,$link) = explode('|',$d['redirect']);
			$href = ($siteConfig['seoURL'] ? $seo:$link);
		}
		$out.='<li '.(basename($_SERVER['REQUEST_URI']) == $href?'class="selected"':'').'><a href="'.$href.'">'.$d['title'].'</a></li>';
	}
	$out.='</ul>';
	return $out;
}

function markaSayac($markaID)
{
	if (!$markaID) return;
	$tarihArray = explode(' ',hq("select private_tarih from marka where ID='$markaID'"));
	list($yil,$ay,$gun) = explode('-',$tarihArray[0]);
	list($dak,$san) = explode(':',$tarihArray[1]);
	
	return '<script>
			function liftOff() 
			{
				window.location.reload();
			}
			$(\'#sayac_'.$markaID.'\').countdown({tickInterval: 1,onExpiry: liftOff,until: new Date('.$yil.', ('.$ay.' - 1), '.$gun.', '.$dak.', '.$san.'),timezone: +2,     layout: \'{dn} gün {hnn} saat {mnn} dk {snn} sn\'});	
			
			</script>';
}

function markaList($catID)
{
	global $siteConfig;
	if ($catID)
		$q = my_mysql_query("select marka.*,kategori.ID as catID from urun,kategori,marka where urun.markaID = marka.ID AND urun.catID=kategori.ID AND (urun.showCatIDs like '%|$catID|%' OR urun.catID='$catID') AND marka.private_tarih >= now()  AND marka.private_start <= now() group by marka.ID order by marka.name") or die(mysql_error());
	else 
		$q = my_mysql_query("select marka.*,kategori.ID as catID from urun,kategori,marka where urun.markaID = marka.ID AND urun.catID=kategori.ID AND marka.private_tarih >= now()  AND marka.private_start <= now() group by marka.ID order by marka.name") or die(mysql_error());
	while($d=my_mysql_fetch_array($q))
	{
		if ($siteConfig['seoURL']) 
			$out.='<li><a href="'.seoFix($d['name']).'-kat'.$catID.'-marka'.$d['ID'].'.html" style="background:none;">'.($d['name']).'</a></li>'."\n";	
		else
			$out.='<li><a href="page.php?act=kategoriGoster&catID='.$catID.'&markaID='.$d['ID'].'" style="background:none;">'.($d['name']).'</a></li>'."\n";	
	}
	return $out;
}

function kategoriList()
{
	$q = my_mysql_query("select * from kategori where active = 1 AND parentID=0 order by kategori.seq,name") or die(mysql_error());
	while($d = my_mysql_fetch_array($q))
	{
		$selected = '';
		$catArray = explode('/',hq("select idPath from kategori where ID='".$_GET['catID']."'"));
		if (in_array($d['ID'],$catArray)) 
			$selected = 'class="selected"';
		if (markaList($d['ID']))
			$out.='<li '.$selected.'><a href="#"><span>'.($d['name']).'</span></a><div class="sub">
								<ul>'.markaList($d['ID']).'</ul>
							</div></li><li>|</li>'."\n";
	}
	return substr($out,0,-11);
}
function oncekiUrun()
{
	$q = my_mysql_query("select * from urun where markaID='".$_GET['markaID']."' AND active=1 order by seq,ID desc") or die(mysql_error());
	$i=1;
	while($d = my_mysql_fetch_array($q))
	{
		$s[$i] = $d['ID'];
		if ($d['ID'] == $_GET['urunID']) $suAnkiSira = $i; 	
		$i++;
	}
	$q1 = my_mysql_query("select * from urun where ID='".$s[($suAnkiSira - 1)]."'");
	$q2 = my_mysql_query("select * from urun where ID='".$s[($suAnkiSira + 1)]."'");
	$oncekiUrun = my_mysql_fetch_array($q1);
	$sonrakiUrun = my_mysql_fetch_array($q2);
	if ($s[($suAnkiSira - 1)])
	{
		$d = $oncekiUrun;
		$urunLink = ($siteConfig['seoURL'] ? seoFix($d['name']).'-urun'.$d['ID'].'.html':'page.php?act=urunDetay&urunID='.$d['ID'].'&name='.seoFix($d['name']));
		$out.='					<a class="prev" href="'.$urunLink.'">
								<span>önceki ürün</span><br />
								<img src="include/resize.php?path=images/urunler/'.$d['resim'].'&width=100" alt="" style="width:100px; " />
							</a>';
	}
	if ($s[($suAnkiSira + 1)])
	
	{
		$d = $sonrakiUrun;
		$urunLink = ($siteConfig['seoURL'] ? seoFix($d['name']).'-urun'.$d['ID'].'.html':'page.php?act=urunDetay&urunID='.$d['ID'].'&name='.seoFix($d['name']));		
		$out.='
							<a class="next" href="'.$urunLink.'">
								<span>sonraki ürün</span><br />
								<img src="include/resize.php?path=images/urunler/'.$d['resim'].'&width=100" alt="" style="width:100px; " />
							</a>';
	}
	return $out;
}

function urunGoster_ResimListKucuk()
{
	$q = my_mysql_query("select * from urun where ID='".$_GET['urunID']."'") or die(mysql_error());
	while($d = my_mysql_fetch_array($q))
	{
		for($i=0;$i<=5;$i++)
		{
			//if ($i==1) continue;
			$str = ($i?'resim'.$i:'resim');
			if (!$d[$str]) continue;
				$resimX = '';
				if ($d[$str]) $resimX = '<a href="#product'.($i + 1).'" title="'.$d['name'].'"><img src="include/resize.php?path=images/urunler/'.$d[$str].'&width=90&height=47" style="width:60px; height:90px;"  alt="'.$d['name'].'"/></a>';
				$out.='<li '.($i==5?'class="last"':'').'>'.$resimX.'</li>'."\n";
		}
	}
	return $out;
}

function urunGoster_ResimListBuyuk()
{
	$q = my_mysql_query("select * from urun where ID='".$_GET['urunID']."'") or die(mysql_error());
	while($d = my_mysql_fetch_array($q))
	{
		//if ($i==1) continue;
		for($i=0;$i<=5;$i++)
		{
			$str = ($i?'resim'.$i:'resim');
			if (!$d[$str]) continue;
			$resimX = 
				$out.='	<div id="product'.($i + 1).'">
							<a href="images/urunler/'.$d[$str].'" class="zoom lightbox"><img src="include/resize.php?path=images/urunler/'.$d[$str].'&width=500" style="width:275px;"  alt="'.$d['name'].'"/></a>
						</div>'."\n";
		}
	}
	return $out;
}
function urunGoster_ResimList()
{
	$out.='<div class="urun_galeri">';
	$q = my_mysql_query("select * from urun where ID='".$_GET['urunID']."'") or die(mysql_error());
	while($d = my_mysql_fetch_array($q))
	{
		for($i=0;$i<=5;$i++)
		{
			$str = ($i?'resim'.$i:'resim');
			if ($d[$str])
				$out.='<a href="include/resize.php?path=images/urunler/'.$d[$str].'&width=300&height=300" title="'.$d['name'].'" rel="include/resize.php?path=images/urunler/'.$d[$str].'&width=42&height=42"><img src="include/resize.php?path=images/urunler/'.$d[$str].'&width=300&height=300"  alt="'.$d['name'].'"/></a>'."\n";
		}
	}
	$out.='</div>';
	return $out;
}

function myurunDetay()
{
	if (hq("select urun.ID from urun,marka where markaID=marka.ID and marka.private_tarih < now() AND urun.ID='".$_GET['urunID']."'"))
		return 'Ürün satışta değildir.';
	$out.='<div class="clear">&nbsp;</div>'.proHead();
	$out .= generateTableBox('',showItem($_GET['urunID']),tempConfig('urundetay'));
	return $out;
}

function mymodDavetURL()
{
	global $seo;
	$out.='	<div id="invitePage" class="context">
				<h2 class="headings">DAVET ET</h2>
				<div id="links">
					<ul>
						<li><a href="page.php?act=modDavet">Adres Defterimden Davet Et</a></li>
						<li  class="selected"><a href="page.php?act=modDavetURL">Sosyal Ağlarda Paylaş</a></li>
						<li class="last" ><a href="page.php?act=modDavetliste">Davet Ettiklerim</a></li>
					</ul>
				</div><!--#links END-->
				<div class="clear"></div>';
		$seo->currentTitle = 'Sitemizi tavsiye edin, puan kazanın!';
		$disableRightColumn = true;
		$out.=generateTableBox('Size Özel Davet URL adresiniz','<h3>Kıskandıran alışveriş  davet linkinizi paylaşın, davet ettikçe hem kazanın hem kazandırın.</h3><p>Facebook statusunuzde, bloglarda, MSN\'de, Twitter\'da, her yerde paylaşın, kazanın, kazandırın.</p><div class="inviting">'.davetURL().'</div>',tempConfig('formlar'));
		$out.="<script>$('.inviting input').addClass('input').attr('style','width:489px');</script>";
		insertToUserLog('Ziyaret','Size Özel Davet URL adresiniz',selfURL());
	return $out;
}
function myKategoriGoster()
{
	global $siteConfig;
	$out.='<div class="clear">&nbsp;</div>'.proHead();
	if ($_GET['markaID']) setSEO(dbinfo('marka','name',$_GET['markaID']),dbinfo('kategori','metaDescription',$_GET['markaID']),dbinfo('kategori','metaKeywords',$_GET['markaID']));
	$out .= generateTableBox('',myItemOrder(),tempConfig('formlar'));
	if ($_GET['catID']) $out .= generateTableBox(currentCatName().' Kategorileri',showCategoryPictures('KategoriList'),tempConfig('formlar'));
	if ($_GET['catID']) $out .= showCategoryBanner();
	$order = ($_GET['orderBy']?$_GET['orderBy']:'urun.seq desc,urun.ID desc');
	$baslik = ($_GET['catID']?currentCatName():dbInfo('marka','name',$_GET['markaID']));
	if ($_GET['fID'] && !$_GET['catID']) $baslik = $_GET['fVal'];
	if (!$_SESSION['listType'] || $_SESSION['listType'] == 'detay') $out .= generateTableBox('',showCategory($_GET['catID'],$order),tempConfig('urunliste'));
	else $out .= generateTableBox('',listCategory($_GET['catID'],$order,'UrunListLite','UrunListLiteShow'),tempConfig('urunliste'));
	insertToUserLog('Ziyaret','Kategori',selfURL());
	my_mysql_query('update kategori set hit = hit + 1 where ID='.$_GET['catID']);
	setStats('updateKategori');	
	return $out;
}

function myItemOrder() {
	global $siteConfig;
	if ($_POST['listType']) $_SESSION['listType'] = $_POST['listType'];
	$out='<div class="filter"><h3>SIRALAMA</h3><form name="urunsirala" id="urunsirala" method="get" action="page.php">
			<input type="hidden" name="act" value="'.$_GET['act'].'">
			<input type="hidden" name="fID" value="'.$_GET['fID'].'">
			<input type="hidden" name="fVal" value="'.$_GET['fVal'].'">
			<input type="hidden" name="catID" value="'.$_GET['catID'].'">
			<input type="hidden" name="markaID" value="'.$_GET['markaID'].'">';
	switch($siteConfig['listType'])
	{
		case 0:
			$out2.='
			<div class="selection"><select name="listType" id="listType">
				<option value="detay" '.($_SESSION['listType'] == 'detay'?'selected':'').'>'._lang_urunDetay.'</option>
				<option value="liste" '.($_SESSION['listType'] == 'liste'?'selected':'').'>'._lang_urunListe.'</option></select></div>';
		break;
		case 1:
			$_SESSION['listType'] = 'detay';
		break;
		case 2:
			$_SESSION['listType'] = 'liste';
		break;
	}
		
	$out.='<div class="selection"><select name="orderBy" id="orderBy" onchange="$(\'#urunsirala\').submit();"><option value="tarih desc">'._lang_tariheGore.'</option><option value="fiyat asc">'._lang_fiyataGore.'</option><option value="marka.name asc">'._lang_markayaGore.'</option><option value="name asc">'._lang_urunAdinaGore.'</option>><option value="sold desc">'._lang_satisaGore.'</option></select></div></form></div>';
	//$out.=jselect('markaID',$_GET['markaID']);
	$out.=jselect('orderBy',$_GET['orderBy']);
	return $out;
}

function proHead()
{
	if (!$_GET['markaID']) $_GET['markaID'] = hq("select markaID from urun where ID='".$_GET['urunID']."'");
	$q = my_mysql_query("select * from marka where ID='".$_GET['markaID']."'");
	if (!my_mysql_num_rows($q)) return;
	$d = my_mysql_fetch_array($q);	
	$out.='	<div id="proHead">
				<div class="img"><img src="images/markalar/'.$d['private_resim1'].'" alt="'.$d['name'].'" style="width:495px; height:129px;"/></div>
				<div id="proHeadRight">
					<h1>'.$d['name'].'</h1>
					<p>'.$d['private_info'].'</p>
					<div id="remain">
						Kampanya bitimine <strong><span id="sayac_'.$d['ID'].'"></span></strong> kaldı
					</div><!--#remain END-->
				</div>
			</div><!--#proHead END-->';	
	$out.=markaSayac($d['ID']);
	return $out;
}
?>