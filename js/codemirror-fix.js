(function ($) {
    $(document).ajaxComplete(function(event, xhr, options) {
        $('#widgets-right').find('.widget-control-save').each(function(i, obj) {
            var smsb = $(this).attr('id').includes("widget-monetize_wordpress_solvemedia_unlock_custom");
            var cmsb = $(this).attr('id').includes("widget-monetize_wordpress_custom_ads_widget");
            var addnew = options.data.includes("add_new=multi&action=save-widget");
            if(addnew){
                if(smsb){
                    var newid = $(this).attr('id').replace('-savewidget', '').replace('widget-', '');
                    var has_save = options.data.includes(newid);
                    if(has_save){
                        $(this).trigger('click');
                    }
                }else if(cmsb){
                    var newid = $(this).attr('id').replace('-savewidget', '').replace('widget-', '');
                    var has_save = options.data.includes(newid);
                    if(has_save){
                        $(this).trigger('click');
                    }
                }
            }
        });    
    });
})(jQuery);
