<?php 

function ucretsiz_kargo($d)
{
	$out='';
	if($d['ucretsizKargo'] == 1)
		$out = '<img src="templates/orion/images/detay_kargo_bedava.png" alt="Ücretsiz Kargo" title="Ücretsiz Kargo">';
    return $out;
}

function hizli_kargo($d)
{
	$out='';
	if($d['anindaGonderim'] == 1)
		$out = '<img src="templates/orion/images/detay_hizli_kargo.png" alt="hızlı kargo" title="hızlı kargo">';
    return $out;
}

function urunDuzenleAdmin($d) {
	if($_SESSION['admin_isAdmin']){
		$out.='<div class="clearfix"></div><div class="adminTools"><a class="btn btn-small btn-success btn-adminx" target="_blank" href="../secure/s.php?f=urun.php&y=d&ID='.$d['ID'].'">Düzenle</a>';
		$out.='<span class="btn btn-small btn-info btn-adminx">Stok :<strong class="pink-color"> '.$d['stok'].'</strong></span>';		
		$out.='</div><div class="clearfix"></div>';
		return $out;
		}
}

function adetBirim($d) {
	$out = $d['urunBirim'];
	return $out;
}

function minSiparisInfo($d) {
	$out.="";
	if ($d['minSiparis'] > 1){
		$out = '<p class="alert alert-info"><strong>Bilgi :</strong> Bu ürünümüzden minimum <b> '.$d['minSiparis']." ".$d['urunBirim'].'</b> sipariş verebilirsiniz.</p>';
	}
	return $out;
}

function mobileProductSlider($d)
{
	$out = '';
	if(isReallyMobile()) {
		for($i=1;$i<=7;$i++)
		{
			$str = ($i?'resim'.$i:'resim');
			if (!$d[$str]) continue;
				$resimx = '';
			if ($d[$str])
				 $fotob = "include/resize.php?path=images/urunler/" . $d[$str] . "";
            	 $fotok = "resizer/700x700/2/images/urunler/" . $d[$str] . "";
				$resimx='<div class="item"><a href="'.$fotob.'" class="lightbox"><img class="owl-lazy" src="templates/orion/images/placeholder.jpg" data-src="'.$fotok.'" alt="'.$d['name'].'"/></a></div>';
			$out.= $resimx;
		}
	return $out;
	}
}

function desktopProductImg($d)
{
	$out = '';
	if(!isReallyMobile()) {
			$out.= '<img class="img lozad" src="templates/orion/images/placeholder.jpg" data-src="include/resize.php?path=images/urunler/'.$d['resim'].'"/>';
		}
	return $out;
}

function mainSlider($demo=0)
{
	$out = '';
	if($demo == 0) {
		$q = my_mysql_query("select * from kampanyaJSBanner order by seq asc");
		while ($d=my_mysql_fetch_array($q))
		{
			$out.='<a href="'.$d['link'].'"><img class="owl-lazy" alt="'.$d['title'].'" src="templates/orion/images/placeholder-slider.jpg" data-src="images/kampanya/'.$d['resimJS'].'"/></a>'."\n";
		}
	} else {

		$out.='<a href="#"><img class="owl-lazy" alt="demo" src="templates/orion/images/placeholder-slider.jpg" data-src="templates/orion/images/demo/slider02.jpg"/></a><a href="#"><img class="owl-lazy" alt="demo" src="templates/orion/images/placeholder-slider.jpg" data-src="templates/orion/images/demo/slider01.jpg"/></a><a href="#"><img class="owl-lazy" alt="demo" src="templates/orion/images/placeholder-slider.jpg" data-src="templates/orion/images/demo/slider03.jpg"/></a>';
	}

	return $out;
}

