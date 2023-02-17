<?
$dbase = "siteConfig";
$title = 'Sepet Hesap Ayaları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Sepet Zaman Aşımı Süresi',
		db => 'sepetAsimSuresi',
		info => 'Kullanıcının siparişi tamamlaması için tanınan azami süredir. Bu süre sonrasında kullanıcıya sepet zaman aşımı maili gönderilir ve ürünler stoklarına iade edilir.<br />Boş bırakılırsa (0) ürün stokları anlık değil, onaylı satıştan (kredi kartı, onaylı havale vs..) sonra güncellenir.',
		stil => 'normaltext',
		intab => 'genel',
		gerekli => '0'
	),
	array(
		isim => 'Asgari Sipariş Tutarı',
		db => 'minSiparis',
		intab => 'siparis',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Tek Çekim İndirim Oranı',
		db => 'tekCekimIndirim',
		intab => 'siparis',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Sabit Kargo Ücreti',
		db => 'kargo',
		intab => 'kargo',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Ücretsiz Kargo Limiti',
		db => 'minKargo',
		intab => 'kargo',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Ücretsiz Kargo Kontrol Tipi',
		db => 'kargoHesaplama',
		stil => 'simplepulldown',
		intab => 'kargo',
		align => 'left',
		width => 40,
		simpleValues => '0|Sepet toplamı limiti geçerse veya tümü ücretsiz kargo ürünü ise kargo ücretsiz.,1|Sepette tek bir ücretsiz kargo ürünü olsa bile kargo ücretsiz. ',
		gerekli => '1'
	),
	array(
		isim => 'Ücretsiz Kargo Saat Kampanyası (Ör: 00-02 = Gece 12 ile 2 arası kargo ücretsiz.)',
		db => 'kargoZaman',
		intab => 'kargo',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Varsayılan Kargo Teslimat Süresi (Gün)',
		db => 'kargoGun',
		intab => 'kargo',
		stil => 'normaltext',
		unlist => true,
		gerekli => '0'
	),
	array(
		isim => 'Dövizi Güncel Tut',
		db => 'updateDoviz',
		intab => 'genel',
		info => 'Aktif olduğunda 3 saatte bir güncellenir.',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Döviz Hesaplama',
		db => 'dovizType',
		intab => 'genel',
		stil => 'simplepulldown',
		simpleValues => '1|TCMB,3|Piyasa',
		autoSelected => '1',
		gerekli => '0'
	),
	array(
		isim => 'Fiyat Gösterim Tipi',
		db => 'priceType',
		intab => 'gosterim',
		stil => 'simplepulldown',
		simpleValues => '1|Orijinal Para Birimi (KDV Dahil),2|Orijinal Para Birimi (KDV Hariç),3|TL (KDV Dahil),4|TL (KDV Hariç)',
		autoSelected => '1',
		info => '- Sadece {%URUN_FIYAT%} ve {%URUN_PIYASA_FIYAT%} makrosu kullanan şablonlarda geçerlidir.<br />- Fiyat gösterim şablonuna + KDV eklenmesi, fiyat gösterim kısmı dar olan şablonda taşmaya neden olabilir.<br />- Şablonda dil veya para birimi seçimi yapılırsa, bu ayarın önüne geçer.',
		gerekli => '0'
	),

	array(
		isim => 'Fiyatlarda .00 kısmını gizle.',
		db => 'kurusgizle',
		info => 'Kuruş hanesi 00 olduğunda ve şablonda {%URUN_FIYAT%} makrosunun kullandılığı yerlerde geçerli olur.',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Altın Fiyatlarını Güncel Tut',
		db => 'updateAltin',
		info => 'Aktif olduğunda 3 saatte bir güncellenir.',
		intab => 'genel',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Altın Hesaplama',
		db => 'altinType',
		intab => 'genel',
		stil => 'simplepulldown',
		simpleValues => '1|Alış,2|Satış',
		autoSelected => '1',
		gerekli => '0'
	),
	array(
		isim => 'Ödeme Seçim Listeleme Tipi',
		db => 'sepet_odeme',
		intab => 'gosterim',
		stil => 'simplepulldown',
		simpleValues => '0|Klasik Listeleme,1|Tab Listeleme,2|Sipariş Formunda Listeleme,3|Tek Ekranda Ödeme',
		autoSelected => '1',
		gerekli => '0'
	),
	array(
		isim => 'Üye Siparişlerinde Otomatik Seçim Formunu Pasif yap',
		db => 'uyeForm',
		info => 'Aktif olduğunda, üyelerin siparişlerinde ödeme adres seçim ekranı yerine direkt doldurulabilir form gelir.',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Çoklu Filtre Seçim Tipi',
		db => 'filterType',
		intab => 'gosterim',
		stil => 'simplepulldown',
		simpleValues => '0|Checkbox,1|Div',
		autoSelected => '1',
		gerekli => '0'
	),
	array(
		isim => 'Fiyat Filitre Aralığı',
		db => 'filterFiyat',
		intab => 'gosterim',
		info => 'ÖR: 0,2000 .Boş bırakılırsa, fiyat aralığı gözükmez.',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Fiyatı Olmayan Ürünleri Gizle',
		db => 'hideNoPrice',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Stoğu Olmayan Ürünleri Gizle',
		db => 'hideNoStock',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Resmi Olmayan Ürünleri Gizle',
		db => 'hideNoPic',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Filtrede Markaları Gizle',
		db => 'hideFilterBrands',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Filtrede Stok Durumunu Gizle',
		db => 'hideFilterStock',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Kategori Üst Filtreyi Gizle',
		db => 'hideTopFilter',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Sepette Havale İndirimini Gizle',
		db => 'hideSepetHavale',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Sepet KDV Dahil Toplam Tutarını Gizle',
		db => 'hideSepetKdvdahil',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Sepet KDV Hariç Toplam Tutarını Gizle',
		db => 'hideSepetKdvHaric',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Sepet KDV Tutarı Gizle',
		db => 'hideSepetKdv',
		intab => 'gosterim',
		stil => 'checkbox',
		gerekli => '0'
	),

	array(
		isim => 'Sepetteki Ucuz Ürün Ücretsiz Kamp. Aktif',
		db => 'ucretsizurun',
		intab => 'genel',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Sepetteki Ucuz Ürün Ücretsiz Kamp. İçin Asgari Sepet Ürün Sayısı',
		db => 'ucretsizsayi',
		intab => 'genel',
		info => 'Üstteki checkbox aktif edildiğinde ve buraya girilen adet kadar ürün sepette bulunduğunda, en ucuz 1 ürün *ücretsiz* olur.',
		stil => 'normaltext',
		gerekli => '0'
	),
	/*	  
				array(isim=>'Ürün Kodu Eşleştirmesi Aktif',
					  db=>'kodeslestirme',
					  stil=>'checkbox',
					  intab=>'genel',
					  info=>'İşaretlendiğinde aynı koda sahip ürünlerden fiyatı uygun ve stok sayısı olan aktif olur. İlgili ürün stok kalmadığımda pasif edilir ve diğer ürün aktif olur. Aynı ürünleri gönderen XML servislerinde kullanılabilir. ',
					  gerekli=>'0'),
					  */

	array(
		isim => 'Tamamlanmamış Sipariş Koruma Aktif',
		db => 'koruma',
		stil => 'checkbox',
		intab => 'siparis',
		info => 'İşaretlendiğinde ödeme kısmına gelen ama limit hatası vs. nedenilye tamamlanamayan siparişler koruma altına alınır. ',
		gerekli => '0'
	),
	array(
		isim => 'Sepet Zaman Aşımını Göster',
		db => 'sepetzaman',
		intab => 'genel',
		stil => 'checkbox',
		gerekli => '0'
	),
	array(
		isim => 'Teslim Edilen Siparişlerde, Ürün Yorum Formu Gönder',
		db => 'sepetteslimform',
		intab => 'siparis',
		info => 'Değerlendirme formu, teslim tarihinden 2 gün sonra otomatik olarak gönderilir. Bu kısım aktif edildikten sonra, teslim tarihi 14 günden fazla olan eski siparişlere form gönderilmez.',
		stil => 'checkbox',
		gerekli => '0'
	),




	/*	
				array(isim=>'Sepet Adımlarını Göster',
					  db=>'sepetadim',
					  stil=>'checkbox',
					  gerekli=>'0'),		
 */
);

$adminTabs[] = array('genel', 'fa-shopping-cart', 'Sepet');
$adminTabs[] = array('siparis', 'fa-cube', 'Sipariş');
$adminTabs[] = array('kargo', 'fa-truck', 'Kargo');
$adminTabs[] = array('gosterim', 'fa-picture-o', 'Gösterim');

$tempInfo .= v4Admin::generateTabMenu($adminTabs, $icerik, $dbase);

$tempInfo .= adminInfov3('Döviz bilgileri her 3 saatte bir güncellenmektedir.');


admin($dbase, $where, $icerik, $ozellikler);
