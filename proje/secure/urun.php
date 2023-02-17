<?php
@set_time_limit(0);
@ini_set('memory_limit', '1024M');
$dbase = "urun";
$title = 'Ürün Yönetimi';
$listTitle = 'Ürünler';

if ($_GET['y'] == 'd') {
	updateItemOptions($_GET['ID']);
}
/*
$insertToForm = 'UrunFilitre';
$insertToFormDB = 'urun';
*/
$where = 'bakiyeOdeme=0' . (isset($_GET['stokaz']) ? ' AND stok <=' . (int) $_GET['stokaz'] : '');
$ozellikler = array(
	ekle => '1',
	baseid => 'ID',
	orderby => ((int) $_GET['stokaz'] ? 'stok' : 'ID'),
	ordersort => 'desc',
	excelLoad => 1,
	allowCopy => 1,
	moveProductCat => 1,
	help => 'http://yardim.shopphp.net/page.php?act=kategoriGoster&katID=258',
	faq => 'http://yardim.shopphp.net/page.php?act=kategoriGoster&katID=326',
);
$icerik = array(
	/*
				array(isim=>'Ürün Tipi',
					  db=>'mod',
					  unlist=>true,
					  stil=>'simplepulldown',
					  align=>'left',
					  width=>50,
					  intab => 'genel',
					  simpleValues=>'|Satış Ürünü,ProductDesigner|Tasarım Ürünü'),
 */

	array(
		isim => 'Meta Tag Keywords',
		disableFilter => true,
		unlist => true,
		multilang => true,
		maxlength => 320,
		db => 'metaKeywords',
		stil => 'normaltext',
		intab => 'seo',
		gerekli => '0'
	),
	array(
		isim => 'Meta Tag Description',
		disableFilter => true,
		unlist => true,
		maxlength => 320,
		multilang => true,
		db => 'metaDescription',
		stil => 'normaltext',
		intab => 'seo',
		gerekli => '0'
	),
	array(
		isim => 'Custom Tile (Opsiyonel)',
		disableFilter => true,
		unlist => true,
		multilang => true,
		maxlength => 70,
		db => 'customTitle',
		stil => 'normaltext',
		intab => 'seo',
		gerekli => '0'
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
		isim => 'Ürün Adı',
		db => 'name',
		multilang => true,
		stil => 'normaltext',
		zorunlu => 1,
		width => 300,
		intab => 'genel'
	),
	array(
		isim => 'Ürün Tıklama (Çoğul Hit)',
		db => 'hit',
		//	multilang => true,
		unlist => true,
		stil => 'normaltext',
		width => 226,
		intab => 'diger'
	),
	array(
		isim => 'Ürün Fatura Adı (Sadece Farklıysa)',
		db => 'faturaname',
		//	multilang => true,
		unlist => true,
		stil => 'normaltext',
		width => 226,
		intab => 'diger'
	),
	array(
		isim => 'Ürün Barkod',
		unlist => true,
		info => '<div class="button-box"><input type="button" target="_self" name="" value="Rastgele Barkod Ekle" class="mb-xs mt-xs mr-xs btn btn-info" onclick="var val2 = Math.floor(10000000000000 + Math.random() * 99999999999999); $(\'#gtin\').val(val2); return false;"></div>GTIN(14) / EAN(12) / UPC(13) / ISBN(10) | <a href="https://support.google.com/merchants/answer/6219078?hl=tr" target="_blank">GTIN Nedir? / Google</a> | <a href="https://gs1.tobb.org.tr" target="_blank">GTIN Nedir? / TOBB</a>',
		db => 'gtin',
		width => 100,
		maxlength => 16,
		stil => 'normaltext',
		intab => 'genel',
		gerekli => '0'
	),

	array(
		isim => 'Tedarikci Firma',
		unlist => true,
		db => 'tedarikciID',
		simpleValues => (function_exists('urunTedarikciList') ? urunTedarikciList() : array()),
		stil => (function_exists('urunTedarikciList') ? 'simplepulldown' : 'normaltext'),
		intab => 'pazaryeri',
		gerekli => '0'
	),
	array(
		isim => 'Ürün Kodu',
		db => 'tedarikciCode',
		stil => 'normaltext',
		intab => 'pazaryeri',
		gerekli => '0'
	),
	array(
		isim => 'SEO URL girişi',
		db => 'seo',
		info => 'Girilmezse, otomatik oluşturulur.',
		multilang => true,
		unlist => true,
		stil => 'normaltext',
		width => 226,
		intab => 'seo'
	),
	array(
		isim => 'Instagram URL',
		db => 'instagramURL',
		info => 'Instagram Feed Shop APP kullanan siteler içindir.',
		unlist => true,
		stil => 'normaltext',
		intab => 'pazaryeri'
	),
	/*
				array(isim=>'Custom URL<br />(Tıklandığındna farklı bir URLe yönlendirir.))',
					  db=>'customURL',
					  unlist=>true,
					  stil=>'normaltext',
					  width=>226),
					  
	 */
	/*
				array(isim=>'Ana Ürün',
					  db=>'parentID',
					  width=>269,
					  unlist=>true,
					  stil=>'dbpulldown',
					  dbpulldown_data =>array(db=>'urun',
					  						  base=>'ID',
											  name=>'name',
											  )),
	 */
	array(
		isim => 'Marka',
		db => 'markaID',
		zorunlu => 1,
		stil => 'dbpulldown',
		info => '<div class="button-box"><input type="button" target="_self" name="" value="Hızlı Marka Ekle" class="mb-xs mt-xs mr-xs btn btn-info" onclick="openBrandDialog(); return false;"> <input type="button" target="_self" name="" value="Marka Düzenle" class="mb-xs mt-xs mr-xs btn  btn-success" onclick="editBrand(); return false;"></div>',
		dbpulldown_data => array(
			db => 'marka',
			base => 'ID',
			name => 'name',
		),
		intab => 'genel'
	),


	array(
		isim => 'Ana Kategori',
		db => 'catID',
		width => 269,
		zorunlu => 1,
		stil => 'dbpulldown',
		info => '<div class="button-box"><input type="button" target="_self" name="" value="Hızlı Kategori Ekle" class="mb-xs mt-xs mr-xs btn btn-info" onclick="openCatDialog(); return false;"> <input type="button" target="_self" name="" value="Kategori Düzenle" class="mb-xs mt-xs mr-xs btn  btn-success" onclick="editCat(); return false;"></div>',
		dbpulldown_data => array(
			db => 'kategori',
			base => 'ID',
			name => 'namePath',
		),
		intab => 'genel'
	),
	array(
		isim => 'Ek Listeleme Kategorileri',
		db => 'virtualCatIDs',
		removeFromExcel => true,
		stil => 'multiplechoice',
		unlist => true,
		multiplechoice_data => array(
			db => 'kategori',
			base => 'ID',
			name => 'namePath',
		),
		intabKey => 'virtualCatIDs[]',
		intab => 'genel',
		gerekli => '0'
	),


	array(
		isim => 'Rich Snippets İçin Ortalama Puan (Dinamik)',
		db => 'puan',
		unlist => true,
		info => 'Ürüne yorum yapılmazsa bu sayı geçerli olur. Yorum yapılırsa gerçek değer iletilir. Bu değer her yorum yapıldığında güncellenir.',
		stil => 'normaltext',
		intab => 'seo'
	),

	array(
		isim => 'Rich Snippets İçin Yorum Sayısı',
		db => 'reviewCount',
		unlist => true,
		info => 'Girilmezse, gerçek yorum sayısı iletilir.',
		stil => 'normaltext',
		intab => 'seo'
	),


	array(
		isim => 'Liste Bilgisi',
		db => 'listeDetay',
		multilang => true,
		unlist => true,
		stil => 'normaltext',
		intab => 'genel'
	),
	array(
		isim => 'Ön Detay',
		db => 'onDetay',
		maxlength => 512,
		unlist => true,
		stil => 'textarea',
		multilang => true,
		rows => '4',
		cols => '64',
		intab => 'genel'
	),
	array(
		isim => 'Özellikler',
		db => 'detay',
		stil => 'HTML',
		removeFromExcel => true,
		multilang => true,
		en => '450',
		boy => '150',
		unlist => true,
		intab => 'genel',
		gerekli => '0',
	),
	array(
		isim => 'Özel Tab Başlık',
		info => 'Özel Tab, sadece ShopPHP altyapısındaki tab fonksiyonunu kullanan şablonlarda geçerlidir.',
		db => 'tabbaslik',
		multilang => true,
		unlist => true,
		stil => 'normaltext',
		intab => 'diger'
	),
	array(
		isim => 'Özel Tab İçerik',
		info => 'Özel Tab, sadece ShopPHP altyapısındaki tab fonksiyonunu kullanan şablonlarda geçerlidir.',
		db => 'tabdetay',
		stil => 'HTML',
		removeFromExcel => true,
		multilang => true,
		en => '450',
		boy => '150',
		unlist => true,
		intab => 'diger',
		gerekli => '0',
	),

	array(
		isim => 'Paket Adet Seçimi',
		db => 'talepAdet',
		maxlength => 512,
		info => 'Her satıra başlık ve adet sayısı girilmesi gerekmektedir.<br />Örnek :<br />1 Kutu|10<br />2 Kutu|20<br />3 Kutu|30',
		unlist => true,
		stil => 'textarea',
		// multilang => true,
		rows => '4',
		cols => '64',
		intab => 'varyant'
	),
	array(
		isim => 'Talep Edilecek Diğer Seçim Fieldlar',
		db => 'talepSelect',
		maxlength => 512,
		info => 'Seçim başlığı için ilgili satır başında * olması gerekmektedir.<br />Örnek :<br />*Hediye Paketi<br/>Evet<br/>Hayır<br/>*Hediye Kime?<br/>Erkek<br/>Kadın<br /><span class="color-red">Not : Bu bir varyasyon seçimi değildir ve stok desteği yoktur. Stok desteği için bir üst satırdaki "Ürün Varsyasyonları" kısmı kullanılmalıdır.</span>',
		unlist => true,
		stil => 'textarea',
		multilang => true,
		rows => '4',
		cols => '64',
		intab => 'varyant'
	),
	array(
		isim => 'Talep Edilecek Yazılar',
		db => 'talepText',
		maxlength => 512,
		multilang => true,
		unlist => true,
		stil => 'textarea',
		info => 'Ürün sipariş verilirken bir veya birden fazla yazı talebi için kullanılır. Ör : <br/>Alyans İsim 1<br/>Alyans İsim 2<br/><span class="color-red">Girilen her satır farklı olmalıdır.</span>',
		// multilang => true,
		rows => '4',
		cols => '64',
		intab => 'varyant'
	),

	array(
		isim => 'Talep Edilecek Dosyalar',
		db => 'talepDosya',
		maxlength => 512,
		info => 'Ürün sipariş verilirken bir veya birden fazla resim talebi için kullanılır. Ör : <br/>Kupa Resim 1<br/>Kupa Resim 2<br/><span class="color-red">Girilen her satır farklı olmalıdır.</span>',
		unlist => true,
		stil => 'textarea',
		multilang => true,
		rows => '4',
		cols => '64',
		intab => 'varyant'
	),

	array(
		isim => 'Talep Edilecekler Kısmını Tüm Kategori ile Eşitle',
		db => 'talep-esitle',
		removeFromExcel => true,
		intab => 'varyant',
		unlist => true,
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),

	array(
		isim => 'Ana Resim',
		db => 'resim',
		width => 100,
		stil => 'file',
		uploadto => 'images/urunler/',
		gerekli => '0',
		intab => 'genel,gorsel'
	),
	array(
		isim => 'Resim 2',
		db => 'resim2',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),
	array(
		isim => 'Resim 3',
		db => 'resim3',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),
	array(
		isim => 'Resim 4',
		db => 'resim4',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),
	array(
		isim => 'Resim 5',
		db => 'resim5',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),

	array(
		isim => 'Resim 6',
		db => 'resim6',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),
	array(
		isim => 'Resim 7',
		db => 'resim7',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),
	array(
		isim => 'Resim 8',
		db => 'resim8',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),
	array(
		isim => 'Resim 9',
		db => 'resim9',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),
	array(
		isim => 'Resim 10',
		db => 'resim10',
		stil => 'file',
		uploadto => 'images/urunler/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel'
	),

	/*
	array(
		isim => 'Ürün Bilgi Dosya',
		db => 'dosya',
		info=>'Ürüne ait PDF, ek bilgi resmi vs. yükleyebilirsiniz.',
		stil => 'file',
		uploadto => 'files/',
		unlist => true,
		gerekli => '0',
		intab => 'gorsel,diger'
	),
*/
	array(
		isim => 'Ürün Birim',
		db => 'urunBirim',
		unlist => true,
		stil => 'simplepulldown',
		align => 'left',
		//  multilang=>true,
		width => 50,
		simpleValues => 'Ad.,Kg.,Lt.,Pkt.,Dmt.',
		intab => 'genel'
	),
	array(
		isim => 'Sepet Asgari Tutar',
		defaultValue => '0',
		info => '0 = Sınır Yok. 40 = Sepette en az 40 TL lik ürün olması gerekir.<br />Eğer bir ürüne hem "Sepet Asgari Tutar" hem de "Promosyon Ürünü" tanımlaması yapılırsa, o sipariş toplamı sonrasında ürün sepet otomatik ve ücretsiz olarak eklenir.',
		db => 'minSepet',
		unlist => true,
		stil => 'normaltext',
		unlist => true,
		intab => 'fiyatlar,diger',
	),
	array(
		isim => 'Promosyon Ürünü',
		db => 'promosyon',
		intab => 'diger',
		info => 'İşaretlenen ürünlerinden sepette 1 adet bulunabilir.<br />Eğer bir ürüne hem "Sepet Asgari Tutar" hem de "Promosyon Ürünü" tanımlaması yapılırsa, o sipariş toplamı sonrasında ürün sepet otomatik ve *** ücretsiz *** olarak eklenir. ',
		unlist => true,
		stil => 'checkbox',
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Tek Sipariş Min Adet<br>(0 = Sınır Yok.)',
		db => 'minSiparis',
		stil => 'normaltext',
		intab => 'stok',
		unlist => true
	),
	array(
		isim => 'Tek Sipariş Max Adet<br>(0 = Sınır Yok.)',
		db => 'maxSatis',
		stil => 'normaltext',
		intab => 'stok',
		unlist => true
	),
	array(
		isim => 'Piyasa Fiyatı',
		db => 'piyasafiyat',
		stil => 'normaltext',
		intab => 'genel,fiyatlar',
		multilang => true,
		unlist => true
	),
	array(
		isim => 'Alış Fiyatı (Bilgi Amaçlıdır)',
		db => 'bayifiyat',
		unlist => true,
		intab => 'fiyatlar',
		stil => 'normaltext'
	),
	array(
		isim => 'Satış Fiyatı (KDV Dahil)',
		db => 'fiyat',
		align => 'right',
		width => 50,
		multilang => true,
		intab => 'genel,fiyatlar',
		stil => 'normaltext'
	),
	array(
		isim => 'Bayi Satış Fiyatı #1',
		db => 'fiyat1',
		align => 'right',
		intab => 'fiyatlar',
		unlist => true,
		stil => 'normaltext'
	),
	array(
		isim => 'Bayi Satış Fiyatı #2',
		db => 'fiyat2',
		align => 'right',
		unlist => true,
		intab => 'fiyatlar',
		stil => 'normaltext'
	),
	array(
		isim => 'Bayi Satış Fiyatı #3',
		db => 'fiyat3',
		align => 'right',
		unlist => true,
		intab => 'fiyatlar',
		stil => 'normaltext'
	),
	array(
		isim => 'Bayi Satış Fiyatı #4',
		db => 'fiyat4',
		align => 'right',
		unlist => true,
		intab => 'fiyatlar',
		stil => 'normaltext'
	),
	array(
		isim => 'Bayi Satış Fiyatı #5',
		db => 'fiyat5',
		align => 'right',
		unlist => true,
		intab => 'fiyatlar',
		stil => 'normaltext'
	),
	array(
		isim => 'İndirim Oranı',
		db => 'kar',
		align => 'right',
		unlist => true,
		intab => 'fiyatlar',
		stil => 'normaltext'
	),
	array(
		isim => 'X,Y Adet Ücretsiz Kampanya<br />Ör : 5,2 = 5 adet alana 2 adeti ücretsiz.',
		db => 'adetucretsiz',
		align => 'right',
		unlist => true,
		intab => 'diger',
		stil => 'normaltext'
	),
	array(
		isim => 'Peşin Fiyatına Taksit Kampanya<br />Ör : 5 = Ürün peşin fiyatına 5 taksit.',
		db => 'pesintaksit',
		align => 'right',
		info => '- Kullanıcının bu kampanyadan yararlanabilmesi için sepette kampanya dışında bir ürün bulunmamalıdır. <br />- Bu mod ödeme sayfasından taksit seçilebilen ödeme modülleri için geçerlidir.',
		unlist => true,
		intab => 'diger',
		stil => 'normaltext'
	),
	array(
		isim => 'Fiyat Birim',
		db => 'fiyatBirim',
		zorunlu => 1,
		defaultValue => 'TL',
		multilang => true,
		width => 50,
		intab => 'genel,fiyatlar',
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'fiyatbirim',
			base => 'code',
			name => 'code',
		)
	),

	array(
		isim => 'KDV',
		db => 'kdv',
		intab => 'fiyatlar',
		stil => 'normaltext',
		defaultValue => '0.18',
		unlist => true
	),
	/*
				
				array(isim=>'KDV Tutar (opsyionel)',
					  db=>'kdvtutar',
					  stil=>'normaltext',
					  defaultValue=>'0.18',
					  unlist=>true),
	 */

	array(
		isim => 'Video Kodu',
		disableFilter => true,
		removeFromExcel => true,
		db => 'video',
		unlist => true,
		intab => 'diger',
		stil => 'textarea',
		rows => '5',
		cols => '40'
	),

	array(
		isim => 'Garanti Süresi',
		db => 'garanti',
		stil => 'normaltext',
		intab => 'diger',
		defaultValue => '24',
		unlist => true
	),
	array(
		isim => 'Stok',
		db => 'stok',
		stil => 'normaltext',
		width => 30,
		intab => 'genel,stok,varyant',
		info => 'Sepette sipariş aşamasında bekleyen stok adedi : <b>' . (int) hq("select sum(adet) from sepet where urunID='" . $_GET['ID'] . "' AND durum = 0") . '</b>. <a href="#" onclick="window.open(\'s.php?f=sepet.php&urunID=' . $_GET['ID'] . '&durum=0\'); return false;">Stok Log Penceresi</a>.',
		align => 'center',
		gerekli => '0'
	),

	array(
		isim => 'Stok Yedek',
		db => 'stoky',
		stil => 'normaltext',
		width => 30,
		unlist=>true,
		intab => 'genel,stok,varyant',
		info => 'Buranın yazılım sepet işleyişinde bir fonksiyonu yoktur. Girilen değer XML entegrasyonda, gelen stok sayısına eklenir. ',
		align => 'center',
		gerekli => '0'
	),

	array(
		isim => 'Fix Kargo Ücreti',
		db => 'fixKargoFiyat',
		stil => 'normaltext',
		unlist => true,
		intab => 'kargo',
		gerekli => '0'
	),
	array(
		isim => 'Kargo Desi Değeri',
		db => 'desi',
		stil => 'normaltext',
		intab => 'kargo',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Kargo Teslimat Süresi (Gün)',
		db => 'kargoGun',
		stil => 'normaltext',
		intab => 'kargo',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Öncelik',
		disableFilter => true,
		db => 'seq',
		width => 50,
		intab => 'genel',
		stil => 'normaltext',
		gerekli => '0'
	),
	/*
				array(isim=>'PC Toplama Uyumlulukları',
					  db=>'PCToplama',
					  stil=>'checkboxlist',
					  unlist=>true,
					  checkboxlist_data =>array(db=>'pcToplama',
					  						  base=>'ID',
											  name=>'name',
											  ),
					  gerekli=>'0'),
	 */
	array(
		isim => 'Çiçeksepeti Zorunlu Özellikler',
		db => 'cicekozellik',
		maxlength => 512,
		info => 'Varyantı olmayan ürünlerde, her satıra başlık ve özellik : ile ayrılarak girilmelidir.<br />Örnek :<br />Renk:Siyah<br />Beden:Standart Boy',
		unlist => true,
		stil => 'textarea',
		rows => '4',
		cols => '64',
		intab => 'pazaryeri'
	),
	array(
		isim => 'Çiçek Sipariş Modu Aktif',
		db => 'cicek',
		intab => 'diger',
		info => 'İşaretlendiğinde ürün detayında, şehir, semt, tarih ve saat seçimi eklenir.',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Kasa Önü Fırsatlarında Göster',
		db => 'kasa',
		intab => 'vitrin',
		unlist => true,
		stil => 'checkbox',
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Bu Numune Üründür<br />(Ödeme sonrasında bu ürün ücreti,<br />promosyon kodu olarak gönderilir.)',
		db => 'numune',
		intab => 'diger',
		unlist => true,
		stil => 'checkbox',
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Alternatif Gönderim Formu Göster',
		db => 'alter',
		intab => 'diger',
		stil => 'checkbox',
		unlist => true,
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Anasayfada Listele',
		db => 'anasayfa',
		intab => 'vitrin',
		stil => 'checkbox',
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Yerli Üretim',
		db => 'yerli',
		intab => 'vitrin',
		stil => 'checkbox',
		unlist => true,
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'İndirimde',
		db => 'indirimde',
		intab => 'vitrin',
		stil => 'checkbox',
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Anında Kargo',
		db => 'anindaGonderim',
		stil => 'checkbox',
		intab => 'kargo,vitrin',
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Ücretsiz Kargo',
		db => 'ucretsizKargo',
		stil => 'checkbox',
		intab => 'kargo,vitrin',
		width => 50,
		gerekli => '0'
	),
	array(
		isim => 'Yeni Ürün',
		db => 'yeni',
		intab => 'vitrin',
		width => 50,
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Şablon Liste 1',
		db => 'sablon1',
		intab => 'vitrin',
		stil => 'checkbox',
		info => 'Şablon desteği gerekir.',
		width => 50,
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Şablon Liste 2',
		db => 'sablon2',
		intab => 'vitrin',
		stil => 'checkbox',
		info => 'Şablon desteği gerekir.',
		width => 50,
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Şablon Liste 3',
		db => 'sablon3',
		intab => 'vitrin',
		stil => 'checkbox',
		info => 'Şablon desteği gerekir.',
		width => 50,
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Toplu İndirim veya Bayi İndirimi Uygulama',
		db => 'indirimyok',
		stil => 'checkbox',
		intab => 'diger',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'XML / API Servislerinde Gönderim Yapma',
		db => 'noxml',
		intab => 'pazaryeri',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),

	array(
		isim => 'Google Merchant Servislerinde Gönderim Yapma',
		db => 'gnoxml',
		intab => 'pazaryeri',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),
	/*
				array(isim=>'XML Servislerinde Güncelleme Yapma',
					  db=>'noxmlup',
					  stil=>'checkbox',
					  unlist=>true,
					  gerekli=>'0'),
	 */
	array(
		isim => 'Ön Sipariş Verilebilir',
		db => 'onsiparis',
		intab => 'diger,stok',
		info => 'Ön sipariş stok 0 olduğunda verilebilir.',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Ön Sipariş Bilgi',
		db => 'onsiparisinfo',
		intab => 'diger,stok',
		multilang => true,
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Fiyat Sorunuz Olarak Gelsin',
		db => 'sigorta',
		intab => 'fiyatlar',
		stil => 'checkbox',
		unlist => true,
		gerekli => '0'
	),
	/*
	array(
		isim => ($siteTipi == 'GRUPSATIS' ? 'Kod Doğrulaması Yapacak Kullanıcı' : 'İlgili Kullanıcı'),
		db => 'userID',
		intab => 'diger',
		stil => 'dbpulldown',
		width => 182,
		unlist => true,
		dbpulldown_data => array(
			db => 'user',
			base => 'ID',
			name => 'username',
		),
		detailLink => 's.php?f=users.php&y=d&ID={%%}',
		detailText => 'Kullanıcı Detayları'
	),
	*/
	array(
		isim => 'Giriş Tarihi',
		db => 'tarih',
		intab => 'diger',
		intabKey => 'tarih_gun',
		removeFromExcel => true,
		stil => 'date',
		unlist => true,
		readonly => true,
		gerekli => '0'
	),
	array(
		isim => 'Aktif',
		db => 'active',
		intab => 'genel',
		stil => 'checkbox',
		width => 50,
		gerekli => '0'
	),

);