function kargobeles($d) {
	$out='';
	if($d['ucretsizKargo']==1)
		$out.='<span class="ribbon-freeCargo hidden">ÜCRETSİZ KARGO</span>';
	return $out;
}
function urunStockStatus($d) {
	$out='';
	if($d['stok'] <= 0 ) {
	   $out.='<div class="alert alert-danger">Ürün geçici olarak temin edilememektedir.</div>';
	   $out.='<style type="text/css">.durumlar,.form-action,.kargosayac {display:none!important;}</style>';
	} else {
		 $out.='<div class="stock-amount">Bu ürün stoklarımızda mevcuttur.</div>';
	}
	return $out;
} 
function tukendim($d) {
	$out='';
	if(($d['stok'])<=0)
		$out.='<span class="ribbon-stockOut">TÜKENDİ</span>';
	return $out;
}
function tukendimBadge($d) {
	$out='';
	if(($d['stok'])<=0)
	$out.='<span class="tukendimBadge">TÜKENDİ</span>';
	return $out;
}
function indirimde($d) {
	$out='';
	if($d['indirimde']==1)
		$out.='<span class="ribbon-sale hidden">İNDİRİM</span>';
	return $out;
}
function yeniUrun($d) {
	$out='';
	if($d['yeni']==1)
		$out.='<span class="ribbon-new hidden-xs">YENİ</span>';
	return $out;
}
function anindaGonderim($d) {
	$out='';
	if($d['anindaGonderim']==1)
		$out.='<span class="ribbon-fastCargo hidden-xs">AYNI GÜN KARGO</span>';
	return $out;
}
function populerCats($parentID,$limit) 
{
   global $siteConfig,$langPrefix; 
    $cacheName= __FUNCTION__.$parentID.$limit; 
    $cache = cacheout($cacheName); 
    if ($cache) 
        return $cache; 
    $out='';
    $q = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active =1 AND parentID='$parentID' order by seq,name limit 0,$limit"); 
    while($d = my_mysql_fetch_array($q)) 
    { 
    	
        $d = translateArr($d); 
        $link= kategoriLink($d); 
        if(catCheck($d['ID'])) 
        {
            $out.='<li><a href="'.$link.'">'.$d['name'].'</a></li>'."\n"; 
        } 
    }
    return cachein($cacheName,$out);
}

function orionAllCats($parentID,$limit) 
{
    global $siteConfig,$langPrefix; 
    $cacheName= __FUNCTION__.$parentID.$limit; 
    $cache = cacheout($cacheName); 
    if ($cache) 
        return $cache; 
    $out='';
    $q = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active =1 AND parentID='$parentID' order by seq,name limit 0,$limit"); 
    while($d = my_mysql_fetch_array($q)) 
    { 
    	
        $d = translateArr($d); 
        $link= kategoriLink($d); 
        if(catCheck($d['ID'])) 
        {
            $out.='<li><a href="'.$link.'"><i class="fa fa-chevron-right"></i> '.$d['name'].'</a></li>';
        }
    }
    return cachein($cacheName,$out);
}

function ust_kategori_varmi($parentID){
	$say= my_mysql_num_rows(my_mysql_query("select * from kategori where active=1 and parentID=$parentID order by seq asc"));
	return $say;
}

