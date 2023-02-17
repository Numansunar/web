<?php
$ggForm =
	autoModalForm('gg', 'GittiGidiyor', 'mod_GittiGidiyor.php') .
	autoModalForm('n11', 'N11', 'mod_N11.php') .
	autoModalForm('ty', 'Trendyol', 'mod_Trendyol.php') .
	autoModalForm('hb', 'HepsiBurada', 'mod_HepsiBuradav2.php') .
	autoModalForm('amazon', 'Amazon', 'mod_Amazon.php') . '				
					<div id="gg-dialog-specs" class="modal-block modal-block-primary mfp-hide">
						<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">GittiGidiyor Kategori Varyasyonları</h2>
								</header>
								<div class="panel-body" id="gg-cat-specs">

								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button class="btn btn-default modal-dismiss">Kapat</button>
										</div>
									</div>
								</footer>
							</section>
                    </div>';
$ggForm .= "
<script>
	function loadGGSpecs()
	{
		if(!$('#gg_Kod').val())
		{
			alert('Önce GittiGidiyor kategorisini seçmelisiniz');
			return;	
		}
	  $.ajax({
	  url: 'ajax.php?act=ggCatSpecs&catID='+$('#gg_Kod').val()+'&r='+ Math.floor(Math.random()*99999),
	  success: function(data) 
			   {
				   $('#gg-cat-specs').html(data);
			   },
	  error: function (xhr, ajaxOptions, thrownError) {
        		alert('GittiGidiyor kategorileri varyasyonları çekilemedi. Lütfen giriş ayarlarınızı kontrol edin.');
      		 }
	  });	

	}
	
	function openGGSpecs()
	{
		 $.magnificPopup.open({
                items: {
                    src: '#gg-dialog-specs',
                },
				preloader: false,
				modal: false,
                type: 'inline'
            });
		loadGGSpecs();
		return;
	}
</script>
";
if (!hq("select count(*) from kategori where parentID='" . (int) $_GET['ID'] . "'")) {
	$pazarYeriGoster = true;
} else if ($_GET['y'] == 'd') {
	$tempInfo .= adminWarnv3('Bu kateogrinin alt kategorileri olduğundan, XML / API altındaki pazaryerleri kategori eşleştirme kısımları kapalıdır. Kategori eşleştirmelerini en alt seviye kategorilerde yapabilirsiniz.');
} else
	$pazarYeriGoster = true;

	$pazarYeriGoster = true;
	
$dbase = "kategori";
$title = 'Kategori Yönetimi';
$listTitle = 'Kategoriler';
$ozellikler = array(
	ekle => '1',
	baseid => 'ID',
	orderby => 'level,name',
	ordersort => 'asc',
	excelLoad => 1,
	allowCopy => 1,
	// moveParentCat=>1,
);

