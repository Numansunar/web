<?
$orandStr = $_SESSION['randStr'];
function googleOdeme()
{
	global $tamamlandi,$orandStr,$siteConfig;
	if($_GET['op'] == 'odeme' && $tamamlandi)	
	{
		$qSiparis = my_mysql_query("select * from siparis where randStr = '".$orandStr."'");
		$dSiparis = my_mysql_fetch_array($qSiparis);
				
		$sehir = hq('select name from iller where plakaID=\''.$dSiparis['city'].'\' ');
		$semt = hq('select name from ilceler where ID=\''.$dSiparis['semt'].'\' ');
		
		if(siteConfig('googleMerchantID'))
			$gtin = array();
		$q = my_mysql_query("select sepet.*,kategori.name catName from urun,kategori,sepet where urun.ID = sepet.urunID AND urun.catID = kategori.ID AND sepet.randStr like '$orandStr'");
		while($d = my_mysql_fetch_array($q))
		{
			$gaq_push.='_gaq.push([\'_addItem\',
			\''.$orandStr.'\', // transaction ID - required
			\''.$d['urunID'].'\', // SKU/code - required
			\''.$d['urunName'].'\', // product name
			\''.$d['catName'].'\', // category or variation
			\''.$d['ytlFiyat'].'\', // unit price - required
			\''.$d['adet'].'\' // quantity - required
			]);'."\n";	
			
			if(siteConfig('googleMerchantID'))
			{
				$urunKargoGun = hq("select kargoGun from urun where ID='".$d['urunID']."'");
				$urunGtin = hq("select gtin from urun where ID='".$d['urunID']."'");
				if($urunGtin)
					$gtin[] = '{"gtin":"GTIN1"}';
				if((int)$kargoGun < (int)$urunKargoGun)
					$kargoGun = $urunKargoGun;
			}
		}
		
		if(siteConfig('javaScript'))
			$out = '<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push([\'_setAccount\', \''.siteConfig('javaScript').'\']);
			_gaq.push([\'_trackPageview\']);
			_gaq.push([\'_addTrans\',
			\''.$orandStr.'\', // transaction ID - required
			\''.$orandStr.' Nolu Siparis Odemesi\', // affiliation or store name
			\''.basketInfo('toplamKDVHaric',$orandStr).'\', // total - required
			\''.basketInfo('toplamKDV',$orandStr).'\', // tax
			\''.basketInfo('kargo',$orandStr).'\', // shipping
			\''.$semt.'\', // city
			\''.$sehir.'\', // state or province
			\'Turkiye\' // country
			]);
			
			// add item might be called for every item in the shopping cart
			// where your ecommerce engine loops through each item in the cart and
			// prints out _addItem for each
			'.$gaq_push.'
			_gaq.push([\'_trackTrans\']); //submits transaction to the Analytics servers
			
			(function() {
			var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
			ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
			var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
			})();
			
			</script>';	
		list($tarih) = explode(' ',$dSiparis['tarih']);
		if(siteConfig('googleMerchantID'))
			$out.='<script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>
					<script>
					  window.renderOptIn = function() {
						window.gapi.load("surveyoptin", function() {
						  window.gapi.surveyoptin.render(
							{
							  // REQUIRED FIELDS
							  "merchant_id": '.siteConfig('googleMerchantID').',
							  "order_id": "'.$orandStr.'",
							  "email": "'.$dSiparis['email'].'",
							  "delivery_country": "TR",
							  "estimated_delivery_date": "'.$tarih.'",
					
							  // OPTIONAL FIELDS
							  '.(sizeof($gtin) > 0?'"products": ['.implode(',',$gtin):'').'
							});
						});
					  }
					</script>';
		return $out;
	}
}


function googleSepetList()
{
	global $orandStr;
	$out = '';
	$q = my_mysql_query("select urunID from sepet where randStr like '".$orandStr."'");
	while($d = my_mysql_fetch_array($q))
	{
		$out.='"'.$d['urunID'].'",';
	}
	if($out) return substr($out,0,-1);	
}

function googledynr()
{
	global $tamamlandi,$orandStr;
	if(!siteConfig('googledynr'))
		return;
	$out = "<script async src='https://www.googletagmanager.com/gtag/js?id=".siteConfig('googledynr')."'></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', '".siteConfig('googledynr')."');
			</script>";
	if($tamamlandi)
	{
		$out.= "<script>
		gtag('event', 'purchase', {
		  'send_to': '".siteConfig('googledynr')."',
		  'ecomm_pagetype': 'purchase',
		  'ecomm_prodid': '".$orandStr."',
		  'ecomm_totalvalue': '".basketInfo('ModulFarkiIle',$orandStr)."'
		});
	  </script>
	  ";
	}
	else
	{
		switch($_GET['act'])
		{
			case '':
				$out.="<script>
				gtag('event', 'page_view', {
					'send_to': '".siteConfig('googledynr')."',
					'ecomm_pagetype': 'home'
				  });
				</script>";
			break;

			case 'urunDetay':
				$out.= "<script>
					gtag('event', 'view_item', {
					'send_to': '".siteConfig('googledynr')."',
					'ecomm_pagetype': 'product',
					'ecomm_prodid': '".(int)$_GET['urunID']."',
					'ecomm_totalvalue': '".ytlFiyat(urun('fiyat'),urun('fiyatBirim'))."'
					});
				</script>
				";
			break;
			case 'kategoriGoster':
				$out.= "<script>
					gtag('event', 'page_view, {
					'send_to': '".siteConfig('googledynr')."',
					'ecomm_pagetype': 'category',
					'ecomm_category': '".addslashes(kat('name'))."'
					});
				</script>
				";
			break;
			case 'sepet':
			case 'satinal':
				$out.= "<script>
					gtag('event', 'add_to_cart', {
					'send_to': '".siteConfig('googledynr')."',
					'ecomm_pagetype': 'cart',
					'ecomm_prodid': '".googleSepetList()."',
					'ecomm_totalvalue': '".basketInfo('ModulFarkiIle',$orandStr)."'
					});
				</script>
				";
			break;
		}
	}
	return $out;
}

function googleReconversion()
{
	global $orandStr,$tamamlandi;
	if(siteConfig('googleCustomerReviewsBadge') && siteConfig('googleMerchantID') && $tamamlandi)
	{
		$out = '<script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>
				<script>
				  window.renderBadge = function() {
					var ratingBadgeContainer = document.createElement("div");
					document.body.appendChild(ratingBadgeContainer);
					window.gapi.load("ratingbadge", function() {
					  window.gapi.ratingbadge.render(ratingBadgeContainer, {"merchant_id": '.siteConfig('googleMerchantID').'});
					});
				  }
				</script>
<script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>
<script>
window.renderOptIn = function() {
window.gapi.load("surveyoptin", function() {
window.gapi.surveyoptin.render(
{
"merchant_id": '.siteConfig('googleMerchantID').',
"order_id": "'.$orandStr.'>",
"email": "'.hq("select email from siparis where randStr = '$orandStr'").'",
"delivery_country": "Turkey",
"estimated_delivery_date": "'.date('Y-m-d',strtotime('+'.(int)$setting['est_ship_days'].' days')).'"
});
});
}
</script>
				
				
				';	
	}
	if(!siteConfig('google_conversion_id'))
		return $out;
	$pt[''] = 'home';
	$pt['urunDetay'] = 'product';
	$pt['kategoriGoster'] = 'category';
	$pt['arama'] = 'searchresults';
	$pt['sepet'] = 'cart';
	$pt['satinal'] = 'purchase';
	$act = (string)$_GET['act'];
	
	$page = $pt[$act];
	if(!$page) $page='other';
	
	switch($_GET['act'])
	{
		case 'urunDetay':
			$pID = '"'.$_GET['urunID'].'"';
			$total = hq("select fiyat from urun where ID='".$_GET['urunID']."'");
		break;
		case 'sepet':
		case 'satinal':
			$pID = googleSepetList();
			$total = basketInfo('ModulFarkiIle',$orandStr);
		break;
		case 'kategoriGoster':
			$pID = '';
			$total = '0';
		break;	
		case 'arama':
			$pID = "'".addslashes($_GET['str'])."'";
			$total = '0';
		break;	
		default:
			$pID = '';
			$total = '0';
		break;	
	}
	
	$_SESSION['googleConversion'] =
		$out.='<script type="text/javascript"> 
				var google_tag_params = { 
				ecomm_prodid: ['.$pID.'], 
				ecomm_pagetype: \''.$page.'\', 
				ecomm_totalvalue: '.(float)$total.' 
				}; 
				</script> 
				<script type="text/javascript"> 
				/* <![CDATA[ */ 
				var google_conversion_id = '.siteConfig('google_conversion_id').'; 
				var google_custom_params = window.google_tag_params; 
				var google_remarketing_only = true; 
				/* ]]> */
				</script> 
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"> 
				</script> 
				<noscript> 
				<div style="display:inline;"> 
				<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/'.siteConfig('google_conversion_id').'/?value=0&amp;guid=ON&amp;script=0"/> 
				</div> 
				</noscript> ';	
	return $out;
}
?>