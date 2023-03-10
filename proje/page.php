<?php
header('Access-Control-Allow-Origin: *');
$postSize = @sizeof($_POST);
include('include/all.php');
$orandStr = $_SESSION['randStr'];
$seo = new SEO();
setRealActnOp();
$customFunction = 'my' . $_GET['act'];
$out .= actHeader();
if (function_exists($customFunction)) $out .= $customFunction();
else if (file_exists('include/mod_page_' . basename(str_replace(array(',', '.', '/', '\\'), '', $customFunction) . '.php'))) {
	include_once('include/mod_page_' . basename(str_replace(array(',', '.', '/', '\\'), '', $customFunction) . '.php'));
	$out .= $customFunction();
} else {
	switch ($_GET['act']) {
		case "login":
			if (!(stristr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false))
				$_SESSION['login_redirect'] = str_replace(array('https://', 'http://', $_SERVER['HTTP_HOST']), '', $_SERVER['HTTP_REFERER']);
			$seo->currentTitle = _lang_titleLogin;
			if ($_SESSION['userID'])
				$out .= generateTableBox(_lang_titleLogin, generateLoginBox(), tempConfig('formlar'));
			else {
				include('include/mod_Login.php');
				$out .= generateTableBox(_lang_titleLogin, $loginOut, tempConfig('formlar'));
			}
			if ($_GET['backTo'] && $_SESSION['userID']) {
				header('location:.' . urldecode($_GET['backTo']));
				exit('<script>window.location=".' . urldecode($_GET['backTo']) . '";</script>');
			}
			if ($_SESSION['userID'] && $_GET['back'] == 'satinal') {
				header('location:./page.php?act=satinal&op=adres');
				exit('<script>window.location="./page.php?act=satinal&op=adres";</script>');
			}

			break;
		case "logout": {
				cleancache();
				setRandStr();
				if ($_GET['remove'] && $_SESSION['userID'])
					my_mysql_query("update user set bayiStatus = 0 where ID='".$_SESSION['userID']."'");
				$_SESSION['userID'] = $_SESSION['username'] = $_SESSION['password'] = $_SESSION['loginStatus'] = $_SESSION['siparisID'] = $_SESSION['bayi'] = $_SESSION['groupID'] = $_SESSION['userGroupID'] = $_SESSION['token'] = $_SESSION['user_xmlcat'] = '';
				setcookie("sp_username", false, time() + (60 * 60 * 24 * 30));
				setcookie("sp_password", false, time() + (60 * 60 * 24 * 30));
				setcookie('autousercheck', '', time() - 3600, '/', null);
				redirect('index.php');
			}
		case 'autopay':
			$out .= setautopay($_GET['key']);

			break;
		case 'karsilastir':
			$outX = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'compare.php?act=karsilastir' . ($_GET['pIDs'] ? '&pIDs=' . $_GET['pIDs'] : '') . ($_GET['KarsilastirmaListeTemizle'] ? '&KarsilastirmaListeTemizle=' . $_GET['KarsilastirmaListeTemizle'] : ''));
			$out .= generateTableBox(_lang_listeyiKarsilastir, $outX, tempConfig('sepet'));
			break;
		case "bakiye":
			uyeKontrol();
			$out .= generateTableBox(_lang_mb_oncekiKrediYukelemlerim, bakiyeTakipGiris(), tempConfig('formlar'));
			$out .= generateTableBox(_lang_mb_oncekiKrediKullanimlarim, bakiyeTakipCikis(), tempConfig('formlar'));
			if ($_GET['sn']) $out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliSiparisBilgileriniz, showOrder(true), tempConfig('sepet'));
			$out .= generateTableBox(_lang_mb_krediYukleme, bakiye(), tempConfig('formlar'));
			break;
		case "kacanFirsatlar":
			$seo->currentTitle = _lang_titleKacanFirsatlar;
			$liste .= urunList("select * from urun where finish < now() OR stok < 1", 'UrunList_Empty', 'UrunListShow_Firsat');
			$out .= generateTableBox(_lang_titleKacanFirsatlar, $liste, tempConfig('formlar'));
			break;
		case "tumFirsatlar":
			$seo->currentTitle = _lang_titletumFirsatlar;
			$liste .= urunList("select * from urun where finish > now() AND stok >= 1", 'UrunList_Empty', 'UrunListShow_Firsat');
			$out .= generateTableBox(_lang_titletumFirsatlar, $liste, tempConfig('formlar'));
			break;
		case "filitreDetay":
			$siteConfig['useAjaxPager'] = 0;
			$seo->currentTitle = getFilterName($_GET['filitreID'], $_GET['v']);
			$_GET['v'] = utf8fix(str_replace(array('s', 'i', 'u', 'c', 'g', 'o', ' ', '-', '_'), '_', $_GET['v']));
			$out .= generateTableBox($seo->currentTitle, hq("select icerik from filitredetay where baslik like '" . $_GET['v'] . "'"), tempConfig('urunliste'));
			$out .= generateTableBox('Se??ilen ??r??nler ', urunList('select * from urun where active=1 AND filitre like \'%[' . $_GET['filitreID'] . '::' . $_GET['v'] . ']%\''), tempConfig('urunliste'));
			break;
		case "fList":
			$siteConfig['useAjaxPager'] = 0;
			$seo->currentTitle = dbInfo('filitre', 'baslik', $_GET['fID']);
			$out .= generateTableBox(dbInfo('filitre', 'baslik', $_GET['fID']), fList(), tempConfig('formlar'));
			break;
		case "kategoriKampanya":
			require_once('include/mod_KampanyaKategori.php');
			$seo->currentTitle = _lang_titleKampanyalar;
			$out .= generateTableBox(_lang_titleKampanyalar, kampanyaKategori(), tempConfig('formlar'));
			break;
		case "sozlesme":
		case "onay":

			if (!$_GET['sn'])
				$_GET['sn'] = $_SESSION['randStr'];
			if (!$_GET['tp'] || $_GET['tp'] == 'satinalma') {
				$seo->currentTitle = $_GET['sn'] . ' ' . _lang_pageSiparisSozlesme;
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_pageSiparisSozlesme, '<textarea class="sozlesme" style="width:95%; height:480px; border:1px solid #ccc; padding:10px;" onkeydown="return false;">' . Sepet::sozlesme($_GET['sn'], $_GET['email']) . '</textarea>', tempConfig('formlar'));
			}
			if (!$_GET['tp'] || $_GET['tp'] == 'onsatis') {
				$seo->currentTitle = $_GET['sn'] . ' ' . _lang_pageSiparisSozlesme2;
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_pageSiparisSozlesme2, '<textarea class="sozlesme" style="width:95%; height:480px; border:1px solid #ccc; padding:10px;" onkeydown="return false;">' . Sepet::sozlesme2($_GET['sn'], $_GET['email']) . '</textarea>', tempConfig('formlar'));
			}
			if (!$_GET['tp'] || $_GET['tp'] == 'kvkk') {
				$seo->currentTitle = _lang_pageSiparisSozlesme3;
				$out .= generateTableBox( _lang_pageSiparisSozlesme3, '<textarea class="sozlesme" style="width:95%; height:480px; border:1px solid #ccc; padding:10px;" onkeydown="return false;">' . Sepet::sozlesme3($_GET['sn'], $_GET['email']) . '</textarea>', tempConfig('formlar'));
			}
			break;
		case "puan":
			uyeKontrol();
			$seo->currentTitle = _lang_titlePuanlar??m;
			$out .= generateTableBox(_lang_titlePuanlar??m, puanlarim(), tempConfig('formlar'));
			break;
		case "pcToplama":
			$seo->currentTitle = _lang_titlePCToplama;
			$disableRightColumn = true;
			$out .= generateTableBox(_lang_pagePcToplamaSihirbazi, pcToplama(), tempConfig('formlar'));
			break;
		case 'instagram':
			require('include/mod_Instagram.php');
			$out .= generateTableBox('<a href="' . siteConfig('instagram_URL') . '" target="_blank">' . siteConfig('instagram_URL') . '</a> Instagram Feed', spInstagramFeed(), tempConfig('bilgi_sayfalari'));
			break;
		case "modKupon":
			include('include/mod_Kupon.php');
			break;
		case "modDavet-liste":
			uyeKontrol();
			$seo->currentTitle = _lang_titleModDavetListe;
			$disableRightColumn = true;
			$out .= generateTableBox('Size ??zel Davet URL adresiniz', davetURL(), tempConfig('formlar'));
			$out .= generateTableBox('Sitemize Davet Etti??iniz ??yeler', listInvitedMembers(), tempConfig('formlar'));
			break;
		case "modDavet-link":
			uyeKontrol();
			$seo->currentTitle = _lang_titleModDavetLink;
			$disableRightColumn = true;
			$out .= generateTableBox('Size ??zel Davet URL adresiniz', davetURL(), tempConfig('formlar'));
			break;
		case "modDavet":
			uyeKontrol();
			$seo->currentTitle = _lang_titleModDavet;
			$disableRightColumn = true;
			$out .= generateTableBox('Site Davetiye Formu', modDavet(), tempConfig('formlar'));
			break;
		case "alarmList":
			uyeKontrol();
			$seo->currentTitle = _lang_titleAlarmList;
			$out .= generateTableBox(_lang_aklimdakiler, alarmList('AlarmListem'), tempConfig('urunliste')) . '<br>';
			$out .= generateTableBox(_lang_fiyatAlarm, alarmList('AlarmFiyat'), tempConfig('urunliste')) . '<br>';
			$out .= generateTableBox(_lang_stokAlarm, alarmList('AlarmStok'), tempConfig('urunliste')) . '<br>';
			break;
		case "aylist":
			$seo->currentTitle = $aylar[(int) $_GET[mID]] . ' ' . _lang_titleUrunleri;
			$out .= generateTableBox($aylar[(int) $_GET[mID]] . ' ' . _lang_titleUrunleri, urunList("select * from urun where active=1 AND tarih <= '" . date('Y-m-d', mktime(0, 0, 0, ((int) $_GET[mID]), '31', date('Y'))) . "' AND tarih >= '" . date('Y-m-d', mktime(0, 0, 0, (int) $_GET[mID], '1', date('Y'))) . "' order by urun.seq desc,urun.ID desc"), tempConfig('urunliste'));
			break;
		case "cokSatanlar":
			$seo->currentTitle = _lang_titleCokSatanlar;
			$out .= generateTableBox(_lang_titleCokSatanlar, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 order by urun.sold desc'), tempConfig('urunliste'));
			break;
		case "onerilenler":
			$seo->currentTitle = _lang_titleOnerilenler;
			$out .= generateTableBox(_lang_titleOnerilenler, urunList('select urun.* from urun,kategori where urun.anasayfa=1 AND urun.catID=kategori.ID AND kategori.active=1 order by urun.seq desc,urun.ID desc'), tempConfig('urunliste'));
			break;
		case "yeniUrunler":
		case "yeni":
			$seo->currentTitle = _lang_titleSonEklenenler;
			if (!$_GET['catID'])
				$out .= generateTableBox(_lang_titleSonEklenenler, urunList('select urun.* from urun,kategori where urun.yeni=1 AND urun.catID=kategori.ID AND kategori.active=1 order by urun.ID desc'), tempConfig('urunliste'));
			else
				$out .= generateTableBox(_lang_titleSonEklenenler, urunList('select urun.* from urun,kategori where urun.yeni=1 AND urun.catID=kategori.ID AND kategori.active=1 AND (urun.catID = \'' . (int) $_GET['catID'] . '\' OR urun.showCatIDs like \'%|' . (int) $_GET['catID'] . '|%\')  order by urun.ID desc'), tempConfig('urunliste'));
			break;
		case "sonEklenenler":
			$seo->currentTitle = _lang_titleSonEklenenler;
			$out .= generateTableBox(_lang_titleSonEklenenler, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 order by urun.ID desc'), tempConfig('urunliste'));
			break;
		case "hizliKargo":
			$seo->currentTitle = _lang_iconAnindaGonderim;
			$out .= generateTableBox(_lang_iconAnindaGonderim, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 AND urun.anindaGonderim=1 order by urun.seq desc,urun.ID desc'), tempConfig('urunliste'));
			break;
		case "ucretsizKargo":
			$seo->currentTitle = _lang_iconUcretsizKargo;
			$out .= generateTableBox(_lang_iconUcretsizKargo, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 AND urun.ucretsizKargo=1 order by urun.seq desc,urun.ID desc'), tempConfig('urunliste'));
			break;
		case "beklenenler":
			$seo->currentTitle = _lang_titleBeklenenler;
			$out .= generateTableBox(_lang_titleBeklenenler, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 AND yeni = 1 AND stok = 0 order by urun.ID desc'), tempConfig('urunliste'));
			break;
		case "stokaz":
			$seo->currentTitle = _lang_titleStokAz;
			$out .= generateTableBox(_lang_titleStokAz, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 AND stok < 5 order by urun.ID desc'), tempConfig('urunliste'));
			break;
		case "indirimde":
			$seo->currentTitle = _lang_titleIndirimde;
			$out .= generateTableBox(_lang_titleIndirimde, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 AND urun.indirimde=1 order by urun.ID desc'), tempConfig('urunliste'));
			break;
		case "kullaniciUrunleri":
			$title = dbinfo('user', 'name', $_GET['userID']) . ' ' . dbinfo('user', 'lastname', $_GET['userID']);
			$seo->currentTitle = $title;
			$out .= generateTableBox($title, urunList('select urun.* from urun,kategori where urun.catID=kategori.ID AND kategori.active=1 AND urun.userID=\'' . $_GET['userID'] . '\' order by urun.seq desc,urun.ID desc'), tempConfig('urunliste'));
			break;
		case "kullaniciDetay":
			uyeKontrol();
			$title = dbinfo('user', 'name', $_GET['userID']) . ' ' . dbinfo('user', 'lastname', $_GET['userID']);
			$seo->currentTitle = $title;
			$out .= generateTableBox($title, userDetails($_GET['userID'], 'KullaniciGoster'), tempConfig('urunliste'));
			break;
		case 'siparisYorum':
			$out .= generateTableBox(_lang_yorumlar, showOrderComments(), tempConfig('formlar'));
			break;
		case 'urunYorum':
			if (siteConfig('yorumUyelikZorunlu'))
				uyeKontrol();
			if (siteConfig('yorumUyelikZorunlu') && $_GET['siparisID'] && !hq("select ID from siparis where userID='" . $_SESSION['userID'] . "' AND randStr = '" . (int) $_GET['siparisID'] . "'"))
				$out .= generateTableBox('Hata', '<span class="error">Hata : Sipari?? / ??r??n Hatas??.</span>', tempConfig('formlar'));
			else if (siteConfig('yorumUyelikZorunlu') && hq("select ID from urunYorum where urunID='" . (int) $_GET['urunID'] . "' AND userID='" . $_SESSION['userID'] . "'"))
				$out .= generateTableBox('Hata', '<span class="error">Hata : Bu ??r??n i??in kay??tl?? bir ??r??n yorumunuz bulunmaktad??r.</span>', tempConfig('formlar'));
			else {
				$out .= generateTableBox(_lang_yorumlar, showItemComments((int) $_GET['urunID']), tempConfig('formlar'));
			}
			$out .= generateTableBox(breadCrumb(), showItem($_GET['urunID']), tempConfig('urundetay'));
			break;
		case 'yorumlar':
			$out .= generateTableBox(_lang_yorumlar, showSiteComments(), tempConfig('formlar'));
			break;
		case "paketler":
			$seo->currentTitle = _lang_kampanyaliPaketler;
			$out .= paketIndirim(0, 'UrunListLite', 'UrunListLiteShow', tempConfig('urunliste'));
			break;
		case "urunDetay":
		case "seo":
			if (!hq("select ID from urun where ID='" . $_GET['urunID'] . "'"))
				exit("<script>window.location.href ='index.php';</script>");
			if ($siteTipi == 'TEKURUN' || $siteTipi == 'GRUPSATIS') {
				header('location:index.php?urunID=' . $_GET['urunID']);
				exit();
			}
			$out .= generateTableBox(breadCrumb(), showItem($_GET['urunID']), tempConfig('urundetay'));
			$out .= '<br>';
			// $caprazSonra = 1;
			if (!$_GET['viewPopup']) {
				$out .= generateTableBox(_lang_titleIndirimdeAlabileceginizUrunler, caprazPromosyonUrunList(), tempConfig('urunliste'));
				$out .= paketIndirim($_GET['urunID'], 'UrunListLite', 'UrunListLiteShow', tempConfig('urunliste'));
				$out .= generateTableBox(_lang_ilgiliUrunler, ilgiliUrunList(), tempConfig('urunliste'));
				$out .= generateTableBox(_lang_kategorininEnCokSatanlari, urunlist('select * from urun where catID=\'' . urun('catID') . '\' AND ID!= \'' . $_GET['urunID'] . '\' order by sold desc limit 0,10', 'UrunListLite', 'UrunListLiteShow'), tempConfig('urunliste'));
			}

			break;
		case "tumKategoriler":
			$seo->currentTitle = _lang_titleTumKategoriler;
			$out .= generateTableBox(_lang_titleTumKategoriler, listAllCats(0), tempConfig('urunliste'));
			break;
		case "kategoriGoster":
			$out .= autoModLoad('Slider');
			//$defaultOrderBy = 'urun.stok = 0,urun.seq desc,urun.ID desc';
			$defaultOrderBy = "if(urun.resim = '' or urun.resim is null,1,0),if(urun.stok = 0,1,0),urun.seq desc,urun.ID desc";

			//$out .= generateTableBox(breadCrumb(),itemOrder(),tempConfig('formlar'));
			$out .= generateTableBox(currentCatName() . ' Kategorileri', showCategoryPictures('KategoriList'), tempConfig('formlar'));
			if ((int) $_GET['page'] < 2)
				$out .= showCategoryBanner('body' . $langPrefix);
			if ($_GET['catID'])
				$out .= generateTableBox(_lang_titleSikcaSorularnSorular, sss(), tempConfig('bilgi_sayfalari'));

			if (function_exists('getOrderBy'))
				$order = getOrderBy();
			else
				$order = ($_GET['orderBy'] ? $_GET['orderBy'] : $defaultOrderBy);
			$baslik = ($_GET['catID'] ? breadCrumb() : dbInfo('marka', 'name', $_GET['markaID']));
			if ($_GET['fID'] && !$_GET['catID']) $baslik = $_GET['fVal'];
			if (!$_SESSION['listType'] || $_SESSION['listType'] == 'detay') $out .= generateTableBox($baslik . '', itemOrder() . showCategory($_GET['catID'], $order), tempConfig('urunliste'));
			else $out .= generateTableBox($baslik . ' ??r??nleri', itemOrder() . listCategory($_GET['catID'], $order, 'UrunListLite', 'UrunListLiteShow'), tempConfig('urunliste'));
			if ((int) $_GET['page'] < 2)
				$out .= showCategoryBanner('footer' . $langPrefix);
			my_mysql_query('update kategori set hit = hit + 1 where ID=\'' . $_GET['catID'] . '\' limit 1');
			setStats('updateKategori');
			break;
		case "profile":
		case "banka":
		case "affbasvuru":
			uyeKontrol();
			$seo->currentTitle = _lang_titleProfile;
			$out .= generateTableBox(_lang_titleProfile, ($_POST['data_name'] || $_POST['data_aff_web'] ? profileSubmit() : profileForm()), tempConfig('formlar'));
			break;
		case "dsbasvuru":
			uyeKontrol();
			$seo->currentTitle = _lang_titleProfile;
			$out .= generateTableBox(_lang_titleProfile, ($_POST['data_name'] || $_POST['data_aff_banka'] ? profileSubmit() : profileForm()), tempConfig('formlar'));
			break;
		case "qregister":
			$seo->currentTitle = _lang_titleRegisterForm;
			if ($_SESSION['userID']) {
				redirect(slink('profile'));
			}
			$out .= generateTableBox(_lang_titleRegisterForm, ($_POST['data_name'] ? registerSubmit() . ($_SESSION['p-code'] ? '<div style="clear:both;">&nbsp;</div>' . _lang_form_promosyonKodu . ' <strong>' . $_SESSION['p-code'] . '</strong>' : '') : quickRegisterForm()), tempConfig('formlar'));
			if ($_POST['data_name'])
				unset($_SESSION['p-code']);
			break;
			case "register":

				if (file_exists('include/mod_FacebookConnect.php')) require_once('include/mod_FacebookConnect.php');
	
				if ($_GET['op'] == 'confirm') {
					$seo->currentTitle = _lang_titleRegisterOnay;
					$out .= registerConfirm();
				} else {
					$seo->currentTitle = _lang_titleRegisterForm;
					if ($_SESSION['userID']) {
						redirect(slink('profile'));
					}
					$out .= generateTableBox(_lang_titleRegisterForm, $facebookConnectLogin.'<div class="clear-space">&nbsp;<br><br></div>'.($_POST['data_name'] ? registerSubmit() : registerForm()), tempConfig('formlar'));
				}
				break;
		case "sifre":
		case "forgotPassword":
			$seo->currentTitle = _lang_titleForgotPassword;
			$out .= generateTableBox(_lang_titleForgotPassword, ($_POST['data_email'] ? forgotPasswordSubmit() : forgotPasswordForm()), tempConfig('formlar'));
			break;
		case "smsOnay":
			if(hq("select bayiStatus from user where ID='".$_SESSION['userID']."'"))
				redirect('index.php');
			$seo->currentTitle = _lang_titleSMSOnay;
			$out .= generateTableBox(_lang_titleSMSOnay, ($_POST['data_email'] ? smsOnaySubmit() : smsOnayForm()), tempConfig('formlar'));
			break;
		case "sepet":
			$_SESSION['bakiyeOdeme'] = '';
			$seo->currentTitle = _lang_titleSepet;
			$showMenu = true;
			Sepet::sepetMenuAct();
			if (siteConfig('sepetzaman'))
				$ekle = '<div class="sepet-sayac">' . Sepet::sepetSayac() . '</div><div class="clear"></div>';
			$out .= generateTableBox(_lang_titleSepet, $ekle . $msg . showBasket($showMenu), tempConfig('sepet'));
			if (isReallyMobile()) {
				$out .= generateTableBox(_lang_kasaOnuFirsatlari, urunList("select urun.* from urun,kategori where urun.ID NOT IN(select urunID from sepet where adet > 0 AND randStr = '" . $_SESSION['randStr'] . "') AND urun.catID = kategori.ID AND urun.stok > 0 AND urun.kasa=1 AND urun.active = 1 AND kategori.active = 1"), tempConfig('urunliste'));
			} else {
				require_once('include/mod_CatSlider.php');
				$out .= generateTableBox(_lang_kasaOnuFirsatlari, modCatSlider(), tempConfig('sepet'));
			}
			break;
		case "satinal":
			if (!basketInfo('toplamUrun', $_SESSION['randStr']))
				redirect(slink('sepet'));
			//if ($shopphp_demo)
			//	$out .= generateTableBox('', '<h1>Bu bir yaz??l??m demo sitesidir. Siteden ??r??n sat?????? yap??lmamaktad??r.</h1>', tempConfig('formlar'))
			if (siteConfig('sepetzaman'))
				$ekle = '<div class="sepet-sayac">' . Sepet::sepetSayac() . '</div><div class="clear"></div>';
			if ((basketInfo('ModulFarkiIle', $_SESSION['randStr']) <= 0 && !$_GET['sRequest'] && !$_GET['viewPopup'] && !$_GET['isAjax']))
				redirect(slink('sepet'));

			$seo->currentTitle = _lang_titleSatinAl;
			disableCaptcha();
			if (siteConfig('minSiparis') && (basketInfo('ModulFarkiIle', $_SESSION['randStr']) < siteConfig('minSiparis')) && !$_GET['sRequest']) {
				$out .= generateTableBox('Hata', str_replace('{%MIN_SIPARIS%}', my_money_format('%i', siteConfig('minSiparis')), _lang_minSiparisError), tempConfig('sepet'));
				$_GET['op'] = '';
			}
			$catError = catError();
			if ($catError) {
				$out .= $catError;
				$_GET['op'] = '';
			}

			switch ($_GET['op']) {
				case "sil":
				case "bosalt":
				case "guncelle":
				case "adres":
					$out .= '<style>.basket-button,.discount-coupon { display:none; }</style>';
					if (isReallyMobile())
						$siteConfig['sepet_odeme'] = 2;
					disableCaptcha();
					Sepet::sepetMenuAct();
					$redirectOdemeTipi = $_POST['data_odemeTipi'];
					unset($_POST['data_odemeTipi']);
					//$out .= generateTableBox(_lang_titleSepet, $msg . $ekle . showBasket(0), tempConfig('sepet'));
					if (!$_POST['data_lastname'] && $_GET['odeme']) $_POST['data_lastname'] = $_GET['odeme'];
					if (!$_POST['data_lastname'] && $redirectOdemeTipi) $_POST['data_lastname'] = $redirectOdemeTipi;
					if ($_POST['data_lastname']) $out .= generateTableBox(_lang_titleOdemeSekliniz, $msg . ($_SESSION['templateName'] == 'mobiles' ? siparisOdemeSecim() : siparisOdemeSecim()), tempConfig('formlar'));
					if ($_POST['data_lastname']) $siparisAdresSubmit = siparisAdresSubmit();
					if (!isReallyMobile())
						$out .= generateTableBox(_lang_titleSepet, $msg . $ekle . showBasket(0), tempConfig('sepet'));
					if (!$_SESSION['userID']) $out .= "<div class='sepet-info'><a href='page.php?act=login&back=satinal'>" . _lang_uyelikIleSatinAl . "</a></div>";
					$out .= generateTableBox('<div id="shopphp-payment-title-step1">' . _lang_titleTeslimatBilgileriniz . '</div>', '<div id="shopphp-payment-body-step1">' . $msg . ($_POST['data_lastname'] ? $siparisAdresSubmit : siparisAdresForm()) . '</div>', tempConfig('formlar'));
					if (siteConfig('sepet_odeme') == '3') {
						$out .= generateTableBox('<div id="shopphp-payment-title-step2">' . _lang_titleOdemeSekliniz . '</div>', '<div id="shopphp-payment-body-step2"></div>', tempConfig('formlar'));
						$out .= generateTableBox('<div id="shopphp-payment-title-step3">' . _lang_titleOdemeBilgieriniz . '</div>', '<div id="shopphp-payment-body-step3"></div>', tempConfig('formlar'));
					}

					if ($_POST['data_lastname']) {
						$out .= "<script>$('#paytype').parent().find('.button').attr('onClick','');</script>";
						$out .= "<script>$('#paytype').parent().find('.button').click(function() { if ($('#paytype').val() == '0') alert('" . _lang_hataOdemeTipiSecin . "'); else { $('.viewForm form').submit(); }});</script>";
					}
					if ($redirectOdemeTipi) {
						redirect('page.php?act=satinal&op=odeme&paytype=' . $redirectOdemeTipi);
					}
					enableCaptcha();
					break;
				case "secim":
					$out .= generateTableBox(_lang_titleOdemeSekliniz, $msg . ($_SESSION['templateName'] == 'mobiles' ? siparisOdemeSecim() : siparisOdemeSecim()), tempConfig('formlar'));
					$out .= generateTableBox(_lang_titleSepet, $msg . $ekle . showBasket(0), tempConfig('sepet'));
					break;
				case "odeme":
					if(hq("select taksitOrani from banka where ID='" . $_GET['paytype'] . "'"))
						$siteConfig['httpsAktif'] = 1;
					if (!hq("select email from siparis where randStr = '" . $_SESSION['randStr'] . "'") && $_SESSION['userID']) {
						my_mysql_query("update siparis set email = '" . hq("select email from user where ID='" . $_SESSION['userID'] . "'") . "' where randStr = '" . $_SESSION['randStr'] . "'");
					}

					my_mysql_query("update siparis set tarih = now() " . (siteConfig('koruma') ? ',koruma=1' : '') . " where randStr like '" . $_SESSION['randStr'] . "' limit 1");
					my_mysql_query("update sepet set tarih = now() where randStr like '" . $_SESSION['randStr'] . "' limit 1");
					if (!$_GET['paytype'] || !hq("select email from siparis where randStr = '" . $_SESSION['randStr'] . "'")) {
						redirect('page.php?act=satinal&op=adres&?err=nomail');
					}
					$sepetOUT .= generateTableBox(_lang_titleSepet, $msg . showBasket(false), tempConfig('sepet'));
					$modulDosya = hq("select paymentModulURL from banka where ID='" . $_GET['paytype'] . "'");
					if (!file_exists($modulDosya) || !$modulDosya)
						exit("<div class='error'>" . $modulDosya . ' ' . _lang_hataModulDosyasiBulunamadi . "</div>");
					include($modulDosya);
					if (!$_SESSION['bakiyeOdeme'] && (siteConfig('sepet_odeme') != '3')) {
						$q = my_mysql_query("select * from siparis where randStr = '" . $_SESSION['randStr'] . "'");
						$d = my_mysql_fetch_array($q);
						$viewForm = '<div class="vfContainer">' . generateTableBox(_lang_titleAdresBilgileriniz, viewForm(getSiparisForm(), $d, '', ''), tempConfig('formlar')) . '</div>';
					}
					startShared();
					$payment = payment();
					if (siteConfig('sepet_odeme') == '3') {
						$out .= generateTableBox('<div id="shopphp-payment-title-step1">' . _lang_titleTeslimatBilgileriniz . '</div>', '<div id="shopphp-payment-body-step1"></div>', tempConfig('formlar'));
						$out .= generateTableBox('<div id="shopphp-payment-title-step2">' . _lang_titleOdemeSekliniz . '</div>', '<div id="shopphp-payment-body-step2"></div>', tempConfig('formlar'));
					}
					$out .= generateTableBox('<div id="shopphp-payment-title-step3">' . _lang_titleOdemeBilgieriniz . '</div>', '<div id="shopphp-payment-body-step3">' . $payment . '</div>', tempConfig('formlar'));
					$out .= finishShared($tamamlandi, $errmsg, $bankaMesaj);
					$out .= $sepetOUT;
					if ($_GET['taksit'])
						$out .= '<script type="text/javascript">$(\'select[name="taksit"],#taksit\').val(\'' . $_GET['taksit'] . '\')</script>';
					if ($_GET['paytype'])
						$out .= '<script type="text/javascript">selectedPayType = \'' . (int) $_GET['paytype'] . '\';</script>';
					$out .= '<style>div.basket-button { display:none !important; }</style>';
					$out .= $viewForm;
					break;
			}
			break;
		case '404':
			$e404ID = hq("select ID from pages where e404 = 1 limit 0,1");
			if ($e404ID)
				$_GET['ID'] = $e404ID;
			else
				exit();
		case "showPage":
			$out .= '<div class="PageBody">' . showPage($_GET['ID']) . '</div>';
			break;
		case "showKeyResult":
			$out .= '<div class="PageBody">' . showKeyResult($_GET['seID']) . '</div>';
			$out .= generateTableBox(_lang_ilgiliUrunler, seoIlgiliUrunList(), tempConfig('urunliste'));
			break;
		case "showUserOrders":
			uyeKontrol();
			//if ($_SESSION['loginStatus']) 
			{
				$seo->currentTitle = _lang_titleShowOrders;
				tarihFix('start');
				tarihFix('finish');
				foreach ($_POST as $k => $v) $d[str_replace('data_', '', $k)] = $v;
				$out .= generateTableBox(_lang_titleSorgula, generateForm(getSortForm(), $d, '', ''), tempConfig('formlar'));
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliSiparisBilgileriniz, showUserOrder(), tempConfig('sepet'));
				if ($_GET['sn'])
					$out .= generateTableBox($_GET['sn'] . ' ' . _lang_pageSiparisSozlesme, '<textarea class="sozlesme" style="width:95%; height:240px; border:1px solid #ccc; padding:10px;" onkeydown="return false;">' . Sepet::sozlesme($_GET['sn'], $_GET['email']) . '</textarea>', tempConfig('formlar'));
				if ($_GET['sn'])
					$out .= generateTableBox($_GET['sn'] . ' ' . _lang_pageSiparisSozlesme2, '<textarea class="sozlesme" style="width:95%; height:240px; border:1px solid #ccc; padding:10px;" onkeydown="return false;">' . Sepet::sozlesme2($_GET['sn'], $_GET['email']) . '</textarea>', tempConfig('formlar'));
				$out .= generateTableBox(_lang_titleShowOrders, listUserOrders(), tempConfig('sepet'));
			}
			break;
		case "iptal":
			$now = time();
			$then = strtotime(hq("select tarih from siparis where randStr = '" . $_GET['sn'] . "'"));
			$difference = $now - $then;
			$days = floor($difference / (60 * 60 * 24));

			if ($_POST['data_message'] && $days < 15) {
				my_mysql_query("update siparis set notAlici = concat(notAlici,'\n" . addslashes($_POST['data_message']) . "'), durum = 90 where durum > 0 AND durum < 90 AND randStr = '" . $_GET['sn'] . "' && userID = '" . $_SESSION['userID'] . "'");
				my_mysql_query("update sepet set durum = 90 where (durum = 1 OR durum = 2) AND randStr = '" . $_GET['sn'] . "' && userID = '" . $_SESSION['userID'] . "'");
				$mailAdmin = new spPaymentMail();
				$mailAdmin->siparisID = $_GET['sn'];
				$mailAdmin->template = 'Iptal_Talebi';
				$mailAdmin->to = siteConfig('adminMail');
				$mailAdmin->mergeArray = array('MESAJ' => ($_POST['data_message']));
				$mailAdmin->send();
				$out .= _lang_form_iptalOK . '<div class="clear-space">&nbsp;</div>';
			} else
				$out .= generateTableBox(_lang_form_iptalNeden, _lang_form_iptalBilgi . '<div class="clear-space">&nbsp;</div>' . generateForm(getIptalForm(), $d, '', ''), tempConfig('formlar'));
			break;

		case "degistir":

			$now = time();
			$then = strtotime(hq("select tarih from siparis where randStr = '" . $_GET['sn'] . "'"));
			$difference = $now - $then;
			$days = floor($difference / (60 * 60 * 24));

			$toplamTutarTL = hq("select toplamTutarTL from siparis where (durum = 2) AND randStr = '" . $_GET['sn'] . "' && userID = '" . $_SESSION['userID'] . "'");
			if ($toplamTutarTL && $days < 15) {
				my_mysql_query("update user set bakiye = (bakiye + " . (float) $toplamTutarTL . ") where ID='" . $_SESSION['userID'] . "'");
				my_mysql_query("update siparis set durum = 89 where (durum = 2) AND randStr = '" . $_GET['sn'] . "' && userID = '" . $_SESSION['userID'] . "'");
				my_mysql_query("update sepet set durum = 89 where (durum = 2) AND randStr = '" . $_GET['sn'] . "' && userID = '" . $_SESSION['userID'] . "'");

				$mailAdmin = new spPaymentMail();
				$mailAdmin->siparisID = $_GET['sn'];
				$mailAdmin->template = 'Degisim_Talebi';
				$mailAdmin->to = siteConfig('adminMail');
				$mailAdmin->mergeArray = array();
				$mailAdmin->send();
				redirect(slink('showOrders'));
			} else
				$out = 'Hata olu??tu.';
			//	break;
		case "showOrders":
		case "shows":
			$seo->currentTitle = _lang_titleShowOrders;

			//if ($_SESSION['loginStatus']) 
			uyeKontrol(); {
				tarihFix('start');
				tarihFix('finish');
				foreach ($_POST as $k => $v) $d[str_replace('data_', '', $k)] = $v;
				$out .= generateTableBox(_lang_titleSorgula, generateForm(getSortForm(), $d, '', ''), tempConfig('formlar'));
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliKargoBilgileriniz, showCargoInfo(), tempConfig('sepet'));
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliSiparisBilgileriniz, showOrder(false), tempConfig('sepet'));
				if ($_GET['sn'])
					$out .= generateTableBox($_GET['sn'] . ' ' . _lang_pageSiparisSozlesme, '<textarea class="sozlesme" style="width:95%; height:240px; border:1px solid #ccc; padding:10px;" onkeydown="return false;">' . Sepet::sozlesme($_GET['sn'], $_GET['email']) . '</textarea>', tempConfig('formlar'));
				if ($_GET['sn'])
					$out .= generateTableBox($_GET['sn'] . ' ' . _lang_pageSiparisSozlesme2, '<textarea class="sozlesme" style="width:95%; height:240px; border:1px solid #ccc; padding:10px;" onkeydown="return false;">' . Sepet::sozlesme2($_GET['sn'], $_GET['email']) . '</textarea>', tempConfig('formlar'));

				$out .= generateTableBox(_lang_orderOncekiSiparisleriniz, listOrders(), tempConfig('sepet'));
				//$out .= generateTableBox(_lang_orderTekrarlanacakSiparisleriniz,listReOrders(),tempConfig('sepet'));
			}
			break;
		case "showCodes":
			$seo->currentTitle = _lang_titleOnayliKuponlar;
			uyeKontrol();
			//if ($_SESSION['loginStatus']) 
			{
				$out .= generateTableBox($seo->currentTitle, listCodes(), tempConfig('sepet'));
				//$out .= generateTableBox(_lang_orderTekrarlanacakSiparisleriniz,listReOrders(),tempConfig('sepet'));
			}
			break;
		case "tekliflerim":
			require_once('include/mod_Teklif.php');
			$seo->currentTitle = _lang_titleTekliflerim;
			uyeKontrol();
			//if ($_SESSION['loginStatus']) 
			{
				if ($_GET['sn'])
					$out .= generateTableBox($_GET['sn'] . ' ' . _lang_teklifNumaraliTeklif, showOffer(), tempConfig('sepet'));
				$out .= generateTableBox(_lang_teklifKaydedilmisTeklifleriniz, listOffers(), tempConfig('sepet'));
			}
			break;
		case "reOrder":
			uyeKontrol();
			addOrderToBasket($_GET['sn']);
			$_GET['act'] = 'sepet';
			$out .= generateTableBox(_lang_ReOrderSepetim, $_GET['sn'] . ' ' . _lang_noluSiparisSepetinizeEklendi . showBasket(true), tempConfig('sepet'));
			break;
		case "havaleBildirim":
			$showForm = true;
			if ($_POST['data_sn'] && hq("select ID from siparis where email='" . $_POST['data_email'] . "' AND randStr='" . $_POST['data_sn'] . "'")) {
				$_GET['sn'] = $_POST['data_sn'];
				$showForm = false;
			} else if ($_POST['data_sn'])
				$error = _lang_hataHavaleBildirimHataliGiris;
			$seo->currentTitle = _lang_titleHavaleBildirimFormu;
			$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliSiparisBilgileriniz, showOrder(), tempConfig('sepet'));
			$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliHavaleBildirimFormu, generateHavaleForm(), tempConfig('sepet'));
			if ($showForm)
				$out .= generateTableBox(_lang_titleOdemeOnayiBekleyenSiparisleriniz, ($_SESSION['userID'] ? listOrders() : $error . siparisTakip()), tempConfig('sepet'));
			break;
		case "hataBildirim":
			$out .= checkLoginStatus();
			$seo->currentTitle = _lang_titleSiparisHataBildirim;
			uyeKontrol();
			//if ($_SESSION['loginStatus']) 
			{
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliSiparisBilgileriniz, showOrder(), tempConfig('sepet'));
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliSorunBildirimMesajListesi, generateHataMesajForm(), tempConfig('formlar'));
				$out .= generateTableBox($_GET['sn'] . ' ' . _lang_orderNumaraliSorunBildirimFormu, generateHataForm(), tempConfig('formlar'));
				$out .= generateTableBox(_lang_titleGonderimiYapilanSiparisleriniz, listOrders(), tempConfig('sepet'));
			}
			break;
		case "iletisim":
			$seo->currentTitle = _lang_titleMusteriHizmetleri;
			telFix('ceptel');
			$out .= generateTableBox(_lang_titleMusteriHizmetleri, '<div style="clear:both;">&nbsp;</div>' . dbInfo('pages', 'body' . $langPrefix, 4) . ($_POST['data_message'] ? contactFormSubmit() : contactForm()), tempConfig('formlar'));
			if ($_POST['data_subject']) {
				$_POST['data_tarih'] = date('Y-m-d H:i:s');
				insertToDb('iletisim');
			}
			break;
		case "sss":
			$seo->currentTitle = _lang_titleSikcaSorularnSorular;
			$out .= generateTableBox(_lang_titleSikcaSorularnSorular, sss(), tempConfig('bilgi_sayfalari'));
			break;
		case "arama":
		case "Arama":
			$seo->currentTitle = _lang_titleDetayliArama . ' ' . stripslashes($_GET['str']);
			$out .= generateTableBox(_lang_titleDetayliArama, searchForm(), tempConfig('formlar'));
			$out .= generateTableBox(_lang_titleAramaSonuclari . (1 == 1 ? ' (' . (int) my_mysql_num_rows(my_mysql_query(getSearchQuery($_GET['str']))) . ')' : _lang_urunBulunamadi), searchResults(), tempConfig('urunliste'));
			$out .= generateTableBox(_lang_titlecokArananlar, topResults(), tempConfig('formlar'));
			$out .= generateTableBox(_lang_titleEtiket, topSearchResults(), tempConfig('formlar'));

			break;
		case "siparistakip":
		case "siparis":
			if ($_SESSION['userID'] && !$_POST['data_sn']) {
				redirect(slink('shows'));
			}
			$seo->currentTitle = _lang_titleSiparisTakibi;
			if ($_POST['data_sn'])
				$out .= generateTableBox($_POST['data_sn'] . ' ' . _lang_orderNumaraliSiparisBilgileriniz, showOrder(true), tempConfig('sepet'));
			$out .= generateTableBox(_lang_titleSiparisTakibi, siparisTakip() . '<div style="clear:both;">&nbsp;</div>' . dbInfo('pages', 'body', 7), tempConfig('formlar'));
			break;
		case "kuponOnay":
			$out .= generateTableBox('Kupon Onay Formu', kuponOnay(), tempConfig('formlar'));
			if ($_POST['data_code'])
				$out .= generateTableBox($_POST['data_code'] . _lang_titleKuponKoduDogrulama, kuponOnayList(), tempConfig('sepet'));
			$out .= generateTableBox(_lang_titleOnayliKuponlar, listKupon(), tempConfig('formlar'));
			break;
		case "adres":
			uyeKontrol();
			$title = 'Adres Ekle';
			switch ($_GET['op']) {
				case 'adresDuzenle':
					$title = _lang_titleAdresDuzenle;
				case 'adresEkle':
					$out .= generateTableBox($title, ($_POST['data_baslik'] ? adresEkleFormSubmit() : adresEkleForm()), tempConfig('formlar'));
					break;
				case 'adresSil':
					my_mysql_query("delete from useraddress where userID='" . (int) $_SESSION['userID'] . "' AND ID='" . (int) $_GET['adresID'] . "'");
					break;
			}
			$out .= generateTableBox(_lang_titleKayitliAdreslerim, listAddresses(), tempConfig('formlar'));
			break;
		case "listNews":
		case "haber":
			$seo->currentTitle = _lang_titleHaberler;
			$out .= generateTableBox(_lang_titleHaberler, haberList(null, null), tempConfig('bilgi_sayfalari'));
			break;
		case "showNews":
			$seo->currentTitle = hq("select Baslik$langPrefix from haberler where ID= '" . $_GET['ID'] . "'");
			$out .= generateTableBox('<a href="' . slink('haber') . '">' . _lang_titleHaberler . '</a> &raquo; ' . $seo->currentTitle, haberShow($_GET['ID']), tempConfig('bilgi_sayfalari'));
			break;
		case "markaList":
			$seo->currentTitle = _lang_markalar . ($_GET['s'] ? ' ( ' . strtoupper(addslashes($_GET['s'])) . ' )' : '');
			$out .= generateTableBox($seo->currentTitle, '<div class="spBrandList">' . simpleBrandList(addslashes($_GET['s'])) . '</div>', tempConfig('bilgi_sayfalari'));
			break;
		case "listArticles":
		case "showArticles":
		case "showBlog":
		case "blog":
		case "makale":
			$seo->currentTitle = hq("select Baslik from makaleler where ID= '" . $_GET['ID'] . "'");
			$catID = hq("select catID from makaleler where ID= '" . $_GET['ID'] . "'");
			$out .= generateTableBox(_lang_titleMakaleler . ' &raquo; <a href="' . makaleKategoriLink($catID) . '">' . hq("select name from makalekategori where ID= '" . $catID . "'") . '</a> &raquo; ' . $seo->currentTitle, makaleShow($_GET['ID']), tempConfig('bilgi_sayfalari'));
			$out .= generateTableBox('Yorumlar', showArticleComments($_GET['ID']), tempConfig('bilgi_sayfalari'));

			break;
		case "makaleListe":
		case "listArticles":
			$seo->currentTitle = hq("select name from makalekategori where ID='" . $_GET['mcatID'] . "'");
			$out .= generateTableBox(_lang_titleMakaleler . ' &raquo; ' . $seo->currentTitle, makaleList(), tempConfig('bilgi_sayfalari'));
			$out .= articlePager();
			break;
		case "galleryList":
			$seo->currentTitle = hq("select name from modgallery_cat where ID='" . $_GET['gcatID'] . "'");
			$out .= generateTableBox(_lang_titleGaleri . ' &raquo; ' . $seo->currentTitle, galleryShow($_GET['gcatID']), tempConfig('bilgi_sayfalari'));
			break;
		case "showSession":
			//$out .= generateTableBox('Session Debug',showSession(),tempConfig('formlar'));
			break;
		case "makalelerim":
			uyeKontrol();
			$seo->currentTitle = _lang_titleMakaleler;
			switch ($_GET['op']) {
				case 'makaleDuzenle':
					$makaleLink = makaleLink((int) $_GET['mID']);
					$viewLink = '<div><a target="_blank" href="' . $makaleLink . '"><strong>Makale g??r??n??m?? i??in t??klay??n.</strong></a></div><br />';
				case 'makaleEkle':
					$out .= generateTableBox(_lang_titleMakaleler, ($_POST['data_name'] ? makaleEkleFormSubmit() : $viewLink . makaleEkleForm()), tempConfig('formlar'));
					break;
				default:
					$out .= generateTableBox(_lang_titleMakaleler, simpleMakaleListEdit(0), tempConfig('urunliste')) . '<br>';
					break;
			}
			break;
		case "urunlerim":
			uyeKontrol();
			$seo->currentTitle = _lang_titleUrunlerim;
			switch ($_GET['op']) {
				case 'urunDuzenle':
					$urunLink = urunLink(urun());
					$viewLink = '<div><a target="_blank" href="' . $urunLink . '"><strong>' . _lang_urunCanliGorunumuIc??nTiklayin . '</strong></a></div><br />';
				case 'urunEkle':
					$out .= generateTableBox(_lang_titleUrunlerim, ($_POST['data_name'] ? urunEkleFormSubmit() : $viewLink . urunEkleForm()), tempConfig('formlar'));
					break;
				default:
					$out .= generateTableBox(_lang_urunlerim, urunlerimList(), tempConfig('urunliste')) . '<br>';
					break;
			}
			break;
		default:
			//header("HTTP/1.0 404 Not Found");
			//exit('404 cici');
			$out = 'Hatal?? ??stek : ' . debugArray($_GET) . '|' . $_SERVER['REQUEST_URI'];
			break;
	}
}
$out .= actFooter();
$PAGE_OUT = '' . $out;
$seo->setPageHeader();
if (!$_GET['viewPopup'])
	include('templates/' . siteConfig('templateName') . '/temp.php');
else {
	if (file_exists('templates/' . siteConfig('templateName') . '/view.php'))
		include('templates/' . siteConfig('templateName') . '/view.php');
	else
		include('view.php');
}
if ($debugBackTrace) {
	echo debugArray($_SESSION);
	echo 'toplam :' . $totalQry . '<br><br><br>		' . $totalQryStr;
}
if (hq("select ID from siparis where randStr = '" . $_SESSION['randStr'] . "' AND durum > 0")) {
	setRandStr();
	redirect(slink('sepet'));
}
my_mysql_close();