$icerik = array(
	array(
		isim => 'Meta Tag Keywords',
		disableFilter => true,
		unlist => true,
		multilang => true,
		maxlength => 320,
		intab => 'seo',
		db => 'metaKeywords',
		stil => 'normaltext'
	),
	array(
		isim => 'Meta Tag Description',
		disableFilter => true,
		unlist => true,
		maxlength => 320,
		multilang => true,
		intab => 'seo',
		db => 'metaDescription',
		stil => 'normaltext'
	),
	array(
		isim => 'Custom Tile (Opsiyonel)',
		disableFilter => true,
		unlist => true,
		multilang => true,
		maxlength => 70,
		intab => 'seo',
		db => 'customTitle',
		stil => 'normaltext'
	),
	/*
				array(isim=>'Custom CanonicalURL (Opsiyonel)',
					  disableFilter=>true,
					  unlist=>true,
					  multilang=>true,
					  maxlength=>70,
					  db=>'customCanonicalURL',
					  stil=>'normaltext',
					  gerekli=>'0'), 
	 */
	array(
		isim => 'Kategori Adı',
		db => 'name',
		multilang => true,
		zorunlu => 1,
		stil => 'normaltext',
		intab => 'genel',
		width => 299,
		gerekli => '1'
	),
	array(
		isim => 'Üst Kategori',
		db => 'parentID',
		stil => 'dbpulldown',
		intab => 'genel',
		dbpulldown_data => array(
			db => 'kategori',
			base => 'ID',
			name => 'namePath',
		),
		width => 221
	),
	array(
		isim => 'SEO URL girişi<br/>(Girilmezse, otomatik oluşturulur.)',
		db => 'seo',
		unlist => true,
		stil => 'normaltext',
		multilang => true,
		intab => 'seo',
		width => 226
	),
	array(
		isim => 'Kategori Resmi',
		db => 'resim',
		stil => 'file',
		intab => 'genel',
		uploadto => 'images/kategoriler/',
		unlist => true
	),
	/*
				array(isim=>'Varsayılan Bayi',
					  db=>'tedarikciID',
					  stil=>'dbpulldown',
					  dbpulldown_data =>array(db=>'tedarikciler',
					  						  base=>'ID',
											  name=>'name',
											  ),
					  gerekli=>'1'),
			
				array(isim=>'Bayi Kategori Kodu',
					  db=>'tedarikciCode',
					  unlist=>true,
					  stil=>'normaltext',
					  gerekli=>'1'),
	 */
	array(
		isim => 'Google Merchant Name <br /><a href="https://support.google.com/merchants/answer/1705911" target="_blank">Detaylar</a> (ID veya İsimden biri yeterlidir.)',
		db => 'googleMerchant',
		unlist => true,
		stil => 'normaltext',
		intab => 'seo',
		gerekli => '0'
	),
	array(
		isim => 'Çiçek Sepeti Kategori Kodu',
		db => 'cscode',
		intab => 'pazaryeri',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'E-PTT Avm Kategori Kodu',
		db => 'pttcode',
		intab => 'pazaryeri',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Asgari Sipariş Tutarı',
		disableFilter => true,
		db => 'minsiparis',
		unlist => true,
		stil => 'normaltext',
		intab => 'diger',
		width => 20,
		gerekli => '1'
	),
	array(
		isim => 'Asgari Sipariş Adeti',
		disableFilter => true,
		db => 'minsiparisadet',
		unlist => true,
		stil => 'normaltext',
		intab => 'diger',
		width => 20,
		gerekli => '1'
	),

	array(
		isim => 'Azami Taksit Limiti<br>(0 = varsayılan)',
		disableFilter => true,
		db => 'taksit',
		unlist => true,
		stil => 'normaltext',
		intab => 'diger',
		width => 20,
		gerekli => '1'
	),
	array(
		isim => 'XML / API Servislerinde Gönderme',
		db => 'noxml',
		stil => 'checkbox',
		unlist => true,
		intab => 'pazaryeri',
		gerekli => '0'
	),
	array(
		isim => 'Google Merchant Servislerinde Gönderme',
		db => 'gnoxml',
		stil => 'checkbox',
		unlist => true,
		intab => 'pazaryeri',
		gerekli => '0'
	),
	array(
		isim => 'Varsayılan E-PTT Avm Çıkış Kar Marjı (0.10 = %10)',
		disableFilter => true,
		db => 'pttkar',
		unlist => true,
		stil => 'normaltext',
		intab => 'pazaryeri',
		gerekli => '1'
	),
	array(
		isim => 'Varsayılan XML Giriş Kar Marjı (0.10 = %10)',
		disableFilter => true,
		db => 'kar',
		unlist => true,
		stil => 'normaltext',
		intab => 'pazaryeri',
		gerekli => '1'
	),
	array(
		isim => 'Sıra',
		disableFilter => true,
		db => 'seq',
		stil => 'normaltext',
		intab => 'genel',
		gerekli => '1'
	),
	array(
		isim => 'Ürünleri Sigortalanabilir',
		db => 'sigorta',
		info => 'Aktif edilirse, "Sigorta Ücretlerinin" <a href="s.php?f=sigorta.php" target="_blank">bu panelden</a> tanımlanması gerekir.',
		unlist => true,
		intab => 'diger',
		stil => 'checkbox'
	),
	array(
		isim => 'Google Mercant Servisinde Yetişkik Kategorisi',
		db => 'yetiskin',
		unlist => true,
		intab => 'diger',
		stil => 'checkbox'
	),
	array(
		isim => 'PC Toplama Kategorilerine Ekle',
		db => 'PCToplama',
		unlist => true,
		intab => 'diger',
		stil => 'checkbox'
	),
	array(
		isim => 'Şablon Listeleme',
		db => 'menu',
		info => 'Kullanılan şablonun desteklemesi gerekir.',
		intab => 'diger',
		stil => 'checkbox'
	),
	array(
		isim => 'Aktif',
		db => 'active',
		intab => 'genel',
		stil => 'checkbox'
	),
);
/*
if (file_exists('mod_CustomBot_<firma>.php')) {
	require_once('mod_CustomBot_<firma>.php');
	$icerik = array_merge(SpCustomBot_<firma>::getAdminKategoriArray(), $icerik);
}
*/
if ($pazarYeriGoster) {
	if (file_exists('../include/mod_GittiGidiyor.php')) {
		include_once('../include/mod_GittiGidiyor.php');
		$ggIcerik = array(
			array(
				isim => 'Varsayılan GittiGidiyor Çıkış Kar Marjı (0.10 = %10)',
				disableFilter => true,
				db => 'ckar',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				gerekli => '1'
			),
			array(
				isim => 'GittiGidiyor Dükkan No<br/>(Store Cat ID / Zorunlu Değil)',
				disableFilter => true,
				db => 'gg_Dukkan',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 20,
				gerekli => '1'
			),
			array(
				isim => 'GittiGidiyor Kodu',
				db => 'gg_Kod',
				stil => 'normaltext',
				align => 'left',
				intab => 'pazaryeri',
				width => 40,
				simpleValues => gg_catList(),
				gerekli => '1'
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		$ggIcerik = array(

			array(
				db => 'data1',
				stil => 'customtext',
				isim => 'GG API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>
				v4Admin::simpleButtonWithImage('', ' openGgDialog();', 'btn-success', '<i name="data1" class="fa fa-download"></i> ' . ($_GET['gg_catList'] ? 'GittiGidiyor Kategoriler  Yüklendi' : 'GittiGidiyor Kategorileri Çek'), '_self') .
					v4Admin::simpleButtonWithImage('', ' openGGSpecs();', 'btn-success', '<i class="fa fa-sitemap"></i> Kategori Varyasyonları', '_self') .
					v4Admin::simpleButtonWithImage('#', 'if ($(\'#gg_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&gg_upload=1&ggcatID=\' + $(\'#gg_Kod\').val(); else alert(\'Lütfen en alt seviye GittiGidiyor kategori kodunu girin.\'); return false;', 'btn-primary', '<i class="fa fa-upload"></i> ' . ($_GET['gg_upload'] ? 'Ürünler GittiGidiyor\'a Yüklendi' : 'Kategori Ürünlerini Yükle'), '_self')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
	}

	if (file_exists('../include/mod_Trendyol.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan Trendyol Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'tykar',
				unlist => true,
				intab => 'pazaryeri',
				stil => 'normaltext',
				gerekli => '1'
			),

			array(
				isim => 'Trendyol Kodu',
				disableFilter => true,
				db => 'ty_Kod',
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),

			array(
				db => 'data4',
				stil => 'customtext',
				isim => 'Trendyol API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>
				v4Admin::simpleButtonWithImage('#', 'return openTyDialog();', 'btn-success', '<i name="data4" class="fa fa-download"></i> Trendyol Kategorileri Çek', '_self') .
					v4Admin::simpleButtonWithImage('#', 'if ($(\'#ty_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&ty_upload=1&tycatID=\' + $(\'#ty_Kod\').val(); else alert(\'Lütfen en alt seviye Trendyol kategori kodunu girin.\'); return false;', 'btn-primary', '<i class="fa fa-upload"></i> ' . ($_GET['gg_upload'] ? 'Ürünler Trendyol\'a Yüklendi' : 'Kategori Ürünlerini Trendyol\'a Yükle'), '_self')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}

	if (file_exists('../include/mod_N11.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan N11 Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'nckar',
				unlist => true,
				intab => 'pazaryeri',
				stil => 'normaltext',
				gerekli => '1'
			),

			array(
				isim => 'N11 Kodu',
				disableFilter => true,
				db => 'yc_Kod',
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),

			array(
				isim => 'Kategoride 150 Karakter Sınırı Var',
				db => 'n11catlimit',
				stil => 'checkbox',
				unlist => true,
				intab => 'pazaryeri',
				gerekli => '0'
			),
			array(
				db => 'data2',
				stil => 'customtext',
				isim => 'N11 API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>
				v4Admin::simpleButtonWithImage('#', 'return openN11Dialog();', 'btn-success', '<i name="data2" class="fa fa-download"></i> N11 Kategorileri Çek', '_self') .
					v4Admin::simpleButtonWithImage('#', 'if ($(\'#yc_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&n11_upload=1&n11catID=\' + $(\'#yc_Kod\').val(); else alert(\'Lütfen en alt seviye N11 kategori kodunu girin.\'); return false;', 'btn-primary', '<i class="fa fa-upload"></i> ' . ($_GET['gg_upload'] ? 'Ürünler N11\'e Yüklendi' : 'Kategori Ürünlerini N11\'e Yükle'), '_self')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}

	if (file_exists('../include/mod_HepsiBuradav2.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan HepsiBurada Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'hbkar',
				unlist => true,
				intab => 'pazaryeri',
				stil => 'normaltext',
				gerekli => '1'
			),

			array(
				isim => 'HB Kodu',
				disableFilter => true,
				db => 'hb_Kod',
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),
			array(
				db => 'data3',
				stil => 'customtext',
				isim => 'HepsiBurada API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>
				v4Admin::simpleButtonWithImage('#', 'return openHbDialog();', 'btn-success', '<i name="data2" class="fa fa-download"></i> HepsiBurada Kategorileri Çek', '_self') .
					v4Admin::simpleButtonWithImage('#', 'if ($(\'#hb_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&hb_upload=1&hbcatID=\' + $(\'#hb_Kod\').val(); else alert(\'Lütfen en alt seviye HepsiBurada kategori kodunu girin.\'); return false;', 'btn-primary', '<i class="fa fa-upload"></i> ' . ($_GET['hb_upload'] ? 'Ürünler HepsiBurada\'ya Yüklendi' : 'Kategori Ürünlerini HepsiBurada\'ya Yükle'), '_self')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}


	if (file_exists('../include/mod_Amazon.php')) {
		$ggIcerik = array(
			array(
				isim => 'Varsayılan Amazon Çıkış Kar Marji (0.10 = %10)',
				disableFilter => true,
				db => 'amazonkar',
				unlist => true,
				stil => 'normaltext',
				intab => 'pazaryeri',
				gerekli => '1'
			),
			array(
				isim => 'Amazon Kodu',
				disableFilter => true,
				db => 'amazon_Kod',
				stil => 'normaltext',
				intab => 'pazaryeri',
				width => 40,
				gerekli => '1'
			),
			array(
				db => 'data5',
				stil => 'customtext',
				isim => 'Amazon API Entegrasyonu',
				intab => 'pazaryeri',
				unlist => true,
				text =>
				v4Admin::simpleButtonWithImage('#', 'return openAmazonDialog();', 'btn-success', '<i name="data5" class="fa fa-download"></i> Amazon Kategorileri Çek', '_self') .
					v4Admin::simpleButtonWithImage('#', 'if ($(\'#amazon_Kod\').val()) window.location.href = \'s.php?f=kategori.php&y=d&ID=' . $_GET['ID'] . '&amazon_upload=1&amazoncatID=\' + $(\'#amazon_Kod\').val(); else alert(\'Lütfen en alt seviye Amazon kategori kodunu girin.\'); return false;', 'btn-primary', '<i class="fa fa-upload"></i> ' . ($_GET['gg_upload'] ? 'Ürünler Amazon\'a Yüklendi' : 'Kategori Ürünlerini Amazon\'a Yükle'), '_self')
			),

		);
		$icerik = array_merge($icerik, $ggIcerik);
		if (is_array($ggIcerik))
			echo $ggForm;
	}
}



if ($_GET['y'] == 'd') {
	$url = 'http://' . $_SERVER["SERVER_NAME"] . kategoriLink((int) $_GET['ID']);
	$tempInfo .= adminInfov3('Düzenleme yapılan kategorinin URL adresi :<br /> <a href="' . $url . '" target="_blank"><strong>' . $url . '</strong></a>');
	$tempInfo .= adminInfov3('<a href="s.php?f=pc.php&y=e&catID=' . $_GET['ID'] . '">Markayı PushCrew ile göndermek için tıklayın.</a>');
}
if ($_GET['y'] == 'd' || $_GET['y'] == 'e') {
	$adminTabs[] = array('genel', 'fa-shopping-cart', 'Genel Bilgiler');
	$adminTabs[] = array('seo', 'fa-search', 'SEO');
	$adminTabs[] = array('pazaryeri', 'fa-cubes', 'XML / API');
	$adminTabs[] = array('diger', 'fa-puzzle-piece', 'Diğer');
	$tempInfo .= v4Admin::generateTabMenu($adminTabs, $icerik, $dbase);
}
if ($_POST['ID'] && $_POST['ID'] == $_POST['parentID']) {
	$tempInfo .= adminInfov3('Hata : Kategorinin üst kategorisi kendisi olamaz.');
	$_POST['parentID'] = dbInfo('kategori', 'parentID', $_POST['ID']);
	unset($_POST);
}



setAdminPostSEOField();
admin($dbase, $where, $icerik, $ozellikler);

if ($_POST['name']) {
	buildCatBreadCrumb();
	cleancache();
	//setUrunStatus();
}


if ($_GET['y'] == 'd' || $_GET['y'] == 'e') {


	echo "<script type='text/javascript'>$('.panel').css('marginBottom','600px');</script>";
}

function autoModalForm($prefix, $name, $fileName)
{
	global $tempInfo;
	if ($_GET[$prefix . 'catID']) {
		my_mysql_query("update kategori set " . ($prefix == 'n11' ? 'yc' : $prefix) . "_Kod = '" . $_GET[$prefix . 'catID'] . "' where ID='" . $_GET['ID'] . "'");
	}

	if ($_GET[$prefix . '_upload']) {
		include_once('../include/' . $fileName);
		$functionName = $prefix . '_uploadProducts';
		$tempInfo .= $functionName($_GET['ID']);
	}
	$prefix2 = ($prefix == 'n11' ? 'yc' : $prefix);
	return '<div id="' . $prefix . '-dialog-form" class="modal-block modal-block-primary mfp-hide">
		  <section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">' . $name . ' Kategori Form</h2>
			</header>
			<div class="panel-body">
				' . adminInfov3('Seçtiğiniz kategori en alt seviye olmalıdır.') . '
				<select id="' . $prefix . 'level_1" onchange="load' . ucfirst($prefix) . 'Dir(\'2\',$(this).val());">
				<option>Lütfen bekleyin..</option>
				</select><br>
				<select id="' . $prefix . 'level_2" onchange="load' . ucfirst($prefix) . 'Dir(\'3\',$(this).val());">
				</select><br>
				<select id="' . $prefix . 'level_3" onchange="load' . ucfirst($prefix) . 'Dir(\'4\',$(this).val());">
				</select><br>
				<select id="' . $prefix . 'level_4" onchange="load' . ucfirst($prefix) . 'Dir(\'5\',$(this).val());">
				</select><br>
				<select id="' . $prefix . 'level_5" onchange="load' . ucfirst($prefix) . 'Dir(\'6\',$(this).val());">
				</select>
				<select id="' . $prefix . 'level_6" onchange="load' . ucfirst($prefix) . 'Dir(\'7\',$(this).val());">
				</select>
				<select id="' . $prefix . 'level_7" onchange="load' . ucfirst($prefix) . 'Dir(\'8\',$(this).val());">
				</select>
				<select id="' . $prefix . 'level_8" onchange="load' . ucfirst($prefix) . 'Dir(\'9\',$(this).val());">
				</select>
				<select id="' . $prefix . 'level_9" onchange="load' . ucfirst($prefix) . 'Dir(\'10\',$(this).val());">
				</select>
				<select id="' . $prefix . 'level_10" onchange="load' . ucfirst($prefix) . 'Dir(\'11\',$(this).val());">
				</select>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-primary modal-confirm" onclick="' . $prefix . 'Kaydet();">Kaydet</button>
						<button class="btn btn-default modal-dismiss">Kapat</button>
					</div>
				</div>
			</footer>
		</section>
</div>
' . "<script type='text/javascript'>

function load" . ucfirst($prefix) . "Dir(level,parentID)
{
  $.ajax({
  url: 'ajax.php?act=" . $prefix . "Cats&parentID='+parentID+'&r='+ Math.floor(Math.random()*99999),
  success: function(data) 
		   {
			   var check = data.replace(/^\s+|\s+$/g,'');
			   if(level == '1' && check == '')
			   {
					alert('$name kategorileri çekilemedi. Lütfen giriş ayarlarınızı kontrol edin.');
			   }
				if(data.length > 40)
					$('select#" . $prefix . "level_' + level).html(data).show();
				var nlevel = (parseInt(level) + 1);
				for(var i=nlevel;i<=5;i++)
				{
					$('select#" . $prefix . "level_' + i).html('').hide();	
				}
		   },
  error: function (xhr, ajaxOptions, thrownError) {
			alert('$name kategorileri çekilemedi. Lütfen giriş ayarlarınızı kontrol edin.');
		   }
  });	

}
function " . $prefix . "Kaydet()
{	
	if($('#" . $prefix . "level_10').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_10').val());
	else if($('#" . $prefix . "level_9').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_9').val());
	else if($('#" . $prefix . "level_8').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_8').val());
	else if($('#" . $prefix . "level_7').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_7').val());
	else if($('#" . $prefix . "level_6').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_6').val());
	else if($('#" . $prefix . "level_5').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_5').val());
	else if($('#" . $prefix . "level_4').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_4').val());
	else if($('#" . $prefix . "level_3').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_3').val());
	else if($('#" . $prefix . "level_2').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_2').val());
	else if($('#" . $prefix . "level_1').val())
		$('#" . $prefix2 . "_Kod').val($('#" . $prefix . "level_1').val());
	$('.modal-dismiss').click();

}

function open" . ucfirst($prefix) . "Dialog()
{
	 $.magnificPopup.open({
			items: {
				src: '#" . $prefix . "-dialog-form',
			},
			preloader: false,
			modal: false,
			type: 'inline'
		});
	if($('#" . $prefix . "level_1 option').length <= 5)
	{
		load" . ucfirst($prefix) . "Dir(1,0); 
	}
	return;
}

</script>
<style>
	#dialog-form select { margin-bottom:5px; font-size:12px; }
	#" . $prefix . "CatContainer { border-bottom:none; }
	#" . $prefix . "level_2,#" . $prefix . "level_3,#" . $prefix . "level_4,#" . $prefix . "level_5,#" . $prefix . "level_6,#" . $prefix . "level_7,#" . $prefix . "level_8,#" . $prefix . "level_9,#" . $prefix . "level_10 { display:none; }
</style>
";
}
