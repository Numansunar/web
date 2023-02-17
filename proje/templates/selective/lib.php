<?php
$siteConfig['listType'] = 1;
function myurunDetay()
{
			if (!hq("select ID from urun where ID='".$_GET['urunID']."'"))
				exit("<script>window.location.href ='index.php';</script>");
			if ($siteTipi == 'TEKURUN' || $siteTipi == 'GRUPSATIS')
			{
				header('location:index.php?urunID='.$_GET['urunID']);
				exit();
			}
			$out = showItem($_GET['urunID']);
			$out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler,caprazPromosyonSecimList(),'FullBlock');
			$out .= generateTableBox(_lang_ilgiliUrunler,ilgiliUrunList(),'FullBlock');	
			$out .= paketIndirim($_GET['urunID'],'UrunListLite','UrunListLiteShow','FullBlock');
			return $out;
}

function proImg()
{
	$q = my_mysql_query("select * from urun where ID='".$_GET['urunID']."' limit 0,1");
	$d = my_mysql_fetch_array($q);
	$out.='
						<div class="proImg">
						<div class="viewport">
							<ul class="overview">';
	for($i=1;$i<=5;$i++)
	{
		$field = 'resim'.($i>1?$i:'');
		if($d[$field])
		{
			$out.='<li><center><a href="images/urunler/'.$d[$field].'" class="lightbox nozoom"><img class="main-image" src="include/resize.php?path=images/urunler/'.$d[$field].'&amp;width=600" alt="" /></a></center></li>';
		}
	}

	$out.='							</ul>
						</div><ul class="pager">';		
						
	for($i=1;$i<=5;$i++)
	{
		$field = 'resim'.($i>1?$i:'');
		if($d[$field])
		{
			$out.='<li><a rel="'.($i-1).'" class="pagenum" href="#"><img src="include/resize.php?path=images/urunler/'.$d[$field].'&amp;width=200" style="max-width:70px;"  alt="" /></a></li>';
		}
	}						
	$out.='</ul>
			</div><!-- /.proImg -->	';
					
	return $out;
}

function tpBlueMenu($parentID)
{
	$cacheName= md5(__FUNCTION__.$parentID);
	$cache = cacheout($cacheName);
	if ($cache) return $cache;
	
	global $siteConfig;
	$out='<ul>';
	$q = my_mysql_query("select * from kategori where active =1 AND parentID='$parentID' order by seq,name");
	if(!my_mysql_num_rows($q)) return;
	while($d = my_mysql_fetch_array($q))
	{
		$link= ($siteConfig['seoURL'] ? seoFix($d['name']).'-kat'.$d['ID'].'.html':'page.php?act=kategoriGoster&catID='.$d['ID'].'&name='.seoFix($d['name']));
		$out.='<li><a id="a'.$d['ID'].'" href="'.$link.'">'.$d['name'].'</a>'."\n";
		if (hq("select name from kategori where parentID='".$d['ID']."'"))
		{
			$q2 = my_mysql_query("select * from kategori where active = 1 AND parentID='".$d['ID']."' order by seq,name");
			if (my_mysql_num_rows($q2))
			{
				$out.='<ul id="ul'.$d['ID'].'">'."\n";
				while ($d2 = my_mysql_fetch_array($q2))
				{
					$linkSub= kategoriLink($d2['ID'],$d2['name']);
					$out.='<li><a id="a'.$d2['ID'].'"  href="'.$linkSub.'">'.$d2['name'].'</a></li>'."\n";
				}
				$out.='</ul>'."\n";
			}
		}
		$out.='</li>';
	}
	$out.='</ul>';
	return cachein($cacheName,$out);	
}

function opSlide()
{
	$out.='<div id="slider"><div class="viewport">
							<ul class="overview">';
	$q = my_mysql_query("select * from kampanyaBanner order by seq");
	while($d = my_mysql_fetch_array($q))
	{
		$out.='<li><a href="'.$d['link'].'"><img alt="" src="images/kampanya/'.$d['resim'].'" style="width:566px; height:272px;" /></a></li>'."\n";
	}
	$out.='</ul></div><ul class="pager">';
	$q = my_mysql_query("select * from kampanyaBanner order by seq");
	$i = 0;
	while($d = my_mysql_fetch_array($q))
	{
		$out.='<li><a rel="'.$i.'" class="pagenum" href="'.$d['link'].'"><img alt="" src="images/kampanya/'.($d['thumb']?$d['thumb']:$d['resim']).'" /></a><span></span></li>'."\n";
		$i++;
	}
	$out.='</ul></div>';
	return $out;
}

function opSlideDemo()
{
	$out.='					<div id="slider">

						<div class="viewport">
							<ul class="overview">
								<li><a href="#"><img src="templates/selective/sample/6.jpg" /></a></li>
								<li><a href="#"><img src="templates/selective/sample/5.jpg" /></a></li>
								<li><a href="#"><img src="templates/selective/sample/6.jpg" /></a></li>
							</ul>
						</div>
					    <ul class="pager">
					        <li><a rel="0" class="pagenum" href="#"><img src="templates/selective/sample/8.jpg" alt="" /></a><span></span></li>
					        <li><a rel="1" class="pagenum" href="#"><img src="templates/selective/sample/7.jpg" alt="" /></a><span></span></li>
					        <li><a rel="2" class="pagenum" href="#"><img src="templates/selective/sample/8.jpg" alt="" /></a><span></span></li>
					    </ul>

					</div><!-- /#slider -->	';
	return $out;
}
?>