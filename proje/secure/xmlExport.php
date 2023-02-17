<?
$disablehelp = 0;
$userGroupFirstID = (int)hq("select ID from userGroups Order by ID desc limit 0,1");
$xmlArray = array(
	'Shopphp' => array(code=>'shopphp','url'=>'xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.$serial),0,10),'info'=>'<hr />* &username=KULLANICI_ADI&password=SIFRE ekleyip bayi gruba özel XML çıktı alabilirsiniz. Örnek Kullanım : <br /><nobr><strong>https://'.$_SERVER['HTTP_HOST'].$siteDizini.'xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.$serial),0,10).'&username=KULLANICI_ADI&password=SIFRE</strong></nobr><hr />
	<br>* URL adresine &start=0&limit=100 ekleyerek row için başlangıç değeri ve row sayısı verebilirsiniz. Örnek Kullanım : <br /><nobr><strong>https://'.$_SERVER['HTTP_HOST'].$siteDizini.'xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.$serial),0,10).'&start=0&limit=100</strong></nobr>
	<br /><nobr><strong>https://'.$_SERVER['HTTP_HOST'].$siteDizini.'xml.php?c=shopphp&xmlc='.substr(md5('shopphp'.$serial),0,10).'&start=100&limit=100<br />...</strong></nobr>'),
	'Alternatif' => array(code=>'alter','url'=>'xml.php?c=alter&xmlc='.substr(md5('alter'.$serial),0,10)),    
	'RSS' => array(code=>'rss','url'=>'xml.php?c=rss&xmlc='.substr(md5('rss'.$serial),0,10)),
	'Google Sitemap'=>array(code=>'google','url'=>'sitemap.xml',info=>'<br/>* Aktif servis her 3 saatte bir Google\'a otomaik submit edilir.<br/>* Sitemap XML servisini bölmek için sitemap.xml yerine <br /><br />sitemap_&lt;Başlanıç Ürün&gt;_&lt;Toplam Ürün&gt;.xml<br /><br /> gibi kullanabilirsiniz. Örneğin sitemap_0_100.xml 0. üründen başlayarak 100 adet ürün getirir.'),
	'Google Image Map'=>array(code=>'googleimage','url'=>'imagemap.xml'),
	'Google Merchant'=>array(code=>'googlemerchant','url'=>'xml.php?c=googlemerchant&xmlc='.substr(md5('googlemerchant'.$serial),0,10),'info'=>'<br /><br />Tam entegrasyon için kategorilere Google Merchant Kategori karşılığının dolduruması gerekir.'),
	'Akakçe'=>array(code=>'akakce','url'=>'xml.php?c=akakce&xmlc='.substr(md5('akakce'.$serial),0,10)),
	'Bayi Cepte'=>array(code=>'bayicepte','url'=>'xml.php?c=bayicepte&xmlc='.substr(md5('bayicepte'.$serial),0,10)),
	'Çiçek Sepeti'=>array(code=>'ciceksepeti','url'=>'xml.php?c=ciceksepeti&xmlc='.substr(md5('ciceksepeti'.$serial),0,10)),
	'Facebok Product RSS'=>array(code=>'facebookproduct','url'=>'xml.php?c=facebookproduct&xmlc='.substr(md5('facebookproduct'.$serial),0,10),'info'=>'<br /><br />Tam entegrasyon için kategorilere Google Merchant Kategori karşılığının dolduruması gerekir.'),
	'Yandex Market'=>array(code=>'yandexmarket','url'=>'xml.php?c=yandexmarket&xmlc='.substr(md5('yandexmarket'.$serial),0,10)),
	'Cimri' => array(code=>'cimri','url'=>'xml.php?c=cimri&xmlc='.substr(md5('cimri'.$serial),0,10)),
	'Fırsat bu Fırsat' => array(code=>'fbf','url'=>'xml.php?c=fbf&xmlc='.substr(md5('fbf'.$serial),0,10)),
	'Hızlı Al' => array(code=>'hizlial','url'=>'xml.php?c=hizlial&xmlc='.substr(md5('hizlial'.$serial),0,10)),
	'HepsiBurada XML' => array(code=>'hb','url'=>'xml.php?c=hb&xmlc='.substr(md5('hb'.$serial),0,10)),
	'N11' => array(code=>'n11','url'=>'xml.php?c=n11&xmlc='.substr(md5('n11'.$serial),0,10)),
	'PTTAvm' => array(code=>'pttavm','url'=>'xml.php?c=pttavm&xmlc='.substr(md5('pttavm'.$serial),0,10)),
	'Sanal Pazar' => array(code=>'sanalpazar','url'=>'xml.php?c=sanalpazar&xmlc='.substr(md5('sanalpazar'.$serial),0,10)),
	'StockMount' => array(code=>'stockmount','url'=>'xml.php?c=stockmount&xmlc='.substr(md5('stockmount'.$serial),0,10)),
	'Ne Kadar' => array(code=>'nekadar','url'=>'xml.php?c=nekadar&xmlc='.substr(md5('nekadar'.$serial),0,10)),	
	'Tüm Fırsatlar' => array(code=>'tf','url'=>'xml.php?c=tf&xmlc='.substr(md5('tf'.$serial),0,10)),
	'Bilio (Ucuzu)' => array(code=>'ucuzcu','url'=>'xml.php?c=ucuzcu&xmlc='.substr(md5('ucuzcu'.$serial),0,10)),
	'Gelir Ortakları' => array(code=>'go','url'=>'xml.php?c=go&xmlc='.substr(md5('go'.$serial),0,10)),
	'Siparişler' => array(code=>'siparisler','url'=>'xml.php?c=siparisler&xmlc='.substr(md5('siparisler'.$serial),0,10)),
	'Siparişler (BirFatura)' => array(code=>'birfaturasiparisler','url'=>'xml.php?c=birfaturasiparisler&xmlc='.substr(md5('birfaturasiparisler'.$serial),0,10)),
	'Siparişler (Entegra)' => array(code=>'entegrasiparisler','url'=>'xml.php?c=entegrasiparisler&xmlc='.substr(md5('entegrasiparisler'.$serial),0,10)),
	'Siparişler (Logo)' => array(code=>'automSiparisLogo','url'=>'xml.php?c=automSiparisLogo&xmlc='.substr(md5('automSiparisLogo'.$serial),0,10)),
	'Yurtici Kargo Siparişler' => array(code=>'yurticikargosiparisler','url'=>'xml.php?c=yurticikargosiparisler&xmlc='.substr(md5('yurticikargosiparisler'.$serial),0,10)),
	'Kullanıcı Listesi' => array(code=>'kullanicilar','url'=>'xml.php?c=kullanicilar&xmlc='.substr(md5('kullanicilar'.$serial),0,10)),	
	'HepsiBurada <strong>Excel</strong>' => array(code=>'hb-excel','url'=>'xml.php?c=hb-excel&xmlc='.substr(md5('hb-excel'.$serial),0,10)),
	//'Trendyol <strong>Excel</strong>' => array(code=>'trendyol-excel','url'=>'xml.php?c=trendyol-excel&xmlc='.substr(md5('trendyol-excel'.$serial),0,10)),
	'Ürün Varyasyon Listesi <strong>Excel</strong>' => array(code=>'urun-var','url'=>'secure/excelProductVar.php'),
	'Bayi Grubu Ürün Listesi <strong>Excel</strong>'  => array(code=>'bayi','url'=>'secure/excelUserGroup.php?userGroupID='.$userGroupFirstID,'info'=>'<hr />* userGroupID=&lt;Bayi Grubu ID&gt; ekleyip bayi gruba özel ürün excel listesi alabilirsiniz. Örnek ID '.$userGroupFirstID.' olan Bayi Grubu için Kullanım : <br /><nobr><strong>https://'.$_SERVER['HTTP_HOST'].$siteDizini.'secure/excelUserGroup.php?userGroupID='.$userGroupFirstID.'</strong>'),
);
$dbase='xmlexport';
$title = 'XML Servis Ayarları';
$listTitle = 'XML Servisleri';
$ozellikler = array(ekle=>'0', 
					baseid=>'ID',
					orderby=>'ID',
					listDisabled => true,
					listBackMsg => 'Kaydedildi',
					updateDisabled =>true,
					insertDisabled =>true,
					editID=>1,
					);

if($_POST['ID'] && $_POST['y'] == 'du')
{
	my_mysql_query("update xmlexport set status = 0");	
}
$icerik[] = array(isim=>'XML Çıktı Cache Süresi / Saniye<br />(3600 = 1 saat)',
					  db=>'xml_cache',
					  stil=>'normaltext',
					  gerekli=>'0');
if(isset($_POST['xml_cache']))
{
	autoAddFormField('siteConfig','xml_cache','TEXTBOX');
	$siteConfig['xml_cache'] = (int)$_POST['xml_cache'];
	my_mysql_query("update siteConfig set xml_cache = '".(int)$_POST['xml_cache']."' where ID = 1");
}
$lang = getLangArr();
unset($lang['tr']);
foreach($xmlArray as $k=>$v)
{
	$showSPError = 1;
	if($_POST[$v[code]])
	{
		my_mysql_query("update xmlexport set status = 1 where code like '".$v[code]."'");
		if(!my_mysql_affected_rows())
			my_mysql_query("insert into xmlexport (ID,code,status) VALUES (0,'".$v[code]."',1)");			
	}
	$checked = hq("select status from xmlexport where code like '".$v[code]."'");
	$url = '<a href="http://'.$_SERVER['HTTP_HOST'].$siteDizini.$v['url'].'" target="_blank">http://'.$_SERVER['HTTP_HOST'].$siteDizini.$v['url'].'</a>';
	foreach($lang as $kx=>$vx)
	{
		$url.='<br />'.'<a href="http://'.$_SERVER['HTTP_HOST'].$siteDizini.'ln-'.$kx.'/'.$v['url'].'" target="_blank">http://'.$_SERVER['HTTP_HOST'].$siteDizini.'ln-'.$kx.'/'.$v['url'].'</a> - ('.$vx.')';
	}

	$icerik[] = array(isim=>$k,
					  db=>$v['code'],
					  stil=>'checkbox',
					  info => $url
					  	.($checked?"<script>$('#".$v[code]."').attr('checked','checked');</script>":"").$v['info'],
					  gerekli=>'0');	
}
if ($_GET['code'] == 'XML_Shopphp') 
	$tempInfo.= adminInfov3('http://'.$_SERVER['HTTP_HOST'].$siteDizini.'xml.php?c='.strtolower(str_replace('XML_','',$_GET['code'])).'&username=KULLANICIADI&password=SIFRE<br>adresi ile bayileriniz kendilerine özel tanımlanan fiyatlar ile XML çekimi yapabilir.');
echo adminv3($dbase,$where,$icerik,$ozellikler);
?>
<script type="text/javascript">
	$('#xml_cache').val('<?=siteConfig('xml_cache')?>');
	$('#bayi,#urun-var').attr('checked','checked');
</script>