//if($_GET['ID'])
{
	$varUrunIcerik =
		array(
			isim => 'Ürün Varyasyonları',
			offline => true,
			unlist => true,
			info => (!hq("select ID from var limit 0,1") ? '<span class="color-red">Seçim yapabilmek için önce <a href="s.php?f=varyasyon.php" target="_blank">Ürün Varyasyonları</a> panelinden, varyasyonları tanımlamalısınız.</span>' : ''),
			stil => 'customtext',
			intabKey => 'varID1',
			info => '<span class="color-red">*** Varyasyon altyapısı gereği iki varyant isimi aynı olmamalıdır. ***</span><br />Varyasyon limiti sayısını, <a href="s.php?f=siteAyarlari.php">"Genel Ayarlar"</a> panelinden kişiselleştirebiliriniz.',
			intab => 'varyant',
			text => v4Admin::urunVarList((int) $_GET['ID'])
		);
	array_unshift($icerik, $varUrunIcerik);
}

if ($siteTipi == 'SOFTWARE') {
	$tekUrunIcerik = array(
		array(
			isim => 'Download Gönderilecek Dosya Adı (/files/secured/)',
			stil => 'simplepulldown',
			db => 'data1',
			intab => 'genel',
			simpleValues => fileList('/files/secured/'),
			unlist => true,
			gerekli => '0'
		),
	);
	$icerik = array_merge($icerik, $tekUrunIcerik);
}
// if ($siteTipi == 'TEKURUN' || $siteTipi == 'GRUPSATIS')
{
	$tekUrunIcerik = array(
		array(
			isim => 'Sayaç Başlangıç Tarihi',
			db => 'start',
			intab => 'diger',
			intabKey => 'start_gun',
			info => 'Aktif olabilmesi için, şablon desteği gerekir.',
			stil => 'date',
			unlist => true,
			setTime => true,
			gerekli => '0'
		),
		array(
			isim => 'Sayaç Bitiş Tarihi',
			db => 'finish',
			intabKey => 'finish_gun',
			stil => 'date',
			intab => 'diger',
			info => 'Aktif olabilmesi için, şablon desteği gerekir.',
			unlist => true,
			setTime => true,
			gerekli => '0'
		),
	);
	$icerik = array_merge($icerik, $tekUrunIcerik);
}
if ($siteTipi == 'GRUPSATIS') {
	$grupIcerik = array(
		array(
			isim => 'Fırsatın Gerçekleşeceği İl',
			db => 'data4',
			intab => 'genel',
			unlist => true,
			stil => 'dbpulldown',
			dbpulldown_data => array(
				db => 'iller',
				base => 'plakaID',
				name => 'name',
			)
		),
		array(
			isim => 'Fırsata Adres Bilgileri',
			disableFilter => true,
			db => 'data3',
			stil => 'HTML',
			intab => 'genel',
			en => '450',
			boy => '150',
			//multilang => true,
			intab => 'genel',
			gerekli => '1'
		),
		array(
			isim => 'Fırsata Ait Detaylar (Liste)',
			disableFilter => true,
			db => 'data2',
			multilang => true,
			stil => 'HTML',
			en => '450',
			boy => '150',
			unlist => true,
			intab => 'genel',
			gerekli => '1'
		),
		array(
			isim => 'Öne Çıkanlar (Liste)',
			disableFilter => true,
			db => 'data1',
			multilang => true,
			stil => 'HTML',
			en => '450',
			boy => '150',
			unlist => true,
			intab => 'genel',
			gerekli => '1'
		),
		array(
			isim => 'Grup Satışı İçin Minimum Satış Adeti',
			disableFilter => true,
			db => 'minSatis',
			stil => 'normaltext',
			unlist => true,
			intab => 'genel',
			gerekli => '1'
		),
		/*
		array(isim=>'Kod Doğrulaması Yapabilecek Kullanıcı',
					  db=>'userID',
					  stil=>'dbpulldown',
					  width=>182,
					  unlist=>true,
					  dbpulldown_data =>array(db=>'user',
					  						  base=>'ID',
											  name=>'username',
											  ),
					  detailLink=>'s.php?f=users.php&y=d&ID={%%}',
					  detailText=>'Kullanıcı Detayları'),
	 */

	);
	$icerik = array_merge($icerik, $grupIcerik);
}

