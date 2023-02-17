<?php
 /* Aşağıdaki fonkisyonda login olan kullanıcı menüsünü kişiselleştirebilirsiniz. */
function myUserMenuList()
{
  $userID = $_SESSION['userID'];
  $menuArray[_lang_uyeBilgilerim] = (siteConfig('seoURL') ? 'profile_sp.html' : 'page.php?act=profile');
  if (siteConfig('aff_active')) {
    $menuArray['Affilate Hesabım'] = slink('affilate');
    $menuArray['Banka Bilgilerim'] = slink('banka');
  }
  if (siteConfig('ds_active')) {
    $menuArray['Dropshipping Hesabım'] = slink('dropshipping');
    $menuArray['Banka Bilgilerim'] = slink('banka');
  }
  $menuArray[_lang_adreslerim] = (siteConfig('seoURL') ? 'adres_sp.html' : 'page.php?act=adres');
  if (hq("select urunEkleyebilir from user,userGroups,userGroupMembers where user.ID = userGroupMembers.userID AND user.ID = '" . $userID . "' AND userGroups.ID = userGroupMembers.userGroupID limit 0,1")) {
    $menuArray[_lang_urunlerim] = slink('urunlerim');
    $menuArray[_lang_urunSiparislerim] = slink('showUserOrders');
  }
  if (file_exists('include/mod_Teklif.php') && hq("select user.ID from user,userGroups,userGroupMembers where user.ID = userGroupMembers.userID AND user.ID = '" . $userID . "' AND userGroups.ID = userGroupMembers.userGroupID limit 0,1")) {
    //$menuArray[_lang_tekliflerim]=(siteConfig('seoURL') ? 'tekliflerim_sp.html':'page.php?act=tekliflerim');	
  }
  // if (hq("select bakiyeEkleyebilir from user,userGroups,userGroupMembers where user.ID = userGroupMembers.userID AND user.ID = '".$userID."' AND userGroups.ID = userGroupMembers.userGroupID limit 0,1"))
  {
    $menuArray[_lang_bakiyeYukle] = (siteConfig('seoURL') ? 'bakiye_sp.html' : 'page.php?act=bakiye');
  }
  if (file_exists('include/mod_Davet.php')) {
    $menuArray[_lang_siteDavet] = (siteConfig('seoURL') ? 'modDavet_sp.html' : 'page.php?act=modDavet');
    $menuArray[_lang_siteDavetListe] = (siteConfig('seoURL') ? 'modDavet-liste_sp.html' : 'page.php?act=modDavet-liste');
  }
  $menuArray[_lang_alisverisSepetim] = slink('sepet');
  $menuArray[_lang_oncekiSiparislerim] = slink('showOrders');
  $menuArray[_lang_hataBildirimi] = slink('hataBildirim');
  $menuArray[_lang_havaleBildirimi] = slink('havaleBildirim');
  $menuArray[_lang_alarmListem] = slink('alarmList');
  $menuArray[_lang_cikis] = slink('logout');
  $menuArray[_lang_uyelikIptal] = 'javascript:uyelikIptal(\'' . _lang_uyelikIptalConfirm . '\');';
  return $menuArray;
}

/* Aşağıdaki fonkisyonda urunListShow ve/veya urunGoster.php için yeni makro ekleyebilirsiniz. */
function myUrunTemplateReplace($d, $contents)
{

  if (function_exists('myUrunTemplateReplace2')) return myUrunTemplateReplace2($d['ID'], $contents);
  if (function_exists('myUrunTemplateReplaceX')) return myUrunTemplateReplaceX($d['ID'], $contents);
  return $contents;
}

function updateAutoStock($filter = '')
{
  if (!siteConfig('kodeslestirme'))
  return;
  $q = my_mysql_query("SELECT ID,tedarikciCode, COUNT(*) c FROM urun where tedarikciCode != '' AND stok > 0 " . ($filter ? ' AND (' . $filter . ')' : '') . " GROUP BY tedarikciCode HAVING c > 1 order by fiyat asc");
  while ($d = my_mysql_fetch_array($q)) {
    my_mysql_query("update urun set active = 0 where tedarikciCode like '" . $d['tedarikciCode'] . "'");
    my_mysql_query("update urun set active = 1 where ID = '" . $d['ID'] . "' limit 1");
  }
}

function facebookYorum()
{
  global $siteConfig;
  $width = '100%';

  $out = '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = \'https://connect.facebook.net/tr_TR/sdk.js#xfbml=1&version=v2.12&appId=' . siteConfig('facebook_appID') . '&autoLogAppEvents=1\';
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
<div class="fb-comments" data-href="' . selfURL() . '" data-width="' . $width . '" data-numposts="5"></div>';
  return $out;
}


