<?php

function tpLogin()

{

	global $login_message,$siteConfig;

	if (!$_SESSION['loginStatus'])

	{ 

		$out.=' <div id="hello">

                	Merhaba, <strong>Ziyaretçi</strong>

                    <a href="page.php?act=login">giriş yapın</a> veya <a href="page.php?act=register">kayıt olun</a>

                </div>';

	}

	else 

	{

		$classArray=array('newMember','lostPw','loginSubmit');

		$userMenuArray = userMenuList();

		$i=1;

		if ($siteConfig['puanAktif']) $puan = '('.userPuan($_SESSION['userID'],'biriken',0).' '._lang_puan.')';

		$out.=' <div id="hello">

			Merhaba, <a href="page.php?act=login"><strong>'.$_SESSION['name'].' '.$_SESSION['lastname'].'</strong> '.$puan.'</a>

								

		</div>';



	}

	return $out;

}



function tpBlueMarkalar() 

{

	$out='<ul>'."\n";

	$q = my_mysql_query("select marka.*,kategori.ID as catID from urun,marka,kategori where marka.resim != '' AND urun.catID=kategori.ID AND markaID=marka.ID group by markaID order by marka.name") or die(mysql_error());

	while ($d = my_mysql_fetch_array($q)) {

		$kategoriLink = ($siteConfig['seoURL'] ? seoFix(dbinfo('kategori','name',$d['catID'])).'_'.seoFix(dbinfo('marka','name',$d['ID'])).'-kat'.$catstring.'-marka'.$d['ID'].'.html':'page.php?act=kategoriGoster&catID='.$catstring.'&markaID='.$d['ID'].'&name='.seoFix(dbinfo('kategori','name',$d['catID'])).'-'.seoFix(dbinfo('marka','name',$d['ID'])));

		$out.='<li><a href="'.$kategoriLink.'"><img src="include/resize.php?path=images/markalar/'.$d['resim'].'&width=72" alt="'.$d['name'].'"></a></li>'."\n";

	}

	$out.='</ul>'."\n";

	return $out;

}



function tpBlueSepetStr()

{

	return 'Sepetinizde <span id="toplamUrun">'.(int)basketInfo('toplamUrun','').'</span> ürün var';

}



function tpVitrinDemo()

{

	return '        <ul>

                            <li>

                            	<a href="#1"><img src="templates/tpblue/samples/13.jpg" /></a>

                    			<div class="slideNav">

                                	<strong>27.12.2010</strong>

                                    <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>

                                </div>

                            </li>

                            <li>

                            	<a href="#1"><img src="templates/tpblue/samples/14.jpg" /></a>

                    			<div class="slideNav">

                                	<strong>27.12.2010</strong>

                                    <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>

                                </div>

                            </li>

                            <li>

                            	<a href="#1"><img src="templates/tpblue/samples/13.jpg" /></a>

                    			<div class="slideNav">

                                	<strong>27.12.2010</strong>

                                    <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>

                                </div>

                            </li>

                            <li>

                            	<a href="#1"><img src="templates/tpblue/samples/14.jpg" /></a>

                    			<div class="slideNav">

                                	<strong>27.12.2010</strong>

                                    <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>

                                </div>

                            </li>

                            <li>

                            	<a href="#1"><img src="templates/tpblue/samples/13.jpg" /></a>

                    			<div class="slideNav">

                                	<strong>27.12.2010</strong>

                                    <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>

                                </div>

                            </li>



                        </ul>';

}



function tpVitrin()

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



