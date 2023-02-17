(function($) {
	$.fn.arnoTab = function(options) {
		var defaults = {			
			mouseover: false //Can be true/false
		};
		this.each(function() {
			var obj = $(this);
			var o = $.extend(defaults, options);
			var tabs = $('.tabs > div', obj);
			tabs.hide().filter(':first').show();
			if(o.mouseover) {
				$('.tabLinks a', obj).mouseover(function () {
					tabs.hide();
					tabs.filter(this.hash).show();
					$('.tabLinks a', obj).removeClass('selected');
					$(this).addClass('selected');
					return false;
				}).filter(':first').mouseover();
			} else {
				$('.tabLinks a', obj).click(function () {
					tabs.hide();
					tabs.filter(this.hash).show();
					$('.tabLinks a', obj).removeClass('selected');
					$(this).addClass('selected');
					return false;
				}).filter(':first').click();
				
				$('.nextStep').click(function () {
					var ovye = this.hash;
					tabs.hide();
					tabs.filter(ovye).show();
					$('.tabLinks a', obj).removeClass('selected');
					$('.tabLinks a', obj).filter(function (index) {
						return $(this).attr("href").match(ovye);
					}).addClass('selected');
					return false;
				});
			}
		});
	};
})(jQuery);