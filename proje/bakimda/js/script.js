$(document).ready(function() {
	
	/* Run timer */
	
	setTimeCounterOn();
	
	/* Map */
	
	if ($('#contact_map').length)
	{
		startGmap();
		$('body').addClass('map');
	}
	
	


	/* Twitter Widget */
	if (typeof twitter_username !== "undefined" && twitter_username!='')
	{
		$("footer .twitter-feed").tweet({
			modpath: "./twitter/",
			join_text : "",
			count : 1,
			loading_text : "loading tweets...",
			username : twitter_username,
			template : "{text}{join}{time}"
		});
		
	}
	
	else
	{
		$('.tweet_list').hide();
	}
	
	
	/* Form Submission */
	$('form').submit(function() {
		
		var form_data = $(this).serialize();

		if (validateEmail($('input[name=email]').attr('value')))
		{
			
			if (typeof ajax_form !== "undefined" && ajax_form === true)
			{
				
				$.post($(this).attr('action'), form_data, function(data) {
					$('form').fadeOut('slow', function() { $(this).after('<p class="form-msg">' + data + '</p>'); });
	  				$('.spam').html('&nbsp;');
				});
				
				return false;
				
			}
			
		}

		else
		{
			$('p.spam').text(lang_hataliEposta).effect("pulsate", { times:3 }, 1000);
			return false;
		}
		
	});
	
	
	/* Background SlideShow */
	if (typeof slideshow_images !== "undefined" && slideshow_images!='')
	{
		$('body').addClass('slide');
		
		if (typeof slideshow_transition === "undefined")
		{
			slideshow_transition = 'none';
		}
		
		if (typeof slideshow_transition_speed === "undefined")
		{
			slideshow_transition_speed = 1000;
		}
		
		if (typeof slideshow_slide_interval === "undefined")
		{
			slideshow_slide_interval = 5000;
		}
		
		$.supersized({
						
			slideshow : 1, // Slideshow on/off
			autoplay : 1, // Slideshow starts playing automatically
			start_slide : 1, // Start slide (0 is random)
			stop_loop : 0, // Pauses slideshow on last slide
			random : 0, // Randomize slide order (Ignores start slide)
			slide_interval : slideshow_slide_interval, // Length between transitions
			transition : slideshow_transition, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed : slideshow_transition_speed, // Speed of transition
			new_window : 1, // Image links open in new window/tab
			pause_hover : 0, // Pause slideshow on hover
			keyboard_nav : 1, // Keyboard navigation on/off
			performance : 1, // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
			image_protect : 1, // Disables image dragging and right click with Javascript
	
			// Size & Position
			min_width : 0, // Min width allowed (in pixels)
			min_height : 0, // Min height allowed (in pixels)
			vertical_center : 1, // Vertically center background
			horizontal_center : 1, // Horizontally center background
			fit_always : 0, // Image will never exceed browser width or height (Ignores min. dimensions)
			fit_portrait : 1, // Portrait images will not exceed browser height
			fit_landscape : 0, // Landscape images will not exceed browser width
	
			// Components
			slide_links : 'blank', // Individual links for each slide (Options: false, 'num', 'name', 'blank')
			thumb_links : 1, // Individual thumb links for each slide
			thumbnail_navigation : 0, // Thumbnail navigation
			slides : slideshow_images,
	
			// Theme Options
			progress_bar : 1, // Timer for each slide
			mouse_scrub : 0
	
		});
	}
	
	else
	{
		if (typeof timeTo !== "undefined" && timeTo != '')
		{
			$('.timer-background').show();
		}
		
		$('body').removeClass('slide');
		$('#progress-back, #supersized-loader, #supersized').hide();
	}
	
	footer_height();
	map_height();
	
	$(window).resize(function() {
		footer_height();
		map_height();
	});

});

function footer_height(){h_body=$(window).height();h_main=$(".container-comming-soon").outerHeight();h_footer=(h_body-h_main);$(".slide footer").css({"min-height":h_footer})};

