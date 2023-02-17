<?php
function mGrupAnaUrunID()
{
	if ($_SESSION['groupCity']) $cityFilter = 'AND (urun.data4 = \''.$_SESSION['groupCity'].'\' OR urun.data4 = \'\' OR urun.data4 = \'0\')';
	if ($_SESSION['groupCat']) $catFilter = 'AND catID = \''.$_SESSION['groupCat'].'\'';
	return hq("select ID from urun where active=1 AND stok > 0 AND start < now() AND finish > now() $cityFilter $catFilter order by seq desc,start asc limit 0,1");
}
function loginButtons()
{
	if($_SESSION['userID'] && hq("select urun.ID from urun where urun.userID='".$_SESSION['userID']."'"))
		$onay = '<a href="'.($siteConfig['seoURL'] ? 'kuponOnay_sp.html':'page.php?act=kuponOnay').'" class="btn-register">Kupon Onay</a>';
	else $onay = '<a href="'.($siteConfig['seoURL'] ? 'havaleBildirim_sp__status-1.html':'page.php?act=havaleBildirim&status=1').'" class="btn-login">Havale</a>';
	if (!$_SESSION['userID']) return '
		<a href="'.($siteConfig['seoURL'] ? 'tumFirsatlar_sp':'page.php?act=tumFirsatlar').'" class="btn-login">Tüm Fırsatlar</a>
		<a href="'.($siteConfig['seoURL'] ? 'register_sp.html':'page.php?act=register').'" class="btn-register">Üye Olun</a>
		<a href="'.($siteConfig['seoURL'] ? 'login_sp.html':'page.php?act=login').'" class="btn-login">Üye Girişi</a>';
	else
		return '
			<a href="'.($siteConfig['seoURL'] ? 'tumFirsatlar_sp':'page.php?act=tumFirsatlar').'" class="btn-login">Tüm Fırsatlar</a>
			<a href="'.($siteConfig['seoURL'] ? 'login_sp.html':'page.php?act=login').'" class="btn-register">Hesabım</a>
			<a href="'.($siteConfig['seoURL'] ? 'showOrders_sp.html':'page.php?act=showOrders').'" class="btn-register">Siparişlerim</a>					
			'.$onay.'
			';
}


function mybasvuru()
{
	global $seo;
	$seo->currentTitle = 'İşletme Başvuru';
	telFix('ceptel');
	$out .= generateTableBox('İşletme Başvuru',($_POST['data_namelastname']?basvuruFormSubmit():basvuruForm()).'<div style="clear:both;">&nbsp;</div>'.dbInfo('pages','body',4),tempConfig('formlar'));
	return $out;
}

function basvuruForm() {
	$q = my_mysql_query("select * from user where ID ='".$_SESSION['userID']."'");
	$d = my_mysql_fetch_array($q);	
	$out = generateForm(getBasvuruForm(),$d,'','');
	return $out;
}

function basvuruFormSubmit() {
	global $siteConfig;
	$_SESSION['MailSent']++;
	telfix('ceptel');
	if ((!$_SESSION['MailSent'] || $_SESSION['MailSent'] < 9995) && generateMailFromForm(getBasvuruForm(),$siteConfig['adminMail'],'İşletme Başvuru Mesajı')) {
		
		$out.='<div class="success">'._lang_formGonderildi.'</div><br>';		
		foreach ($_POST as $k=>$v) $data[str_replace('data_','',$k)] = $v;
		$out.=viewForm(getBasvuruForm(),$data,'','');
	}
	else $out.='<div class="success">'._lang_formGonderilemedi.'</div><br>';
	return $out;
}


function getBasvuruForm() {
	// Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
	// $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
	// Örnek : 
	// $form[] = array("TC Kimlik No","data1","TEXTBOX",1,'',1,10);
	// $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
	
	$form[] = array(_lang_form_adinizSoyadiniz,"namelastname","TEXTBOX",1,'',1,5);
	$form[] = array('Ünvanınız',"unvan","TEXTBOX",1,'',1,5);
	$form[] = array(_lang_form_emailAdresiniz,"email","TEXTBOX",1,'',1,0);	
	$form[] = array(_lang_form_telefonNumaraniz,"ceptel","TELEPHONE",1,'',0,0);
	$form[] = array('İşletmenizin Adı',"isletmead","TEXTBOX",1,'',0,5);
	$form[] = array('İşletmenizin Web Adresi',"webadres","TEXTBOX",1,'',0,5);
	$form[] = array('İşletmenizin Adresi',"isletmeadres","TEXTAREA",1);
	$form[] = array('Sitemizde nasıl yer almak istersiniz?',"message","TEXTAREA",1);
	return $form;
}

