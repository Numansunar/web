(function($){

lozad('.lozad', {
load: function(el) {
    el.src = el.dataset.src;
    el.onload = function() {
        el.classList.add('fadeIn')
    }
}
}).observe()

if ($(".urunSecim_ozellik1detay li").length == 1) {
  var dataoz = $(".urunSecim_ozellik1detay li").data("value");
  $(".urunSecim_ozellik1detay li").addClass("selected");
  $("#urunSecim_ozellik1detay").val(dataoz);
}

$(".tabs-footer .btnOdeme").on('click',function(e){
    e.preventDefault();
    $(this).attr('disabled','disabled');
    $(this).html('lütfen bekleyiniz..');
    $(".loadingoverlay").css('display','flex');
});

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function replaceTurkishChars(str){
  var charMap = { Ç: 'C', Ö: 'O', Ş: 'S', İ: 'I', I: 'i', Ü: 'U', Ğ: 'G', ç: 'c', ö: 'o', ş: 's', ı: 'i', ü: 'u', ğ: 'g' };
   var str_array = str.split('');
    for (var i = 0, len = str_array.length; i < len; i++) {
      str_array[i] = charMap[str_array[i]] || str_array[i];
    }
    str = str_array.join('');
    var clearStr = str.replace(/[çöşüğı]/gi,"");
	return clearStr;
}

$("#gf_email").on("change",function(){
	var email = $.trim($(this).val());
	email = email.replace(/ /g,'');
	email = replaceTurkishChars(email);
	email = email.toLowerCase();
	
	$(this).val(email);
	
	if(isEmail(email)==false){
		$(this).parents('form').find('input[type="button"]').prop('disabled',true);
		alerter.show('Lütfen mail adresinizi kontrol edin!');
	}else {
		$(this).parents('form').find('input[type="button"]').prop('disabled',false);
		console.log("email doğru girildi");
	}
});

	$('#shopphp-payment-body-step1 input.sf-button').val('SİPARİŞİ ONAYLA / DEVAM ET');
	$('.rulesButtons .sf-button').val('SİPARİŞİ ONAYLA / DEVAM ET');
	$("#gf_kargoFirmaID option:eq(1)").attr('selected','selected');
	$("#orderBy option:eq(1)").attr('selected','selected');
	$('.payment .paymentTab .tabLinks ul li a.pt5').text('Diğer');
	$(".rulesBox input").attr('checked','checked'); 
  $("input#odeme-onay").attr('checked','checked');
	
	//$('a.parent').attr('href','#').click(function() { $(this).parent().find('.vertical-dropdown-menu').toggle(); });
	//$('#orderBy').prepend($('<option>', { value: "" , text: "Seçiniz.."}));
	
  if($('.vitrinSlider').length >0){
    $('.vitrinSlider').owlCarousel({
            autoplay:true,
            autoplayHoverPause:true,
            dots:true,
            lazyLoad: true,
            loop:true,
            items : 1,
            nav:true,
            navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            margin:0,
            autoplayTimeout:3000,
            responsive : {
              0 : {items : 1,},
              480 : {items : 1,},
              768 : {items : 1,},
              1000 : {items : 1,}
          }
    });
  }


if ($(window).width() < 1025) {
	
  if($('.serviceMobile').length >0){
		$('.serviceMobile').owlCarousel(
			{
				autoplay:true,
				autoplayHoverPause:true,
				dots:false,
				loop:true,
				items : 1,
				nav:false,
				navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
				margin:0,
				autoplayTimeout:3000,
				responsive : {
          0 : {items : 1,},
				  480 : {items : 1,},
				  768 : {items : 3,},
				  1000 : {items : 3,}
			  }
		});
  }
		
  	if($('.bannerSlider').length >0){
  		$('.bannerSlider').owlCarousel(
  			{
  				autoplay:true,
          lazyLoad: true,
  				autoplayHoverPause:true,
  				dots:true,
          loop:true,
  				items : 1,
  				nav:false,
  				margin:0,
  				responsive : {
  				  0 : {items : 1,},
  				  480 : {items : 1,},
  				  768 : {items : 2,},
  				  1000 : {items : 3,}
  			  }
  		});
    }
		
		if($('.mobileSliderwrap').length >0){
		  $('.mobileSliderwrap').owlCarousel(
  			{
  				dots:true,
  				items : 1,
  				margin:0,
          lazyLoad: true,
  				responsive : {
  				  0 : {items : 1,},
  				  480 : {items : 1,},
  				  768 : {items : 1,},
  				  1000 : {items : 1,}
  			  }
  			});
		}
}
	
 $('.left-module').find('.title_block').click(function (e) {
      e.preventDefault();
      $(this).next().slideToggle('fast');
      $(this).find('.fa').toggleClass('fa-caret-down fa-caret-up');
      $(".block_content").not($(this).next()).slideUp('fast');
  });	

	$(".box-vertical-megamenus .downtitle").click(function() {
		$(".vertical-dropdown-menu-all").slideToggle();
	});
		
$(document).ready(function() {
		
    		$(".main-header .btnSearch").click(function() {
    			$(".search-box").slideToggle();
    		});

        $(".owl-carousel").each(function(index, el) {
          var config = $(this).data();
          config.navText = ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'];
          config.smartSpeed="300";
          if($(this).hasClass('owl-style2')){
            config.animateOut="fadeOut";
            config.animateIn="fadeIn";    
          }
          $(this).owlCarousel(config);
        });
        
        $(".owl-carousel-vertical").each(function(index, el) {
          var config = $(this).data();
          config.navText = ['<span class="icon-up"></spam>','<span class="icon-down"></span>'];
          config.smartSpeed="900";
          config.animateOut="";
            config.animateIn="fadeInUp";
          $(this).owlCarousel(config);
        });

        $(document).on('click','.toggle-menu',function(){
            $(this).closest('.nav-menu').find('.navbar-collapse').toggle();
            return false;
        })

       $(window).scroll(function() {
    			if ($(this).scrollTop() > 100) {
    			 $('.scroll_top').fadeIn();
    			} else {
    			 $('.scroll_top').fadeOut();
    			}
    		});

  		$('.scroll_top').click(function() {
  			$('html, body').animate({
  			 scrollTop: 0
  			}, 800);
  			return false;
  		});
				

     $(window).scroll(function(){
        var sticky = $('.nav-top-menu'),
            scroll = $(window).scrollTop();
        if (scroll >= 100) sticky.addClass('nav-ontop');
        else sticky.removeClass('nav-ontop');
      });

        // tre menu category
        $(document).on('click','.tree-menu li span',function(){
            $(this).closest('li').children('ul').slideToggle();
            if($(this).closest('li').haschildren('ul')){
                $(this).toggleClass('open');
            }
            return false;
        })

  		if($('.UrunSliderWrap .product-list').length >0){
    		$('.UrunSliderWrap .product-list').owlCarousel(
    			{
    				dots:true,
    				loop:true,
    				autoplay:true,
            lazyLoad: true,
    				autoplayHoverPause:true,
    				items : 4,
    				nav:true,
    				navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
    				margin:0,
    				autoplayTimeout:5000,
    				responsive : {
    				  0 : {items : 2,},
    				  480 : {items : 2,},
    				  768 : {items : 3,},
    				  1000 : {items : 3,},
              1366 : {items : 4,}
    			  }
    			});
  		}

    if($('.urunFirsatSlider .product-list').length >0){
      $('.urunFirsatSlider .product-list').owlCarousel(
          {
              dots:true,
              loop:true,
              autoplay:true,
              lazyLoad: true,
              autoplayHoverPause:true,
              items : 1,
              nav:true,
              navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
              margin:0,
              autoplayTimeout:5000,
              responsive : {
                0 : {items : 2,},
                480 : {items : 2,},
                768 : {items : 3,},
                1000 : {items : 3,},
                1200 : {items : 1,},
                1366 : {items : 1,}
            }
          });
      }

});

})(jQuery);