function map_height()
{
	
	var window_h = $(window).height();
	//var html_h = $('html').height();
	var footer_h = $('footer').height();
	var html_h = $(document).height();
	
	/*alert('window: ' + window_h);
	alert('html: ' + html_h);
	alert('document: ' + document_h);*/
	
	if ( $('body').hasClass('footer-transparent') )
	{
		
		var content_h = $('.content').outerHeight(true);
		var elements_h = $('.tweet_list').outerHeight(true);
		
		if (content_h > (window_h-elements_h)-240) 
		{
			$('.bottom-elements, .rights-reserved').removeClass('bottom');
		}
		
		else
		{
			$('.bottom-elements, .rights-reserved').addClass('bottom');
		}
		
		if (window_h>html_h) map_h = window_h;
		else map_h = html_h;
		$('.contact_map').css({ 'height' : map_h });
		
	}
		
	else
	{
		$('.contact_map').css({ 'height' : (html_h-(footer_h-30)) });
	}
	
	if ( $('body').hasClass('footer-transparent') && !$('.bottom-elements').hasClass('bottom'))
	{
		social_h = $('.social').outerHeight();
		$('.social').css({'margin-top' : -(social_h+50)});
		
	}
	
}


function setTimeCounterOn() {
	var days = 24 * 60 * 60,
    hours = 60 * 60,
    minutes = 60;
	if(typeof timeTo !== "undefined" && timeTo != '')
		var e=Math.floor((timeTo-(new Date()))/1000);if(e<0){e=0}var c=Math.floor(e/days);updateElement("days",c);e-=c*days;var b=Math.floor(e/hours);updateElement("hours",b);e-=b*hours;var a=Math.floor(e/minutes);updateElement("minutes",a);e-=a*minutes;var d=e;updateElement("seconds",d);setTimeout(setTimeCounterOn,1000);
}
	
function updateElement(a, b) {
		if(a=="days"){$(".days").text(b)}else{if(a=="hours"){$(".hours").text(b)}else{if(a=="minutes"){$(".minutes").text(b)}else{if(a=="seconds"){$(".seconds").prepend('<i style="display:none">'+b+"</i>");$(".seconds i").last().hide(200);$(".seconds i").first().show(200);$(".seconds i").last().remove()}}}};
}
//Timer
if (typeof timeTo !== "undefined" && timeTo != '')
{
	setTimeCounterOn();
}

else
{
	setTimeCounterOff();
}

function setTimeCounterOff()
{
		$('.timer-background').hide();
		return false;
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

function startGmap() {
	
	var myOptions = {
		zoom: 4,
		center: new google.maps.LatLng(google_maps_latitude, google_maps_longitude),
		navigationControlOptions: {
			style: google.maps.NavigationControlStyle.NORMAL,
			position: google.maps.ControlPosition.RIGHT_TOP
		},
		streetViewControl: false,
		scrollwheel: false,
		zoomControl: true,
		zoomControlOptions: {
      		style: google.maps.ZoomControlStyle.DEFAULT,
      		position: google.maps.ControlPosition.RIGHT_TOP
    	},
		mapTypeControl: false,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
      		position: google.maps.ControlPosition.TOP_RIGHT,
			mapTypeIds: ["ptMap"]
		}
	};
	
	map = new google.maps.Map(document.getElementById('contact_map'), myOptions);
	
	var styleCP = [
		{ featureType: "administrative", elementType: "all", stylers: [ { visibility: "off" } ] },
		{ featureType: 'landscape', elementType: 'all', stylers: [ { color: google_maps_landscape_color }, { visibility: 'on' } ] },
		{ featureType: "poi", elementType: "all", stylers: [ { visibility: "off" } ] },
		{ featureType: "road", elementType: "all", stylers: [ { visibility: "on" }, { lightness: -30 } ] },
		{ featureType: "transit", elementType: "all", stylers: [ { visibility: "off" } ] },
		{ featureType: "water", elementType: "all", stylers: [ { color: google_maps_water_color } ] }
	];
		
	var styledMapOptions = {name: "Map"};
  	var ptMapType = new google.maps.StyledMapType(styleCP, styledMapOptions);
  	map.mapTypes.set("ptMap", ptMapType);
  	map.setMapTypeId("ptMap");  
	
	
	
	var circle = {
  		path: google.maps.SymbolPath.CIRCLE,
	    fillOpacity: 0.75,
	    fillColor: google_maps_circle_color,
	    strokeOpacity: 1.0,
	    strokeColor: google_maps_circle_color,
	    strokeWeight: 1.0, 
	    scale: 10
	};
	
	var point = new google.maps.LatLng(google_maps_latitude, google_maps_longitude);
	
	var marker = new google.maps.Marker({
		position: point,
		map: map,
		zIndex: 99999,
		optimized: false,
		icon: circle
	});
	
}
