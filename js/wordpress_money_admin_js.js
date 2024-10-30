(function($) {
  $(document).ready( function(){
    $('#adflyFULL').click(function(){
        if($(this).is(':checked')){
            if(!$('.adfly_specific').hasClass('hide-field')){$('.adfly_specific').addClass('hide-field');}
            if($('.adfly_sitewide').hasClass('hide-field')){$('.adfly_sitewide').removeClass('hide-field');}
        } else {
            if($('.adfly_specific').hasClass('hide-field')){$('.adfly_specific').removeClass('hide-field');}
            if(!$('.adfly_sitewide').hasClass('hide-field')){$('.adfly_sitewide').addClass('hide-field');}
        }
    });
  });
})( jQuery );


  