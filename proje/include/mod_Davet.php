<?php
if ($_GET['ref']) $_SESSION['refID'] = hq("select ID from user where username like '".$_GET['ref']."' OR email like '".$_GET['ref']."'");
$d['girisMesaj'] = '<div class="hata davetHata">- Girdiğiniz bilgiler <b>hiçbir şekilde</b> veritabanında saklanmaz. Sadece iletişim listeniz alınır ve tüm bilgiler anında silinir.<br><br></div>';
$mailCode = 'Site_Davet';

function davetURL()
{
	global $siteDizini,$siteConfig;
	if (!$_SESSION['userID']) return '<div class="hata">Davetiye sistemi için lütfen üye girişi yapın.</div>';
	$url = 'http://'.$_SERVER["SERVER_NAME"].$siteDizini.'page.php?act=register&ref='.$_SESSION['username'];
	$name = hq("select concat(name,' ',lastname) from user where ID='".$_SESSION['userID']."'");
	$out = '<br><br><div class="socialBookmarksContainer">
    
    <a rel="nofollow"  target="_blank" title="Facebook.com\'da paylaş"  href="http://www.facebook.com/share.php?t='.$name.' sizi '.siteConfig('seo_title').'\'a davet ediyor&u='.$url.'" ><img border="0" src="images/face.png" /></a>&nbsp;
    <a rel="nofollow" target="_blank"  title="Twitter.com\'da paylaş"  href="http://www.twitter.com/home?status='.$url.'"><img border="0" src="images/twit.png" /></a>
 
</div>
';
	return "<input style='width:400px;' value='".$url."' />".$out;
}
function modDavet()
{
	global $d,$siteConfig,$siteDizini,$mailCode;
	if (!$_SESSION['userID']) return '<div class="hata">Davetiye sistemi için lütfen üye girişi yapın.</div>';
	if ($_GET['email'])
	{	
		$_POST['davetGonder'] = true;
		$_POST['emailPostArray'][] = $_GET['email'];
		$mailCode = 'Site_Davet_Tek';
		$info = davetInsertToQueue(array($_GET['email']));	
		
		if ($hata) $out .= '<div class="hata">'.$hata.'</div>';
		if ($info) $out .= '<div class="info"><strong>Rapor :</strong><br><br>'.$info.'</div>';	
		return $out;
	}
	
	
	$out.=$d['girisMesaj'];
	
	// include('3rdparty/OpenInviter/openinviter.php');
	// $inviter=new OpenInviter();
	// $oi_services=$inviter->getPlugins();
	if (!$_POST['data_ePostaMesaj']) $out.=generateForm(getDavetForm($providers),$d,'','');
	else
	{
		$_POST['data_ePostaFirma'] = strtolower($_POST['data_ePostaFirma']);
		if ($_POST['data_ePostaFirma'])
		{
			/*
			$inviter->startPlugin($_POST['data_ePostaFirma']);
			$internal=$inviter->getInternalError();
			$internal;
			if ($internal)
				{
					$ers['inviter']=$hata=$internal.' ('.$_POST['data_ePostaFirma'].')';
				}
			else if (!$inviter->login($_POST['data_ePosta'],$_POST['data_ePostaSifre']))
				{
					$internal=$inviter->getInternalError();
					$hata = ($internal?$internal:"Hatalı e-posta adres veya şifre !");
				}
			else if (false===$contacts=$inviter->getMyContacts())
				$hata = 'İletişim Listesi Alınamadı !';
			else 
			*/
			{
				foreach($contacts as $k=>$v) $emailContactsArray[] = $k;
				$info = davetInsertToQueue($emailContactsArray);								
			}
		}
		else
		{
			$info = davetInsertToQueue();
		}
	}
	if ($hata) $out .= '<div class="hata">'.$hata.'</div>';
	if ($info && $_POST['davetGonder']) 
		$out .= '<div class="info"><strong>Rapor :</strong><br><br>'.$info.'</div>';
	if ($info && !$_POST['davetGonder']) 
		$out .= '<div class="info">'.$info.'</div>';
	return $out;
}