function orionTopMenu($parentID,$limit) 
{
    global $siteConfig,$langPrefix; 
    $cacheName= __FUNCTION__.$parentID.$limit;
    $title_name = ($langPrefix == '_tr') ? 'name' : 'name' . $langPrefix;
    $cache = cacheout($cacheName); 
    if ($cache) 
        return $cache; 
    $out = '';
    $qx = my_mysql_query("select ID,name$langPrefix,seo,resim,namePath from kategori where active =1 AND parentID='$parentID' order by seq,name limit 0,$limit"); 
    while($d = my_mysql_fetch_array($qx)) 
    {
		
        $d = translateArr($d); 
        $link= kategoriLink($d); 
        if(catCheck($d['ID'])) 
        {    
			if (hq("select name from kategori where active = 1 AND parentID='".$d['ID']."'")) {
				$out.='<li class="'.$d['seo'].' dropdown"><a href="'.$link.'" id="a'.$d['ID'].'" class="dropdown-toggle">'.$d[$title_name].'</a>'."\n"; 
			} else {
				$out.='<li class="'.$d['seo'].'"><a href="'.$link.'">'.$d[$title_name].'</a>'."\n";
			}
			
            {
                $q2 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d['ID']."' order by seq"); 
                if (my_mysql_num_rows($q2)) 
                { 
                    $out.='<ul class="dropdown-menu">'."\n"; 
                    $out.='<div class="row">'."\n"; 
                    $out.='<div class="col-md-2 catLanding"><a href="./ac/yeni">Yeni Gelenler</a><a href="./ac/indirimde">İndirimdekiler</a><a href="./ac/cokSatanlar">Çok Satanlar</a>
                    </div>'."\n"; 
                    $out.='<div class="col-md-7 menucol">'."\n"; 
					 while ($d2 = my_mysql_fetch_array($q2)) 
                    { 
                        $d2 = translateArr($d2);
						$parentID = $d2["ID"];
						$ustCategory = ust_kategori_varmi($parentID);
                        $linkSub= kategoriLink($d2); 
                        if(catCheck($d2['ID'])) 
                        {
                            if (hq("select name from kategori where active = 1 AND parentID='".$d2['ID']."'")) 
                            {
								$out.='<li class="'.($ustCategory>0 ? 'first' : '').'"><a href="'.$linkSub.'"><i class="fa fa-caret-right"></i> '.$d2[$title_name].'</a>'."\n";
								
                                $q3 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d2['ID']."' order by seq,name"); 
                                if (my_mysql_num_rows($q3)) 
                                {
                                    $out.='<ul>'."\n"; 
                                    while ($d3 = my_mysql_fetch_array($q3)) 
                                    { 
                                        $d3= translateArr($d3); 
                                        $link2Sub= kategoriLink($d3); 
                                        if(catCheck($d3['ID'])) 
                                        {
											$out.='<li><a href="'.$link2Sub.'">'.$d3[$title_name].'</a>'."\n"; 
                                        }
                                    }
                                    $out.='</ul>'."\n"; 
                                    
                                }
                              $out.='</li>';
                            } else {
								
								 $out.='<li class="'.($ustCategory>0 ? 'first' : '').'"><a href="'.$linkSub.'"><i class="fa fa-caret-right"></i> '.$d2[$title_name].'</a></li>'."\n";
							}
                        }
                    }
                    $out.='</div>'; 
                    if($d['resim']) {
						$out.='<div class="catimg col-sm-3"><a href="'.$link.'"><img class="img-responsive" src="images/kategoriler/'.$d['resim'].'" alt="'.$d[$title_name].'"></a></div>'."\n"; 
						} else {
						$out.='<div class="catimg col-sm-3"><a href="'.$link.'"><img class="img-responsive" alt="kategori resmi eklenmemiş" src="//dummyimage.com/300x300/eeeeee/333333"></a></div>'."\n"; 
					}
                    $out.='<div class="clearfix"></div>'; 
                    $out.='</div></ul>'; 
                }
            }
			
            $out.='</li>'; 
        } 
    } 
    return cachein($cacheName,$out);
}

