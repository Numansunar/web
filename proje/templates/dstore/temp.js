function tempStart() {
	$('.tabset li a').click(function() { 
		$('.tabset li').removeClass('active'); 
		$(this).parent().addClass('active'); 
		$('.dstoretab').hide(); 
		var id = '#'+$(this).parent().attr('open-tab');
		$('#'+$(this).parent().attr('open-tab')).show(); 
		return false; 
	});
	$("#product-gallery1").jCarouselLite({
							btnPrev: ".product-gallery1 .btn-prev",
							btnNext: ".product-gallery1 .btn-next",
							btnGo: [],
							visible: 5,
							auto: 0,
							scroll:1,
							speed: 800
						});	
	$("#product-gallery2").jCarouselLite({
						btnPrev: ".product-gallery2 .btn-prev",
						btnNext: ".product-gallery2 .btn-next",
						btnGo: [],
						visible: 5,
						scroll:1,
						auto: 0,
						speed: 800
					});
	$("#dstorenews").jCarouselLite({
						btnPrev: ".news .btn-prev",
						btnNext: ".news .btn-next",
						btnGo: [],
						visible: 1,
						scroll:1,
						auto: 0,
						speed: 800
					});					
}

