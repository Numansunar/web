<?php
function modTelefon()
{
	global $modHizliIletisim;
	include('include/mod_HizliIletisim.php');
	return $modHizliIletisim;
}
function modRegister()
{
	global $modRegister;
	include('include/mod_Register.php');
	return $modRegister;
}
function simpleVitrin_()
{
	$q = my_mysql_query("select * from kampanyaJSBanner order by seq");
	while ($d=my_mysql_fetch_array($q))
	{		
		$out.="<li><a href='".$d['link']."'><img src='images/kampanya/".$d['resimJS']."' /></a></li> \n";
	}
	return $out;
}
function simpleTopMenu($parentID)
{
	global $siteConfig;
	$cacheName = __FUNCTION__.','.$parentID;
	$cache = cacheout($cacheName);
	if($cache) return $cache;
	$out='<ul '.($parentID?'':'id="menu"').'>';
	$q = my_mysql_query("select * from kategori where active =1 AND parentID='$parentID' order by seq,name");
	while($d = my_mysql_fetch_array($q))
	{
		$link= kategoriLink($d['ID'],$d['name']);
		$out.='<li><a href="'.$link.'">'.$d['name'].'</a> '."\n";
		if (!$parentID) 
		{
			if(hq("select ID from kategori where parentID='".$d['ID']."'"))
				$out.='<div>'.simpleTopMenu($d['ID']).'</div>';
		}
		$out.='</li>';
	}
	$out.='</ul>';
	if ($link) return cachein($cacheName,$out);	
}
function myitemOrderx() {
	global $siteConfig;
	if ($_POST['listType']) $_SESSION['listType'] = $_POST['listType'];
	$out='<table><form name="urunsirala" id="urunsirala" method="get" action="page.php">
			<input type="hidden" name="act" value="'.$_GET['act'].'">
			<input type="hidden" name="fID" value="'.$_GET['fID'].'">
			<input type="hidden" name="fVal" value="'.$_GET['fVal'].'">
			<input type="hidden" name="catID" value="'.$_GET['catID'].'"><tr>';
	switch($siteConfig['listType'])
	{
		case 0:
			$outx.='
			<td><select name="listType" id="listType">
				<option value="detay" '.($_SESSION['listType'] == 'detay'?'selected':'').'>'._lang_urunDetay.'</option>
				<option value="liste" '.($_SESSION['listType'] == 'liste'?'selected':'').'>'._lang_urunListe.'</option></select></td>';
		break;
		case 1:
			$_SESSION['listType'] = 'detay';
		break;
		case 2:
			$_SESSION['listType'] = 'liste';
		break;
	}
		
	$out.='<td style="display:none;"><select name="markaID" id="markaID"><option value="">'._lang_tumMarkalar.'</option>'.generateBrands('Option').'</select></td>
	<td><select name="orderBy" id="orderBy"><option value="tarih desc">'._lang_tariheGore.'</option><option value="fiyat asc">'._lang_fiyataGore.'</option><option value="name asc">'._lang_urunAdinaGore.'</option>><option value="sold desc">'._lang_satisaGore.'</option></select></td><td style="visibility:hidden;"><span onclick="document.urunsirala.submit();">&nbsp;</span></td></tr></form></table>';
	$out.=jselect('markaID',$_GET['markaID']);
	$out.=jselect('orderBy',$_GET['orderBy']);
	return $out;
}
//'.generateFilter('SelectList','Combo').'
function myKategoriGoster()
{
	global $siteConfig;
	if ($_GET['markaID']) setSEO(dbinfo('marka','name',$_GET['markaID']),dbinfo('kategori','metaDescription',$_GET['markaID']),dbinfo('kategori','metaKeywords',$_GET['markaID']));
	//if ($_GET['catID']) $out .= generateTableBox(currentCatName().' Kategorileri',showCategoryPictures('KategoriList'),tempConfig('formlar'));
	if ($_GET['catID']) $out .= showCategoryBanner();
	$order = ($_GET['orderBy']?$_GET['orderBy']:'urun.seq desc,urun.ID desc');
	$baslik = ($_GET['catID']?currentCatName():dbInfo('marka','name',$_GET['markaID']));
	if ($_GET['fID'] && !$_GET['catID']) $baslik = $_GET['fVal'];
	$out.='<div id="products">';
	if (!$_SESSION['listType'] || $_SESSION['listType'] == 'detay') $out .= generateTableBox(itemOrder(),showCategory($_GET['catID'],$order),'DefaultBlockKisa');
	else $out .= generateTableBox('',listCategory($_GET['catID'],$order,'UrunListLite','UrunListLiteShow'),'DefaultBlockKisa');
	$out.='</div>';
	insertToUserLog('Ziyaret','Kategori',selfURL());
	my_mysql_query('update kategori set hit = hit + 1 where ID='.$_GET['catID']);
	setStats('updateKategori');	
	return $out;
}
function tsLogin()
{
    global $login_message,$facebookConnect;
	if ($_GET['act'] == 'register')
		$login_message = false;
    if (!$_SESSION['loginStatus'])
    {
	if (file_exists('../../include/mod_FacebookConnect.php'))
		include('../../include/mod_FacebookConnect.php');
        $out.=' <form action="" class="form-login" method="post">
                    <fieldset>
						<table><tr><td>
                        <div class="text-frame"><input type="text" value="Kullanıcı Adı" name="username" class="text" /></div>
						</td><td>
                        <div class="text-frame"><input type="password" value="Şifreniz" name="password" class="text" /></div>
						</td><td>
                        <input type="submit" class="submit" />
						</td><td class="facebookTD">
						'.$facebookConnect.'
						</td></tr></table>
                        '.($login_message?'<script>alert(\''.strip_tags($login_message).'\')</script>':'').'
                    </fieldset>                
                    <div class="login-menu">
                            <a href="'.($siteConfig['seoURL'] ? 'register_sp.html':'page.php?act=register').'" class="newMember">Yeni Üye Kaydı</a> | 
                            <a href="'.($siteConfig['seoURL'] ? 'forgotPassword_sp.html':'page.php?act=forgotPassword').'" class="lostPw">Şifremi Unuttum</a>
                    </div>
                </form>';
		        
    }
    else 
    {            
        $out.='
            <div class="form-login">
                <div class="login-menu">
                    Merhaba, <a href="'.slink('profile').'">'.$_SESSION['name'].' '.$_SESSION['lastname'].'</a>	
                    				
                </div>
                <div class="login-menu"> 
					<a href="'.slink('login').'">Kullanıcı İşlemlerim</a> | 
                    <a href="'.slink('showOrders').'">Siparişlerim</a> | 					
                    <a href="'.($siteConfig['seoURL'] ? 'havaleBildirim_sp__status-1.html':'page.php?act=havaleBildirim&status=1').'">Havale Bildirimi</a> | 
                    <a href="'.($siteConfig['seoURL'] ? 'hataBildirim_sp__status-51|81.html':'page.php?act=hataBildirim&status=51|81').'">Hata Bildirimi</a> | 
                    <a href="'.slink('alarmList').'">Alarm Listem</a> |
                    <a href="'.slink('logout').'">Çıkış</a>
                </div>
            </div>';
    }
    return $out;
}
?>