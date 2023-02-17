<?

function cepsiparisMod($d){
	global $shopphp_demo;
	$out = '
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<div id="tel-birakin"><div class="whatsapp_tabela" style="cursor:pointer;">
		<div class="wrap">
		<div class="icon"><i class="fa fa-phone"></i></div>
		<div class="right">
		<p class="title">TELEFONDA SİPARİŞ VER</p>
		<p class="number">'.siteConfig('firma_tel').'</p>
		<p class="slogan">Tıklayın, telefonunuzu bırakın. Sizi arayalım.</p>
		</div>
		</div>
		</div>
	</div>
	<script type="text/javascript">
	var hizliAramaIsim = "";
	var hizliAramaTel = "";
	$("#tel-birakin").click(function() {
		swal({
		  title: "Telefonda Sipariş Verin (1/2)",
  		  text: "Adınız Soyadınız : ",
		  content: "input",
		   button: {
			text: "Sonraki Adım"
		  },

		})
		.then((value) => {
			hizliAramaIsim = value;
			if(!hizliAramaIsim)
			{
				return swal("Hata",`Eksik / hatalı giriş. Numara kaydedilmedi.`,"error");;
			}
			swal({
			  title: "Telefonda Sipariş Verin (2/2)",
			  text: "Telefon Numaranız : ",
				content: "input",
				className: "input-tel",
			  button: {
				text: "Gönder",
				closeModal: false
			  },
	
			})
			.then((value) => {
			  hizliAramaTel = value;
			  if(!hizliAramaTel)
				{
					return swal("Hata",`Eksik / hatalı giriş. Numara kaydedilmedi.`,"error");
				}
				'."	   $.ajax({
						  url: 'include/ajaxLib.php?act=quickContact&urunID=".$d['ID']."&namelastname='+ hizliAramaIsim +'&ceptel=' + hizliAramaTel + '&email=' + 'hizli-arama-talebi',
						  success: function(data) 
								   { 
										swal('Telefonda Sipariş Verin',`Sn. `+ hizliAramaIsim +`, Telefon numaranız `+ hizliAramaTel +` olarak kaydedildi. En kısa sürede sizi arıyoruz.".($shopphp_demo?'*** Demo Amaçlıdır ***':'')."`,'success');				
								   }
						});".'	
			  
			});
		});
	});
	</script>
	
	'; 
	 return $out;
}

function whatsapptxt($d)
{

	global $siteDizini;
	$wno = str_replace(array(' ','(',')','-'), array(''), siteConfig('whatsappNumber'));
	$text = ($_GET['act'] == 'urunDetay'?'Stok Kodu:'.$d['ID'].' - Adı: '.$d['name'].' adlı üründen sipariş vermek istiyorum. http://'.$_SERVER['HTTP_HOST'].$siteDizini.urunLink($d):'Telefon üzerinden sipariş vermek istiyorum.');
	
	//if($_GET['act'] != 'urunDetay' || $shopphp_demo)
	$out='<a href="https://api.whatsapp.com/send?phone=9'.$wno.'&text='.$text.'" id="spWhatsAppFooter" target="_blank">
        <img src="images/whatsApp.png" alt="">
    </a>';
	
		$out = '
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<div class="whatsapp_tabela">
	<a href="https://api.whatsapp.com/send?phone=9'.$wno.'&text='.$text.'" target="_blank">
	<div class="wrap">
	<div class="icon"><i class="fa fa-whatsapp"></i></div>
	<div class="right">
	<p class="title">TIKLA WHATSAPP İLE SİPARİŞ VER</p>
	<p class="number">'.siteConfig('whatsappNumber').'</p>
	<p class="slogan">7x24 Whatsapp Üzerinden de Sipariş Verebilirsiniz.</p>
	</div>
	</div>
	</a>
	</div>
	'; 
	 return $out;
}

function mod_sendWhatsappSMS($msg,$no)
{
	exit();
	$SMSoriginator=siteConfig('SMS_originator');
	$SMSusername = siteConfig('SMS_username');
	$SMSpassword = siteConfig('SMS_password');
    
	require_once __DIR__.'/3rdparty/Whatsapp/whatsprot.class.php';
    $username = $SMSusername; 
    $password = $SMSpassword;
     
    $w = new WhatsProt($username, $SMSoriginator, false); 
    $w->connect();
    $w->loginWithPassword($password);
  
    $target = '90'.str_replace(array('-',''),'',$no); //Target Phone,reciever phone
    $message = $msg;
     
   // $w->SendPresenceSubscription($target);
	$w->sendMessage($target,$message );
	while ($w->pollMessage());
	//while($w->pollMessage());
	 return $result; 
}
?>