function orionMobileMenu($parentID,$limit) 
{
    global $siteConfig,$langPrefix; 
    $cacheName= __FUNCTION__.$parentID.$limit; 
    $title_name = ($langPrefix == '_tr') ? 'name' : 'name' . $langPrefix;
    $cache = cacheout($cacheName); 
    if ($cache) 
        return $cache;
    $out='';
    $q = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active =1 AND parentID='$parentID' order by seq,name limit 0,$limit"); 
    while($d = my_mysql_fetch_array($q)) 
    { 
        $d = translateArr($d); 
        $link= kategoriLink($d); 
        if(catCheck($d['ID'])) 
        {    

            if (hq("select name from kategori where active = 1 AND parentID='".$d['ID']."'")) 
            {
            	$out.='<li><span>'.$d[$title_name].'</span>'."\n";

                $q2 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d['ID']."' order by seq"); 
                if (my_mysql_num_rows($q2)) 
                {
					 $out.='<ul>'."\n";
                    while ($d2 = my_mysql_fetch_array($q2)) 
                    {
                        $d2 = translateArr($d2); 
                        $linkSub= kategoriLink($d2); 
                        if(catCheck($d2['ID'])) 
                        { 
                            if (hq("select name from kategori where active = 1 AND parentID='".$d2['ID']."'")) 
                            {
								$out.='<li><span>'.$d2[$title_name].'</span>'."\n";
								
                                $q3 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d2['ID']."' order by seq,name"); 
                                if (my_mysql_num_rows($q3)) 
                                {
                                    $out.='<ul>'."\n"; 
                                    while ($d3 = my_mysql_fetch_array($q3)) 
                                    { 
                                        $d3= translateArr($d3); 
                                        $link2Sub= kategoriLink($d3); 
                                        if(catCheck($d3['ID'])) 
                                        {
                                        	 if (hq("select name from kategori where active = 1 AND parentID='".$d3['ID']."'")) 
					                            {
													$out.='<li><span>'.$d3[$title_name].'</span>'."\n";
													
					                                $q4 = my_mysql_query("select ID,name$langPrefix,seo,namePath from kategori where active = 1 AND parentID='".$d3['ID']."' order by seq,name"); 
					                                if (my_mysql_num_rows($q4)) 
					                                {
					                                    $out.='<ul>'."\n"; 
					                                    while ($d4 = my_mysql_fetch_array($q4)) 
					                                    { 
					                                        $d4= translateArr($d4); 
					                                        $link3Sub= kategoriLink($d4); 
					                                        if(catCheck($d4['ID'])) 
					                                            $out.='<li><a id="a'.$d4['ID'].'"  href="'.$link3Sub.'">'.$d4[$title_name].'</a></li>'."\n"; 
					                                    }

					                                 	$out.='<li class="item"><a href="'.$link2Sub.'" class="parent"><i class="fa fa-chevron-right"></i> Tümünü Göster</a>'."\n";

					                                    $out.='</ul>'."\n"; 
					                                    
					                                }
					                              $out.='</li>';
					                            } else {
													
													$out.='<li><a href="'.$link2Sub.'">'.$d3[$title_name].'</a>'."\n"; 
												}
                                        }
                                    }

                                 	$out.='<li class="item"><a href="'.$linkSub.'" class="parent"><i class="fa fa-chevron-right"></i> Tümünü Göster</a>'."\n";

                                    $out.='</ul>'."\n"; 
                                    
                                }
                              $out.='</li>';
                            } else {
								
								$out.='<li><a href="'.$linkSub.'">'.$d2[$title_name].'</a>'."\n"; 
							}                            
                        }
                    }
                    $out.='<li class="item"><a href="'.$link.'" id="a'.$d['ID'].'" class="parent"><i class="fa fa-chevron-right"></i> Tümünü Göster</a>'."\n";
                    $out.='</ul>'."\n"; 
                }
            	$out.='</li>';
            } else {
	        	$out.='<li class="item"><a href="'.$link.'" id="a'.$d['ID'].'" class="parent">'.$d[$title_name].'</a></li>'."\n"; 
	   		 }
	    }
	}
return cachein($cacheName,$out);
}

function urunResim2($d) {
	$out = '';
	if(!isReallyMobile()) {
		$resim1 = $d['resim'];
		$resim2 = $d['resim2'];
		if($resim2) {
			$out.= '<img class="lozad image2" src="templates/orion/images/placeholder.jpg" data-src="resizer/400x400/2/images/urunler/'.$resim2.'">';
		} else {
			$out.= '<img class="lozad image2" src="templates/orion/images/placeholder.jpg" data-src="resizer/400x400/2/images/urunler/'.$resim1.'">';
		}
	}
	return $out;
}

