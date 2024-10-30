(function($) {
  $(document).ready( function(){
        function hf(cc, a){
            if(a == 'show'){
               if($(cc).hasClass('hide-field')){$(cc).removeClass('hide-field');} 
            }else{
               if(!$(cc).hasClass('hide-field')){$(cc).addClass('hide-field');} 
            }
          }        
    });                    
})( jQuery );