$urunFieldArray = array();
$q = my_mysql_query("select * from urunField order by seq");
while ($d = my_mysql_fetch_array($q)) {
	$urunFieldArray[] = array(
		isim => addslashes($d['name']),
		disableFilter => true,
		db => $d['fname'],
		stil => $d['ftype'],
		unlist => true,
		intab => 'ekfield',
		gerekli => '1'
	);
}

$icerik = array_merge($icerik, $urunFieldArray);

/*
if (file_exists('mod_CustomBot_<firma>.php')) {
	require_once('mod_CustomBot_<firma>.php');
	$icerik = array_merge(SpCustomBot_<firma>::getAdminUrunArray(), $icerik);
}
 */

if (file_exists('../include/mod_HepsiBurada.php')) {

	$pazarArraySet = array(
		array(
			isim => 'Ürün HepsiBurada Kodu',
			info => 'Bu kısım otomatik dolar. Eğer bu ürün zaten HepsiBurada da önceden kayıtlı değilse buraya bir veri girmeyin.',
			unlist => true,
			db => 'barkodNo_HB',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		)
	);
	$icerik = array_merge($pazarArraySet, $icerik);
}


if (file_exists('../include/mod_Trendyol.php')) {

	$pazarArraySet = array(
		array(
			isim => 'TY Kodu',
			readonly => true,
			width=>22,
			db => 'barkodNo_ty',
			info => 'Bu kısım otomatik dolar. Eğer bu ürün zaten Trendyolda önceden kayıtlı değilse buraya bir veri girmeyin. Buraya -1 Girerseniz ürün ilgili pazaryerinde işleme konmaz.',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		),

		array(
			isim => 'Trendyol Güncelleme Bekliyor',
			db => 'tyup',
			intab => 'pazaryeri',
			unlist => true,
			stil => 'checkbox',
			width => 29,
			gerekli => '0'
		),

		array(
			isim => 'Trendyol Güncelleme Tarihi',
			unlist => true,
			db => 'ty_tarih',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		)
	);
	$icerik = array_merge($icerik,$pazarArraySet);
}

