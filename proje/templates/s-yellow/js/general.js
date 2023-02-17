jQuery(document).ready(function(){+
jQuery('.date-pick').datePicker().val('').trigger('change').bind(
			'dateSelected',
			function(e, selectedDate, $td)
			{
					$('#neleriKacirdiniz').html('<div class="neler_kacirdiniz_box" style="background:none;">Lütfen bekleyin ..</div>');
					pars = 'act=nelerKacirdiniz&tarih=' + $('.date-pick').val();
					$.ajax({
					  url: 'include/ajaxLib.php?' + pars,
					  success: function(data) 
							   { 
									if(data != '')
									{
										$('#neleriKacirdiniz').html(data);
									}
									else {
									 	$('#neleriKacirdiniz').html('<div class="neler_kacirdiniz_box" style="background:none;">Listelenecek ürün bulunamadý.</div>');	
									}
							   }
					});
			}
		);
;
$('.date-pick').val('Tarih Seçin');

$('.s1,textarea.yorum').addClass("idleField");
$('.s1,textarea.yorum').focus(function() {
	$(this).removeClass("idleField").addClass("focusField");
	if (this.value == this.defaultValue){ 
		this.value = '';
	}
	if(this.value != this.defaultValue){
		this.select();
	}
});
$('.s1,textarea.yorum').blur(function() {
	$(this).removeClass("focusField").addClass("idleField");
	if (jQuery.trim(this.value) == ''){
		this.value = (this.defaultValue ? this.defaultValue : '');
	}
});

$(".urun_galeri a").fancybox();
$('.urun_galeri').after('<div class="urun_galeri_navs">').cycle({fx:'fade',speed:'slow',timeout:0,pager:'.urun_galeri_navs',pagerEvent:'mouseover',pagerAnchorBuilder:function(idx,slide){return'<a href="'+slide.href+'"><img src="'+slide.rel+'"/></a>';}});
$(".haberler").easySlider({auto: true, continuous: true, nextId: "kayan_haber_sonraki", prevId: "kayan_haber_onceki" });
$('.giris_yap').click(function(e){
	e.preventDefault();
	$(".giris_paneli").slideDown("slow");
	$(".giris_yap").addClass("giris_yap_on");
});
$(".giris_yap").addClass("giris_yap_on");
$('.giris_paneli_kapat').click(function(e){
	e.preventDefault();
	$(".giris_paneli").slideUp("slow");
	$(".giris_yap").removeClass("giris_yap_on");
});
Cufon.replace('.menu li', {	hover: true });
Cufon.replace('.giris_paneli .baslik');
Cufon.replace('.icerik_sag .baslik');
Cufon.replace('.urun_bilgisi .urun_ismi');
Cufon.replace('.urun_bilgisi .fiyat');
});