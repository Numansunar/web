function tempStart() {
	$('#trip > div > ul > li > a').each(function() {  
		//alert($(this).parent().find('ul').length);
		if(!$(this).parent().find('ul').length) $(this).hover(function() { $(this).css({'background':'url(templates/tpblue/img/arrowRight.png)  244px 12px no-repeat','color':'#e57b0d'}); },function() { $(this).css({'color':'#939393'}); });
	});
	$('.loginForm').parent().find('.trip a').css({'background':'none','padding':'0','border':'none'});
}

$(document).ready(function() {	
		$("#sepetGoster").css({'top':($('#menu').position().top + $('#menu').height() - 10) + 'px','left':($('#header').position().left + 600) + 'px'});						   
});