if (file_exists('../include/mod_GittiGidiyor.php')) {

	$pazarArraySet = array(
		array(
			isim => 'GG Kodu',
			readonly => true, 
			width=>26,
			db => 'barkodNo',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		),

		array(
			isim => 'GittiGidiyor Güncelleme Bekliyor',
			db => 'ggup',
			intab => 'pazaryeri',
			unlist => true,
			stil => 'checkbox',
			width => 29,
			gerekli => '0'
		),

		array(
			isim => 'GittiGidiyor Güncelleme Tarihi',
			unlist => true,
			db => 'gg_tarih',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		)
	);
	$icerik = array_merge($icerik,$pazarArraySet);
}

if (file_exists('../include/mod_N11.php')) {

	$pazarArraySet = array(
		array(
			isim => 'N11 Bundle Aktif',
			db => 'n11BundleActive',
			intab => 'pazaryeri',
			unlist => true,
			stil => 'checkbox',
			width => 29,
			gerekli => '0'
		),

		array(
			isim => 'N11 Katalog Kodu Kodu',
			info => 'Ürünün N11 katalog numarası\'dır. N11\'de tek bir ilan üzerinde birden fazla satıcının toplandığı gtinsiz ürünlerin katalogtan çekilerek kullanımı sağlanır. <br/><br />N11 katalog ID sine ise; N11 panetlindeki ürün yönetimi-yeni ürün ekle-katagori seçimi-Barkod / GTIN(N11 Kataloğundan Al diyerek)-Barkod / GTIN Arama alanını Ürün Adı veya Barkod / GTIN aratıp, Arama Sonuç Listesi\'nde N11 Katalog ID kolonu altından ulaşabilirsiniz. ',
			unlist => true,
			db => 'n11CatalogId',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		),

		array(
			isim => 'N11 Kodu',
			readonly => true, 
			width=>26,
			info => 'Bu kısım otomatik dolar. Eğer bu ürün zaten N11 de önceden kayıtlı değilse buraya bir veri girmeyin.',
			db => 'barkodNo_n11',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		),
		array(
			isim => 'N11 Güncelleme Bekliyor',
			db => 'n11up',
			intab => 'pazaryeri',
			unlist => true,
			stil => 'checkbox',
			width => 29,
			gerekli => '0'
		),
		array(
			isim => 'N11 Güncelleme Tarihi',
			unlist => true,
			db => 'n11_tarih',
			stil => 'normaltext',
			intab => 'pazaryeri',
			gerekli => '0'
		)
	);
	$icerik = array_merge($icerik,$pazarArraySet);
}

