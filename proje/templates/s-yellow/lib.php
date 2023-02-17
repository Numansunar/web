<?php

$tempConfig['urundetay'] = ($_GET['op'] == 'ekle'?'UrunEkleBlock':'');

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



function urunGoster_LoginForm()

{

	if (!$_SESSION['loginStatus'])

	{ 

		$out='

			<form method="post" action="" id="uye_girisi" name="login">

			<fieldset>

				<div class="inputx">

					<input type="text" name="username" value="Kullanıcı Adınız" class="s1"/>

				</div>

				<div class="inputx">

					<input type="password" name="password" value="Şifre" class="s1"/>

				</div>

				<input type="submit" name="test" value=""  class="submit_giris"/>

			</fieldset>

			</form>

			<ul class="giris_menu">

				<li><a href="#">Üye olmak istiyorum</a></li>

				<li><a href="#">Şifremi Unuttum!</a></li>

			</ul>';

	}

	else 

	{

		if ($_POST['data_puan'])

		{

			$out = insertYorum($_GET['urunID']);			

		}

		else 

		{

			$out='

				<form method="post" action="" id="uye_girisi" name="login" style="width:443px;">

				<input type="hidden" name="data_puan" value="5">

				<fieldset>

					<div class="inputx">

						<textarea name="data_aciklama" class="yorum">Yorum ekleyin ..</textarea>

					</div>

					<input type="submit" name="test" value=""  class="submit_gonder"/>

				</fieldset>

				</form>

				';	

		}

	}

	return $out;

}



function mylistNews()

{

	global $seo;

	$seo->currentTitle = 'Haberler';

	$csdata = new csData();

	$csdata->query = "select * from haberler order by ID desc";

	$csdata->temp = 'lists/haberliste';

	return generateTableBox('Haberler',$csdata->execute(),tempConfig('bilgi_sayfalari'));

}



function gununFirsatlari()

{

	return urunList("select * from urun where stok > 0 AND start < now() AND finish > now() order by seq desc,start asc");

}



function sYellowTopNews()

{

	$csdata = new csData();

	$csdata->query = "select * from haberler order by ID desc limit 0,10";

	$csdata->temp = 'lists/habertop';

	return $csdata->execute();

}



function sYellowTopPages()

{

	global $siteConfig;	

	$out = '<ul>

			<li '.(strtolower(basename($_SERVER['SCRIPT_FILENAME'])) == 'index.php'?'class="selected_"':'').'><a href="./index.php">Ana Sayfa</a></li><li> | </li>

			<li><a href="page.php?act=siparistakip">Sipariş Takip</a></li><li> | </li>

			<li><a href="page.php?act=havaleBildirim&status=1">Havale Bildirimi</a></li><li> | </li>

			';			

	$q = my_mysql_query('select * from pages where showBottom=1 AND title not like \'%arama%\' order by seq');

	while ($d = my_mysql_fetch_array($q)) {

		$link = ($siteConfig['seoURL'] ? seoFix($d['title']).'-sID'.$d['ID'].'.html':'page.php?act=showPage&ID='.$d['ID']);

		$href=($d['redirect']?$d['redirect']:$link);

		if ($d['redirect'] && !(stristr($d['redirect'],'|') === false)) {

			list($seo,$link) = explode('|',$d['redirect']);

			$href = ($siteConfig['seoURL'] ? $seo:$link);

		}

		$out.='<li '.(basename($_SERVER['REQUEST_URI']) == $href?'class="selected_"':'').'><a href="'.$href.'">'.$d['title'].'</a></li><li> | </li>';

	}

	$out = substr($out,0,-12);

	$out.='</ul>';

	return $out;

}



function sYellowNeleriKacirdiniz()

{

	return urunList("select * from urun where stok > 0 OR finish < now() order by finish desc limit 0,3",'UrunListBlog','UrunListShowBlog');

}



function sYellowIstatistikIL()

