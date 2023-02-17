<?
$dbase = "user";
$title = 'Kullanıcı Yönetimi';
$listTitle = 'Kullanıcılar';
$ozellikler = array(
	ekle => (int) (strtolower($yonetimKoruma) == 'script'),
	baseid => 'ID',
	orderby => 'isAdmin desc,isMod desc,bayiStatus desc,name',
	excelLoad => 1,
);


$icerik = array(
	array(
		isim => 'Yönetici Notu',
		db => 'notYonetici',
		unlist => true,
		intab => 'genel,diger',
		stil => 'textarea',
		rows => '3',
		cols => '64',
		gerekli => '1'
	),
	array(
		isim => 'Kullanıcı Adı',
		db => 'username',
		zorunlu => 1,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Şifre',
		db => 'password',
		zorunlu => 1,
		isPassword => true,
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Davet Eden Kullanıcı',
		db => 'davetUserID',
		width => 70,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'user',
			base => 'ID',
			name => 'username',
		),
		detailLink => 's.php?f=users.php&y=d&ID={%%}',
		detailText => '<i class="fa fa-user"></i> Kullanıcı Detayları',
		nullValue => 'Direkt Kayıt',
		gerekli => '1'
	),

	array(
		isim => 'Adı',
		db => 'name',
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Soyadı',
		db => 'lastname',
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'E-Posta Adresi',
		db => 'email',
		width => 139,
		zorunlu => 1,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Doğum Tarihi',
		db => 'birthdate',
		unlist => true,
		stil => 'date',
		gerekli => '1'
	),

	array(
		isim => 'Cinsiyeti',
		db => 'sex',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Adres',
		db => 'address',
		unlist => true,
		stil => 'textarea',
		rows => '4',
		cols => '32',
		gerekli => '1'
	),

	array(
		isim => 'Semt',
		unlist => true,
		db => 'semt',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ilceler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Şehir',
		unlist => true,
		db => 'city',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'iller',
			base => 'plakaID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Ülke',
		db => 'country',
		width => 282,
		unlist => true,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ulkeler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),


	array(
		isim => 'Fatura Adres',
		db => 'address2',
		unlist => true,
		stil => 'textarea',
		rows => '4',
		cols => '32',
		gerekli => '1'
	),

	array(
		isim => 'Fatura Semt',
		unlist => true,
		db => 'semt2',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ilceler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Fatura Şehir',
		unlist => true,
		db => 'city2',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'iller',
			base => 'plakaID',
			name => 'name',
		),
		gerekli => '1'
	),

	array(
		isim => 'Fatura Ülke',
		db => 'country2',
		width => 282,
		unlist => true,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'ulkeler',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),


	array(
		isim => 'Ev Telefonu',
		db => 'evtel',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'İş Telefonu',
		db => 'istel',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Cep Telefonu',
		db => 'ceptel',
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'TC Kimlik Numarası',
		db => 'tckNo',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Firma Ünvanı',
		db => 'firmaUnvani',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Vergi Numarası',
		db => 'vergiNo',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Vergi Dairesi',
		db => 'vergiDaire',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'İzin Verilen (-) Bakiye (TL)',
		db => 'arti',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Kullanılabilir Bakiye (TL)',
		db => 'bakiye',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Sipariş Adet',
		db => 's_adet',
		width => 70,
		stil => 'normaltext',
		gerekli => '1'
	),
	array(
		isim => 'Sipariş Toplam TL',
		db => 's_ciro',
		width => 90,
		stil => 'normaltext',
		align => 'right',
		gerekli => '1'
	),
	array(
		isim => 'E-Bülten Üyeliği',
		db => 'ebulten',
		stil => 'simplepulldown',
		align => 'left',
		width => 40,
		simpleValues => '1|Evet,2|Hayır',
		gerekli => '1'
	),
	array(
		isim => 'Varsayılan Dil',
		db => 'autolang',
		width => 400,
		unlist => true,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'langs',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),
	array(
		isim => 'Sadece BU IP Adreslerinden Girebilir',
		db => 'IPs',
		unlist => true,
		stil => 'textarea',
		rows => '4',
		cols => '32',
		gerekli => '1'
	),
	array(
		isim => 'Onaylı Üye',
		db => 'bayiStatus',
		width => 70,
		stil => 'checkbox',
		//  disable_inline => 1,
		gerekli => '0'
	),
	array(
		isim => 'Kayıt Tarihi',
		db => 'submitedDate',
		unlist => true,
		stil => 'date',
		gerekli => '1'
	),
);


