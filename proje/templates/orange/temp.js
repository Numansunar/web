function tempStart() {
	$('.form-login .text').click(function() { $(this).val(''); });	
	$('#urunsirala select').change(function() { $('#urunsirala').submit(); });
}



$(document).ready(function() {
	$('#imgSepetGosterOcean').hover(function(e){
     if ($("#sepetGoster").is(':hidden'))  
	 	$("#sepetGoster").css({'left':(e.pageX - 380) + 'px','top':e.pageY +  'px'}).show();
   },
   function(e){
      $("#sepetGoster").hide();
   }).click(function() { window.location.href = 'page.php?act=sepet'; });
});

var indexBasla = 4;
var stopAjaxLoad = false;

function indexUrunEkle()
{
	indexBasla+=4;
	$.ajax({
	  url: 'index.php?basla=' + indexBasla,
	  success: function(data) 
			   { 
					var src = $(data).find(".urunAjax").html();
					if (!src) 
						stopAjaxLoad = true;
					else
						$(src).appendTo(".urunAjax");	
			   }
	});
	return false;	
}

window.onscroll = function () {
	var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
	if (scrollBottom < 500 && !stopAjaxLoad) indexUrunEkle();	
}