if (file_exists('../include/mod_Amazon.php')) {
	require_once('../include/mod_Amazon.php');
	$icerik = array_merge(SpAmazon::getAdminArray(), $icerik);
	$tempInfo .= SpAmazon::getAdminJS();
}

if (file_exists('../include/mod_Kiralama.php')) {
	require_once('../include/mod_Kiralama.php');
	$icerik = array_merge(SpKiralama::getAdminArray(), $icerik);
	$adminTabs[50] = array('kiralama', 'fa-users', 'Kiralama');
}
/*
if (file_exists('../include/mod_Hali.php')) {
	require_once('../include/mod_Hali.php');
	if(class_exists('SpHali'))
		$icerik = array_merge(SpHali::getAdminArray(), $icerik);
	$adminTabs[51] = array('olcu','fa-users','Ölçü');
}
*/
if (file_exists('../include/mod_Altin.php')) {
	require_once('../include/mod_Altin.php');
	if (class_exists('SpAltin'))
		$icerik = array_merge(SpAltin::getAdminArray(), $icerik);
	$adminTabs[52] = array('altin', 'fa-users', 'Altın');
}

if ($_GET['y'] == 'd' || $_GET['y'] == 'e') {

	$adminTabs[0] = array('genel', 'fa-shopping-cart', 'Genel Bilgiler');
	$adminTabs[1] = array('fiyatlar', 'fa-try', 'Fiyatlar');
	$adminTabs[2] = array('gorsel', 'fa-picture-o', 'Görseller');
	$adminTabs[3] = array('stok', 'fa-qrcode', 'Stok');
	$adminTabs[4] = array('seo', 'fa-search', 'SEO');
	$adminTabs[5] = array('vitrin', 'fa-eye fa-check-square', 'Vitrin');
	$adminTabs[6] = array('varyant', 'fa-random', 'Varyant');
	$adminTabs[7] = array('kargo', 'fa-truck', 'Kargo');
	$adminTabs[9] = array('pazaryeri', 'fa-cubes', 'XML / API');
	$adminTabs[100] = array('diger', 'fa-puzzle-piece', 'Diğer');
	$adminTabs[101] = array('ekfield', 'fa-puzzle-piece', 'Ek Fieldlar');

	ksort($adminTabs);
	$tempInfo .= v4Admin::generateTabMenu($adminTabs, $icerik, $dbase);

	if ($_GET['ID']) {
		$url = '//' . $_SERVER["SERVER_NAME"] . urunlink((int) $_GET['ID']);
		$tempInfo .= adminInfov3('GTIN numarası genellikle kutulu ürünlerin barkod gösteriminin yanında veya ürünün kutusunda ya da kitap ürünleri için kapak bölgesinde yer alır. Türkiye\'de yaygın olarak (%95) EAN-13 formatında olan GTIN numarası kullanılmaktadır.');
		$tempInfo .= adminInfov3('Düzenleme yapılan ürünün URL adresi :<br /> <a href="' . $url . '" target="_blank"><strong>' . $url . '</strong></a>');
		$tempInfo .= adminInfov3('<a href="s.php?f=pc.php&y=e&urunID=' . $_GET['ID'] . '">Ürünü PushCrew ile göndermek için tıklayın.</a>');
		$tempInfo .= adminInfov3('Bu ürün bugüne kadar toplam <strong>' . (int) hq("select sum(adet) from sepet where urunID='" . $_GET['ID'] . "' AND durum > 0 AND durum < 90") . '</strong> adet satın alındı.<br />Sepet bazında satışları için <a target="_blank" href="s.php?f=sepet.php&urunID=' . $_GET['ID'] . '"><strong>tıklayın</strong></a>.<br />Kullanıcı bazında satışları için <a target="_blank" href="s.php?f=sepetToplam.php&urunID=' . $_GET['ID'] . '&group=user"><strong>tıklayın</strong></a>.');
	}
}
$_POST['prefix'] = md5($_POST['start']);
$KDVHaricFiyat = $_POST['fiyatkdvharic'];
unset($_POST['fiyatkdvharic']);
$oncekiFiyat = hq("select fiyat from urun where ID='" . $_POST['ID'] . "'");
$oncekiStok = hq("select stok from urun where ID='" . $_POST['ID'] . "'");
if ($KDVHaricFiyat && ($_POST['fiyat'] == $oncekiFiyat)) {
	$_POST['fiyat'] = $KDVHaricFiyat + ($KDVHaricFiyat * $_POST['kdv']);
	$_POST['fiyat'] = my_money_format('%i', $_POST['fiyat']);
	$_POST['fiyat'] = str_replace(",", "", $_POST['fiyat']);
}
if ($_POST['name'] && $_POST['ID']) {

	Sepet::urunFiltreGuncelle($_POST['ID']);
	fiyatAlarm($_POST['ID'], $_POST['fiyat'], $_POST['fiyatBirim']);
	stokAlarm($_POST['ID'], $_POST['stok']);
}
if (($oncekiStok != $_POST['stok']) && $_POST['ID'] && $_POST['name']) {
	cleanBasket($_POST['ID']);
}
if (!$_POST['fiyatBirim'])
	$_POST['fiyatBirim'] = 'TL';

