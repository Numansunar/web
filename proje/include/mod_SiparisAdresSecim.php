<?php

class SpSiparisAdres
{
	const JS = '
	
	<style>
		.basket-button { display:none !important; } 
	</style>
	<script type="text/javascript">
					function siparisKargoSecimListeGuncelle() {
						$(".kargo-secim").html("<tr><td>"+lang_lutfenBekleyin+"</td></tr>");
						$(".kargo-secim").load("include/mod_SiparisAdresSecim.php?siparisKargoListe=true", function() {
						$(".kargo-secim.disabled")
							.removeClass("disabled")
							.addClass("enabled");
						$(".kargo-secim.enabled input").click(function() {
								$("#kargoFirmaID").val($(this).attr("kargoFirmaID"));     
								$(".kargo-secim tr").removeClass("active");
								$(this).parent().parent().addClass("active");
								siparisBilgiGuncelle(true,false);
								$(this).addClass("active");      
							});	
							$(".kargo-secim.enabled input:first").click();							
						});		
															
					}
					
					function siparisBilgiGuncelle(update,kargo)
					{
						$.ajax({
						url:
							"include/ajaxLib.php?act=setSiparisAdresID&adresID="+$("#adresID").val()+"&kargoFirmaID=" + $("#kargoFirmaID").val() + "&faturaID=" + $("#faturaID").val() + "&teslimatID=" + $("#teslimatID").val(),
						success: function(data) {
							if(update)
								sepetAdresHTMLGuncelle();
								if(kargo)
									siparisKargoSecimListeGuncelle();
						}
						});
					}
					
