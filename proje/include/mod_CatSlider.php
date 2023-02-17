<?php
/*
if($_GET['act'] == 'kategoriGoster')
{
	require_once('include/mod_CatSlider.php');
	$actHeaderArray['kategoriGoster'] = modCatSlider('400');
}
 */

function simpleCatSlider($tag = 'li', $tagAttr = '', $imgAttr = '')
{
	$q = my_mysql_query("select * from sliderkategori where catIDs = '" . $_GET['catID'] . "' OR catIDs like '%," . $_GET['catID'] . ",%' OR catIDs like '%," . $_GET['catID'] . "' OR catIDs like '" . $_GET['catID'] . ",%' order by seq limit 0,4");
	if (!my_mysql_num_rows($q)) return;
	$i = 0;
	while ($d = my_mysql_fetch_array($q)) {
		$li .= '<' . $tag . ' ' . $tagAttr . '>
				<a href="' . $d['link'] . '"><img ' . $imgAttr . '  src="images/kampanya/' . $d['resim'] . '"  alt=""></a>
			</' . $tag . '>' . "\n";
		$i++;
	}
	return $li;
}

function modCatSlider()
{
	global $jsLoad, $globalFilter;

	if ($_GET['catID'] && hq("select ID from sliderkategori where catIDs = '" . $_GET['catID'] . "' OR catIDs like '%," . $_GET['catID'] . ",%' OR catIDs like '%," . $_GET['catID'] . "' OR catIDs like '" . $_GET['catID'] . ",%' limit 0,1")) {
		$q = my_mysql_query("select * from sliderkategori where catIDs = '" . $_GET['catID'] . "' OR catIDs like '%," . $_GET['catID'] . ",%' OR catIDs like '%," . $_GET['catID'] . "' OR catIDs like '" . $_GET['catID'] . ",%' order by seq limit 0,4");
		if (!my_mysql_num_rows($q)) return;
		$i = 0;
		while ($d = my_mysql_fetch_array($q)) {
			$li .= '<li>
				<a href="' . $d['link'] . '"><img src="images/kampanya/' . $d['resim'] . '"  alt=""></a>
			</li>' . "\n";
			$cat_pager .= '<li>
					<a rel="' . $i . '" href="javascript:;" class="pagenum">
					  <img src="images/kampanya/' . $d['resim'] . '" alt="" />			  
					</a>
				  </li>';
			$i++;
		}
	} else {
		if ($globalFilter)
			$globalFilterString = '(' . $globalFilter . ') AND ';

		$q = ($_GET['act'] == 'sepet' ?
			my_mysql_query("select urun.* from urun,kategori where urun.ID NOT IN(select urunID from sepet where adet > 0 AND randStr = '" . $_SESSION['randStr'] . "') AND urun.catID = kategori.ID AND urun.stok > 0 AND urun.kasa=1 AND urun.active = 1 AND kategori.active = 1 order by rand() limit 0,4") :
			my_mysql_query("select urun.* from urun,kategori where $globalFilterString urun.catID=kategori.ID AND (kategori.idPath like '" . currentCatPatern() . "' OR kategori.idPath like '" . currentCatPatern() . "/%') AND piyasafiyat != '' AND indirimde=1 AND urun.active = 1 AND kategori.active = 1 order by rand() limit 0,4"));
		if (!my_mysql_num_rows($q)) return;
		$i = 0;
		while ($d = my_mysql_fetch_array($q)) {
			$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
			if (!$_SESSION['cache_setfiyatBirim']) {
				$piyasaFiyat = $d['piyasafiyat'];
				$fiyatBirim = fiyatBirim($d['fiyatBirim']);
				$fiyat = $d['fiyat'];
			} else {
				$fiyatBirim = fiyatBirim($_SESSION['cache_setfiyatBirim']);
				$piyasaFiyat = fiyatCevir($d['piyasafiyat'], $d['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
				$fiyat = fiyatCevir($d['fiyat'], $d['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
			}


			$fiyatBirim = fiyatBirim('TL');
			$piyasaFiyat = fiyatCevir($d['piyasafiyat'], $d['fiyatBirim'], 'TL');
			$fiyat = fiyatCevir($d['fiyat'], $d['fiyatBirim'], 'TL');


			$resim = ($d['resimvitrin'] ? $d['resimvitrin'] : 'include/resize.php?path=images/urunler/' . $d['resim'] . '&width=400');
			$li .= '<li>
			<div class="sldimg"><center><a href="' . urunLink($d) . '"><img src="' . $resim . '"></a></center></div>
			<div class="sldinfo"><strong>' . $d['name'] . '</strong> <span class="cat-slider-fiyat"><span>' . ($piyasaFiyat?my_money_format('', $piyasaFiyat) . ' ' . $fiyatBirim:'') . '</span> ' . my_money_format('', $fiyat) . ' ' . $fiyatBirim . '</span></div>
			<div class="gitbtn"><a href="' . urunLink($d) . '">' . _lang_urunIncele . '</a></div>
			</li>' . "\n";
			$cat_pager .= '<li>
					<a rel="' . $i . '" href="javascript:;" class="pagenum">
					  <img src="include/resize.php?path=images/urunler/' . $d['resim'] . '&width=400" alt="' . $d['name'] . '" alt="" />
					  
					</a>
				  </li>';
			$i++;
		}
	}
	$out .= '
	<div class="catSlider">
            <div class="viewport">
              <ul class="overview">
                ' . $li . '
              </ul>
            </div><!-- /.viewport -->
            <ul class="cat_pager">
              ' . $cat_pager . '
            </ul>
          </div>';

	$out .= '<style>
	.sldimg{float:left; width:300px;}
	.gitbtn{padding:9px 18px; border:1px solid #ebebeb; position:absolute; bottom:40px; margin-left:340px; font-size:15px; background:#f4f4f4;}
	.sldinfo{float:left; text-align:left; position:absolute; margin-top:50px; margin-left:340px; font-size:15px;}
	.sldinfo strong { height:70px; overflow:hidden; display:block; }
	    .catSlider {position: relative; width: 100%; height: 260px; border: 1px solid #f2f2f2; background-color:#fff; margin-bottom:18px; }
      .catSlider .viewport { float: left; width:600px; height: 260px; overflow: hidden; position: relative;}
        .catSlider .overview { list-style: none; position: absolute; padding: 0; margin: 0; left: 0; top: 0; }
          .catSlider .overview li { float: left; width:600px; height: 260px; position: relative;}
            .catSlider .overview li img {max-width: 100%; max-height: 260px;}
      .catSlider .cat_pager {position: absolute; top: 0; right: 0; width: 68px;height: 260px; font-size:14px; line-height:10px; margin:0px; box-sizing:content-box; }
        .catSlider .cat_pager li {float: left; width: 68px; height: 64px;margin-bottom: 1px; position: relative; box-}
          .catSlider .cat_pager li a {display: block; width: 55px; padding: 10px 8px; height: 44px; background: #f2f2f2; position: absolute; right: 0; line-height: 1.4; text-align: right; border-radius:0; border:none;}
            .catSlider .cat_pager li a img {float: left; margin-top: -5px;}
          .catSlider .cat_pager li a.active {padding: 10px 8px 10px 40px; background: url("images/active.png") right center no-repeat;}
			.catSlider .pagenum img { width:40px; padding:5px; border:1px solid #ccc; border-radius:5px; background-color:#fff; }
			.catSlider a { color:#555; }
			.cat-slider-fiyat { font-size:22px !important; font-weight:bold; color:red; display:block; margin-top:20px; }
			.cat-slider-fiyat span { color:grey; text-decoration:line-through; font-weight:normal; font-size:19px; padding-top:5px; }
			
			@media (max-width: 800px) {
			 .catSlider { display:none;}	
			}
	</style>';
	if (!$jsLoad['tinycarousel'])
		$out .= "<script type='text/javascript' src='js/jquery.tinycarousel.js'></script>";
	$out .= "<script type='text/javascript'>$('.catSlider').tinycarousel({interval: true, duration: 1500, cat_pager: true, intervaltime: 6000});</script>";
	return $out;
}
?>