if ($_SESSION['admin_isAdmin']) {
	$checkUser = array(
		array(
			isim => 'Admin Statüsünde Kullanıcı',
			db => 'isAdmin',
			width => 70,
			stil => 'checkbox',

			gerekli => '0'
		),
		array(
			isim => 'Yönetici Paneline Girebilir',
			db => 'isMod',
			width => 70,
			stil => 'checkbox',

			gerekli => '0'
		),
		array(
			isim => 'Erişebileceği Bölümler',
			db => 'accessTo',
			stil => 'multiplechoice',
			unlist => true,
			info => 'Admin statüsünde olan kullanıcılar, bu kısıma bakılmaksızın her yere erişebilir.',
			multiplechoice_data => array(
				db => 'adminmenu',
				base => 'ID',
				name => 'Adi',
				where => 'ID != 10 AND (parentID = 0 OR parentID = 10)',
				order => 'parentID,Sira',
			),
			gerekli => '0'
		),
	);
	$icerik = array_merge($icerik, $checkUser);
}
if ($_POST['bayiStatus']) {
	$oncekiDurum = hq("select bayiStatus from user where ID='" . $_POST['ID'] . "'");
	if (!$oncekiDurum && $_POST['bayiStatus'] == 'on') {
		$q = my_mysql_query("select title,body from sablonEmail where code='Kullanici_Onay'");
		$mergeArray = $_POST;
		$mail = my_mysql_fetch_array($q);
		$mail['body'] = mergeText($mail['body'], $mergeArray);
		my_mail($_POST['email'], $mail['title'], $mail['body'], getHeaders($siteConfig['adminMail']));
	}
}

if ($_GET['y'] == 'd') {
	updateUserOrderDB($_GET['ID']);
	$tempInfo .= adminInfov3('Bu kullanıcın bugüne kadar toplam <strong>' . (int) hq("select sum(adet) from sepet where userID='" . $_GET['ID'] . "' AND durum > 0 AND durum < 90") . '</strong> ürün satın aldı.<br /> Sepet bazında görüntülemek için <a target="_blank" href="s.php?f=sepet.php&userID=' . $_GET['ID'] . '"><strong>tıklayın</strong></a>.<br />Ürün bazında görüntülemek için <a target="_blank" href="s.php?f=sepetToplam.php&userID=' . $_GET['ID'] . '"><strong>tıklayın</strong></a>.');
	$tempInfo .= adminInfov3('Bu kullanıcın bugüne kadar <strong>' . my_money_format('', hq("select sum(toplamTutarTL) from siparis where userID='" . $_GET['ID'] . "' AND durum > 0 AND durum < 90")) . ' TL</strong> tutarında toplam <strong>' . (int) hq("select count(*) from siparis where userID='" . $_GET['ID'] . "' AND durum > 0 AND durum < 90") . '</strong> siparişi var.<br /> Siparişlerini görüntülemek için <a target="_blank" href="s.php?f=tumSiparisler.php&userID=' . $_GET['ID'] . '"><strong>tıklayın</strong></a>.');
}

