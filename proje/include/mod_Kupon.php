<?php
/* Ayarlar */
$seo->currentTitle = "Kupon Onay Formu";
$firma['Grupfoni'] = 1;
$firma['Grupanya'] = 1;
$firma['Sehirfirsati'] = 1;

$user['Grupfoni']['user'] = '';
$user['Grupfoni']['pass'] = '';
$user['Grupfoni']['appId'] = '';
/* Ayarlar */

foreach($_POST as $k=>$v) $_SESSION['cache'][$k] = $v;
foreach($_SESSION['cache'] as $k=>$v) if (!$_POST[$k]) $_POST[$k] = $v;
$q = my_mysql_query("select * from user where ID ='".$_SESSION['userID']."'");
$data = my_mysql_fetch_array($q);	
foreach ($_POST as $k=>$v) $data[str_replace('data_','',$k)] = $v;
$data['site'] = $_GET['firmaS'];
$out .= generateTableBox('Kupon Onay Formu',($_POST['data_name']?basvuruFormSubmit():basvuruForm()).'<div style="clear:both;">&nbsp;</div>'.dbInfo('pages','body',4),tempConfig('formlar'));
$out.="<script>$('#gf_site').change(function() { window.location.href ='page.php?act=modKupon&firmaS=' + $(this).val(); });</script>";

function basvuruForm() {
	global $data;
	$out = generateForm(getBasvuruForm(),$data,'','');
	if ($_GET['firmaS'])
	{
		$out.="<script>$('#gf_site').parent().parent().css('visibility','hidden').parents().find('table:first').css('margin-top','-30px');</script>";	
	}
	return $out;
}

function basvuruFormSubmit() {
	global $siteConfig,$data,$user;
	
	unset($_SESSION['cache']);
	$_SESSION['MailSent']++;
	telfix('tel');
	switch($_GET['firmaS'])
	{
		case 'Grupfoni':
			list($x,$ID) = explode('ID : ',$_POST['data_urun']);
			$urunID = substr($ID,0,-1);
			$sonuc = file_get_contents('http://www.grupfoni.com/CouponCheck?username='.$user['Grupfoni']['user'].'&password='.$user['Grupfoni']['pass'].'&couponCode='.$_POST['data_kod']);
			$sonucXML = $katalog = new SimpleXMLElement($sonuc); 			
			   

			if (utf8fix($sonucXML->Result)=='OK')
			{
					$kuponOnay = 1;
			}
			else
			{
				$sonuc = utf8fix($sonucXML->errorMessage);
			}
		break;	
		case 'Grupanya':
			list($x,$ID) = explode('ID : ',$_POST['data_urun']);
			$urunID = substr($ID,0,-1);
			$firma['Grupanya']['OzelKod'] = hq("select kuponFirmaData from urun where ID='".$urunID."'");
			$sonuc = file_get_contents('http://onay.grupanya.com/s/KodSorgula.ashx?k='.$_POST['data_kod'].'&ci=so&x='.$firma['Grupanya']['OzelKod']);
			if ($sonuc == 1)
			{
				$dogrula = file_get_contents('http://onay.grupanya.com/s/KodDogrula.ashx?k='.$_POST['data_kod'].'&ci=so&x='.$firma['Grupanya']['OzelKod']);
				$kuponOnay = 1;
			}
			else {
				$hataArray['-1'] = 'Parametre Hatas?? Y??netici Kodu Hatal??';
				$hataArray['-2'] = 'Kupon Kodunu Hatal?? Girdiniz L??tfen Tekrar Deneyiniz. (Kupon kodu size bildirildi??i ??ekilde aradaki tire i??aretleriyle girilmelidir) ';
				$hataArray['-3'] = 'Verdi??iniz Kupon Kodu Ba??ka Bir ??r??ne Aittir. L??tfen Kontrol Edip Tekrar Giriniz. ';
				$hataArray['-4'] = 'Bu Kupon Kodu Grupanya Taraf??ndan ??ptal Edilmi??tir.';
				$hataArray['-5'] = 'Bu Kod Daha ??nceden Kullan??lm????t??r.';
				$sonuc = $hataArray[substr($sonuc,0,2)];
			}			
		break;
		default:
			if($_GET['firmaS'])
			{
				$kuponOnay = 1;	
			}
		break;
	}
	if ($kuponOnay)
	{
		list($x,$ID) = explode('ID : ',$_POST['data_urun']);
		$ID = substr($ID,0,-1);
		my_mysql_query("update urun set stok = (stok - 1) where ID='$ID'");	
		if ((!$_SESSION['MailSent'] || $_SESSION['MailSent'] < 9995) && generateMailFromForm(getBasvuruForm(),siteConfig('adminMail'),'Kupon Onay Giri??i')) 
		{
			
			$out.='<div class="success">Bilgileriniz kaydedildi. Size tekrar d??n??lecektir.</div><br>';		
			$out.=viewForm(getBasvuruForm(),$data,'','');
		}
		else $out.='<div class="success">'._lang_formGonderilemedi.'</div><br>';
		saveform(getBasvuruForm(),$data,array('name','email','urun','site','tel','kod','adres'));	
		generateMailFromForm(getBasvuruForm(),siteConfig('adminMail'),'Kupon Sipari?? Detaylar??');
		generateMailFromForm(getBasvuruForm(),$_POST['data_email'],'Kupon Sipari?? Detaylar??n??z');
	}
	else{
		$out .= '<span class="error">HATA : '.$sonuc.'</span><br /><br />'.generateForm(getBasvuruForm(),$data,'','');	
	}
	return $out;
}

function getBasvuruForm() {
	// A??a????daki sat??r?? kullanarak data1 ... data5 aras?? manuel sat??rlar?? ekleyebilirsiniz.
	// $form[] = array("BASLIK","data[1|5]","TEXTBOX",[D??zenlenebilir : 1 | D??zenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu De??il : 0] ,[Minimum karakter s??n??r??]);
	// ??rnek : 
	// $form[] = array("TC Kimlik No","data1","TEXTBOX",1,'',1,10);
	// $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
	
	global $firma;
	$uArray = array();
	foreach($firma as $k=>$v)
	{
		if ($firma[$k])
			$fArray[] = ucfirst($k);	
	}
	if ($_GET['firmaS'])
	{
		$q = my_mysql_query("select * from urun where kuponFirma like '".addslashes($_GET['firmaS'])."'");
		while($d = my_mysql_fetch_array($q))
		{
			$uArray[] = $d['name'].' (ID : '.$d['ID'].')';	
		}
	}
	
	$form[] = array("Kupon Sat??n Ald??????n??z Site","site","SELECT",1,$fArray,1,0);
	$form[] = array("Sat??n Ald??????n??z ??r??n","urun","SELECT",1,$uArray,1,0);
	$form[] = array("Kupon Kodu","kod","TEXTBOX",1,'',1,0);
	$form[] = array(_lang_form_adinizSoyadiniz,"name","TEXTBOX",1,'',1,0);
	$form[] = array(_lang_form_emailAdresiniz,"email","EMAIL",1,'',1,0);
	$form[] = array("Telefon Numaran??z","tel","TEXTBOX",1,'',1,0);			
	$form[] = array('Adres',"adres","TEXTAREA",1,'',1,0);	
	return $form;
}


?>