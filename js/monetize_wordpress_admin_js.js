(function($) {
  $(document).ready( function(){
    $('#adflyFULL').click(function(){
        if($(this).is(':checked')){
             hf('.adfly_domains_select', 'show');
            if($("#adflyDOMAINS").val() == 'include'){
                hf('.adfly_included', 'show');
                hf('.adfly_excluded', 'hide');
            }else{
                hf('.adfly_excluded', 'show');
                hf('.adfly_included', 'hide');
            }
        } else {
            $('.adfly_domains').addClass('hide-field');
        }
    });
    $("#adflyDOMAINS").on('change', function() {
        if ($(this).val() == 'include'){
            hf('.adfly_included', 'show');
            hf('.adfly_excluded', 'hide');
        } else {
            hf('.adfly_excluded', 'show');
            hf('.adfly_included', 'hide');
        }
    });
    $('#adflyENTRY').click(function(){
        if($(this).is(':checked')){
            hf('.adfly_entry', 'show');
        } else {
            hf('.adfly_entry', 'hide');
        }
    });
    $('#solvemediaLOGIN').click(function(){
        if($(this).is(':checked')){
            hf('.sm_loptions', 'show');
        } else {
            hf('.sm_loptions', 'hide');
        }
    });
    $('#solvemediaREG').click(function(){
        if($(this).is(':checked')){
            hf('.sm_roptions', 'show');
        } else {
            hf('.sm_roptions', 'hide');
        }
    });
    $('#solvemediaLOST').click(function(){
        if($(this).is(':checked')){
            hf('.sm_loptions', 'show');
        } else {
            hf('.sm_loptions', 'hide');
        }
    });
    $("#vivadsDOMAINS").on('change', function() {
        if ($(this).val() == 'include'){
            hf('.vivads_included', 'show');
            hf('.vivads_excluded', 'hide');
        } else {
            hf('.vivads_excluded', 'show');
            hf('.vivads_included', 'hide');
        }
    });
    
  });
  function hf(cc, a){
    if(a == 'show'){
       if($(cc).hasClass('hide-field')){$(cc).removeClass('hide-field');} 
    }else{
       if(!$(cc).hasClass('hide-field')){$(cc).addClass('hide-field');} 
    }
  }
})( jQuery );