function mgGrupDigerUrunID()
{
	if ($_SESSION['groupCity']) $cityFilter = 'AND (urun.data4 = \''.$_SESSION['groupCity'].'\' OR urun.data4 = \'\' OR urun.data4 = \'0\')';
	$urunID = ($_GET['urunID']?$_GET['urunID']:grupAnaUrunID());
	return hq("select ID from urun where stok > 0 AND start < now() AND finish > now() AND ID !='".$urunID."' $cityFilter order by seq desc,start asc limit 0,1");
}

function mgIller()
{
	if ($_GET['groupCity']) $_SESSION['groupCity'] = $_GET['groupCity'];
	$out.='<select name="groupCity" onchange="if ($(this).val())window.location.href = \'index.php?groupCity=\'+$(this).val();"><option value="">Şehirler</option>'."\n";
	$q = my_mysql_query("select iller.* from urun,iller where urun.data4=iller.plakaID AND  stok > 0 AND start < now() AND finish > now() group by iller.plakaID order by urun.seq,iller.name");	
	while($d=my_mysql_fetch_array($q))
	{
		
		$out.='<option '.($_SESSION['groupCity'] == $d['plakaID']?'selected':'').' value="'.$d['plakaID'].'">'.$d['name'].'</option>'."\n";
	}
	$out.='</select>';
	return $out;
}

function myBreadCrumb() {
	global $siteConfig;
	$breadCrumb = getBreadCrumb();
	for ($i=0;$i<sizeof($breadCrumb);$i++) $breadCrumb[$i] = '<a class="BreadCrumb" href="'.($siteConfig['seoURL'] ? seoFix(dbinfo('kategori','name',$breadCrumb[$i])).'-kat'.$breadCrumb[$i].'.html':'page.php?act=kategoriGoster&catID='.$breadCrumb[$i].'&name='.seoFix(dbinfo('kategori','name',$breadCrumb[$i]))).'">'.hq("select name from kategori where ID='".$breadCrumb[$i]."'").'</a>';
	//$out = implode(" &raquo; ", $breadCrumb); if($_GET['t4'] != $_POST['t']) generateTrForm();
	return $out;	
}

function myUrunSayac($urunID)
{
	if (!$urunID) return;
	$tarihArray = explode(' ',hq("select finish from urun where ID='$urunID'"));
	list($yil,$ay,$gun) = explode('-',$tarihArray[0]);
	list($dak,$san) = explode(':',$tarihArray[1]);
	
	return '<script>
			$(\'#sayac\').countdown({tickInterval: 1,until: new Date('.(int)$yil.', ('.(int)$ay.' - 1), '.(int)$gun.', '.(int)$dak.', '.(int)$san.'),timezone: +2,     layout: \'<strong>{hnn}</strong> saat <strong>{mnn}</strong> dakika <strong>{snn}</strong> saniye</span>\'});	
		    </script>';
}

function mGroupDigerFirsatlar()
{
	global $siteConfig;
	if ($_SESSION['groupCity']) $cityFilter = 'AND (urun.data4 = \''.$_SESSION['groupCity'].'\' OR urun.data4 = \'\' OR urun.data4 = \'0\')';
	//return urunlist('select ID from urun order by seq desc,start asc limit 2,'.$siteConfig['anaSayfaUrun']);
	return urunlist('select * from urun where stok > 0 AND start < now() AND finish > now() '.$cityFilter.' order by seq desc,start asc limit 2,'.$siteConfig['anaSayfaUrun']);
}

function mGroupFooterPages()
{
	global $siteConfig;	
	$out = '<ul class="menu">';			
	$q = my_mysql_query('select * from pages where showBottom=1 order by seq');
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
?>