function piyasafiyatList($d) {
	if(fixFiyat($d['piyasafiyat']) > fixFiyat($d['fiyat'])) {
	$out.='<span class="price old-price">'.fixFiyat($d['piyasafiyat']).' TL</span>';
	return $out;
	}
}
function piyasafiyatDetay($d) {
	if(fixFiyat($d['piyasafiyat']) > fixFiyat($d['fiyat'])) {
	$out.='<span class="old-price">'.fixFiyat($d['piyasafiyat']).' TL</span>';
	return $out;
	}
}
function mykategoriGoster()
{
	//$out .= autoModLoad('Slider');
	//$defaultOrderBy = 'urun.stok = 0,urun.seq desc,urun.ID desc';
	$defaultOrderBy = "if(urun.resim = '' or urun.resim is null,1,0),if(urun.stok = 0,1,0),urun.seq desc,urun.ID desc";

	//$out .= generateTableBox(breadCrumb(),itemOrder(),tempConfig('formlar'));
	//$out .= generateTableBox(currentCatName() . ' Kategorileri', showCategoryPictures('KategoriList'), tempConfig('formlar'));
	if(showCategoryBanner('body' . $langPrefix)){
		$out .= '<div class="categoryTextWrap"><div class="categoryText">'.showCategoryBanner('body' . $langPrefix).'</div></div>';
	}

	if ($_GET['catID'])
	//$out .= generateTableBox(_lang_titleSikcaSorularnSorular, sss(), tempConfig('bilgi_sayfalari'));
	if (function_exists('getOrderBy'))
		$order = getOrderBy();
	else
		$order = ($_GET['orderBy'] ? $_GET['orderBy'] : $defaultOrderBy);
	//$baslik = ($_GET['catID'] ? breadCrumb() : dbInfo('marka', 'name', $_GET['markaID']));
	$baslik = ($_GET['catID'] ? currentCatName() : dbInfo('marka', 'name', $_GET['markaID']));
	if ($_GET['fID'] && !$_GET['catID']) $baslik = $_GET['fVal'];
	if (!$_SESSION['listType'] || $_SESSION['listType'] == 'detay') $out .= generateTableBox($baslik . '', itemOrder() . showCategory($_GET['catID'], $order), tempConfig('urunliste'));
	else $out .= generateTableBox($baslik . ' Ürünleri', itemOrder() . listCategory($_GET['catID'], $order, 'UrunListLite', 'UrunListLiteShow'), tempConfig('urunliste'));
	
	if(showCategoryBanner('footer' . $langPrefix)){
		$out .= '<div class="categoryTextWrap"><div class="categoryText">'.showCategoryBanner('footer' . $langPrefix).'</div></div>';
	}

	my_mysql_query('update kategori set hit = hit + 1 where ID=\'' . $_GET['catID'] . '\' limit 1');
	setStats('updateKategori');
	return $out;
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
	$out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler, caprazPromosyonUrunList(), tempConfig('kasaonu'));
	$out .= paketIndirim($_GET['urunID'],'UrunListLite','UrunListLiteShow',tempConfig('kasaonu'));
	$out .= generateTableBox('Bu Ürünler de İlginizi Çekebilir',ilgiliUrunList('UrunList','UrunListBenzer'),'UrunDetayInnerBlock');	
	return $out;	 
}

function piyasafiyatx($d) {
	$out='';
	if(fixFiyat($d['piyasafiyat']) > fixFiyat($d['fiyat'])) {
	$out.='<span class="prdct-price-old">'.fixFiyat($d['piyasafiyat']).' TL</span>';
	return $out;
	}
}
function markaID($d) {
	$out='';
	if($d['markaID'])
		$out.= $d['markaID'];
	return $out;
}
function indirimOranList($d) {
	$out='';
	if(fixFiyat($d['piyasafiyat']) > fixFiyat($d['fiyat'])) {
	$oranx = (($d['fiyat'] / $d['piyasafiyat']) * 100);
	$yuzdem = round(100 - $oranx);
	$out.='<div class="discount-badge"><small>%</small><span>'.$yuzdem.'</span></div>';
	return $out;
	}
}
function indirimOran($d) {
	$out='';
	if(fixFiyat($d['piyasafiyat']) > fixFiyat($d['fiyat'])) {
	$oranx = (($d['fiyat'] / $d['piyasafiyat']) * 100);
	$yuzdem = round(100 - $oranx);
	$out.='<div class="discount">% '.$yuzdem.'<p>İNDİRİM</p></div>';
	return $out;
	}
}
function urunKod($d) {
	$out='';
	if($d['tedarikciCode']) {
		$out.= $d['tedarikciCode'];
	} else {
		$out.= '#000'.$d['ID'];
	}
	return $out;
}

function myBreadCrumb() 
{
	return seoBreadCrumb();
}

function mySeoBreadCrumb()
{
	$cacheName= __FUNCTION__.currentCat().'_'.urun('ID');		
	$cache = cacheout($cacheName);		
	if ($cache)		
		return $cache;		
	global $siteConfigi,$langPrefix;		
	$breadCrumb = getBreadCrumb();		
	for ($i=0;$i<sizeof($breadCrumb);$i++)				
		$breadCrumb[$i] = '
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" class="BreadCrumb" href="'.(kategoriLink((int)$breadCrumb[$i])).'">
	<span itemprop="name">'.hq("select name$langPrefix from kategori where ID='".$breadCrumb[$i]."' limit 0,1").'</span>
	</a>		
	<meta itemprop="position" content="'.($i+1).'" /></li>';			
	if ($_GET['urunID']){				
		$name = urun('name');				
		$breadCrumb[] = '<li><a class="BreadCrumb" 	href="'.urunlink((int)$_GET['urunID'],$name,($name)).'">'.$name.'</a></li>';
	}
	$out = implode(" ", $breadCrumb);			
	return '<ul class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'.cachein($cacheName,$out).'</ul>';
}

?>