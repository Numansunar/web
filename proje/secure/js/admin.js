var xmldilim = 10;

function randomString(string_length) {
	var chars = "0123456789";
	// var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

function randomChars(string_length) {
	// var chars = "0123456789";
	var chars = "0123456789abcdefghiklmnopqrstuvwxyz";
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

$(document).ready(function() {
	$('#kuponeklebutton').click(function()
		{
			for(var i=1;i<=$('#kuponekle').val();i++)
			{
				var obj ='#id_kuponlist';
				if ($(obj).val() == null) obj = '#kuponlist';
				if ($(obj).val()) $(obj).val($(obj).val() + "\n");
				$(obj).val($(obj).val() + randomChars(10));
			}
		}
	);
	$('.st-form-line select[multiple="multiple"],select[name="catID"],select[name="markaID"],select[name="userID"]').attr('data-placeholder','Seçim için týklayýn').chosen({search_contains: true});
});

function checkAll(check){
	for (var i=0;i<document.getElementsByTagName('input').length;i++)
	{
		var e=document.getElementsByTagName('input')[i];
		if ((e.name != 'allbox') && (e.type=='checkbox'))
		{
			e.checked=check;
		}
	}
}
function removeFile(dbase,field,dbID,filePath,spanID) {
	if (confirm('Dosya hem veritabanýndan hemde diskden silinecek. Emin misiniz?')) {
		document.getElementById('ajaxEmu').src = './removeFile.php?dbName='+dbase+'&dbField='+field+'&dbID='+dbID+'&filePath='+filePath;
		// window.open('./s.php?f=removeFile.php&dbName='+dbase+'&dbField='+field+'&dbID='+dbID+'&filePath='+filePath);
		document.getElementById(spanID).innerHTML = '<b>Lütfen Bekleyin...</b>';
		setTimeout(function(){ document.getElementById(spanID).innerHTML = '<b>Dosya Silindi!</b>'; },500);
	}
	return false;
}

function xmlCheckFields(data,updateURL)
{
	/*
	if(($('.xmlcatcache select').val() == null || $('.xmlcatcache select').val().length < 1) && $('#indexKatalog').is(':checked'))
	{
		alert('Katalog güncellemesi yapabilmek için firma güncelleme kategorilerini seçmelisiniz.');
		return false;
	}
	*/
	var cont = false;
	var checkFileds = data.split(',');
	for(var i = 0; i<=checkFileds.length; i++)
	{
		if ($('#'+checkFileds[i]).is(':checked')) cont = true;
	}
	if(!cont) 
	{	
		alert('Lütfen en az bir seçeneði iþaretleyin.');
		return false;
	}
						
	var pars = 'val='+$('.xmlcatcache select').val();
	$.ajax({
		url:'ajax.php?act=xmlCatCacheSet&dosya='+$('#dosya').val()+'&rand=' + randomString(5),
		type: 'POST',
	  	data: pars,
		success: function(dataunused) 
		{ 
				xmlUpdate(updateURL,0);
		}
	});
	return false;
}

var XMLWindow;

function debugCat()
{
	if($('#dosya').val() == '')
	{
		alert("Lütfen entegrasyon yapacaðýnýz firmayý seçin.");
		return false;	
	}
	window.open('s.php?f=XML/xml.php&debug-cat=1&dosya='+$('#dosya').val());		
}

function debugFiyat()
{
	if($('#dosya').val() == '')
	{
		alert("Lütfen entegrasyon yapacaðýnýz firmayý seçin.");
		return false;	
	}
	window.open('s.php?f=XML/xml.php&debug-fiyat=1&kar='+$('#kar').val()+'&dosya='+$('#dosya').val());		
}

function debugXML()
{
	if($('#dosya').val() == '')
	{
		alert("Lütfen entegrasyon yapacaðýnýz firmayý seçin.");
		return false;	
	}
	if (!$('select[name=parentID]').val() || $('select[name=parentID]').val() == 0)
	{
		if(!confirm('Üst kategori seçilmedi. Debug etmek istediðinizden emin misiniz?'))
			return false;
	}
	window.open('s.php?f=XML/xml.php&debug-xml=1&dosya='+$('#dosya').val() + '&parentID=' + $('select[name=parentID]').val());		
}

function xmlCatCache(URL)
{
	if($('#dosya').val() == '')
	{
		alert("Lütfen entegrasyon yapacaðýnýz firmayý seçin.");
		return false;	
	}
	$('.loadingbox,.loadingbox img').show();
	$('.loadingbox h3').html('Kategoriler Çekiliyor...');
	$('.xmlstats').html('').hide(); 
	$("#progressbar").progressbar({ value: 0 });
	$('#progressper').html('0');
					
	URL += '&dosya='+$('#dosya').val()+'&indexKatalog=1&xmlUpdate=1&xmlCatCache=1&dilim=0&rand=' + randomString(5)
	$.ajax({
		url: URL,
		success: function(data) 
		{ 
			$.ajax({
				url:'ajax.php?act=xmlCatCache&dosya='+$('#dosya').val()+'&rand=' + randomString(5),
				success: function(data) {  
					$('.xmlcatcache select').html(data);
					$('.loadingbox img').hide();
					$('.loadingbox h3').html('Tamamlandý...');
					$("#progressbar").progressbar({ value: 100 });
					$('#progressper').html('100'); 	
				}
			});			
		}
	});
	return false;
}

function sepetUrunChange(obj)
{
	var durum = $(obj).val();
	var adet = 0;
	if(durum == '50')
	{
		adet = prompt('Temin edilemeyen ürün adetini girin','1');	
	}
	$.ajax({
		url:'ajax.php?act=sepetDurum&lineID='+$(obj).attr('lineID')+'&durum='+durum + '&adet=' + adet,
		success: function(data) {  
			alert('Sepete ait ürün durumu güncellendi.');
		}
	});	
}

function xmlCatCacheUpdate()
{
	$.ajax({
		url:'ajax.php?act=xmlCatCache&dosya='+$('#dosya').val()+'&rand=' + randomString(5),
		success: function(data) {  
			$('.xmlcatcache select').html(data);
		}
	});	
	$.ajax({
		url:'ajax.php?act=xmlSetXMLDilim&dosya='+$('#dosya').val()+'&rand=' + randomString(5),
		success: function(data) {  
			xmldilim = parseInt(data);
			if(!xmldilim)
				xmldilim = 10;
		}
	});		
}

function xmlUpdate(updateURL,dilim)
{
	if (dilim == 0) {
		$('.loadingbox,.loadingbox img').show();
		$('.loadingbox h3').html('Yükleniyor...');
		$('.xmlstats').html('').hide(); 
		$("#progressbar").progressbar({ value: 0 });
		$('#progressper').html('0');
		// XMLWindow = window.open('xmlViewLog.php?rand=' + randomString(5),'XML','width=800,height=600,scrollbars=1');
		// window.open (updateURL + '&dilim=' + dilim + '&rand=' + randomString(5));
	}
	if (dilim != 0) $('#xmlPer').css('backgroundColor','green');
	$.ajax({
	  url: updateURL + '&dilim=' + dilim + '&rand=' + randomString(5),
	  error:function(data, textStatus, errorThrown) {
		alert(textStatus + ' | ' + errorThrown + ' | ' + data);
	  },
	  timeout: 3600000,
	  success: function(data) {
		if(data.search("XMLUpdateOK") < 0)
		{
			$('.loadingbox img').hide();
			$('.loadingbox h3').html('Hata Oluþtu... Lütfen XML ayarlarýnýzý kontrol edin.');	
			return false;			
		}
		var oran = ((dilim +1) * xmldilim);
		$("#progressbar").progressbar({ value: oran });
		$('#progressper').html(oran); 
		if (dilim < (xmldilim - 1)) xmlUpdate(updateURL,(dilim + 1));
		else {
			$('.loadingbox img').hide();
			$('.loadingbox h3').html('Tamamlandý...');
			$.ajax({
				url:'ajax.php?act=xmlStats&rand=' + randomString(5),
				success: function(data) { $('.xmlstats').html(data).slideDown(); }
			});
		}
		// XMLWindow.location.replace('xmlViewLog.php?rand=' + randomString(5));
		/*
		$.ajax({
			url:'xmlViewLog.php?rand=' + randomString(5),
			success: function(data) { if (data) $('#ViewLogFile').val(data); }
		});
		*/
	  }
	});	
}