function tpBreadCrumb() {

	global $siteConfig;

	$breadCrumb = getBreadCrumb();

	//if(!$_GET['catID'] || !sizeof($breadCrumb)) return;

	$out.='<div id="nav"><strong>Şuanda bulunduğunuz yer: </strong><ul>'."\n";	

	$out.='<li class="first"><a href="index.php">Ana Sayfa</a></li>'."\n";

	for ($i=0;$i<sizeof($breadCrumb);$i++) 

	{

		if ($breadCrumb[$i]) $out.= '<li><a href="'.($siteConfig['seoURL'] ? seoFix(dbinfo('kategori','name',$breadCrumb[$i])).'-kat'.$breadCrumb[$i].'.html':'page.php?act=kategoriGoster&catID='.$breadCrumb[$i].'&name='.seoFix(dbinfo('kategori','name',$breadCrumb[$i]))).'">'.hq("select name from kategori where ID='".$breadCrumb[$i]."'").'</a></li>'."\n";

	}

	$q = my_mysql_query('select * from pages');

	while ($d = my_mysql_fetch_array($q)) {

		$link = ($siteConfig['seoURL'] ? seoFix($d['title']).'-sID'.$d['ID'].'.html':'page.php?act=showPage&ID='.$d['ID']);

		$href=($d['redirect']?$d['redirect']:$link);

		if ($d['redirect'] && !(stristr($d['redirect'],'|') === false)) {

			list($seo,$link) = explode('|',$d['redirect']);

			$href = ($siteConfig['seoURL'] ? $seo:$link);

		}

		if (basename($_SERVER['REQUEST_URI']) == $href) $out.='<li><a href="'.$href.'">'.$d['title'].'</a></li>'."\n";

	}

	$out.="</ul></div>\n";

	return $out;	

}



function tpBlueTopPages()

{

	global $siteConfig;	

	$out = '<ul><li '.(strtolower(basename($_SERVER['SCRIPT_FILENAME'])) == 'index.php'?'class="selected"':'').'><a href="./index.php">ANA SAYFA</a></li>';			

	$q = my_mysql_query('select * from pages where showBottom=1 order by seq');

	while ($d = my_mysql_fetch_array($q)) {

		$link = ($siteConfig['seoURL'] ? seoFix($d['title']).'-sID'.$d['ID'].'.html':'page.php?act=showPage&ID='.$d['ID']);

		$href=($d['redirect']?$d['redirect']:$link);

		if ($d['redirect'] && !(stristr($d['redirect'],'|') === false)) {

			list($seo,$link) = explode('|',$d['redirect']);

			$href = ($siteConfig['seoURL'] ? $seo:$link);

		}

		$out.='<li '.(basename($_SERVER['REQUEST_URI']) == $href?'class="selected"':'').'><a href="'.$href.'">'.trupper($d['title']).'</a></li>';

	}

	$out.='</ul>';

	return $out;

}



function tpBlueHeaderPages()

{

	global $siteConfig;	

	$out = '<ul>';			

	$q = my_mysql_query('select * from pages where showLeft=1 order by seq');

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



function tpBlueMenu($parentID)

{

	global $siteConfig;

	$out='<ul>';

	$q = my_mysql_query("select * from kategori where active =1 AND parentID='$parentID' order by seq,name");

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

					$linkSub= ($siteConfig['seoURL'] ? seoFix($d2['name']).'-kat'.$d2['ID'].'.html':'page.php?act=kategoriGoster&catID='.$d2['ID'].'&name='.seoFix($d2['name']));

					$out.='<li><a id="a'.$d2['ID'].'"  href="'.$linkSub.'">'.$d2['name'].'</a></li>'."\n";

				}

				$out.='</ul>'."\n";

				

			}

		}

		$out.='</li>';

	}

	$out.='</ul>';

	$out.="<script>var tripUlx = $('#trip ul li'); tripUlx.find('ul').hide(); </script> \n";

	// Eğer bir kategoride veya bir ürün sayfasındaysa aktif kategoriyi aç.

	if ((int)currentCatPatern())

	{

		$out.="<script> $('#trip #a".$_GET['catID']."').css({'color':'#939393'}); </script>";

		$cArray = explode('/',currentCatPatern());

		foreach($cArray as $c)

		{

			$out.="

			<script>			

				tripUlx.find('#ul$c').show().parent().find('#a$c').addClass('selected');			

			</script>	

			";

		}

	}

	return $out;	

}

?>