if ($_POST['fiyat']) {
	if ($oncekiFiyat != $_POST['fiyat']) {
		cleanBasket($_POST['ID']);
	}
	$_POST['fiyat'] = str_replace(',', '.', $_POST['fiyat']);
	if ($_POST['fiyat1'])
		$_POST['fiyat1'] = str_replace(',', '.', $_POST['fiyat1']);
	if ($_POST['fiyat2'])
		$_POST['fiyat2'] = str_replace(',', '.', $_POST['fiyat2']);
	if ($_POST['fiyat3'])
		$_POST['fiyat3'] = str_replace(',', '.', $_POST['fiyat3']);
	if ($_POST['fiyat4'])
		$_POST['fiyat4'] = str_replace(',', '.', $_POST['fiyat4']);
	if ($_POST['fiyat5'])
		$_POST['fiyat5'] = str_replace(',', '.', $_POST['fiyat5']);
}

if ($_POST['name'] && !$_POST['stok'] && $oncekiStok) {
	cleanBasket($_POST['ID']);
}

setAdminPostSEOField();
if ($_POST['name'] && $_POST['ID'])
	adminLog($_POST, array('active', 'fiyat', 'fiyat1', 'fiyat2', 'fiyat3', 'fiyat4', 'fiyat5', 'fiyatBirim', 'piyasafiyat', 'stok'), $dbase, $_POST['ID']);

