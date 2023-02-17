$(document).ready(function() {
	$('#imgSepetGosterOcean').hover(function(e){
     if ($("#sepetGoster").is(':hidden'))  
	 	$("#sepetGoster").css({'left':(e.pageX - 380) + 'px','top':e.pageY +  'px'}).show();
   },
   function(e){
      $("#sepetGoster").hide();
   }).click(function() { window.location.href = 'page.php?act=sepet'; });
});

function tempStart() {
}