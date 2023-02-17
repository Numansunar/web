<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td width="500" valign="top">
	<form action="index.php?SK=10" method="post"><table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr height="40">
				<td style="color: #FF9900"><h2>Havale Bildirim Formu</h2></td>
			</tr>
			<tr height="30">
				<td valing="top"style="border-bottom: 1px dashed #CCCCCC">Tamamlanmış Olan Ödeme İşleminizi Aşağıdaki Formdan İletin</td>
			</tr>
			<tr height="30">
				<td valign="bottom" align="left">İsim Soyisim (*)</td>		
			</tr>		
			<tr height="30">
				<td valign="top"><input type="text" name="IsimSoyisim" class="InputAlanlari"></td>		
			</tr>
			<tr height="30">
				<td valign="bottom" align="left">Email Adresi (*)</td>		
			</tr>		
			<tr height="30">
				<td valign="top"><input type="text" name="EmailAdresi" class="InputAlanlari"></td>		
			</tr>
			<tr height="30">
				<td valign="bottom" align="left">Telefon Numarası (*)</td>		
			</tr>		
			<tr height="30">
				<td valign="top"><input type="text" name="TelefonNumarasi" maxlength="11" class="InputAlanlari"></td>		
			</tr>	
			<tr height="30">
				<td valign="bottom" align="left">Ödeme Yapılan Banka (*)</td>		
			</tr>		
			<tr height="30">
				<td valign="top"><select name="BankaSecimi" class="SelectAlanlari">
					<?php
					$BankalarSorgusu= $VeritabaniBaglantisi->prepare("SELECT * FROM bankahesaplarimiz ORDER BY BankaAdi ASC");
					$BankalarSorgusu->execute();
					$BankaSayisi = $BankalarSorgusu->rowCount();
					$BankaKayitlari = $BankalarSorgusu->fetchAll(PDO::FETCH_ASSOC);
					foreach($BankaKayitlari as $Bankalar){
					?>
					<option value="<?php echo $Bankalar["id"];?>"><?php echo $Bankalar["BankaAdi"]; ?></option>
					<?php
					}
					?>
					</select></td>		
			</tr>
			<tr height="30">
				<td valign="bottom" align="left">Açıklama</td>		
			</tr>		
			<tr height="30">
				<td valign="top" align="left"><textarea name="Aciklama" class="TextAreaAlanlari"></textarea></td>		
			</tr>	
			<tr height="40">
				<td align="center"><input type="submit" value="Bildirimi Gönder" class="YesilButon"></td>		
			</tr>	
	</table></form>
		</td>
<td width="20">&nbsp;</td>
		<td width="545" valign="top"><table width="500" align="center" border="0" cellpadding="0" cellspacing="0"></td>
			<tr height="40">
				<td colspan="2" style="color: #FF9900"><h3>İşleyiş</h3></td>
	</tr>
			<tr height="30">
				<td colspan="2" valing="top"style="border-bottom: 1px dashed #CCCCCC">Havale / EFT İşlemlerinin Kontrolü</td>
			</tr>	
	<tr height="30">
		<td align="left" width="30"><img src="Resimler/Banka20x20.png" border="0" style="margin-top: 3px"></td>
		<td align="left"><b>Havale / EFT İşlemleri</b></td>	
	</tr>
	<tr>
		<td colspan="2" align="left">Müşteri Tarafından Öncelikle Banka Hesaplarımız Sayfasında Bulunan Herhangi Bir Hesaba Ödeme İşlemi Gerçekleştirilir</td>
	</tr>
<td colspan="2">&nbsp;</td>
	<tr height="30">
		<td align="left" width="30"><img src="DokumanKirmiziKalemli20x20.png" border="0" style="margin-top: 3px"></td>
		<td align="left"><b>Bildirim İşlemi</b></td>	
	</tr>
	<tr>
		<td colspan="2" align="left">Ödeme İşleminizi Tamamladıktan Sonra Havale Bildirim Formu Sayfasından Müşteri Yapmış Olduğu İşlemler İçin Bildirim Formunu Doldurarak Online Olarak Gönderir</td>
	</tr>			
<td colspan="2">&nbsp;</td>
	<tr height="30">
		<td align="left" width="30"><img src="CarklarSiyah20x20.png" border="0" style="margin-top: 3px"></td>
		<td align="left"><b>Kontroller</b></td>	
	</tr>
	<tr>
		<td colspan="2" align="left">Havale Bildirim Formunuz Ulaştığı Anda İlgili Departmanlar Tarafından Yapmış Olduğunuz Havale / EFT İşlemi İlgili Banka Üzerinden Kontrol Edilir</td>
	</tr>
<td colspan="2">&nbsp;</td>
	<tr height="30">
		<td align="left" width="30"><img src="InsanlarSiyah20x20.png" border="0" style="margin-top: 3px"></td>
		<td align="left"><b>Onay / Red</b></td>	
	</tr>
	<tr>
		<td colspan="2" align="left">Havale Bildirimi Geçerli İse Yani Hesaba Ödeme Geçmiş İse Yönetici İlgili Ödeme Onayını Vererek Siparişiniz Teslimat Bilimine İletilir</td>
	</tr>
<td colspan="2">&nbsp;</td>
	<tr height="30">
		<td align="left" width="30"><img src="SaatEsnetikGri20x20.png" border="0" style="margin-top: 3px"></td>
		<td align="left"><b>Sipariş Hazırlama & Teslimat</b></td>	
	</tr>
	<tr>
		<td colspan="2" align="left">Yönetici Ödeme Onayından Sonra Sayfamız Üzerinden Vermiş Olduğunuz Sipariş En Kısa Sürede Hazırlanarak Kargoya Teslim Edilir ve Tarafınıza Ulaştırılır</td>
	</tr>
		</table></td>	
	</tr>
</table>