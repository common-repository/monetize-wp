(function($) {
    
    var adfly_id = parseInt(adfly_settings.adflyID);
    var adfly_domain = 'adf.ly';
    var adfly_advert = adfly_settings.adflyTYPE
    if(adfly_settings.adflyPOP == 'true') {
        var popunder = true;
    }else{
        var popunder = false;
    }
    if(adfly_settings.adflyNOFOLLOW == 'true') {
        var adfly_nofollow = true;
    }else{
        var adfly_nofollow = false;
    }
    if(adfly_settings.adflyLOAD == 'true') {
        var adfly_protocol = 'https';
    }else{
        var adfly_protocol = 'http';
    }
    if(adfly_settings.adflyFULL === 'on'){
        if(adfly_settings.adflyDOMAINS === 'include'){
            if(adfly_settings.adflyINCLUDED != ''){
                var domains = adfly_settings.adflyINCLUDED.split("\n");
            }
        }else{
           if(adfly_settings.adflyIEXCLUDED != ''){
                var exclude_domains = adfly_settings.adflyIEXCLUDED.split("\n");
           } 
        }
    }
    console.log(adfly_id);
    console.log(adfly_advert);
    console.log(popunder);
    console.log(adfly_nofollow);
    console.log(adfly_domain);
    console.log(adfly_protocol);
    console.log(exclude_domains);
    console.log(domains);
    console.log(adfly_settings.adflyDOMAINS);
      
})();