					$(document).ready(function() {
						$("input[name=ceptel]").mask("(Z00) 000-0000", {
							translation: {
							  Z: {
								pattern: /[1-9]/,
								optional: false,
							  },
							},
						  });
						
						$("#teslimat-adres .addres-item").click(function() {
							$("#teslimat-adres .addres-item").removeClass("active");
							$(this).addClass("active");
							$("#adresID").val($(this).attr("adresID"));
							siparisBilgiGuncelle(false,true);							
						  });
						
						  $("#fatura-adres-load").click(function() {
							if (!$(this).is(":checked")) {
							  if ($("#fatura-adres").html() == "") {
								$("#fatura-adres").html(
								  $(".adress-list")
									.html()
									.replace(/name="adresID"/g, \'name="faturaID"\')
									.replace(/adres-item-/g, "fatura-item-")
								);
								$("#fatura-adres .addres-item").removeClass("active");
								$("#fatura-adres .addres-item").click(function() {
								  $("#fatura-adres .addres-item").removeClass("active");
								  $(this).addClass("active");
								  $("#faturaID").val($(this).attr("adresID"));
								  siparisBilgiGuncelle(false,false);
								});
							  }
							} else {
							  $("#faturaID").val("");
							  $("#fatura-adres").html("");
							  siparisBilgiGuncelle(false,false);
							}
						  });
						  
						  $(".teslimat-secim input").click(function() {
							$("#teslimatID").val($(this).attr("teslimatID"));     
							$(".teslimat-secim tr").removeClass("active");
							$(this).parent().parent().addClass("active");
							$(this).addClass("active");      
							siparisBilgiGuncelle(true,false);							
						});					
						$(".teslimat-secim input:first").click();		
					});
				</script>';

	public static function getForm($addressID)
	{
		$q = my_mysql_query("select * from useraddress where ID='" . (int)$addressID . "' AND userID='" . $_SESSION['userID'] . "'");
		$d = my_mysql_fetch_array($q);
		$cityOption = $townOption = '';
		$cityQuery = my_mysql_query('select * from iller where cID=0 OR cID=1 order by name');
		while ($cityRow = my_mysql_fetch_array($cityQuery)) {
			$cityOption .= '<option value="' . $cityRow['plakaID'] . '" ' . ($cityRow['plakaID'] == $d['city'] ? 'selected' : '') . '>' . $cityRow['name'] . '</option>' . "\n";
		}

		$qt = my_mysql_query("select * from ilceler where parentID='" . $d['city'] . "' order by name");
		while ($dt = my_mysql_fetch_array($qt)) {
			$attr = ($dt['disabled'] ? '0' : '1');
			$townOption .= '<option ' . ($dt['ID'] == $d['semt'] ? 'selected' : '') . ' kargo="' . $attr . '" value="' . $dt['ID'] . '">' . $dt['name'] . '</option>' . "\n";
		}

		$out = self::JS;
		$out .= '<form id="adres_form_' . (int)$addressID . '"><div class="addres-add-form">
							<div>
									<div>
										<input id="name' . (int)$addressID  . '" name="name" type="text" placeholder="" value="' . $d['name'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
										<label for="name' . (int)$addressID  . '">Adı</label>
									</div>
									<div>
										<input id="lastname' . (int)$addressID  . '" name="lastname" type="text" placeholder="" value="' . $d['lastname'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
									    <label for="lastname' . (int)$addressID  . '">Soyadı</label>

									</div>
									
									<div>
											<select name="city" id="gf_city' . (int)$addressID  . '" class="col-two marginRight" onchange="formCityChange(this);">
													<option value="">İl</option>
													' . $cityOption . '
											</select>
											<select name="semt" id="gf_semt' . (int)$addressID  . '" class="col-two marginLeft">
													<option value="">İlçe</option>
													' . $townOption . '
											</select>
									</div>
									<div>
											<textarea id="address' . (int)$addressID  . '" name="address" id="" placeholder="" onkeyup="this.setAttribute(\'value\', this.value);">' . $d['address'] . '</textarea>
											<label for="address' . (int)$addressID  . '">Adres</label>

									</div>
							</div>
							<div>
							
									<div>
											<input type="text" id="ceptel' . (int)$addressID  . '" name="ceptel" placeholder="" value="' . $d['ceptel'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
											<label for="ceptel' . (int)$addressID  . '">Cep Telefonu</label>

									</div>
									<div>
											<input type="text" id="tckNo' . (int)$addressID  . '" name="tckNo" placeholder="" value="' . $d['tckNo'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
											<label for="tckNo' . (int)$addressID  . '">TC Kimlik No</label>

									</div>
									<div>
									
									<input type="text" id="baslik' . (int)$addressID  . '" placeholder="" name="baslik" value="' . $d['baslik'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
                                    <label for="baslik' . (int)$addressID  . '">Adres Başlığı</label>
								   </div>
								   <div class="radio-list">
										<div class="radio-backed" style="width: 100%;">
											<input id="type-3' . (int)$addressID  . '" value="' . _lang_evet . '" type="checkbox" name="efatura" ' . ($d['efatura'] == _lang_evet ? 'checked' : '') . '>
											<label for="type-3' . (int)$addressID  . '">
													E-Fatura Mükellefiyim.
											</label>
										</div>									
									</div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="radio-list">
											<h3>Fatura Türü</h3>
											<div class="radio-backed">
                                                <input id="type-1' . (int)$addressID  . '" type="radio" name="x1" onchange=\'$(".kurumsalForm").hide();\' ' . (($d['firmaUnvani'] || $d['vergiDaire'] || $d['vergiNo'] || $d['efatura']) ? '' : 'checked') . '>
                                                <label for="type-1' . (int)$addressID  . '">
                                                        Bireysel
                                                </label>
                                            </div>
											<div class="radio-backed">
											<input id="type-2' . (int)$addressID  . '" type="radio" name="x1" onchange=\'$(".kurumsalForm").show();\' ' . (($d['firmaUnvani'] || $d['vergiDaire'] || $d['vergiNo'] || $d['efatura']) ? 'checked' : '') . '>
											<label for="type-2' . (int)$addressID  . '">
													Kurumsal
											</label>
                                        </div>
									</div>
									<div class="kurumsalForm" ' . (($d['firmaUnvani'] || $d['vergiDaire'] || $d['vergiNo']) ? '' : 'style="display:none"') . '>
											<div>
													<input type="text" id="firmaUnvani' . (int)$addressID  . '" name="firmaUnvani" placeholder="" class="" value="' . $d['firmaUnvani'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
                                                    <label for="firmaUnvani' . (int)$addressID  . '">Firma Adı</label>
											</div>
											<div class="kurumsalForm50">
											<div>
											
													<input type="text" id="vergiDaire' . (int)$addressID  . '" name="vergiDaire" placeholder="" class="" value="' . $d['vergiDaire'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
													<label for="vergiDaire' . (int)$addressID  . '">Vergi Dairesi</label>

													
											</div>
											<div>
											<input type="text" id="vergiNo' . (int)$addressID  . '" name="vergiNo" placeholder="" class="" value="' . $d['vergiNo'] . '" onkeyup="this.setAttribute(\'value\', this.value);">
													<label for="vergiNo' . (int)$addressID  . '">Vergi Numarası</label>
											</div>

										</div>
									</div>									
								</div>
							</div>
							<button addressID="' . $addressID . '" onclick="return adresKayit(this,\'#adres_form_' . (int)$addressID . '\')" class="addres-button">' . ($addressID ? 'Kaydet' : 'Adreslerime Ekle') . '</button>							
				</form>
				';
				$out .= '
				<script type="text/javascript">
				$(document).ready(function() { $(".addres-item[adresid=\''. hq("select adresID from siparis where userID='".$_SESSION['userID']."' AND durum > 0 order by ID desc limit 0,1").'\'").click(); });
				</script>
				';

				
		return $out;
	}

	public static function getDeliveryForm()
	{
		if (!hq("select ID from teslimat limit 0,1"))
			return;
		$out = '<div class="clear">&nbsp;</div>
				<h4>Teslimat Seçimi</h4>
				<table class="kargo-liste">
					<theader>
						<tr>
							<th colspan="2">Teslimat Tipi</th>
							<th>Fiyat Farkı</th>
						</tr>
					</theader>
					<tbody class="teslimat-secim">';
		$deliveryQuery = my_mysql_query('select * from teslimat order by seq desc');
		while ($d = my_mysql_fetch_array($deliveryQuery)) {
			if ($d['degisimYuzde']) {
				$fark = (basketInfo('toplamKDVDahil', $_SESSION['randStr']) * abs($d['degisimYuzde']));
				$isaret = ($d['degisimYuzde'] > 0 ? '+' : '-');
			}
			if ($d['degisimYTL']) {
				$fark = $d['degisimYTL'];
				$isaret = ($d['degisimYTL'] > 0 ? '+' : '-');
			}
			$fark = $isaret . $fark;

			$out .= '<tr><td><input type="radio" name="teslimat" teslimatID="' . $d['ID'] . '" id="teslimat-secim-' . $d['ID'] . '">&nbsp;</td><td><label for="teslimat-secim-' . $d['ID'] . '">' . $d['name'] . '</label></td><td><label for="teslimat-secim-' . $d['ID'] . '">' . my_money_format('', (float)$fark) . ' ' . fiyatBirim('TL') . '</label></td></tr>' . "\n";
		}

		$out .= ' 	</tbody>
				</table>';
		return $out;
	}

	public static function getAddressList()
	{
		//if (!hq("select count(*) from useraddress where userID='" . $_SESSION['userID'] . "'"))
		adresEkleGuncelle(_lang_kayitAdresim, user());
		$out = '
		<input type="hidden" name="adresID" id="adresID" value="" />
		<input type="hidden" name="faturaID" id="faturaID" value="" />
		<input type="hidden" name="kargoID" id="kargoFirmaID" value="" />
		<input type="hidden" name="teslimatID" id="teslimatID" value="" />
		<div class="containter">
			<div class="adress-container">
					<h4>Teslimat Adresi</h4>
					
					<div class="adress-list" id="teslimat-adres">
						<div class="clear">&nbsp;</div>
							<ul>';
		$i = 1;
		$q = my_mysql_query("select * from useraddress where userID='" . $_SESSION['userID'] . "' group by baslik order by if(useraddress.baslik = '" . _lang_kayitAdresim . "',0,1),ID desc");
		while ($d = my_mysql_fetch_array($q)) {

			my_mysql_query("delete from useraddress where baslik = '".$d['baslik']."' AND userID='".$d['userID']."' AND ID != '".$d['ID']."'");
			
			$ilce = $d['semt'];
			$ilce = hq("SELECT name FROM `ilceler` WHERE `ID` = '{$ilce}' LIMIT 1");
			$il = $d['city'];
			$il = hq("SELECT name FROM `iller` WHERE `ID` = '{$il}' LIMIT 1");

			$out .= '			<li class="addres-item" adresID="' . $d['ID'] . '">
										<div>
												<label for="adres-item-' . $i . '">
														<strong>' . $d['baslik'] . '</strong><hr />
														<span>' . $d['name'] . ' ' . $d['lastname'] . '</span>
												</label>
												<p>
														' . substr($d['address'], 0, 40) . (strlen($d['address']) > 40 ? '...' : '') . '<br />
														' . $ilce . ' / ' . $il . '
												</p>

												<p><b>Tel : </b> ' . $d['ceptel'] . '</p>
										</div>
										' . ($d['baslik'] != _lang_kayitAdresim ? '
										<div class="addres-footer">
												<a href="" addressID="' . $d['ID'] . '" onclick="return adresGuncelle(this)">Düzenle</a>
												<a href="" addressID="' . $d['ID'] . '" onclick="return adresSil(this)">Sil</a>
										</div>' : '') . '
										<div class="active-set"><i class="fa fa-check"></i></div>
								</li>';
			$i++;
		}
		$out .= '				<li class="new-addres-item">
									<a href="#adres-ekle" class="fancybox">Yeni Adres Ekle<span>+</span></a>
								</li>
							</ul>
						</div>
						<div class="clear">&nbsp;</div>
						<h4>Fatura Bilgileri</h4>
						<div class="clear">&nbsp;</div>
						<div class="checkbox-fa">
								<input type="checkbox" checked="checked" id="fatura-adres-load">
								<label for="fatura-adres-load">Faturaya teslimat adresi yazılsın.</label>
						</div>
						<div class="adress-list" id="fatura-adres"></div>						
						' . self::getDeliveryForm() . '
						<div class="clear">&nbsp;</div>';
		
		if(hq("select ID from kargofirma limit 0,1"))
			$out .= '			<h4>Kargo Seçim</h4>
						<table class="kargo-liste">
							<theader>
								<tr>
									<th colspan="2">Firma</th>
									<th>Tutar</th>
									<th>Süre</th>
								</tr>
							</theader>
							<tbody class="kargo-secim disabled">
								<tr><td colspan="4">Lütfen önce teslimat adresini seçin.</td></tr>
							</tbody>
						</table>';

		$out .= '		<div id="adres-ekle" style="display: none;width:100%;max-width:900px;">
					<h2 class="mb-3">
							Yeni Adres Ekle
					</h2>
					' . SpSiparisAdres::getForm(0) . '
				</div>
				<div class="clear-space height-20">&nbsp;</div>
				';
		if (file_exists('templates/' . siteConfig('templateName') . '/images/form_Gonder.gif'))
			$button = '<input type="image" class="formGonderButton" onclick="shopPHPPaymentStep2(); return false;" src="templates/' . siteConfig('templateName') . '/images/form_Gonder.gif" value="' . _lang_gonder . '" />';
		else
			$button = '<input type="button" onclick="shopPHPPaymentStep2(); return false;" class="sf-button sf-button-large sf-neutral-button" value="' . (constant('_lang_gonder_' . $_GET['act']) ? constant('_lang_gonder_' . $_GET['act']) : _lang_gonder) . '" />';

		$out .= $button . "\n				
			</div>
		</div>";
		return $out;
	}

	public static function getShippingList()
	{
		if (!basketInfo('toplamUrun', $_SESSION['randStr']))
			exit("<script type='text/javascript'>window.location.href = '" . slink('sepet') . "';</script>");
		$kargoArray = getKargoArray();
		$out = '';
		foreach ($kargoArray as $kargok => $kargov) {
			$resim = hq("select resim from kargoFirma where ID='$kargok");
			$tutar = sepetKargoHesapla($_SESSION['randStr'], $kargok);
			//if ((float)$tutar > 0) 
			$tutarStr = my_money_format('', $tutar) . ' ' . fiyatBirim('TL');
			$out .= '<tr>
					<td><input type="radio" name="kargo" kargoFirmaID="' . $kargok . '" id="kargo-secim-' . $kargok . '">&nbsp;</td>
					<td><label for="kargo-secim-' . $kargok . '">' . ($resim_iptal ? '<img src="images/' . $resim . '" alt="' . $kargov . '" />' : $kargov) . '</label></td>
					<td><label for="kargo-secim-' . $kargok . '">' . $tutarStr . '</label></td>
					<td><label for="kargo-secim-' . $kargok . '">' . kargoGun($kargok) . '</label></td>
				   </tr>';
		}
		return $out;
	}

	public static function getPaymentList($bankListArray)
	{
		$bankList = array();
		foreach ($bankListArray as $d) {
			$type = 'diger';
			if ($d['taksitOrani'])
				$type = 'cc';
			if (stristr($d['paymentModulURL'], 'payment_havale'))
				$type = 'havale';
			if (stristr($d['paymentModulURL'], 'payment_kapida'))
				$type = 'kapida';
			if (stristr($d['paymentModulURL'], 'payment_mobil'))
				$type = 'mobil';
			$bankList[$type] .= '<li class="addres-item bank-item" bankaID="' . $d['ID'] . '">
										<div>
												<label for="bank-item-' . $i . '">
													' . ($d['odemeLogo'] ? '<center><img alt="" src="images/banka/' . $d['odemeLogo'] . '"" /></center>' : '<strong>' . $d['bankaAdi'] . '</strong>') . '
												</label>
												<div class="clear-space">&nbsp;</div>
												<p>
														' . $d['odemeAciklama'] . '
												</p>
												<div class="addres-footer">
													<p><b>' . $d['payPercent'] . '</b></p>
												</div>
												<div class="active-set"><i class="fa fa-check"></i></div>												
										</div>
								</li>';
		}
		if (siteConfig('sepet_odeme') == '3')
			$onclick = 'if(selectedPayType && odemeKontrol(\'' . addslashes(_lang_formJSError_acceptRules) . '\')) { shopPHPPaymentStep3(selectedPayType); } ';
		else
			$onclick = 'if(selectedPayType && odemeKontrol(\'' . addslashes(_lang_formJSError_acceptRules) . '\')) { window.location.href = \'page.php?act=satinal&op=odeme&paytype=\' + selectedPayType; }';

		return '        <div class="tabs-container">
							<div class="tabs-list">
								<ul>
									<li class="tabs-item" ' . ($bankList['cc'] ? '' : 'style="display:none;"') . '>
										<a href="#tab-item-1" class="active">Kredi Kartı / Banka Kartı
											<i class="fa fa-caret-right" aria-hidden="true"></i>
										</a>
									</li>
									<li class="tabs-item" ' . (!empty($bankList['havale']) ? '' : 'style="display:none;"') . '>
										<a href="#tab-item-2">Havale ile Ödeme<i class="fa fa-caret-right" aria-hidden="true"></i></a>
									</li>
									<li class="tabs-item" ' . (!empty($bankList['kapida']) ? '' : 'style="display:none;"') . '>
										<a href="#tab-item-3">Kapıda Ödeme<i class="fa fa-caret-right" aria-hidden="true"></i></a>
									</li>
									<li class="tabs-item" ' . (!empty($bankList['mobil']) ? '' : 'style="display:none;"') . '>
										<a href="#tab-item-4">Mobil ile Ödeme <i class="fa fa-caret-right" aria-hidden="true"></i></a>
									</li>
									<li class="tabs-item" ' . (!empty($bankList['diger']) ? '' : 'style="display:none;"') . '>
										<a href="#tab-item-5">Diğer <i class="fa fa-caret-right" aria-hidden="true"></i>
										</a>
									</li>
								</ul>
							</div>
							<div class="tabs-content">
								<div id="tab-item-1" class="adress-container">
									<div class="adress-list">
										<ul>
											' . $bankList['cc'] . '
										</ul>
									</div>
								</div>
								<div id="tab-item-2" style="display:none" class="adress-container">
									<div class="adress-list">
										<ul>
											' . $bankList['havale'] . '
										</ul>
									</div>
								</div>
								<div id="tab-item-3" style="display:none" class="adress-container">
									<div class="adress-list">
										<ul>
											' . $bankList['kapida'] . '
										</ul>
									</div>
								</div>
								<div id="tab-item-4" style="display:none" class="adress-container">
									<div class="adress-list">
										<ul>
											' . $bankList['mobil'] . '
										</ul>
									</div>
								</div>
								<div id="tab-item-5" style="display:none" class="adress-container">
									<div class="adress-list">
										<ul>
											' . $bankList['diger'] . '
										</ul>
									</div>
								</div>
							</div>
							<div class="tabs-footer">
								<div>
									<input type="checkbox" id="odeme-onay" checked="checked">
									<label for="odeme-onay">' . _lang_odemeOnay . '</label>
								</div>
								<button onclick="' . $onclick . '">Onaylıyorum</button>
							</div>
						</div>
						<script>
							$(function () {
								$(".tabs-container .tabs-list ul li a").click(function () {

									$(".tabs-container .tabs-list ul li a.active").removeClass("active");
									$(".tabs-container .tabs-content > div").hide();
									$(this).addClass("active");
									$($(this).attr("href")).show();
									$($(this).attr("href")).find(".bank-item:first").click();
									return false;

								});
								$(".bank-item").click(function() { $(".bank-item").removeClass("active"); $(this).addClass("active"); selectedPayType = $(this).attr("bankaID"); sepetSecimGuncelle(selectedPayType,0); });
								$(".tabs-container .tabs-list ul li:visible a:first").click();
							});
						</script>';
	}
}

function siparisOdemeSecimY($query)
{
	return SpSiparisAdres::getPaymentList($query);
}

if (isset($_GET['siparisKargoListe'])) {
	include('all.php');
	exit(SpSiparisAdres::getShippingList());
}

if (isset($_GET['getAjaxAddressID'])) {
	include('all.php');
	exit('<div style="width:100%;max-width:900px;"><h2 class="mb-3">Adres Güncelle</h2>' . SpSiparisAdres::getForm(hq("select ID from useraddress where ID='" . (int)$_GET['getAjaxAddressID'] . "' AND userID='" . $_SESSION['userID'] . "'")) . '</div>');
}

if (isset($_GET['setAjaxAddressID'])) {
	include('all.php');
	if ($_GET['setAjaxAddressID'] && !hq("select ID from useraddress where ID='" . (int)$_GET['setAjaxAddressID'] . "' AND userID='" . $_SESSION['userID'] . "'"))
		exit('ok-but-why?');
	exit(adresEkleGuncelle(false, $_POST));
}

if (isset($_GET['deleteAjaxAddressID'])) {
	include('all.php');
	exit(my_mysql_query(("delete from useraddress where ID='" . (int)$_GET['deleteAjaxAddressID'] . "' AND userID='" . $_SESSION['userID'] . "'")));
}
 


function mySiparisOdemeSecim()
{
    if (siteConfig('sepet_odeme') == '1') {
        require_once 'mod_Odeme.php';
    }
    userAdresKontrol();
    if ($_SESSION['bakiyeOdeme']) {
        $filter = 'AND paymentModulURL != \'include/payment_kredi.php\'';
        if (hq("select ID from banka where active = 1  AND bakiye = 1")) {
            $filter .= ' AND taksitOrani = 1';
        }
    }
    if (!$_SESSION['userID']) {
        $filter = 'AND paymentModulURL != \'include/payment_kredi.php\'';
    }
    if (basketInfo('Promosyon', $randStr) && (basketInfo('ModulFarkiIle', $_SESSION['randStr']) <= 0)) {
        $filter .= " AND paymentModulURL = 'include/payment_promosyon.php'";
    } else {
        $filter .= " AND paymentModulURL != 'include/payment_promosyon.php'";
    }
    if ($_GET['cconly']) {
        $filter .= " AND taksitOrani = 1";
    }
    if (userGroupID() && hq("select ID from banka where userGroup != '' AND userGroup != '0' AND active =1")) {
        $query = "select * from banka where minsiparis <= " . basketInfo('ModulFarkiIle', $_SESSION['randStr']) . " AND active = 1 AND (userGroup like '%," . userGroupID() . ",%' OR userGroup = '') AND paymentModulURL != '' $filter order by seq";
    } else {
        $query = "select * from banka where minsiparis <= " . basketInfo('ModulFarkiIle', $_SESSION['randStr']) . " AND active = 1 AND (userGroup='' OR userGroup = '0') AND paymentModulURL != '' $filter order by seq";
    }
    if (function_exists('siparisOdemeSecimX') && siteConfig('templateName') != 'mobiles') {
        return siparisOdemeSecimX($query);
    }
    $out .= '<link href="css/pay_select.css" rel="stylesheet" type="text/css" />
		<div class="selectPayBlock">
			<div class="wrapSelectPay">
			<form>
				<div class="selectMethods">';
    $q = my_mysql_query($query);
    $i = 1;
    $listArray = array();
    while ($d = my_mysql_fetch_array($q)) {
        if ($d['hide']) {
            continue;
        }
        $d = translateArr($d);
        $list = true;
        if ($d['maxsiparis'] && basketInfo('ModulFarkiIle', $_SESSION['randStr']) > $d['maxsiparis']) {
            continue;
        }
        if (($d['cat'] && $d['cat'] != '0') || ($d['marka'] && $d['marka'] != '0')) {
            $qSepet = my_mysql_query("select * from sepet where randStr like '" . $_SESSION['randStr'] . "'");
            while ($dSepet = my_mysql_fetch_array($qSepet)) {
                $qUrun = my_mysql_query("select * from urun where ID='" . $dSepet['urunID'] . "'");
                $urun = my_mysql_fetch_array($qUrun);
                if ($d['cat'] && $d['cat'] != '0') {
                    if (!(stristr($d['cat'], ',' . $urun['catID'] . ',') === false)) {
                        $list = false;
                    }
                }
                if ($d['marka'] && $d['marka'] != '0') {
                    if (!(stristr($d['marka'], ',' . $urun['markaID'] . ',') === false)) {
                        $list = false;
                    }
                }
            }
        }
        if ($list && ($d['langs'] && $d['langs'] != '0')) {
            if ((stristr($d['langs'], ',' . $_SESSION['lang'] . ',') === false)) {
                $list = false;
            }
        }
        if ($list) {
            $degisimYuzde = (float) dbInfo('banka', 'degisimYuzde', $d['ID']);
            $degisimYTL = (float) dbInfo('banka', 'degisimYTL', $d['ID']);
            $isaret = (($degisimYuzde + $degisimYTL) >= 0 ? '+' : '-');
            $desc = ($isaret == '+' ? '' : _lang_sepet_indirimli);
            $orgGet = $_GET;
            $_GET['paytype'] = $d['ID'];
            $_GET['act'] = 'satinal';
            $_GET['op'] = 'odeme';
            $toplamTutarTL = $yeniTutar = basketInfo('ModulFarkiIle', $_SESSION['randStr']);
            //  $yeniTutar = ($degisimYuzde ? ($toplamTutarTL + ($toplamTutarTL * $degisimYuzde)) : $toplamTutarTL + $degisimYTL);
            $_GET = $orgGet;
            if ($degisimYuzde != 0 || $degisimYTL != 0) {
                $degisim = $degisimYTL;
                $fiyatBirim = fiyatBirim('TL');
                if($_SESSION['cache_setfiyatBirim'])
                {
                    $degisim = fiyatCevir($degisimYTL,'TL',$_SESSION['cache_setfiyatBirim']);
                    $yeniTutar = fiyatCevir($yeniTutar,'TL',$_SESSION['cache_setfiyatBirim']);
                    $fiyatBirim = fiyatBirim($_SESSION['cache_setfiyatBirim']); 
                }
                $payPercent = '(' . ($degisimYuzde ? '%' . abs($degisimYuzde * 100) : abs($degisim) . ' ' . $fiyatBirim . '') . ' ' . ($isaret == '-' ? _lang_sepet_indirimli : '') . ') ' . my_money_format('', $yeniTutar) . ' ' . $fiyatBirim;
            } else {
                $payPercent = '';
            }
            $d['payPercent'] = $payPercent;
            $out .= '<div class="payMethods">
					<div class="payLogo"><label for="odemeSelect' . $d['ID'] . '" onclick="selectedPayType = \'' . $d['ID'] . '\';">' . ($d['odemeLogo'] ? '<img alt="" src="images/banka/' . $d['odemeLogo'] . '"">' : '') . '</label></div>
					<div class="payTitle"><label for="odemeSelect' . $d['ID'] . '" onclick="selectedPayType = \'' . $d['ID'] . '\';">' . $d['odemeAciklama'] . '</label></div>
					<div class="payPercent">' . $payPercent . '</div>
					<div class="paySelector"><input id="odemeSelect' . $d['ID'] . '" ' . ($i == 0 ? 'checked="checked"' : '') . ' type="radio" name="odemeSelect" ' . (!$d['active'] ? 'disabled="true"' : '') . ' onclick="selectedPayType = \'' . $d['ID'] . '\';"></div>
					<div class="clear-space"></div>
				</div>';
            $i++;
            $listArray[] = $d;
        }
    }
    include_once 'mod_SiparisAdresSecim.php';
    if (function_exists('siparisOdemeSecimY') && siteConfig('templateName') != 'mobiles') {
        return siparisOdemeSecimY($listArray);
    }
    if (siteConfig('sepet_odeme') == '3') {
        $onclick = 'if(selectedPayType && odemeKontrol(\'' . addslashes(_lang_formJSError_acceptRules) . '\')) { shopPHPPaymentStep3(selectedPayType); } ';
    } else {
        $onclick = 'if(selectedPayType && odemeKontrol(\'' . addslashes(_lang_formJSError_acceptRules) . '\')) { window.location.href = \'page.php?act=satinal&op=odeme&paytype=\' + selectedPayType; }';
    }
    if (file_exists('templates/' . siteConfig('templateName') . '/images/form_Onayliyorum.gif')) {
        $button = '<input onclick="' . $onclick . ' return false;" type="image" src="templates/' . siteConfig('templateName') . '/images/form_Onayliyorum.gif" />';
    } else {
        $button = '<input onclick="' . $onclick . ' return false;" class="sf-button sf-button-large sf-primary-button" type="button" value="' . _lang_onayliyorum . '" />';
    }
    $out .= '  <div style="clear:both;"></div>
				</div>
				<div class="payFooter">
				<div class="rulesBox"><input type="checkbox" id="odeme-onay" /></div>
				<div class="rulesText"><label for="odeme-onay">' . _lang_odemeOnay . '</label></div>
				<div class="rulesButtons">' . $button . '</div>
				<div style="clear:both;"></div>
				</div>
			  </form>
			<div class="clear-space"></div>
			</div>
			<div class="clear-space"></div>
			</div>';
    $out .= '<div style="clear:both;">&nbsp;</div>';
    $out .= '<script type="text/javascript">
		$("input[name=odemeSelect]").click(function() {
			sepetSecimGuncelle(selectedPayType,0);
		});</script>';
    return $out;
}