function davetInsertToQueue($emailContactsArray = array())
{
	global $siteConfig,$siteDizini,$mailCode;
	$ManuelEmailArray = explode(',',$_POST['data_ePostaDiger']);
	$emailArray = array_merge($emailContactsArray,$ManuelEmailArray);
	if (!$_POST['davetGonder'])
	{
		$out='<form method="POST" id="emailPostArrayForm">
				<input type="hidden" name="davetGonder" value="true">
				<input type="hidden" name="data_ePostaMesaj" value="'.$_POST['data_ePostaMesaj'].'">
				<input type="hidden" name="data_ePostaDiger" value="'.$_POST['data_ePostaDiger'].'">
		';
		$out.='<input type="checkbox" 
					  checked="checked" class="offer"
					  onclick="$(document).find(\':checkbox\').attr(\'checked\',$(this).attr(\'checked\'));"> 
				Tümünü Seç<hr />
				<script>
				$(\'.offer\').click(function(){ 
       var $checkbox = $(this).parent().parent().find(\':checkbox\');
       $checkbox.attr(\'checked\', !$checkbox.is(\':checked\'));
 });

		</script>		
				';
		foreach($emailArray as $email)
		{
			if (!$email) continue;
			if (email_kontrol($email))
			{
				$out.='<input name="emailPostArray[]" type="checkbox" value="'.$email.'" checked="checked"> '.$email.'<br />';
			}	
		}
		$out.='<br /><input type="submit" value="Davet Gönder">';
		$out.='</form>';
		return $out;
	}	
	
	$header = getHeaders(siteConfig('adminMail'));
	
	$mailQ = my_mysql_query("select * from sablonEmail where code = '$mailCode'");
	$mailD = my_mysql_fetch_array($mailQ);
	
	$q = my_mysql_query("select * from user where ID='".$_SESSION['userID']."'");
	$merge = my_mysql_fetch_array($q);
	$merge['davetURL'] = 'http://'.$_SERVER["SERVER_NAME"].$siteDizini.'page.php?act=register&ref='.$_SESSION['username'];
	$merge['arkadasMesaj'] = $_POST['data_ePostaMesaj'];
	
	foreach($_POST['emailPostArray'] as $email)
	{
		if (!$email) continue;
		if (email_kontrol($email))
		{
			$mailD['siteAdi'] = siteConfig('seo_title');
			$mailD['body'] = mergeText($mailD['body'],$merge);
			
			$mail = new spEmail();
			$mail->headers = $header;
			$mail->to = $email;
			$mail->subject = $mailD['title'];
			$mail->body = $mailD['body'];			
			$mail->insertToQueue();	
			$gonderilen[] = $email;
			$info.="$email : Sıraya eklendi.<br>";
		}
		else 
		{
			$info.="$email : <b class='hata'>Hatalı.</b> Sıraya eklenmedi.<br>";
		}
	}
	$info.="<br />Girmiş olduğunuz toplam <strong>".sizeof($gonderilen)."</strong> e-posta adresi sıraya eklendi ve gün içerisinde alıcılara iletilecektir. Davetiyeniz ile siteye üye olup ilk alışverişini yapan her kullanıcı için <strong>".siteConfig('puanTavsiye')."</strong> puan kazancaksınız. Teşekkür ederiz.";
	return $info;
}

function getDavetForm($providers)
{
	// Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
	// $form[] = array("BASLIK","data[1|5]","TEXTBOX",1,'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
	// Örnek : 
	// $form[] = array("TC Kimlik No","data1","TEXTBOX",1,'',1,10);
	// $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
	$form[] = array('E-Posta Adresiniz',"ePosta","TEXTBOX",1,'',1,2);
	// $form[] = array('E-Posta Şifreniz',"ePostaSifre","PASSWORD",1,'',1,0);
	// $form[] = array('Servis Sağlayıcı',"ePostaFirma","SELECT",1,array('Gmail','Hotmail','MSN','Mynet','Yahoo','LinkedIn','MySpace','Xing'),0,0);
	$form[] = array('Göndermek İstediğiniz E-Posta Adresleri<br>(Virgül ile ayırın)',"ePostaDiger","TEXTAREA",1);
	$form[] = array('Mesajınız',"ePostaMesaj","TEXTAREA",1,'',1,5);
	return $form;	
}