function paytrTaksit()
{

  $username = hq("select clientID from banka where paymentModulURL like '%payment_paytr%' AND active = 1 limit 0,1");
  $token = hq("select modData1 from banka where paymentModulURL like '%payment_paytr%' AND active = 1 limit 0,1");
  if (!$username || !$token)
  return;
  $qu = my_mysql_query("select * from urun where ID='" . $_GET['urunID'] . "'");
  $du = my_mysql_fetch_array($qu);
  $du['fiyat'] = fixFiyat($du['fiyat'], 0, $du['ID']);
  $du['fiyat'] = YTLfiyat($du['fiyat'], $du['fiyatBirim']);
  $du['fiyat'] = my_money_format('', $du['fiyat']);
  $du['fiyat'] = str_replace(array(','), '', $du['fiyat']);
  $amount = $du['fiyat'];
  $azami = azamiTaksit($_GET['urunID']);
  if ($azami == 1)
  return 'Bu üründe taksit yapılamamaktadır.';
  if (!$azami || $azami > 12)
  $azami = 12;

  return '

	<style>
    #paytr_taksit_tablosu{clear: both;font-size: 12px;max-width: 1200px;text-align: center;font-family: Arial, sans-serif;}
    #paytr_taksit_tablosu::before {display: table;content: " ";}
    #paytr_taksit_tablosu::after {content: "";clear: both;display: table;}
    .taksit-tablosu-wrapper{margin: 5px;width: 280px;padding: 12px;cursor: default;text-align: center;display: inline-block;border: 1px solid #e1e1e1;}
    .taksit-logo img{max-height: 28px;padding-bottom: 10px;}
    .taksit-tutari-text{float: left;width: 126px;color: #a2a2a2;margin-bottom: 5px;}
    .taksit-tutar-wrapper{display: inline-block;background-color: #f7f7f7;}
    .taksit-tutar-wrapper:hover{background-color: #e8e8e8;}
    .taksit-tutari{float: left;width: 126px;padding: 6px 0;color: #474747;border: 2px solid #ffffff;}
    .taksit-tutari-bold{font-weight: bold;}
    @media all and (max-width: 600px) {.taksit-tablosu-wrapper {margin: 5px 0;}}
</style>
<div id="paytr_taksit_tablosu"></div>
<script src="https://www.paytr.com/odeme/taksit-tablosu/v2?token=' . $token . '&merchant_id=' . $username . '&amount=' . $amount . '&taksit=' . $azami . '&tumu=0"></script>';
}

function iyziTaksit()
{
  $username = hq("select username from banka where paymentModulURL like '%payment_iyzi%' limit 0,1");
  if (!$username) return;

  $qu = my_mysql_query("select * from urun where ID='" . $_GET['urunID'] . "'");
  $du = my_mysql_fetch_array($qu);
  $du['fiyat'] = fixFiyat($du['fiyat'], 0, $du['ID']);
  $du['fiyat'] = YTLfiyat($du['fiyat'], $du['fiyatBirim']);
  $du['fiyat'] = my_money_format('', $du['fiyat']);
  $du['fiyat'] = str_replace(array(',', '.'), '', $du['fiyat']);
  $amount = $du['fiyat'];
  $currency = 'TL';
  $timestamp = date('YmdHis'); // Timestamp
  $apiID = $username; // Merchant API ID - in current eg., 
  $publicKey = sha1($apiID);
  $hash = sha1($apiID . $timestamp . $amount);
  $out = "<iframe height='500' width='900' src='https://www.iyzico.com/installment/amount/$amount/currency/$currency/publicKey/$publicKey/timeStamp/$timestamp/hash/$hash' seamless='seamless'></iframe>";
  return $out;
}

/* Aşağıdaki fonkisyonda kullanıcı ürün ekleme formunu kişiselleştirebilirisniz. */
function getMakaleUrunEkleForm()
{
  if (function_exists('myGetMakaleUrunEkleForm')) return myGetMakaleUrunEkleForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  // Aşağıdaki satırı açarak kullanıcının sadece 99 ID'li kategori altındaki kategorilere ürün ekleyebilmesini sağlayabilirsiniz.
  // $urunEkleRootID = 99;

  switch($_GET['mcatID'])
  {
    default:
      $form[] = array(_lang_form_urunAdi, "name", "TEXTBOX", 1, '', 1, 2);
      $form[] = array(_lang_form_urunMarka, "markaID", "MARKALIST", 1, '', 1, 0);
      $form[] = array(_lang_form_urunKategori, "catID", "KATEGORILIST", 1, '', 1, 5);
      $form[] = array(_lang_form_urunResim . ' 1 (jpg,gif)', "resim", "RESIMUPLOAD", 1, '', 0, 5);
      $form[] = array(_lang_form_urunResim . ' 2 (jpg,gif)', "resim2", "RESIMUPLOAD", 1, '', 0, 5);
      $form[] = array(_lang_form_urunResim . ' 3 (jpg,gif)', "resim3", "RESIMUPLOAD", 1, '', 0, 5);
      $form[] = array(_lang_form_urunListeAciklama, "listeDetay", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunOnDetay, "onDetay", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunDetay, "detay", "TEXTAREA", 1, '', 0, 5);
      $form[] = array(_lang_form_urunSatisFiyatiKDVDahil, "fiyat", "TEXTBOX", 1, '', 1, 0);
      $form[] = array(_lang_form_urunSatisBirim, "fiyatBirim", "SELECT", 1, array('TL', 'USD', 'EUR'), 1, 0);
      $form[] = array(_lang_form_urunSatisKDV, "kdv", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunGaranti, "garanti", "TEXTBOX", 1, '', 0, 5);
      $form[] = array(_lang_form_urunStok, "stok", "TEXTBOX", 1, '', 1, 0);
      $form[] = array(_lang_form_urunDesi, "desi", "TEXTBOX", 1, '', 0, 5);
    break;
  }


  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı ürün ekleme formunu kişiselleştirebilirisniz. */
function getUrunEkleForm()
{
  if (function_exists('myGetUrunEkleForm')) return myGetUrunEkleForm();
  global $urunEkleRootID;

  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  // Aşağıdaki satırı açarak kullanıcının sadece 99 ID'li kategori altındaki kategorilere ürün ekleyebilmesini sağlayabilirsiniz.
  // $urunEkleRootID = 99;

  $form[] = array(_lang_form_urunAdi, "name", "TEXTBOX", 1, '', 1, 2);
  $form[] = array(_lang_form_urunMarka, "markaID", "MARKALIST", 1, '', 1, 0);
  $form[] = array(_lang_form_urunKategori, "catID", "KATEGORILIST", 1, '', 1, 5);
  $form[] = array(_lang_form_urunResim . ' 1 (jpg,gif)', "resim", "RESIMUPLOAD", 1, '', 0, 5);
  $form[] = array(_lang_form_urunResim . ' 2 (jpg,gif)', "resim2", "RESIMUPLOAD", 1, '', 0, 5);
  $form[] = array(_lang_form_urunResim . ' 3 (jpg,gif)', "resim3", "RESIMUPLOAD", 1, '', 0, 5);
  $form[] = array(_lang_form_urunListeAciklama, "listeDetay", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunOnDetay, "onDetay", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunDetay, "detay", "TEXTAREA", 1, '', 0, 5);
  $form[] = array(_lang_form_urunSatisFiyatiKDVDahil, "fiyat", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_urunSatisBirim, "fiyatBirim", "SELECT", 1, array('TL', 'USD', 'EUR'), 1, 0);
  $form[] = array(_lang_form_urunSatisKDV, "kdv", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunGaranti, "garanti", "TEXTBOX", 1, '', 0, 5);
  $form[] = array(_lang_form_urunStok, "stok", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_urunDesi, "desi", "TEXTBOX", 1, '', 0, 5);
  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı adres ekleme formunu kişiselleştirebilirsiniz. */
function getAdresEkleForm()
{
  if (function_exists('myGetAdresEkleForm')) return myGetAdresEkleForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  $form[] = array(_lang_form_adresAdi, "baslik", "TEXTBOX", 1, '', 1, 2);
  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
	$form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
	$form[] = array(_lang_form_telefonNumaraniz, "ceptel", "TELEPHONE", 1, '', 0, 0);
  $form[] = array(_lang_form_tckno, "tckNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_adresiniz, "address", "TEXTAREA", 1, '', 1, 10);
  $form[] = array(_lang_form_sehir, "city", "CITY", 1, '', 1, 4);
  $form[] = array(_lang_form_semt, "semt", "TOWN", 1, '', 1, 3);
  $form[] = array(_lang_form_firmaUnvani, "firmaUnvani", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiDaireniz, "vergiDaire", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiNumaraniz, "vergiNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = array('E-Fatura', "efatura", "SELECT", 1, array(_lang_formEvet, _lang_formHayir), 0, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda ürün geri bildirim formunu kişiselleştirebilirsiniz. */
function getFeedbackForm()
{
  if (function_exists('myGetFeedbackForm')) return myGetFeedbackForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
  $form[] = '<li class="feedback-container"><ul>';
  $form[] = array(_lang_form_aciklamaYetersiz, "aciklama", "CHECKBOX", 0);
  $form[] = array(_lang_form_hataliBilgi, "hatalibilgi", "CHECKBOX", 0);
  $form[] = array(_lang_form_urunPahali, "pahali", "CHECKBOX", 0);
  $form[] = array(_lang_form_resimKalitesiz, "resimhatali", "CHECKBOX", 0);
  $form[] = array(_lang_form_tekinHata, "teknikhata", "CHECKBOX", 0);
  $form[] = array(_lang_form_yazimHatasi . '<br /><br />', "yazimhatasi", "CHECKBOX", 0);
  $form[] = '</ul></li>';
  $form[] = array(_lang_form_adinizSoyadiniz, "namelastname", "TEXTBOX", 1);
  $form[] = array(_lang_form_telefonNumaraniz, "tel", "TELEPHONE", 1);
  $form[] = array(_lang_form_emailAdresiniz, "email", "EMAIL", 1);
  $form[] = array(_lang_form_detaylar, "message", "TEXTAREA", 1);
  return $form;
}

function getQstForm()
{
  if (function_exists('myGetQstForm')) return myGetQstForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  $form[] = array(_lang_form_adinizSoyadiniz, "namelastname", "TEXTBOX", 1, '', 1);
  $form[] = array(_lang_form_emailAdresiniz, "email", "EMAIL", 1, '', 1);
  $form[] = array(_lang_form_sorunuz, "message", "TEXTAREA", 1, '', 1);
  return $form;
}

function getIptalForm()
{
  if (function_exists('myGetIptalForm')) return myGetIptalForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
  $form[] = array(_lang_form_iptalNeden, "message", "TEXTAREA", 1, '', 1);
  return $form;
}


/* Aşağıdaki fonkisyonda iletişim formunu kişiselleştirebilirsiniz. */
function getContactForm()
{
  if (function_exists('myGetContactForm')) return myGetContactForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  $form[] = array(_lang_form_adinizSoyadiniz, "namelastname", "TEXTBOX", 1, '', 1, 5);
  $form[] = array(_lang_form_telefonNumaraniz, "ceptel", "TELEPHONE", 1, '', 0, 0);
  $form[] = array(_lang_form_emailAdresiniz, "email", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_mesajinizibKonusu, "subject", "TEXTBOX", 1, '', 1, 1);
  $form[] = array(_lang_form_mesajiniz, "message", "TEXTAREA", 1, '', 1);
  $form[] = array(_lang_form_kvkkOkudum, "kvkk", "ACCEPTRULES", 1, "", 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı kayıt formunu kişiselleştirebilirsiniz. */
function getQuickRegisterForm()
{
  if (function_exists('myGetQuickRegisterForm')) return myGetQuickRegisterForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  //$form[] = array(_lang_form_kullaniciAdiniz,"username","TEXTBOX",1,'',1,5);
  //if($_GET['act'] == 'register')
  //	$form[] = '<li class="sf-form-header"><input name="uye-tipi" type="radio" value="bireysel" id="bireysel"> <label for="bireysel">Bireysel Üyelik</label> - <input name="uye-tipi" type="radio" value="kurumsal" id="kurumsal"> <label for="kurumsal">Kurumsal Üyelik</label></li>';
  $form[] = _lang_epostaAdresiniz;
  $form[] = array(_lang_form_emailAdresiniz, "email", "EMAIL", 1, '', 1, 0);
  $form[] = _lang_guvenlik;
  $form[] = array(_lang_form_sifreniz, "password", "PASSWORD", 1, '', 1, 5);

  $form[] = _lang_kisiselBilgiler;
  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
  $form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
  $form[] = '<div class="bireysel">';
  $form[] = array(_lang_form_dogumTarihiniz, "birthdate", "DATE", 1, '', 1, 0);
  //$form[] = array(_lang_form_Resim.' 1 (jpg,gif,png)',"resim","RESIMUPLOAD",1,'',1,0);
  //$form[] = array(_lang_form_Resim.' 2 (jpg,gif,png)',"resim2","RESIMUPLOAD",1,'',0,0);
  $form[] = '</div>';

  if ($_GET['act'] == 'register') $form[] = array(_lang_form_uyelikKurallariOkudum, "uyelikKural", "ACCEPTRULES", 1, "", 1, 0);
  checkForFields($form, 'user');
  return $form;
}

/* Aşağıdaki fonkisyonda kullanıcı kayıt formunu kişiselleştirebilirsiniz. */
function getRegisterForm()
{
  if (function_exists('myGetRegisterForm')) return myGetRegisterForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  //$form[] = array(_lang_form_kullaniciAdiniz,"username","TEXTBOX",1,'',1,5);
  //if($_GET['act'] == 'register')
  //	$form[] = '<li class="sf-form-header"><input name="uye-tipi" type="radio" value="bireysel" id="bireysel"> <label for="bireysel">Bireysel Üyelik</label> - <input name="uye-tipi" type="radio" value="kurumsal" id="kurumsal"> <label for="kurumsal">Kurumsal Üyelik</label></li>';
  $form[] = _lang_epostaAdresiniz;
  $form[] = array(_lang_form_emailAdresiniz, "email", "EMAIL", 1, '', 1, 0);
  $form[] = array(_lang_form_emailAdresinizTekrar, "check_email", "EMAIL", 1, '', 1, 0);
  $form[] = _lang_guvenlik;
  if ($_GET['act'] == 'profile') {
    /* Profile 'de şifre zorunlu değil. Boşsa eski şifre geçerli */
    $form[] = array(_lang_form_sifreniz, "password", "PASSWORD", 1, '', 0, 5);
    $form[] = array(_lang_form_sifrenizTekrar, "check_password", "PASSWORD", 1, '', 0, 5);
  } else {
    $form[] = array(_lang_form_sifreniz, "password", "PASSWORD", 1, '', 1, 5);
    $form[] = array(_lang_form_sifrenizTekrar, "check_password", "PASSWORD", 1, '', 1, 5);
  }
  $form[] = _lang_kisiselBilgiler;
  // $form[] = array(_lang_davetKullanici,"davetUserID","USERLIST",1,'',1,0);
  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
  $form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
  $form[] = '<div class="bireysel">';
  $form[] = array(_lang_form_dogumTarihiniz, "birthdate", "DATE", 1, '', 1, 0);
  //	$form[] = array(_lang_form_cinsiyetiniz, "sex", "SELECT", 1, array(_lang_form_kadin, _lang_form_erkek), 1, 0);
  $form[] = array(_lang_form_tckno, "tckNo", "TEXTBOX", 1, '', 0, 0);
  //$form[] = array(_lang_form_Resim.' 1 (jpg,gif,png)',"resim","RESIMUPLOAD",1,'',1,0);
  //$form[] = array(_lang_form_Resim.' 2 (jpg,gif,png)',"resim2","RESIMUPLOAD",1,'',0,0);
  $form[] = '</div>';
  $form[] = '<div class="kurumsal">';
  $form[] = '';
  // $form[] = array(_lang_form_firmaUnvani,"firmaUnvani","TEXTBOX",1,'',0,0);		
  $form[] = array(_lang_form_vergiDaireniz, "vergiDaire", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiNumaraniz, "vergiNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = array('E-Fatura', "efatura", "SELECT", 1, array(_lang_formEvet, _lang_formHayir), 0, 0);
  $form[] = '</div>';
  $form[] = _lang_iletisimBilgileri;
  //$form[] = array(_lang_form_ulke,"country","COUNTRY",1,'',1,4);
  $form[] = array(_lang_form_sehir, "city", "CITY", 1, '', 1, 4);
  $form[] = array(_lang_form_semt, "semt", "TOWN", 1, '', 1, 3);
  $form[] = array(_lang_form_adresiniz, "address", "TEXTAREA", 1, '', 1, 10);
  $form[] = '<div class="bireysel">';
  //	$form[] = array(_lang_form_evTelefonunuz, "evtel", "TELEPHONE", 1, '', 0, 0);
  $form[] = '</div>';
  $form[] = '<div class="kurumsal">';
  //	$form[] = array(_lang_form_isTelefonunuz, "istel", "TELEPHONE", 1, '', 0, 0);
  $form[] = '</div>';
  $form[] = array(_lang_form_cepTelefonunuz, "ceptel", "TELEPHONE", 1, '', 1, 0);
  $form[] = '';
  $form[] = array(_lang_ebulten . ' (Email)', "ebulten", "SELECT", 1, array('1|' . _lang_evet, '2|' . _lang_hayir . '|0'), 1, 0);
  if (siteConfig('SMS_kullan'))
  $form[] = array(_lang_ebulten . ' (SMS)', "ebultenSMS", "SELECT", 1, array('1|' . _lang_evet, '2|' . _lang_hayir . '|0'), 1, 0);
  if ($_GET['act'] == 'register') {
    $form[] = '';
    $form[] = array(_lang_form_kvkkOkudum, "kvkk", "ACCEPTRULES", 1, "", 1, 0);
    $form[] = array(_lang_form_uyelikKurallariOkudum, "uyelikKural", "ACCEPTRULES", 1, "", 1, 0);
  }
  $form[] = '';
  checkForFields($form, 'user');
  return $form;
}

/* Aşağıdaki fonkisyonda affilate banka hesabı formunu kişiselleştirebilirsiniz. */
function getBankaForm()
{
  if (function_exists('myGetBankaForm')) return myGetBankaForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  $form[] = array(_lang_form_bankaAdi, "aff_banka", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaHesapAdi, "aff_name", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaIbanNo, "aff_iban", "TEXTBOX", 1, '', 0, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda affilate başvuru formunu kişiselleştirebilirsiniz. */
function getAffBasvuruForm()
{
  if (function_exists('myGetAffBasvuruForm')) return myGetAffBasvuruForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  $form[] = array(_lang_form_aff_siteAdresi, "aff_web", "TEXTBOX", 1, '', 1, 0);
  $form[] = array(_lang_form_bankaAdi, "aff_banka", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaHesapAdi, "aff_name", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaIbanNo, "aff_iban", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_aff_not, "aff_not", "TEXTAREA", 1, '', 0, 0);
  $form[] = array(_lang_form_aff_kural, "aff_kural", "ACCEPTRULES", 1, "", 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda affilate başvuru formunu kişiselleştirebilirsiniz. */
function getDsBasvuruForm()
{
  if (function_exists('myGetDsBasvuruForm')) return myGetDsBasvuruForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  // $form[] = array(_lang_form_aff_siteAdresi,"aff_web","TEXTBOX",1,'',1,0);
  $form[] = array(_lang_form_bankaAdi, "aff_banka", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaHesapAdi, "aff_name", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_bankaIbanNo, "aff_iban", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_mesajiniz, "ds_not", "TEXTAREA", 1, '', 0, 0);
  $form[] = array('Dropshipping ' . _lang_form_uyelikKurallariOkudum, "ds_kural", "ACCEPTRULES", 1, "", 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda affilate başvuru formunu kişiselleştirebilirsiniz. */
function getSortForm()
{
  if (function_exists('myGetSortForm')) return myGetSortForm();
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",[Düzenlenebilir : 1 | Düzenlenemez : 0],'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);

  //$form[] = array(_lang_form_Resim.' (jpg,gif)',"resim","RESIMUPLOAD",1,'',0,5);
  $form[] = array(_lang_form_BaslangicTarihi, "start", "DATE", 1, '', 1, 0);
  $form[] = array(_lang_form_BitisTarihi, "finish", "DATE", 1, '', 1, 0);
  return $form;
}

/* Aşağıdaki fonkisyonda sipariş formunu kişiselleştirebilirsiniz. */
function getSiparisForm()
{
  if (function_exists('myGetSiparisForm')) return myGetSiparisForm();
  global $siteConfig;
  // Aşağıdaki satırı kullanarak data1 ... data5 arası manuel satırları ekleyebilirsiniz.
  // $form[] = array("BASLIK","data[1|5]","TEXTBOX",1,'',[Zorunlu Field : 1 | Zorunlu Değil : 0] ,[Minimum karakter sınırı]);
  // Örnek : 
  // $form[] = array("TC Kimlik No","data1","TCKIMLIKNO",1,'',1,10);
  // $form[] = array("Musteri ID","data2","TEXTBOX",1,'',1,5);
  // $form[] = array("Ek Bilgi","data3","TEXTBOX",1,'',1,5);

  $form[] = array(_lang_form_adiniz, "name", "TEXTBOX", 1, '', 1, 3);
  $form[] = array(_lang_form_soyadiniz, "lastname", "TEXTBOX", 1, '', 1, 2);
  $form[] = array(_lang_form_emailAdresiniz, "email", "EMAIL", 1, '', 1, 0);
  //$form[] = array(_lang_form_evTelefonunuz, "evtel", "TELEPHONE", 1, '', 0, 0);
  //$form[] = array(_lang_form_isTelefonunuz, "istel", "TELEPHONE", 1, '', 0, 0);
  $form[] = array(_lang_form_cepTelefonunuz, "ceptel", "TELEPHONE", 1, '', 1, 0);
  $form[] = array(_lang_form_tckno, "tckNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = _lang_vergiBilgileri;
  $form[] = array(_lang_form_vergiDaireniz, "vergiDaire", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_vergiNumaraniz, "vergiNo", "TEXTBOX", 1, '', 0, 0);
  $form[] = array(_lang_form_firmaUnvani, "firmaUnvani", "TEXTBOX", 1, '', 0, 0);


  $form[] = array('E-Fatura', "efatura", "SELECT", 1, array(_lang_formEvet, _lang_formHayir), 0, 0);
  $form[] = _lang_teslimatAdresi;
  if ($_SESSION['userID'] && hq('select ID from useraddress where userID=\'' . $_SESSION['userID'] . '\'')) $form[] = array(_lang_form_kayitliAdresleriniz, "addressID", "ADDRESS", 1, '', 0, 10);
  $form[] = array(_lang_form_adresiniz, "address", "TEXTAREA", 1, '', 1, 10);
  //$form[] = array(_lang_form_ulke,"country","COUNTRY",1,'',1,4);
  $form[] = array(_lang_form_sehir, "city", "CITY", 1, '', 1, 4);
  $form[] = array(_lang_form_semt, "semt", "TOWN", 1, '', 1, 3);

  if (!isReallyMobile())
  $form[] = '<li class="sf-form-header"><input id="fatura" type="checkbox"> <label for="fatura">' . _lang_faturaAdresimFarkli . '</label> </li><div class="fatura">';
  // $form[] = 'Fatura Adresi';
  if ($_SESSION['userID'] && hq('select ID from useraddress where userID=\'' . $_SESSION['userID'] . '\'')) $form[] = array(_lang_form_kayitliAdresleriniz, "addressID2", "ADDRESS", 1, '', 0, 10);
  $form[] = array(_lang_form_faturaAdresi, "address2", "TEXTAREA", 1, '', 0, 0);
  //$form[] = array(_lang_form_ulke,"country2","COUNTRY",1,'',1,4);
  $form[] = array(_lang_form_sehir, "city2", "CITY", 1, '', 0, 0);
  $form[] = array(_lang_form_semt, "semt2", "TOWN", 1, '', 0, 0);


  if (!isReallyMobile())
  $form[] = '</div>';


  $form[] = _lang_kargoSecenegi;
  // Eğer kargo firması eklendiyse bu satırı göster.
  if (hq("select ID from kargofirma where ID!=0") && kargoFirmaListele() && !$_SESSION['bakiyeOdeme']) {
    $form[] = array(_lang_form_kargo, "kargoFirmaID", "KARGO", 1, '', 1, 0);
  }
  // Eğer teslimat saati eklendiyse bu satırı göster.
  if (hq("select ID from teslimat")) {
    $form[] = array(_lang_form_teslimat, "teslimatID", "TESLIMAT", 1, '', 1, 0);
  }
  $form[] = _lang_hediyeindirim;

  //	$form[] = '';
  $form[] = array(_lang_form_siparisNotu, "notAlici", "TEXTAREA", 1, '', 0, 0);
  $form[] = array(_lang_form_hediyePaketi, "hediye", "SELECT", 1, array(_lang_formEvet, _lang_formHayir), 0, 0);

  if (isReallyMobile() && basketInfo('toplamKDVDahil', $_SESSION['randStr']) >= siteConfig('promosyonAlisverisSiniri'))
  $form[] = array(_lang_form_promosyonKodu, "promotionCode", "TEXTBOX", 1, '', 0, 0);



  //$form[] = array('Sipariş Saati',"data1","CUSTOM",1,siparisSaati(),0,0);

  if (siteConfig('ds_active') && userGroupID() && hq("select ds_active from userGroups where ID='" . userGroupID() . "'") && hq("select ds_onay from user where ID='" . $_SESSION['userID'] . "'")) {
    $form[] = '';
    $form[] = array('Dropshipping Tahsilat Tutarı (TL)', "ds_tutar", "TEXTBOX", 1, '', 0, 0);
  }

  $form[] = '';
  if (siteConfig('sepet_odeme') == '2' || siteConfig('sepet_odeme') == '1' || isReallyMobile()) 
  {

    $form[] = array(_lang_titleOdemeSekliniz, "odemeTipi", "SELECTV", 1, siparisOdemeSecimArray(), 1, 0);
    $form[] = '';
    $form[] = array(_lang_form_satinAlmaKurallariOkudum, "satinalKural", "ACCEPTRULES", 1, "", 1, 0);
  }
  /*
	if($_GET['sn'])
		$form[] = array('Site Mesaj',"notYonetici","TEXTAREA",1,'',1,10);
	 */
  checkForFields($form, 'siparis');
  return $form;
}

$saatler = array('10:30', '13:30', '15:00', '18:00');
$maxGun = 3;
$saatKoruma = 2;

function siparisSaati()
{
  global $saatler, $maxGun, $saatKoruma;
  $out = '<table class="siparisSaati" cellpadding="0" cellspacing="1"><tr>
			<td>Saatler</td>';
  for ($i = 0; $i <= $maxGun; $i++) {
    $tarih = date('Y-m-d', mktime((date('H')), date('i'), date('s'), date('m'), (date('d') + $i), date('Y')));
    $out .= '<td>' . mysqlTarih($tarih) . '</td>' . "\n";
  }
  $out .= '</tr>';
  foreach ($saatler as $saat) {
    $out .= '<tr class="saat"><td>' . $saat . '</td>';
    for ($i = 0; $i <= $maxGun; $i++) {
      $tarih = date('Y-m-d', mktime((date('H')), date('i'), date('s'), date('m'), (date('d') + $i), date('Y')));
      list($s, $d) = explode(':', $saat);
      $stop = false;
      if ($i == 0) {
        if (date('H') > ($s - $saatKoruma)) $stop = true;
        else
					if (date('H') == ($s - $saatKoruma))
        if (date('i') > $m)
        $stop = true;
        if (hq("select ID from stats where k like 'teslimatSaati' AND v like '" . $tarih . ':' . $saat . "'"))
        $stop = true;
      }
      if (!$stop)
      $out .= '<td><center><input name="data_data1" type="radio" value="' . mysqlTarih($tarih) . ' : ' . $saat . '"></center></td>' . "\n";
      else
      $out .= '<td class="dolu"><center>' . _lang_dolu . '</center></td>' . "\n";
    }
    $out .= '</tr>';
  }
  $out .= '</table>';

  $out .= '
	<style>
		.siparisSaati  {  background-color:#ccc; padding:0; margin:0; border:none; width:100%; }
		.siparisSaati td { background-color:white; }
		.siparisSaati tr.saat:hover td { background-color:#555; color:white; }
		.siparisSaati .dolu { background-color:#555; color:white; font-weight:bold; }

	</style>
	';
  return $out;
}

/* Aşağıdaki fonkisyonda açıp, sepet ve satın alma ekranınlarını gösteren bar'ı aktif edebilirsiniz. */
// $actHeaderArray['sepet'] = $actHeaderArray['satinal'] = siraGoster();

/* Aşağıdaki fonkisyonda satın alma adımlarını gösteren bar'ı kişiselleştirebilirsiniz. */
function siraGoster()
{
  $out = '<div class="multi-step five-steps">
			<ol>
				<li id="ms_1">
					<div class="wrap">
						<p class="title">' . _lang_sepet . '</p>
						<p class="subtitle">' . _lang_sepetiniziOnaylayin . '</p>
					</div>
				</li>
				<li id="ms_2">
					<div class="wrap">
						<p class="title">' . _lang_adres . '</p>
						<p class="subtitle">' . _lang_teslimatBilgileriniziGirin . '</p>
					</div>
				</li>
				<li id="ms_3">
					<div class="wrap">
						<p class="title">' . _lang_odemeSecim . '</p>
						<p class="subtitle">' . _lang_odemeTipiSecimiYapin . '</p>
					</div>
				</li>
				<li id="ms_4">
					<div class="wrap">
						<p class="title">' . _lang_odemeGiris . '</p>
						<p class="subtitle">' . _lang_odemeBilgileriniGirin . '</p>
					</div>
				</li>
				<li id="ms_5">
					<div class="wrap">
						<p class="title">' . _lang_onay . '</p>
						<p class="subtitle">' . _lang_odemenizTamamlandi . '</p>
					</div>
				</li>
			</ol>
		</div>';
  $out .= "<script type='text/javascript'>$('.multi-step li:eq(" . (alisverisSirasix() - 1) . ")').addClass('current');</script>";
  return $out;
}

function alisverisSirasix()
{
  global $tamamlandi;
  $out = 1;
  list($x, $_GET['op']) = explode('-', $_GET['replaceGet']);
  if ($_GET['act'] == 'satinal') {
    if ($_GET['op'] == 'adres') $out = 2;
    if ($_GET['op'] == 'adres' && $_POST['data_address']) $out = 3;
    if ($_GET['paytype']) $out = 4;
    if ($tamamlandi) $out = 5;
  }
  return $out;
}

function textBox($backColor, $textColor, $fontSize, $text)
{
  $out = '<div class="textBox">' . "\n";
  $out .= '<div style="background-color:' . $backColor . ';color:' . $textColor . ';font-size:' . $fontSize . 'px;">' . $text . '</div></div>' . "\n";
  return $out;
}



function scriptmenu()
{
  $out = '';

  if (siteConfig('promosyonTeklifAktif'))
  include('mod_Promosyon.php');
  if (siteConfig('splash_active'))
  include('mod_Splash.php');

  stats_update();
  require_once('include/mod_FacebookPopup.php');
  if (function_exists('facebookPopup') && !$_SESSION['facebookPopup'] && siteConfig('facebook_URL') && siteConfig('facebook_Popup')) {
    $out .= facebookPopup();
    $_SESSION['facebookPopup'] = 1;
  }

  if (function_exists('facebookFloating') && siteConfig('facebook_Floating')) {
    $out .= facebookFloating();
  }
  $out .= "<iframe src='update.php' style='display:none;' width='1' height='1'></iframe>";
  if (siteConfig('criteoAccountID')) {
    include_once('mod_CriteoTracking.php');
    $out .= criteoReconversion();
  }
  $out.=googleDynr();
  if (siteConfig('cookie')) {
    $out .= '<script type="text/javascript">
						window.cookieconsent_options = {"message":"' . addslashes(_lang_cookieAccept) . '","dismiss":"' . _lang_onayliyorum . '","learnMore":"More info","link":null,"theme":"dark-bottom"};
					</script>					
					<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
					<!-- End Cookie Consent plugin -->';
  }

  $out .= str_replace('&#39;', "'", siteConfig('google_analytics'));
  $out .= str_replace('&#39;', "'", siteConfig('pc_code'));
  $out .= str_replace('&#39;', "'", siteConfig('google_remarketing'));
  if(siteConfig('facebook_pixel'))
  {
    $out .= str_replace('&#39;', "'", siteConfig('facebook_pixel'));
    $out .= facebookPixel();
  }
  $out .= googleReconversion();
  if (function_exists('searchRichSnippets'))
    $out .= searchRichSnippets();
  if (function_exists('googleOdeme'))
    $out .= googleOdeme();
  if ($_SESSION['googleConversion']) {
    $out .= $_SESSION['googleConversion'];
    unset($_SESSION['googleConversion']);
  }
  if ($_SESSION['googleConversionUye']) {
    $out .= $_SESSION['googleConversionUye'];
    unset($_SESSION['googleConversionUye']);
  }
  if (siteConfig('google_purchases')) {
    require_once('mod_GooglePurchases.php');
    $out .= googlePurchases();
  }
  return $out;
}

function tr2eu($str, $ucFirst = false)
{
  if ($ucFirst) $str = strtolower($str);
  $str = str_replace(array('ğ', 'ü', 'ş', 'ı', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'), array('g', 'u', 's', 'i', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'), $str);
  if ($ucFirst) $str = ucfirst($str);
  return $str;
}

function trupper($str)
{
  $str = str_replace(array('ğ', 'ü', 'ş', 'ı', 'ö', 'ç', 'i'), array('Ğ', 'Ü', 'Ş', 'I', 'Ö', 'Ç', 'İ'), $str);
  return strtoupper($str);
}


function ajaxfix($tck, $iconv = false)
{
  return $tck;
}

function utf8fix($tck, $iconv = false, $tr = false)
{
  return $tck;
}

function tr_cevir($str)
{
  $str = str_replace(array('&amp;', '&Ccedil;', '&ccedil;', '&#286;', '&#287;', '&#304;', '&#305;', '&Ouml;', '&ouml;', '&#350;', '&#351;', '&Uuml;', '&uuml;'), array('&', 'Ç', 'ç', 'Ğ', 'ğ', 'İ', 'ı', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü'), $str);
  return $str;
}

function generateTemplateFinish()
{
  global $disablehelp, $shopphp_demo;
  $out = scriptmenu();
  $out .= sepetGoster();

  if (!siteConfig('telif-footer') && !$disablehelp && !$shopphp_demo && !isset($_GET['viewPopup']) && (!basename($_SERVER['SCRIPT_FILENAME']) || basename($_SERVER['SCRIPT_FILENAME']) == 'index.php' || basename($_SERVER['SCRIPT_FILENAME']) == 'page.php'))
  $out .= '<div class="powered-by"><a class="shopphp" title="ShopPHP" href="https://www.shopphp.net/" target="_blank">ShopPHP</a> <a class="e-ticaret" title="E-Ticaret" href="https://www.shopphp.net/" target="_blank">E-Ticaret</a> | v4</div>';
  // Aşağıdaki satırın, document.ready'den farkı, HTML load bittikten, ama document.ready çağılmadan çalışmasıdır.
  $out .= '<script language="javascript" type="text/javascript">tempStart();</script>';

  return $out;
}

function generateTemplateHead()
{
  global $siteDizini, $disableJquery,$shopphp_demo;
  $out  = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
  $out .= '<meta name="keywords" content="' . cleanForMetaTags(siteConfig('metaKeywords')) . '" />' . "\n";
  $out .= '<meta name="description" content="' . cleanForMetaTags(siteConfig('metaDescription')) . '" />' . "\n";
  $out .= '<meta http-equiv="x-dns-prefetch-control" content="on">
  <link rel="dns-prefetch" href="//ajax.googleapis.com" />';
  if($_GET['paytype'])
    $out.='<meta http-equiv="refresh" content="600;url='.$siteDizini.'" />';
  if (!$_GET['setFilter'] && !$shopphp_demo)
    $out .= '<meta name="robots" content="index, follow"/>' . "\n";
  else
    $out .= '<meta name="robots" content="noindex, nofollow"/>' . "\n";
  $out .= '<meta name="Language" content="Turkish" />' . "\n";
  $out .= '<meta http-equiv="Content-Language" content="tr" />' . "\n";
  $out .= SEO::setCanonicalURL();
  $out .= '<base href="http' . (isSSL() ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $siteDizini . '" />' . "\n";
  if (siteConfig('google_meta')) {
    $googleMeta = siteConfig('google_meta');

    if (!(stristr($googleMeta, 'content') === false)) {
      $array = array();
      preg_match('/content="([^"]*)"/i', $googleMeta, $array);
      $googleMeta = $array[1];
    }
    $out .= '<meta name="google-site-verification" content="' . $googleMeta . '"/>' . "\n";
  }
  $nofArray = array('login', 'register', 'profile', 'siparistakip', 'sepet', 'satinal');
  if (in_array($_GET['act'], $nofArray))
  $out .= '<meta name="robots" content="noindex, nofollow" />' . "\n";
  $out .= SEO::socialMetaTags();

  $out .= '<title>' . siteConfig('title') . '</title>' . "\n";
  $out .= '<link rel="shortcut icon" type="image/png" href="images/' . (siteConfig('favicon') ? siteConfig('favicon') : 'shop.png') . '"/>' . "\n";
  $out .= '<link rel="stylesheet" href="css/all-css.php" />' . "\n";
  $out .= '<link rel="stylesheet" href="templates/' . siteConfig('templateName') . '/style.css" />' . "\n";
  $out .= '<link rel="manifest" href="manifest.json">';
  if ($_GET['act'] == 'urunDetay')
  $out .= '<link rel="stylesheet" href="css/popup.cc.css" />';
  if (!$disableJquery) {
      $out .= '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>' . "\n";
  }
  $out .= '<script type="text/javascript" src="js/all-js.php" type="text/javascript"></script>' . "\n";
  $out .= '<script src="templates/' . siteConfig('templateName') . '/temp.js" type="text/javascript"></script>' . "\n";
  $out .= str_replace(array('&#39;'), array("'"), siteConfig('google_head'));

  return $out;
}

function myShowItemTab($urunID)
{
  global $langPrefix;
  $tabBaslik = hq("select tabbaslik$langPrefix from urun where ID='$urunID'");
  $out = '<div id="tabs1">
  <ul>
    <li><a id="option1" href="#" onclick="openTab(1); return false;" title="' . _lang_urunOzellikleri . '"><span>' . _lang_urunOzellikleri . '</span></a></li>
    <li><a id="option8" href="#" onclick="openTab(8); return false;" ' . (hq("select video from urun where ID='$urunID'") ? '' : 'style="display:none;"') . '  title="Video"><span>' . _lang_video . '</span></a></li>    
    <li><a id="option5" href="#" onclick="openTab(5); return false;" title="' . _lang_odemeBilgileri . '"><span>' . _lang_odemeBilgileri . '</span></a></li>
    <li><a id="option2" href="#" onclick="openTab(2); return false;" title="' . _lang_urunResimleri . '"><span>' . _lang_urunResimleri . '</span></a></li>
    <li><a id="option4" href="#" onclick="openTab(4); return false;" title="' . _lang_urunYorumlari . '"><span>' . _lang_urunYorumlari . '</span></a></li>
    <li><a id="option7" href="#" onclick="openTab(7); return false;" title="' . _lang_titleSikcaSorularnSorular . '"><span>' . _lang_titleSikcaSorularnSorular . '</span></a></li>
    <li><a id="option3" href="#" onclick="openTab(3); return false;" title="' . _lang_geriBildirim . '"><span>' . _lang_geriBildirim . '</span></a></li>
    '.($tabBaslik?'<li><a id="option9" href="#" onclick="openTab(9); return false;" title="' . $tabBaslik . '"><span>' . $tabBaslik . '</span></a></li>':'').'

  </ul>
</div>';
  $out .= '<img src="images/spacer.gif" width=1 height=15><br /><div id="tabData" class="tabData">';
  $out .= '<div id="tabData1" style="display:none;">' . hq("select detay$langPrefix from urun where ID='$urunID'") . '<div style="clear:both">&nbsp;</div>' . urunTemplateReplace($urunID, '{%FILTRE_TABLO%}') . '</div>';
  $out .= '<div id="tabData8" style="display:none;">' . hq("select video from urun where ID='$urunID'") . '</div>';
  if($tabBaslik)
    $out .= '<div id="tabData9" style="display:none;">' . hq("select tabdetay$langPrefix from urun where ID='$urunID'"). '</div>';
  $out .= '<div id="tabData2" style="display:none;">' . showItemPictures($urunID) . '</div>';
  $out .= '<div id="tabData3" style="display:none;">' . generateFeedback($urunID) . '</div>';
  $out .= '<div id="tabData4" style="display:none;">' . showItemComments($urunID) . '</div>';
  $out .= '<div id="tabData5" style="display:none;">' . showTaksit() . '</div>';
  $out .= '<div id="tabData7" style="display:none;">' . showItemQst($urunID) . '</div>';
  $out .= '</div>';
  $openTab = ($_POST['SpcForm'] == 'feedback' ? 4 : 1);
  if ($openTab == 1) $openTab = ($_POST['SpcForm'] == 'qst' ? 7 : 1);
  if ($openTab == 1) $openTab = ($_POST['data_urun'] ? 3 : 1);
  $out .= '<script>openTab(' . $openTab . ');</script>';
  return $out;
}



function showTaksit()
{
  if (siteConfig('fiyatUyelikZorunlu') && !$_SESSION['userID']) return _lang_fiyatIcinUyeGirisiYapin;
  $urunID = $_GET['urunID'];
  $qUrun = my_mysql_query("select * from urun where ID='$urunID'");
  $d = my_mysql_fetch_array($qUrun);

  if ($_SESSION['cache_setfiyatBirim'] && $_SESSION['cache_setfiyatBirim'] != 'TL')
  $out = _lang_urunFiyati . ' : {%URUN_FIYAT%} ';
  else {
    if (siteConfig('tekCekimIndirim'))
    $out .= '<b style="display:block; padding-bottom:4px;">Kredi Kartı Tek Çekim (%' . (siteConfig('tekCekimIndirim') * 100) . ') :</b>{%URUN_TEKCEKIM_FIYAT_YTL%} TL (KDV Dahil)><br /><br />';
    if (siteConfig('havaleIndirim') && !hq("select ID from banka where (cat like '%," . urun('catID') . ",%' OR marka like '%," . urun('markaID') . ",%') AND paymentModulURL like '%havale%' AND active =1 "))
    $out .= '<b style="display:block; padding-bottom:4px;">Havale / EFT (%' . (siteConfig('havaleIndirim') * 100) . ') :</b>{%URUN_HAVALE_FIYAT_YTL%} TL (KDV Dahil)<br /><br />';
    $out .= '<b>' . _lang_bankaOzelTaksit . '</b><br /><br />';
    $paytrTaksit = paytrTaksit();
    if ($paytrTaksit)
    $out .= $paytrTaksit;

    $q = my_mysql_query("select banka.* from banka,bankaVade where banka.taksitOrani = 1 AND banka.active = 1 AND bankaVade.ay > 0 AND banka.ID=bankaVade.bankaID group by banka.ID order by banka.seq");
    $i = 1;
    while ($dt = my_mysql_fetch_array($q)) {

      $list = true;
      if (($dt['cat'] && $dt['cat'] != '0') || ($dt['marka'] && $dt['marka'] != '0')) {
        if ($dt['cat'] && $dt['cat'] != '0') if (!(stristr($dt['cat'], ',' . $d['catID'] . ',') === false)) {
          $list = false;
          $catArray = explode('|', $d['showCatIDs']);
          foreach ($catArray as $catVal) {
            if (!(stristr($dt['cat'], ',' . $catVal . ',') === false) && ((int)$catVal))
            $list = true;
          }
        }
        if ($dt['marka'] && $dt['marka'] != '0') if (!(stristr($dt['marka'], ',' . $d['markaID'] . ',') === false)) {
          $list = false;
        }
      }
      if ($dt['bakiye']) $list = false;
      if ($list) {
        $out .= '<div class="taksit-container">';
        $out .= taksit($dt['ID'], $urunID);
        $out .= '</div>';
        if (!($i % 3)) $out .= "<div class='clear-space'></div>";
        $i++;
      }
    }
  }
  $out .= "<div class='clear-space'></div>";
  return urunTemplateReplace($d, $out);
}

function pesinTaksitFix2($dVade, $urunID = 0)
{
  if ($urunID)
  $c = hq("select pesintaksit from urun where ID='$urunID' limit 0,1");
  else
  $c = hq("select urun.pesintaksit from urun,sepet where sepet.urunID=urun.ID AND sepet.randStr = '" . $_SESSION['randStr'] . "' order by pesintaksit desc limit 0,1");

  if ((int)$dVade['ay'] <= (int)$c)
  $dVade['vade'] = 0;
  return $dVade;
}

function taksit($bankaID, $urunID)
{
  $_GET['bankaID'] = $bankaID;
  $_GET['urunID'] = $urunID;

  $q = my_mysql_query("select * from banka where ID='" . $_GET['bankaID'] . "'");
  $d = my_mysql_fetch_array($q);
  $v = my_mysql_query("select * from bankaVade where bankaID='" . $_GET['bankaID'] . "' order by ay");
  $d['taksitSayisi'] = (my_mysql_num_rows($v) + 1);
  list($arka, $font) = explode(',', $d['taksitGosterimCSS']);
  $d['taksitGosterimCSS'] = 'genel_';
  $qu = my_mysql_query("select * from urun where ID='" . $_GET['urunID'] . "'");
  $du = my_mysql_fetch_array($qu);
  $du['fiyat'] = fixFiyat($du['fiyat'], 0, $du['ID']);
  $du['fiyat'] = YTLfiyat($du['fiyat'], $du['fiyatBirim']);
  // $pesinFiyatinaTaksitOrani = dbinfo('urun','pesinTaksitOrani',$_GET['urunID']);
  $out .= '<div class="' . $d['taksitGosterimCSS'] . 'taksitDiv" style="margin:0; padding:0;">';
  $out .= '<table cellspacing="1" cellpadding="0" width="100%">';
  $out .= '<tr>';
  $out .= '<td colspan="3" valign="top" class="taksitTopHeader" style=" background-color:' . $arka . '; color:' . $font . ';">' . ($d['taksitGosterimBaslik'] ? $d['taksitGosterimBaslik'] : '<img src="images/banka/' . $d['taksitUrunLogo'] . '" />') . '</td></tr>';
  $out .= '<tr><td class="taksitHeaderEmpty" style=" background-color:' . $arka . '; color:#' . $font . ';"></td><td class="taksitHeader" style=" background-color:' . $arka . '; color:' . $font . ';">' . _lang_taksitTutari . '</td><td class="taksitHeader" style=" background-color:' . $arka . '; color:' . $font . ';">' . _lang_toplam . '</td></tr>';
  //$out.='<tr height=2><td></td></tr>';
  $azamiTaksit = azamiTaksit($urunID);
  while ($vade = my_mysql_fetch_array($v)) {
    if (function_exists('pesinTaksitFix2'))
    $vade = pesinTaksitFix2($vade, $urunID);
    if (!$vade['ay'] || ($azamiTaksit < $vade['ay'])) continue;
    $i = $vade['ay'];
    $p = $vade['plus'];
    $goster = ($p ? $i . ' (+' . $p . ')' : $i);
    $toplamFaiz = $pesinFiyatinaTaksitOrani >= $vade['vade'] ? 0 : $vade['vade'];
    $toplamOdenecek = (($toplamFaiz + 1) * $du['fiyat']);
    $taksit = ($i == 1 ? '' : ($toplamOdenecek / $i));
    $pesinFiyatina = ($toplamOdenecek == $du['fiyat'] ? true : false);
    $trClass = ($pesinFiyatina ? 'class="pesin"' : '');

    $out .= "<tr $trClass><td class='td1'>" . ($i == 1 ? 'Peşin' : $goster) . "</td>";
    $out .= "<td class='td2'>" . ($taksit ? my_money_format('%i', $taksit) . ' TL' : '-') . "</td>";
    $out .= "<td class='td3'>" . my_money_format('%i', $toplamOdenecek) . " TL</td>";
    $out .= '</tr>';
    if ($i != $d['taksitSayisi']) $out2 .= '<tr height=2><td></td></tr>';
  }


  for ($i = 1; $i <= $d['taksitSayisi']; $i++) {
    // $toplamFaiz = ($i * $d['taksitOrani']);

  }
  $out .= '</table>';
  $out .= '</div>';
  return $out;
}


function urunSayac($urunID)
{
  if (!$urunID) return;
  $tarihArray = explode(' ', hq("select finish from urun where ID='$urunID'"));
  list($yil, $ay, $gun) = explode('-', $tarihArray[0]);
  list($dak, $san) = explode(':', $tarihArray[1]);

  return '<script>
			function liftOff() 
			{
				window.location.reload();
			}
			$(\'#sayac\').countdown({tickInterval: 1,onExpiry: liftOff,until: new Date(' . $yil . ', (' . $ay . ' - 1), ' . $gun . ', ' . $dak . ', ' . $san . '),timezone: +2,     layout: \'{dn} - {hnn}:{mnn}:{snn}\'});	
			
			</script>';
}

function seoURLFix($str)
{
  $str = strtolower(trim(tr2eu($str)));
  $str = preg_replace('/[^a-z0-9-\/]/', '-', $str);
  $str = preg_replace('/-+/', "-", $str);
  $str = strtolower($str);
  return $str;
  /*
	$str = str_replace(' ','_',tr2eu($str,false));
	$str = str_replace("'",'',$str);
	$str = str_replace("&#39;",'',$str);	
	$str = str_replace('"','',$str);
	$str = str_replace('/','_',$str);
	return $str;
	 */
}

function seoFix($str)
{
  if (function_exists('mySeoFix')) return mySeoFix($str);
  $str = strtolower(trim(tr2eu($str)));
  $str = str_replace(array('&#39;', '&amp;'), '', $str);
  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
  $str = preg_replace('/-+/', "-", $str);
  $str = strtolower($str);
  $str = str_replace('--', '-', $str);
  return $str;
  /*
	$str = str_replace(' ','_',tr2eu($str,false));
	$str = str_replace("'",'',$str);
	$str = str_replace("&#39;",'',$str);	
	$str = str_replace('"','',$str);
	$str = str_replace('/','_',$str);
	return $str;
	 */
}

function kargoSuresi($d)
{
  if (!$d['kargoGun'] && !$d['anindaGonderim'])
  return;
  $gun = date('N', strtotime(date('Y-m-d') . ' + ' . (int)$d['kargoGun'] . ' days'));
  if(date('H')>15) { $gun++; $d['kargoGun']++; }
  if ($gun == 6)
  $d['kargoGun'] += 2;
  else if ($gun == 7)
  $d['kargoGun'] += 1;

  $gun = date('N', strtotime(date('Y-m-d') . ' + ' . (int)$d['kargoGun'] . ' days'));
  $haftaArr = array('Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma');
  return '<strong>En geç ' . mysqlTarih(date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . (int)$d['kargoGun'] . ' days'))) . ' ' . $haftaArr[($gun - 1)] . ' günü kargoda.</strong>';
}

/*
function cal_days_in_month($calendar,$month, $year) { 
if(checkdate($month, 31, $year)) return 31; 
if(checkdate($month, 30, $year)) return 30; 
if(checkdate($month, 29, $year)) return 29; 
if(checkdate($month, 28, $year)) return 28; 
return 0; // error 
} 
 */
function googleFinish($code, $randStr)
{
  $q = my_mysql_query("select * from siparis where randStr = '" . $randStr . "'");
  $siparisData = my_mysql_fetch_array($q);
  $out = '<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push([\'_setAccount\', \'' . $code . '\']); // 
_gaq.push([\'_trackPageview\']);
_gaq.push([\'_addTrans\',
\'' . $randStr . '\', // 
\'' . siteConfig('seo_urunTitle') . '\', // Affiliate/Mağaza Adı
\'' . basketInfo('toplamKDVHaric', $randStr) . '\', // Toplam Tutar - Gerekli
\'' . basketInfo('toplamKDV', $randStr) . '\', // Vergi
\'' . basketInfo('Kargo', $randStr) . '\', // Kargo Ücreti
\'' . hq("select name from iller where plakaID='" . $siparisData['city'] . "'") . '\', // Şehir
\'' . hq("select name from iller where plakaID='" . $siparisData['city'] . "'") . '\', // Bölge veya Eyalet
\'Turkey\' // Ülke
]);';

  // Satın alınan her farklı ürün için addItem döngüsü kullanılmalıdır

  $q2 = my_mysql_query("select * from sepet where randStr like '$randStr'");
  while ($d2 = my_mysql_fetch_array($q2)) {
    $catID = hq("select markaID from urun where ID='" . $d2['urunID'] . "'");
    $catName = hq("select name from marka where ID='" . $catID . "'");
    $out .= '
		_gaq.push([\'_addItem\',
		\'' . $d2['ID'] . '\', //
		\'DD' . $d2['urunID'] . '\', // SKU/code - Gerekli
		\'' . $d2['urunName'] . '\', // Ürün İsmi
		\'' . $catName . '\', // Kategori veya Varyasyon
		\'' . $d2['ytlFiyat'] . '\', // Birim Fiyatı - Gerekli
		\'' . $d2['adet'] . '\' // Miktar - Gerekli
		]);';
  }
  $out .= '
_gaq.push([\'_trackTrans\']);
(function() {
var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>';
  return $out;
}

function urunDuzenle($d)
{
  if (strtolower(basename($_SERVER['SCRIPT_FILENAME'])) == 'page.php' && siteConfig('urunduzenle') && $_SESSION['admin_isAdmin']) {
    $out = '
		<div class="adminTools">
		<a class="btn-duzenle" target="_blank" href="secure/s.php?f=urun.php&y=d&ID=' . $d['ID'] . '">Düzenle</a>
		<a class="btn-stok">Stok :<strong class="pink-color"> ' . $d['stok'] . '</strong></a>';
    if ($d['bayifiyat'] > 0) {
      $out .= '<a class="btn btn-small btn-info btn-adminx">AF :<strong class="pink-color"> ' . $d['bayifiyat'] . ' TL</strong></a>';
    }
    $out .= '</div>';
    return $out;
  }
}


$hArray = array('0-9', 'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'H', 'I', 'İ', 'J', 'K', 'L', 'M', 'N', 'O', 'Ö', 'P', 'Q', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'W', 'X', 'Y', 'Z');
 