if (!$_GET['ID'] && $_GET['y'] != 'e') {
	echo '<div id="urun-arama-container">' . v4Admin::fullBlock('Ürün Arama', v4Admin::urunAramaForm()) . '</div>';
	if (!$_POST['urun-arama-post'])
		echo '<script type="text/javascript">$("#urun-arama-container .panel").addClass("panel-collapsed ");</script>';
}

$hizliJS = "
<script type='text/javascript'>
		function updateQSelectList(id,data)
		{
			var ofirst = $(id).find('option:first');
			if(!data)
			{
				return false;
				$(id).load('ajax.php?act=selectCatList');	
			}
			else
				$(id).html(data);
			$(id).select2('destroy');
			$(id).select2();		
		}
</script>
";

$hizliKategoriForm = '
	<div id="cat-dialog-form" class="modal-block modal-block-primary mfp-hide">
	   <section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Hızlı Kategori Ekleme</h2>
				</header>
				<div class="panel-body">
					<select id="f-parentCatID">
						<option value="0">Üst Kategori</option>
					</select><br /><br />
					<input type="text" placeholder="Kategori Adı" id="f-catName" class="form-control mb-md">
					
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary modal-confirm" onclick="katKaydet();">Kaydet</button>
							<button class="btn btn-default modal-dismiss">Kapat</button>
						</div>
					</div>
				</footer>
			</section>
	</div>
	<script type="text/javascript">
		' . "
		function editCat()
		{
			var catID = $('[name=catID]').val();
			if(!catID)
				return;
			window.open('s.php?f=kategori.php&y=d&ID=' + catID);
		}
		function openCatDialog()
		{
			$.get('ajax.php?act=selectCatList', function(data) 
			{
				var id = '#f-parentCatID';
				var ofirst = $(id).find('option:first');
				$(id).html(data).width(500);
				$(ofirst).prependTo(id);
				$(id).select2('destroy');
				$(id).select2();
				
				$.magnificPopup.open({
					items: {
						src: '#cat-dialog-form',
					},
					preloader: false,
					modal: false,
					type: 'inline'
				});
				
			});

			return;
		}
		
		function katKaydet()
		{
			$.get('ajax.php?act=catSave&name='+$('#f-catName').val()+'&parentCatID=' + $('#f-parentCatID').val(), function(data) 
			{
				updateQSelectList('select[name=catID]',data);				
				$('.modal-dismiss').click();			
			});
			
		}
		" . '
	</script>
