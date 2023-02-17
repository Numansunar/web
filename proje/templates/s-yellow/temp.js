function tempStart() {

}

function innerPageStart()
{
	$('.giris_paneli').hide();	
	$('.icerik_sol').css({'borderRight':'1px solid #e8e3bd','width':'566px','marginRight':'20px','paddingRight':'24px','paddingTop':'4px','minHeight':'1100px'});
	$('.generatedForm textarea').css({'width':'360px'});
}

function topMenu(act)
{
	if (act)
	{
		$('#topmenu .active').removeClass('active');
		$('#topmenu li[rel*='+act+']').addClass('active');	
	}
}