if ($_GET['y'] == 'd' && $siteConfig['aff_active'] && $_GET['showAff']) {
	$logDetay = '<div style="padding:10px;">' . affKazancTablo($_GET['ID'], 1) . '</div>';
	$payDetay = '<div style="padding:10px;">' . affLogTablo($_GET['ID']) . '</div>';
	$tempInfo .= v3Admin::generateSimpleBlock('Kullanıcı Affilate Log', '', $logDetay, 'grid740');
	$tempInfo .= v3Admin::generateSimpleBlock('Kullanıcı Ödeme Log', '', $payDetay, 'grid740');
}

if ($_GET['ID'] && !$_POST['email']) {
	if (!$_GET['setpay'])
		$tempInfo .= v4Admin::simpleButtonWithImage('', "		 $.magnificPopup.open({ items: {src: '#modalForm',},	preloader: false,modal: false,type: 'inline'});", 'btn-success', '<i class="fa fa-credit-card modal-with-form"></i> Bu kullanıcıya ödeme URL oluştur', '_self');
	else {
		$payurl = 'https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'page.php?act=autopay&key=' . encrypt_decrypt('encrypt', $_GET['tutar'] . '|' . $_GET['bankaID'] . '|' . $_GET['ID']);
		$autoPaymentButtons .= '<hr />';
		$tel = str_replace(array(' ', '-', '+', '(', ')'), '', hq("select ceptel from user where ID='" . $_GET['ID'] . "'"));
		if ($tel) {
			$telPrefix = '9' . (substr($tel, 0, 1) == '0' ? '' : '0');
			$autoPaymentButtons .= v4Admin::simpleButtonWithImage('#', "window.open('https://api.whatsapp.com/send?phone=" . $telPrefix . $tel . "&text=Selamlar, Ödeme için bu bağlantıyı kullanabilirsiniz. " . urlencode($payurl) . "')", 'btn-success', '<i class="fa fa-whatsapp"></i> WhatsApp ile Gönder', '_self');
		}
		//	$autoPaymentButtons.=v4Admin::simpleButtonWithImage('#',"window.open('https://api.whatsapp.com/send?phone=".$telPrefix.$tel."')",'btn-warning','<i class="fa fa-envelope-square"></i> SMS  ile Gönder','_self');
		//	$autoPaymentButtons.=v4Admin::simpleButtonWithImage('#',"window.open('https://api.whatsapp.com/send?phone=".$telPrefix.$tel."')",'btn-primary','<i class="fa fa-envelope"></i> E-Posta ile Gönder','_self');
		$tempInfo .= adminInfov3('Ödeme için kullanıcıya <a href="' . $payurl . '" target="_blank">' . $payurl . '</a> adresini iletebilirsiniz.' . $autoPaymentButtons);
	}
}

admin($dbase, $where, $icerik, $ozellikler);
if ($_GET['y'] == 'd' || $_GET['y'] == 'e') {
	echo "<script type='text/javascript'>$('.panel').css('marginBottom','600px');</script>";
}
?>
<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Ödeme URL Oluşturma</h2>
		</header>
		<div class="panel-body">
			<form id="demo-form" class="form-horizontal mb-lg" novalidate="novalidate">
				<div class="form-group mt-lg">
					<label class="col-sm-3 control-label">Tutar (TL)</label>
					<div class="col-sm-9">
						<input type="text" id="tutar" class="form-control" required="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Ödeme Tipi</label>
					<div class="col-sm-9">
						<select id="bankaID">
							<?= getOptions('banka', 'bankaAdi', '(active=1 AND taksitOrani=1)', 'bankaAdi', 0) ?>
						</select>
					</div>
				</div>
			</form>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-primary modal-confirm" onclick="window.location.href= 's.php?f=users.php&y=d&ID=<?= $_GET['ID'] ?>&setpay=true&tutar=' + $('#tutar').val() + '&bankaID=' + $('#bankaID').val();">Gönder</button>
					<button class="btn btn-default modal-dismiss">İptal</button>
				</div>
			</div>
		</footer>
	</section>
</div>