';

$hizliMarkaForm = '
	<div id="brand-dialog-form" class="modal-block modal-block-primary mfp-hide">
	   <section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Hızlı Marka Ekleme</h2>
				</header>
				<div class="panel-body">
					<input type="text" placeholder="Marka Adı" id="f-brandName" class="form-control mb-md">
					
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary modal-confirm" onclick="markaKaydet();">Kaydet</button>
							<button class="btn btn-default modal-dismiss">Kapat</button>
						</div>
					</div>
				</footer>
			</section>
	</div>
	<script type="text/javascript">
		' . "
		function editBrand()
		{
			var markaID = $('[name=markaID]').val();
			if(!markaID)
				return;
			window.open('s.php?f=marka.php&y=d&ID=' + markaID);
		}
		function openBrandDialog()
		{
			$.magnificPopup.open({
				items: {
					src: '#brand-dialog-form',
				},
				preloader: false,
				modal: false,
				type: 'inline'
			});

			return;
		}
		
		function markaKaydet()
		{
			$.get('ajax.php?act=brandSave&name='+$('#f-brandName').val(), function(data) 
			{
				updateQSelectList('select[name=markaID]',data);				
				$('.modal-dismiss').click();			
			});
			
		}
		" . '
	</script>
';

$hizliVarForm = '
	<div id="var-dialog-form" class="modal-block modal-block-primary mfp-hide">
	   <section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Hızlı Varyasyon Ekleme</h2>
				</header>
				<div class="panel-body">
					<input type="text" placeholder="Varyasyon Adı" id="f-varName" class="form-control mb-md">
					
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary modal-confirm" onclick="varKaydet();">Kaydet</button>
							<button class="btn btn-default modal-dismiss">Kapat</button>
						</div>
					</div>
				</footer>
			</section>
	</div>
	<script type="text/javascript">
		' . "
			
		var varVal = '';
		var varUrunID = '';
		var varSeq = '';
		function openVarDialog(val,urunID,seq)
		{
			varVal = val;
			varUrunID = urunID;
			varSeq = seq;
		
			$.magnificPopup.open({
				items: {
					src: '#var-dialog-form',
				},
				preloader: false,
				modal: false,
				type: 'inline'
			});
			return;
		}
		
		function varKaydet()
		{
			$.get('ajax.php?act=varSave&varID='+varVal+'&name='+$('#f-varName').val(), function(data) 
			{
				updateVarTable(varVal,varUrunID,varSeq);	
				$('#f-varName').val('').attr('placeholder','Varyasyon Eklendi. Yeni Varyasyon Girebilirsiniz.');		
			});
			
		}
		" . '
	</script>
';

if($_GET['y'] == 'd')
{
	$catID = hq("select catID from urun where ID='".$_GET['ID']."'");
	$n11Code = hq("select yc_Kod from kategori where ID='".$catID."'");
	if ($n11Code)
		$tempInfo.=v4Admin::simpleButtonWithImage('s.php?f=kategori.php&y=d&ID='.$catID.'&n11_upload=1&n11catID='.$n11Code.'&urunID='.$_GET['ID'], '', 'btn-danger', '<i class="fa fa-bars"></i> N11\'e Gönder', '_blank');
	$ggCode = hq("select gg_Kod from kategori where ID='".$catID."'");
	if ($ggCode)
		$tempInfo.=v4Admin::simpleButtonWithImage('s.php?f=kategori.php&y=d&ID='.$catID.'&gg_upload=1&ggcatID='.$ggCode.'&urunID='.$_GET['ID'], '', 'btn-primary', '<i class="fa fa-bars"></i> GittiGidiyor\'a Gönder', '_blank');
	$tyCode = hq("select ty_Kod from kategori where ID='".$catID."'");
	if ($tyCode)
		$tempInfo.=v4Admin::simpleButtonWithImage('s.php?f=kategori.php&y=d&ID='.$catID.'&ty_upload=1&tycatID='.$tyCode.'&urunID='.$_GET['ID'], '', 'btn-warning', '<i class="fa fa-bars"></i> Trendyol\'a Gönder', '_blank');		
}

echo $hizliJS;
echo $hizliKategoriForm;
echo $hizliMarkaForm;
echo $hizliVarForm;
echo adminv3($dbase, $where, $icerik, $ozellikler);
//v4Admin::updateUrunStokVar($urunID);
if ($_POST['name']) {
	if (!$_POST['ID'])
		$urunID = hq("select ID from urun order by ID desc limit 0,1");
	else
		$urunID = $_POST['ID'];


	foreach ($pazarArray as $p) {
		my_mysql_query("update urun set $p = 1 where ID='$urunID'");
	}
	v4Admin::updateUrunStokVar($urunID);
	if ($_POST['var-cat-esitle']) {
		$q = my_mysql_query("select ID from urun where catID='" . $_POST['catID'] . "'");
		while ($d = my_mysql_fetch_array($q)) {
			v4Admin::updateUrunStokVar($d['ID']);
		}
	}

	if ($_POST['talep-esitle']) {
		my_mysql_query("update urun set talepText = '" . $_POST['talepText'] . "', talepSelect = '" . $_POST['talepSelect'] . "',talepDosya = '" . $_POST['talepDosya'] . "' where catID='" . $_POST['catID'] . "'");
	}

	updateUrunShowCatIDs($urunID);
	cleancache();
}
if ($_GET['y'] == 'dx') {
	echo "<script type='text/javascript'>$('#fiyatkdvharic').val(parseFloat($('#fiyat').val()) / (1 + parseFloat($('#kdv').val()))).toFixed(2).replace('.00','');</script>";
}
if ($_GET['y'] == 'd' || $_GET['y'] == 'e') {
	echo "<script type='text/javascript'>$('.panel').css('marginBottom','600px');</script>";
}
?>