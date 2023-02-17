<?php 
@set_time_limit(0);
include('include/all.php');
include('include/xmlExport.php');

// Hata Gösterimi - Yazılım Geliştirme
//error_reporting(E_ALL);
if($_GET['clean'])
	cleancache();
function piyasalarUpdate($doviz) {	
	global $siteConfig;
	$url = 'http://www.shopphp.net/doviz.php?d='.$doviz.'&t='.siteConfig('dovizType');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

$out = '';
function updateCheck() 
{
	global $out;
	$out.= (Sepet::sepetZamanAsimiKontrol()?'Sepet zaman aşımı kontrolü çalıştırıldı.<br />':'');
	global $siteConfig;
	$check = mktime((date('H') - 3),date('i'),date('s'),date('m'),date('d'),date('Y'));

	$dateConfig = strtotime(siteConfig('crontabLastUpdate'));
	$out.= "Son Cron-job çalışma zamanı : ".(siteConfig('crontabLastUpdate'))."<br />";
	return ($check>$dateConfig);
}
if (siteConfig('cacheSuresi') >= 3)
{
	$check = date('Y-m-d H:i:s',mktime(date('H'),date('i'),(date('s') - 3600),date('m'),date('d'),date('Y')));
	my_mysql_query("delete from cache where tarih < '$check'");

}


if (siteConfig('cacheSuresi') == 1)
{
	for($i=0;$i<=10;$i++)
	{
		$dirArray = scandir('cache/'.$i.'/');
		foreach($dirArray as $v)
		{
			$v = 'cache/'.$i.'/'.$v;
			if((time() - 3600) > filemtime($v))
			{			
				if (stristr($v,'index') === false)
				{
					$out.= "cache dizininden $v silindi.<br>";
					unlink($v);
				}
			}		 
		}
	}
}

if (updateCheck() || $_GET['up']) 
{


	$check = date('Y-m-d H:i:s',mktime(date('H'),date('i'),(date('s')),(date('m') - 1),date('d'),date('Y')));
	my_mysql_query("delete from adminlog where tarih < '$check'");
	my_mysql_query("ALTER TABLE adminlog AUTO_INCREMENT = ".hq("select (ID + 1) from adminlog order by ID desc limit 0,1"));
	my_mysql_query('update siteConfig set crontabLastUpdate = \''.(date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')))).'\'');

	if(function_exists('autoUpdateDownload'))	
		$out.=autoUpdateDownload();
			
	clearStats();
	if (siteConfig('updateDoviz')) {
		$doviz = array();
		$doviz['USD'] = piyasalarUpdate('Dolar');
		$doviz['EUR'] = piyasalarUpdate('Euro');
		
		if ((int)$doviz['USD'] >= 5 && (int)$doviz['EUR'] >= 6) 
		{
			$bArray = array('Dolar'=>'USD','Euro'=>'EUR','GBP'=>'GBP','CHF'=>'CHF');
			foreach($bArray as $k=>$v)
			{
				if(!$doviz[$v])
					$doviz[$v] = piyasalarUpdate($k);
				my_mysql_query("update fiyatbirim set value='".$doviz[$v]."' where code like '".$v."'");
				if(my_mysql_affected_rows())
				{
					foreach($pazarArray as $p)
					{
						my_mysql_query("update urun set $p = 1 where fiyatBirim = '".$v."'");
					}
					

				}
					
			}

		}
	}

	$q = my_mysql_query("select * from urun where altin = 1");
	while($vd = my_mysql_fetch_array($q))
	{
		$gram = $vd['altin_gram'];
		$ayar = $vd['altin_ayar'];
		$iscilik = $vd['altin_iscilik'];
		$kar = $vd['altin_kar'];

		$ngram = (($gram * $ayar) + ($gram * $iscilik) + ($gram * $kar));
		$tas = ytlFiyat($vd['altin_tas'],'USD');
		$fiyat = ($tas + ($ngram * hq("select value from fiyatbirim where code like 'HAS' OR code like 'HA'")));
		my_mysql_query("update urun set fiyat = '$fiyat' where ID='".$vd['ID']."'");
	}

	unlink('include/mod_Upload.php');
	unlink('include/mod_Kase.php');

	$q = my_mysql_query("select urunID from pazaryeri where hata = 1 AND DATE(tarih) < DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
	while($d = my_mysql_fetch_array($q))
	{
		my_mysql_query("update urun set pazok = 1 where ID='".$d['urunID']."'");
		$t++;
	}
	$out .= ('Toplam <strong>'.(int)$t.'</strong> ürün cron servisine eklendi. Ürünler sıası ile tekrar gönderilecek. Hata alınmaması durumunda log bu listede güncellenecektir.<br />');
	
	
	$path = 'secure/bayiXML/';
	if ($handle = opendir($path)) {
	   while (false !== ($file = readdir($handle))) {
		  if ((time()-filectime($path.$file)) > (60 * 60 * 24 * 3)) {  
			unlink($path.$file);
		  }
	   }
	 }

	if(hq("select ID from otopromosyon limit 0,1"))
	{
		$gun1 = hq("select gun from otopromosyon order by gun asc limit 0,1");
		$gun2 = hq("select gun from otopromosyon order by son desc limit 0,1");

		$q = my_mysql_query("select randStr from siparis where datediff(CURDATE(), tarih) > ".(int)$gun1." AND datediff(CURDATE(), tarih) < ".(int)$gun2." AND otopromosyon = 0 AND durum > 2 AND durum < 90");
		while($d = my_mysql_fetch_array($q))
		{
			$out.=otoPromosyon($d['randStr']);
		}
	}

	if(siteConfig('sepetteslimform'))
	{
		$q = my_mysql_query("select * from siparis where randStr not like '%-%' AND durum = 81 AND yorum = '' AND tarih > '".date("Y-m-d",mktime(0, 0, 0, date("m"),date("d")-14,date("Y")))."' AND tarih < '".date("Y-m-d",mktime(0, 0, 0, date("m"),date("d")-2,date("Y")))."' group by randStr");
		while($d = my_mysql_fetch_array($q))
		{
			$sepet = new Sepet($d['randStr']);
			$sepet->sepetInfoMail($d,'Sepet_Puan');
			my_mysql_query("update siparis set yorum = 'Ürün yorum e-postası gönderildi.' where ID='".$d['ID']."'");
			$out.=$d['randStr'].' numaralı sipariş için ürün değelendirme e-postası gönderildi.<br />';
		}
	}
		
	my_mysql_query("delete from siparis where koruma != 1 AND durum = 0 AND tarih != '0000-00-00' AND tarih < '".date("Y-m-d",mktime(0, 0, 0, date("m"),date("d")-15,date("Y")))."'");
	$out.=max(0,my_mysql_affected_rows()).' tamamlanmamış sipariş bilgisi,3 günü geçtiği, koruma olmadığı ve zaman aşımına uğradığı için silindi.<br />';
	my_mysql_query("delete from sepet,siparis where siparis.randStr = sepet.randStr AND siparis.koruma != 1 AND siparis.durum = 0 AND sepet.tarih != '0000-00-00' AND sepet.tarih < '".date("Y-m-d",mktime(0, 0, 0, date("m"),date("d")-15,date("Y")))."'");
	$out.=max(0,my_mysql_affected_rows()).' tamamlanmamış sepet bilgisi,3 günü geçtiği, koruma olmadığı ve zaman aşımına uğradığı için silindi.<br />';
	my_mysql_query("delete from userLog where `date` < '".date("Y-m-d",mktime(0, 0, 0, date("m"),date("d")-30,date("Y")))."'");	
	my_mysql_query("delete from adminlog where `tarih` < '".date("Y-m-d",mktime(0, 0, 0, date("m"),date("d"),(date("Y") - 1)))."'");		
	my_mysql_query("delete from epostalog where to like '' OR subject like '' OR  subject like '%mail order%' OR `tarih` < '".date("Y-m-d",mktime(0, 0, 0, date("m"),date("d")-120,date("Y")))."'");
	$out.=max(0,my_mysql_affected_rows()).' eposta log 120 günü geçtiği için silindi.<br />';

	my_mysql_query("ALTER TABLE siparis AUTO_INCREMENT = ".hq("select (ID + 1) from siparis order by ID desc limit 0,1"));
	my_mysql_query("ALTER TABLE sepet AUTO_INCREMENT = ".hq("select (ID + 1) from sepet order by ID desc limit 0,1"));
	my_mysql_query("ALTER TABLE userLog AUTO_INCREMENT = ".hq("select (ID + 1) from userLog order by ID desc limit 0,1"));
	my_mysql_query("ALTER TABLE adminlog AUTO_INCREMENT = ".hq("select (ID + 1) from adminlog order by ID desc limit 0,1"));
	my_mysql_query("ALTER TABLE epostalog AUTO_INCREMENT = ".hq("select (ID + 1) from epostalog order by ID desc limit 0,1"));


	spEmail::progressQueue();
	$out.='Bekleyen e-postalar gönderildi.<br />';
	spEmail::checkForUserDays('birthdate','automail_BirthDay','Dogum_Gunu');
	$out.='Bekleyen, doğum günü tebrik e-postaları gönderildi.<br />';

	$q = my_mysql_query("select * from siparis where tekrarlaAktif=1 AND takrarSure > 0");
	while($d = my_mysql_fetch_array($q))
	{
		list($rd) = explode(' ',$d['tarih']);
		list($y,$m,$d) = explode('-',$rd);
		$dateSQL = date('Y-m-d', mktime(0, 0, 0, $m, $d , $y));
		$dateCheck = date('Y-m-d', mktime(0, 0, 0, $m, ($d + ((int)$d['tekrarSure'])) , $y));
		$dateNow = date('Y-m-d');
		if(strtotime($dateNow) >= strtotime($dateCheck))
		{
			$out.= Sepet::autoreOrder($d['randStr']);
			my_mysql_query("update siparis set tekrarAktif =0 where randStr like '".$d['randStr']."'");
			$out.=$d['randStr'].' nolu sipariş tekrarlandı.<br />';
		}
	}
	$out .= 'Güncellenen Dolar Kuru : '.$doviz['USD'].'<br/>';
	$out .= 'Güncellenen Euro Kuru : '.$doviz['EUR'].'<br/>';
	$out .= 'Güncellenen GBP Kuru : '.$doviz['GBP'].'<br/>';

	$url = 'https://www.shopphp.net/xml.php';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	$xmlFile = curl_exec($ch);
	curl_close($ch);

	if($xmlFile)
	{
		my_mysql_query("update temp set text= '' where code like 'news\\_%'");		
		$xml = new SimpleXMLElement($xmlFile);
		foreach($xml->news as $news)
		{
			$out.= "Haber kodu : news_".$news->ID." (".$news->title.") kontrol edildi.<br>";
			tempUpdate('news_'.$news->ID,'<'.'?xml version="1.0" encoding="UTF-8"?'.'><newscontent>'.$news->asXML().'</newscontent>');
		}
		my_mysql_query("delete from temp where text='' AND code like 'news\\_%'");
	}
	$domainURL = $_SERVER['HTTP_HOST'];
	$pr = new GooglePageRankChecker();
	$google_pageRank = $pr->getRank($domainURL);
	set_stats('pagerank',$google_pageRank);
	$out.= "Google Page Rank : $google_pageRank<br/>";

	$indexedPages = getGoogleCount($domainURL,'site');
	set_stats('indexedpages',$indexedPages);
	$out.= "Google Indexed Pages : $indexedPages<br/>";
	
	$indexedPages = getGoogleCount($domainURL,'link');
	set_stats('backlink',$indexedPages);
	$out.= "Google Backlink : $indexedPages<br/>";
	
	$tweetMention = getTweetCount($domainURL);
	set_stats('tweetmention',$tweetMention);
	$out.= "Tweet Mention : $tweetMention<br/>";
	
	$url = 'https://www.shopphp.net/ip.php';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	$result = curl_exec($ch);
	curl_close($ch);

	set_stats('outIP',$result);
	$out.= "Server Out IP : $result<br/>";	
	
	$url = 'https://www.shopphp.net/gelecek.txt';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	$result = curl_exec($ch);
	curl_close($ch);

	list($surum,$oran) = explode('|',$result);
	set_stats('gelecek_surum',$surum);
	set_stats('gelecek_oran',$oran);
	$out.= "Gelecek Sürüm : $surum, %$oran<br/>";	
	/*
	$q = my_mysql_query("select ID from user where s_adet= ''");
	while($d = my_mysql_fetch_array($q))
	{
		updateUserOrderDB($d['ID']);	
	}
	$out.= "Kullanıcı sipariş sayıları güncellendi.<br />";
	*/
	$out.= "Update Tamamlandı.";



	if($_SESSION['admin_isAdmin'])
	echo '<html>
		<head>
		<link rel="stylesheet" href="css/cron.css" />
		</head>
		<body>
		<div id="cron-log">
			<h1>Cron-Job Log</h1>
			<hr />
			'.$out.'</div>
		</body>
		</html>';
	else
		echo "Cron-Job başarıyla çalıştı.";
}
