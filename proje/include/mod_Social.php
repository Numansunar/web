<?
	function modSocial()
	{
		$cacheName= __FUNCTION__;
		$cache = cacheout($cacheName);
		if ($cachec)
			return $cache;
		$socialArray = array('facebook','twitter','youtube','instagram','google-plus','pinterest');
		$out ='
			<link rel="stylesheet" href="css/social/css/social-share-kit.css" type="text/css">
			<div class="ssk-group ssk-rounded">';
		foreach($socialArray as $s)
		{
			list($n) = explode('-',$s);
			$href = str_replace('http://','https://',siteConfig($n.'_URL'));
			if($href)
				$out.='<a target="_blank" href="'.$href.'" class="ssk ssk-'.$s.'"></a>'."\n";	
			else
				$out.=$n.' yok';
		}
		$out.='	</div>';
		return cachein($cacheName,$out);	
	}
?>