{

	// Eğer sadece aktif ürün istatistikerinin görüntülenmesini istiyorsanız aşağıdaki satırın başındaki // leri kaldırın.

	// $urunFilter = "AND urunID= '".$_GET['urunID']."'";

	$q = my_mysql_query("select *,count(*) as toplam from siparis where userID > 0 AND durum > 0 $urunFilter group by city order by toplam desc limit 0,3");

	$veri = array();

	while ($d = my_mysql_fetch_array($q))

	{

		$d['il'] = hq("select name from iller where plakaID = '".$d['city']."'");

		$toplam += $d['toplam'];

		$d['userID'] = hq("select userID,count(*) toplam from siparis where city = '".$d['city']."' group by userID order by toplam limit 0,1");

		$veri[] = $d;		

	}

	foreach ($veri as $d)

	{

		$yuzde = (int)((100 * $d['toplam']) / $toplam);

		$out.='<div class="ilbox">

				<div class="ist">'.$d['il'].' - <strong>'.$d['name'].'</strong> - % '.$yuzde.'</div>

				<div class="oran" style="width:'.$yuzde.'px"></div>

			   </div>';

	}

	return $out;

}



function sYellowIstatistikAdet()

{

	// Eğer sadece aktif ürün istatistikerinin görüntülenmesini istiyorsanız aşağıdaki satırın başındaki // leri kaldırın.

	// $urunFilter = "AND urunID= '".$_GET['urunID']."'";

	$q = my_mysql_query("select *,count(*) as toplam from sepet where durum > 0 $urunFilter group by adet order by toplam desc limit 0,3");

	$veri = array();

	while ($d = my_mysql_fetch_array($q))

	{

		$toplam += $d['toplam'];

		$veri[] = $d;		

	}

	foreach ($veri as $d)

	{

		$yuzde = (int)((100 * $d['toplam']) / $toplam);

		$out.='<div class="ilbox">

				<div class="ist"><strong>'.$d['adet'].' Adet</strong> - % '.$yuzde.'</div>

				<div class="oran" style="width:'.$yuzde.'px"></div>

			   </div>';

	}

	return $out;

}



function sYellowYorumlar()

{

	global $siteConfig;	

	if ($siteConfig['urunOnay']) $qo = 'AND onay=1';

	

	$csdata = new csData();

	$csdata->query = "select urunYorum.*,concat(user.name,' ',user.lastname) as AD_SOYAD from urunYorum,user where user.ID=urunYorum.userID AND urunID='".$_GET['urunID']."' $qo";

	$csdata->temp = 'lists/yorumliste';

	return $csdata->execute();

}					

function sYellowLogin()

{

	global $login_message,$siteConfig;

	if (!$_SESSION['loginStatus'])

	{ 

		$out.='<div class="baslik" style="margin-left:0;">

					<strong>Üye</strong> Girişi 

					<div class="sifremi_unuttum"><a href="'.($siteConfig['seoURL'] ? 'sifre_sp.html':'page.php?act=sifre').'">Şifremi Unuttum</a></div>

				</div>

				<form method="post" action="" id="uye_girisi" name="login">

					<fieldset>

						<label for="eposta">Kullanıcı Adınız:</label>

						<div class="input">

							<input type="text" name="username" value="" />

						</div>

						<br />

						<label for="sifre">Şifre:</label>

						<div class="input">

							<input type="password" name="password" value=""/>

						</div>

						<input type="submit" name="test" value=""  class="submit_giris" style="margin-left:160px;"/>

					</fieldset>

				</form>'.($login_message?'<script>alert(\''.strip_tags($login_message).'\')</script>':'');

	}

	else 

	{

		$classArray=array('newMember','lostPw','loginSubmit');

		$userMenuArray = userMenuList();

		$i=1;

		

		$out.='<div class="baslik" style="margin-left:0;">

					<strong>Üye</strong> Menüsü 

				</div>

				<div class="kullanici_profil">Merhaba <a href="#"><a href="'.($siteConfig['seoURL'] ? 'profile_sp.html':'page.php?act=profile').'">'.$_SESSION['name'].' '.$_SESSION['lastname'].'</a>,

			    <div id="loginRight" class="userTopRightMenu">			  

			   		<a href="'.($siteConfig['seoURL'] ? 'showOrders_sp.html':'page.php?act=showOrders').'" class="newMember">Siparişlerim</a>					

					<a href="'.($siteConfig['seoURL'] ? 'havaleBildirim_sp__status-1.html':'page.php?act=havaleBildirim&status=1').'" class="lostPw">Havale Bildirimi</a>

					<a href="'.($siteConfig['seoURL'] ? 'hataBildirim_sp__status-51|81.html':'page.php?act=hataBildirim&status=51|81').'" class="lostPw">Hata Bildirimi</a>

					<a href="'.($siteConfig['seoURL'] ? 'logout_sp.html':'page.php?act=logout').'">Çıkış</a>

			   </div>

				

				</div>

			   ';

	}

	return $out;

}

?>