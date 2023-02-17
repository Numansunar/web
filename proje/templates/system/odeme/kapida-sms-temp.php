<link rel="stylesheet" type="text/css" href="templates/system/odeme/card-master/css/style.css"/>
<!-- javascript end -->
<!-- pay screen -->
<div id="pay-screen">

	<img src="images/banka/{%DB_ODEMELOGO%}" alt=""  style="margin-bottom:20px;"/>
    <div style="clear:both">&nbsp;</div>
    <ul>
    	<li><a href="page.php?act=satinal&op=odeme&paytype={%DB_ID%}">Onay kodunu tekrar gönder.</a></li>
    	<li><a href="page.php?act=satinal&op=adres">Cep telefonu numaramu değiştirmek istiyorum.</a></li>
    </ul>
    <div style="clear:both">&nbsp;</div>
	<div class="form-element">
		<label>SMS Onay Kodu<br />({%SIPARIS_CEPTEL%})</label>
		<input type="text" class="name" name="sms_code" />
		<div style="clear:both;"></div>
	</div>
	<div class="form-element" id="gonderTD">
		<label>&nbsp </label>
		<input type="submit"  value="Kodu Doğrula" />
		<div style="clear:both;"></div>
	</div>

</div>
<!-- //pay screen -->
<script>
	if($('select[name=taksit]').length && $('select[name=taksit]').find('option').length == 0) $('.taksit').hide();
</script>