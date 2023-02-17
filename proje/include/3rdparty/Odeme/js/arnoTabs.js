(function($) {
    $.fn.arnoTab = function(options) {
        var defaults = {                        
            mouseover: false
        };
        this.each(function() {
            var obj = $(this);
            var o = $.extend(defaults, options);
            var tabs = $('.tabs > div', obj);
            tabs.hide().filter(':first').show();
            if(o.mouseover) {
              $('.tabLinks a', obj).mouseover(function () {
                  var anchor = $(this);
                  tabs.hide();
                  tabs.each(function(){
                      if(anchor.data("tablink")==$(this).data("tab")){
                          $(this).show();
                      }
                  });
                  $('.tabLinks a', obj).removeClass('selected');
                  $(this).addClass('selected');
                  return false;
              }).filter(':first').mouseover();
            } else {
              $('.tabLinks a', obj).click(function () {
                var anchor = $(this);
                tabs.hide();
                tabs.each(function(){
                    if(anchor.data("tablink")==$(this).data("tab")){
                        $(this).show();
                    }
                });
                $('.tabLinks a', obj).removeClass('selected');
                $(this).addClass('selected');
                return false;
              }).filter(':first').click();
            }
        });
    };
})(jQuery);