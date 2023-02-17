<?
function spRichSnippets($d)
{
	if(!siteConfig('google_snippets'))
		return;
	global $siteDizini;
	
	switch($_GET['act'])
	{
		case 'urunDetay':
			$ratingValue = ($d['puan']?$d['puan']:rand(4,5));
			if(!$d['reviewCount'])
				$reviewCount = max(1,(int)hq("select count(ID) from urunYorum where tip=0 AND urunID='".$d['ID']."' AND onay=1"));
			else
				$reviewCount = $d['reviewCount'];
			$markaResim = hq("select resim from marka where ID='".$d['markaID']."'");
			$out.= '<script type="application/ld+json">
			{
				  "@context": "http://schema.org/",
				  "@type": "Product",
				  "name": "'.$d['name'].'",
				  "image": "'.'https://'.$_SERVER[HTTP_HOST].$siteDizini.'images/urunler/'.$d['resim'].'",
				  "description": "'.str_replace(array('"',"\n","\r"),' ',trim(strip_tags($d['detay']))).'",
				  "mpn": "'.$d['ID'].'",
				  "sku": "'.($d['tedarikciCode']?$d['tedarikciCode']:$d['ID']).'",
				  "brand": {
					"@type": "Thing",
					"name": "'.addslashes(hq("select name from marka where ID='".$d['markaID']."'")).'"
					'.($markaResim?',"image":"https://'.$_SERVER[HTTP_HOST].$siteDizini.'images/markalar/'.$markaResim.'"':'').'
				  },
				  '.(hq("select count(ID) from urunYorum where tip=0 AND urunID='".$d['ID']."' AND onay=1") || $reviewCount?'
				  "aggregateRating": {
					"@type": "AggregateRating",
					"ratingValue": "'.$ratingValue.'",
					"reviewCount": "'.$reviewCount.'",
					"bestRating": "5",
					"worstRating": "1"
				  },':'').'
				  "offers": {
					"@type": "Offer",
					"url":"https://'.$_SERVER['HTTP_HOST'].$siteDizini.urunLink($d).'",
					"priceCurrency": "'.str_replace(array('TL','YTL'),'TRY',$d['fiyatBirim']).'",
					"priceValidUntil" : "'.date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d') + 7,date('Y'))).'",
					"price": "'.$d['fiyat'].'",
					"itemCondition": "http://schema.org/NewCondition",
					"availability": "http://schema.org/'.($d['stok']?'InStock':'SoldOut').'",
					"seller": {
					  "@type": "Organization",
					  "name": "'.str_replace('"',"'",siteConfig('seo_title')).'"
							  }
							},
				"review": [';
			$i=0;
			$q2 = my_mysql_query("SELECT puan,aciklama,tarih,name FROM urunYorum where tip=0 AND urunID=".$_GET['urunID']." AND onay=1 order by ID desc");
			while ($d2=my_mysql_fetch_array($q2)) {
			$out.='{';
			$out.='"@type": "Review",';
			$out.='"reviewRating": {"@type": "Rating",';
			$out.='"bestRating": "5",';
			$out.='"ratingValue": "'.$d2['puan'].'",';
			$out.='"worstRating": "1"},';
			$out.='"description": "'.$d2['aciklama'].'",';
			$out.='"author": {"@type": "Person","name": "'.$d2['name'].'"},';
			$rebody=substr($d2['aciklama'], 0, 30);
			$out.='"reviewBody": "'.$rebody.'"';
			$out.='}';
			$i++;
			if($i < $reviewCount)
			$out.=',';
			else
			$out.='';
			
		}
		$out.=']';
		$out.='}';
		$out.='</script>';

			$yorumsayisi = hq("select count(ID) from urunYorum where tip=0 AND urunID='".$d['ID']."' AND onay=1");
			if($yorumsayisi != 0)
			$out.='';
			else
			$out.='<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
					<meta itemprop="ratingValue" content="5">
					<meta itemprop="bestRating" content="5">
					</span>';
		return $out;
			break;
		case "kategoriGoster":
		return '<script ype=\'application/ld+json\'> 
		{ 
					"@context":"https://schema.org", 
					"@type":"WebSite", 
					"@id": "'.kategoriLink($d).'"
					"url":"https://'.$_SERVER[HTTP_HOST].$siteDizini.kategoriLink($d).'", 
					"name":"'.$d['name'].'"
					, 
					"aggregateRating": 
					{ 
					"@type": "AggregateRating", 
					"ratingValue": "5", 
					"reviewCount": "5" 
					} 
					} 
					</script> 
				';	
		break;
		case "listArticles":
		case "showArticles":
		case "showBlog":
		case "blog":
		case "makale":
			if($_GET['ID'])			
				return '<script type="application/ld+json">
						{
						  "@context": "http://schema.org",
						  "@type": "NewsArticle",
						  "mainEntityOfPage": {
							"@type": "WebPage",
							"@id": "https://'.$_SERVER[HTTP_HOST].$siteDizini.makaleLink($d).'"
						  },
						  "headline": "'.$d['Baslik'].'",
						  "image": "'.'https://'.$_SERVER[HTTP_HOST].$siteDizini.'images/makaleler/'.$d['Resim'].'",
						  "datePublished": "'.$d['Tarih'].'",
						  "dateModified": "'.$d['Tarih'].'",
						  "author": {
							"@type": "Organization",
							"name": "'.siteConfig('firma_adi').'"
						  },
						   "publisher": {
							"@type": "Organization",
							"name": "'.siteConfig('firma_adi').'"
							'.(siteConfig('templateLogo')?'
							,"logo": {
							  "@type": "ImageObject",
							  "url": "https://'.$_SERVER['HTTP_HOST'].$siteDizini.'images/'.siteConfig('templateLogo').'"
							}':'').'
						  },
						  "description": "'.addslashes($d['Giris']).'"
						}
						</script>';	
			break;		
		break;
		}	
}

function searchRichSnippets()
{	
	if(!siteConfig('google_snippets') || !$_GET['str'])
		return;

	global $siteDizini;
	return '<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "WebSite",
	  "url": "https://'.$_SERVER['HTTP_HOST'].$siteDizini.'",
	  "potentialAction": {
		"@type": "SearchAction",
		"target": "http'.(siteConfig('httpsAktif')?'s':'').'://'.$_SERVER['HTTP_HOST'].$siteDizini.(siteConfig('seoURL')?'arama/'.urlencode($_GET['str']):'page.php?act=arama&str="'.urlencode($_GET['str']).'"').'",
		"query-input": "required name=search_term_string"
	  }
	}
	</script>';	
}
?>