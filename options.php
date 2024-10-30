<?php

function monetize_wordpress_init_plugin(){
    add_action('admin_menu', 'monetize_wordpress_create_menu');
}  
function monetize_wordpress_create_menu() {
	add_menu_page('Monetize WP', 'Monetize WP', 'manage_options', 'monetize_wordpress', 'monetize_wordpress_settings_page' , 'dashicons-money' );
	add_action( 'admin_init', 'register_monetize_wordpress_settings' ); 
}

function register_monetize_wordpress_settings() {
   
    $adfly_defaults = array(
      'adflyONOFF'                  => '',
      'adflyID'                     => '',
      'adflyTYPE'                   => 'int',
      'adflyPOP'                    => 'false',
      'adflyLOAD'                   => 'true',
      'adflyNOFOLLOW'               => 'true',
      'adflyFULL'                   => '',
      'adflyDOMAINS'                => 'include',
      'adflyINCLUDED'               => '',
      'adflyIEXCLUDED'              => '',
      'adflyENTRY'                  => '',
      'adflyFREQCAP'                => '5',
      'adflyFREQDELAY'              => '5',
      'adflyLOADDELAY'              => '3',
    );
    $solvemedia_defaults = array(
      'solvemediaONOFF'             => '',
      'solvemediaCKEY'              => '',
      'solvemediaVKEY'              => '',
      'solvemediaHKEY'              => '',
      'solvemediaHTTPS'             => 'false',
      'solvemediaLOGIN'             => '',
      'solvemediaREG'               => '',
      'solvemediaLOST'              => '',
      'solvemediaLOGINTHEME'        => 'white',
      'solvemediaLOGINLNG'          => 'en',
      'solvemediaREGTHEME'          => 'white',
      'solvemediaREGLNG'            => 'en',
      'solvemediaLOSTTHEME'         => 'white',
      'solvemediaLOSTLNG'           => 'en'
    );
    $coinmedia_defaults = array(
      'coinmediaONOFF'              => '',
      'solvemediaCKEY'              => ''
    );
    $vivads_defaults = array(
      'vivadsONOFF'                 => '',
      'vivadsKEY'                   => ''
    );
    $adfly_option = wp_parse_args(get_option('monetize_wordpress_adfly_details'), $adfly_defaults);
    $vivads_option = wp_parse_args(get_option('monetize_wordpress_vivads_details'), $vivads_defaults);
    $solve_option = wp_parse_args(get_option('monetize_wordpress_solvemedia_details'), $solvemedia_defaults);
    $coinmedia_option = wp_parse_args(get_option('monetize_wordpress_coinmedia_details'), $coinmedia_defaults);

    
    add_settings_section( 
        'monetize_wordpress_adfly',
        'Full Page Integration',
        'monetize_wordpress_adfly_callback',
        'monetize_wordpress_adfly'
    );
    if($adfly_option['adflyONOFF'] == ''){
        $adfly_option['adflyONOFF'] = '';
    }else if($adfly_option['adflyONOFF'] == 'on'){
        $adfly_option['adflyONOFF'] = 'checked';
    }
    
    add_settings_field(  
        'adflyONOFF',                      
        '',               
        'monetize_wordpress_switch_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyONOFF', 
            'ID'          => 'adflyONOFF', 
            'name'        => 'adflyONOFF',
            'value'       => $adfly_option['adflyONOFF'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => '',
            'hint'        => 'Turn AdFly On / Off Sitewide'
        )
    );
    add_settings_field(  
        'adflyID',                      
        'AdFly ID',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyID', 
            'ID'          => 'adflyID', 
            'name'        => 'adflyID',
            'value'       => $adfly_option['adflyID'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => '',
            'hint'        => '<a href="https://adf.ly/publisher/tools#tools-api" target="_blank"> Find your AdFly ID </a>'
        )
    );
    add_settings_field(  
        'adflyTYPE',                      
        'Advert Type',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyTYPE', 
            'ID'          => 'adflyTYPE', 
            'name'        => 'adflyTYPE',
            'value'       => $adfly_option['adflyTYPE'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'options'     => array('int' => 'Interstitial Advertisement ($$$$$)', 'banner' => 'Framed Banner ($$$)'),
            'class'       => ''
        )
    );
    add_settings_field(  
        'adflyPOP',                      
        'Popunder',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyPOP', 
            'ID'          => 'adflyPOP', 
            'name'        => 'adflyPOP',
            'value'       => $adfly_option['adflyPOP'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'options'     => array('true' => 'True', 'false' => 'False'),
            'class'       => ''
        )
    );
    add_settings_field(  
        'adflyLOAD',                      
        'Securely Load (https)',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyLOAD', 
            'ID'          => 'adflyLOAD', 
            'name'        => 'adflyLOAD',
            'value'       => $adfly_option['adflyLOAD'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'options'     => array('true' => 'True', 'false' => 'False'),
            'class'       => ''
        )
    );
    add_settings_field(  
        'adflyNOFOLLOW',                      
        'No-Follow',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyNOFOLLOW', 
            'ID'          => 'adflyNOFOLLOW', 
            'name'        => 'adflyNOFOLLOW',
            'value'       => $adfly_option['adflyNOFOLLOW'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'options'     => array('true' => 'True', 'false' => 'False'),
            'class'       => ''
        )
    );
    if($adfly_option['adflyFULL'] == ''){
        $in_class = '';
        $ex_class = 'hide-field';
    }else if($adfly_option['adflyFULL'] == 'on'){
        $adfly_option['adflyFULL'] = 'checked';
        $in_class = 'hide-field';
        $ex_class = '';
    }
    
    add_settings_field(  
        'adflyFULL',                      
        'Convert Links',               
        'monetize_wordpress_checkbox_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyFULL', 
            'ID'          => 'adflyFULL', 
            'name'        => 'adflyFULL',
            'value'       => $adfly_option['adflyFULL'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => '',
            'hint'        => 'Apply AdFly to all links'

        )
    );
    if($adfly_option['adflyDOMAINS'] == ''){
        $adfly_option['adflyDOMAINS'] = 'include';
        $in_class = '';
        $ex_class = 'hide-field';
    }else if($adfly_option['adflyDOMAINS'] == 'exclude'){
        $in_class = 'hide-field';
        $ex_class = '';
    }else if($adfly_option['adflyDOMAINS'] == 'include'){
        $in_class = '';
        $ex_class = 'hide-field';
    }
    add_settings_field(  
        'adflyDOMAINS',                      
        'Domain Type',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyDOMAINS', 
            'ID'          => 'adflyDOMAINS', 
            'name'        => 'adflyDOMAINS',
            'value'       => $adfly_option['adflyDOMAINS'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'options'     => array('include' => 'Include', 'exclude' => 'Exclude'),
            'class'       => 'adfly_domains adfly_domains_select'
        )
    );
    add_settings_field(  
        'adflyINCLUDED',                      
        'Included Domains',               
        'monetize_wordpress_textarea_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyINCLUDED', 
            'ID'          => 'adflyINCLUDED', 
            'name'        => 'adflyINCLUDED',
            'value'       => $adfly_option['adflyINCLUDED'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => 'adfly_domains adfly_included '.$in_class,
            'hint'        => '1 Domain Per Line without http:// or www eg. google.com (leave blank for all)'
        )
    );
    add_settings_field(  
        'adflyIEXCLUDED',                      
        'Excluded Domains',               
        'monetize_wordpress_textarea_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyIEXCLUDED', 
            'ID'          => 'adflyIEXCLUDED', 
            'name'        => 'adflyIEXCLUDED',
            'value'       => $adfly_option['adflyIEXCLUDED'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => 'adfly_domains adfly_excluded '.$ex_class,
            'hint'        => '1 Domain Per Line without http:// or www eg. google.com (leave blank for all)'
        )
    );
    if($adfly_option['adflyENTRY'] == ''){
        $adfly_option['adflyENTRY'] = '';
        $entry_class = 'hide-field';
    }else if($adfly_option['adflyENTRY'] == 'on'){
        $adfly_option['adflyENTRY'] = 'checked';
        $entry_class = '';
    }
    add_settings_field(  
        'adflyENTRY',                      
        'Display On Visit',               
        'monetize_wordpress_checkbox_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyENTRY', 
            'ID'          => 'adflyENTRY', 
            'name'        => 'adflyENTRY',
            'value'       => $adfly_option['adflyENTRY'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => '',
            'hint'        => 'Show Ads when someone visits your site.<br /> Note: If you advertise your website on a PTC site, this is NOT permitted'

        )
    );
    add_settings_field(  
        'adflyFREQCAP',                      
        'Frequency Cap',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyFREQCAP', 
            'ID'          => 'adflyFREQCAP', 
            'name'        => 'adflyFREQCAP',
            'value'       => $adfly_option['adflyFREQCAP'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => 'adfly_entry '.$entry_class,
            'hint'        => '24hr Ad Display Cap Per User'
        )
    );
    add_settings_field(  
        'adflyFREQDELAY',                
        'Ad Display Delay',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyFREQDELAY', 
            'ID'          => 'adflyFREQDELAY', 
            'name'        => 'adflyFREQDELAY',
            'value'       => $adfly_option['adflyFREQDELAY'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => 'adfly_entry '.$entry_class,
            'hint'        => 'Delay between Ads shown (in Minutes)'
        )
    );
    add_settings_field(  
        'adflyLOADDELAY',                      
        'Ad Load Delay',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_adfly',                     
        'monetize_wordpress_adfly',
        array (
            'label_for'   => 'adflyLOADDELAY', 
            'ID'          => 'adflyLOADDELAY', 
            'name'        => 'adflyLOADDELAY',
            'value'       => $adfly_option['adflyLOADDELAY'],
            'option_name' => 'monetize_wordpress_adfly_details',
            'class'       => 'adfly_entry '.$entry_class,
            'hint'        => 'Delay between website load and Ad shown (in seconds)'
        )
    );
    
    
    add_settings_section( 
        'monetize_wordpress_vivads',
        'Full Page Integration',
        'monetize_wordpress_vivads_callback',
        'monetize_wordpress_vivads'
    );
    if($vivads_option['vivadsONOFF'] == ''){
        $vivads_option['vivadsONOFF'] = '';
    }else if($vivads_option['vivadsONOFF'] == 'on'){
        $vivads_option['vivadsONOFF'] = 'checked';
    }
    
    add_settings_field(  
        'vivadsONOFF',                      
        '',               
        'monetize_wordpress_switch_callback',   
        'monetize_wordpress_vivads',                     
        'monetize_wordpress_vivads',
        array (
            'label_for'   => 'vivadsONOFF', 
            'ID'          => 'vivadsONOFF', 
            'name'        => 'vivadsONOFF',
            'value'       => $vivads_option['vivadsONOFF'],
            'option_name' => 'monetize_wordpress_vivads_details',
            'class'       => '',
            'hint'        => 'Turn Vivads On / Off Sitewide'
        )
    );
    add_settings_field(  
        'vivadsKEY',                      
        'API Token',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_vivads',                     
        'monetize_wordpress_vivads',
        array (
            'label_for'   => 'vivadsKEY', 
            'ID'          => 'vivadsKEY', 
            'name'        => 'vivadsKEY',
            'value'       => $vivads_option['vivadsKEY'],
            'option_name' => 'monetize_wordpress_vivads_details',
            'class'       => '',
            'hint'        => '<a href="http://vivads.net/member/tools/quick" target="_blank">Find your API Token</a>'
        )
    );
    if($vivads_option['vivadsDOMAINS'] == ''){
        $vivads_option['vivadsDOMAINS'] = 'include';
        $vivads_in_class = '';
        $vivads_ex_class = 'hide-field';
    }else if($vivads_option['vivadsDOMAINS'] == 'exclude'){
        $vivads_in_class = 'hide-field';
        $vivads_ex_class = '';
    }else if($vivads_option['vivadsDOMAINS'] == 'include'){
        $vivads_in_class = '';
        $vivads_ex_class = 'hide-field';
    }
    add_settings_field(  
        'vivadsDOMAINS',                      
        'Domain Type',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_vivads',                     
        'monetize_wordpress_vivads',
        array (
            'label_for'   => 'vivadsDOMAINS', 
            'ID'          => 'vivadsDOMAINS', 
            'name'        => 'vivadsDOMAINS',
            'value'       => $vivads_option['vivadsDOMAINS'],
            'option_name' => 'monetize_wordpress_vivads_details',
            'options'     => array('include' => 'Include', 'exclude' => 'Exclude'),
            'class'       => 'vivads_domains vivads_domains_select'
        )
    );
    add_settings_field(  
        'vivadsINCLUDED',                      
        'Included Domains',               
        'monetize_wordpress_textarea_callback',   
        'monetize_wordpress_vivads',                     
        'monetize_wordpress_vivads',
        array (
            'label_for'   => 'vivadsINCLUDED', 
            'ID'          => 'vivadsINCLUDED', 
            'name'        => 'vivadsINCLUDED',
            'value'       => $vivads_option['vivadsINCLUDED'],
            'option_name' => 'monetize_wordpress_vivads_details',
            'class'       => 'vivads_domains vivads_included '.$vivads_in_class,
            'hint'        => '1 Domain Per Line without http:// or www eg. google.com (leave blank for all)'
        )
    );
    add_settings_field(  
        'vivadsIEXCLUDED',                      
        'Excluded Domains',               
        'monetize_wordpress_textarea_callback',   
        'monetize_wordpress_vivads',                     
        'monetize_wordpress_vivads',
        array (
            'label_for'   => 'vivadsIEXCLUDED', 
            'ID'          => 'vivadsIEXCLUDED', 
            'name'        => 'vivadsIEXCLUDED',
            'value'       => $vivads_option['vivadsIEXCLUDED'],
            'option_name' => 'monetize_wordpress_vivads_details',
            'class'       => 'vivads_domains vivads_excluded '.$vivads_ex_class,
            'hint'        => '1 Domain Per Line without http:// or www eg. google.com (leave blank for all)'
        )
    );
    
    add_settings_section( 
        'monetize_wordpress_solvemedia',
        'Integrate Solve Media',
        'monetize_wordpress_solvemedia_callback',
        'monetize_wordpress_solvemedia'
    );
    if($solve_option['solvemediaONOFF'] == ''){
        $solve_option['solvemediaONOFF'] = '';
    }else if($solve_option['solvemediaONOFF'] == 'on'){
        $solve_option['solvemediaONOFF'] = 'checked';
    }
    add_settings_field(  
        'solvemediaONOFF',                      
        '',               
        'monetize_wordpress_switch_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaONOFF', 
            'ID'          => 'solvemediaONOFF', 
            'name'        => 'solvemediaONOFF',
            'value'       => $solve_option['solvemediaONOFF'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => 'Turn SolveMedia On / Off Sitewide'
        )
    );
    add_settings_field(  
        'solvemediaCKEY',                      
        'Challenge Key (C-key)',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaCKEY', 
            'ID'          => 'solvemediaCKEY', 
            'name'        => 'solvemediaCKEY',
            'value'       => $solve_option['solvemediaCKEY'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => '<a href="?page=monetize_wordpress&tab=details" target="_blank">Find your C-Key</a>'
        )
    );
    add_settings_field(  
        'solvemediaVKEY',                      
        'Verification Key (V-key)',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaVKEY', 
            'ID'          => 'solvemediaVKEY', 
            'name'        => 'solvemediaVKEY',
            'value'       => $solve_option['solvemediaVKEY'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => '<a href="?page=monetize_wordpress&tab=details" target="_blank">Find your V-Key</a>'
        )
    );
    add_settings_field(  
        'solvemediaHKEY',                      
        'Authentication Hash Key (H-key)',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaHKEY', 
            'ID'          => 'solvemediaHKEY', 
            'name'        => 'solvemediaHKEY',
            'value'       => $solve_option['solvemediaHKEY'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => '<a href="?page=monetize_wordpress&tab=details" target="_blank">Find your H-Key</a>'
        )
    );
    add_settings_field(  
        'solvemediaLKEY',                      
        'Content Locker Key',               
        'monetize_wordpress_textbox_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaLKEY', 
            'ID'          => 'solvemediaLKEY', 
            'name'        => 'solvemediaLKEY',
            'value'       => $solve_option['solvemediaLKEY'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => '<a href="?page=monetize_wordpress&tab=details" target="_blank">Find your Content Locker Key</a>'
        )
    );
    add_settings_field(  
        'solvemediaHTTPS',                      
        'Use HTTPS',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaHTTPS', 
            'ID'          => 'solvemediaHTTPS', 
            'name'        => 'solvemediaHTTPS',
            'value'       => $solve_option['solvemediaHTTPS'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'options'     => array('true' => 'True', 'false' => 'False'),
            'class'       => ''
        )
    );
    if($solve_option['solvemediaLOGIN'] == 'on'){
        $solve_option['solvemediaLOGIN'] = 'checked';
        $solve_login_class = '';
    }else{
        $solve_login_class = 'hide-field';
    }
    add_settings_field(  
        'solvemediaLOGIN',                      
        'Add To Login',               
        'monetize_wordpress_checkbox_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaLOGIN', 
            'ID'          => 'solvemediaLOGIN', 
            'name'        => 'solvemediaLOGIN',
            'value'       => $solve_option['solvemediaLOGIN'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => 'Apply SolveMedia Captcha To Login Page'

        )
    );
    add_settings_field(  
        'solvemediaLOGINTHEME',                      
        'Login Theme',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaLOGINTHEME', 
            'ID'          => 'solvemediaLOGINTHEME', 
            'name'        => 'solvemediaLOGINTHEME',
            'value'       => $solve_option['solvemediaLOGINTHEME'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'options'     => array('white' => 'White', 'black' => 'Black', 'purple' => 'Purple', 'red' => 'Red'),
            'class'       => 'sm_loptions '.$solve_login_class
        )
    );
    add_settings_field(  
        'solvemediaLOGINLNG',                      
        'Login Language',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaLOGINLNG', 
            'ID'          => 'solvemediaLOGINLNG', 
            'name'        => 'solvemediaLOGINLNG',
            'value'       => $solve_option['solvemediaLOGINLNG'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'options'     => array('en'=>'EN', 'de'=>'DE', 'fr'=>'FR', 'es'=>'ES', 'it'=>'IT', 'yi'=>'YI', 'ja'=>'JA', 'pl'=>'PL', 'hu'=>'HU', 'sv'=>'SV', 'no'=>'NO', 'pt'=>'PT', 'nl'=>'NL', 'tr'=>'TR'),
            'class'       => 'sm_loptions '.$solve_login_class
        )
    );
    if($solve_option['solvemediaREG'] == 'on'){
        $solve_option['solvemediaREG'] = 'checked';
        $solve_reg_class = '';
    }else{
        $solve_reg_class = 'hide-field';
    }
    add_settings_field(  
        'solvemediaREG',                      
        'Add To Registration',               
        'monetize_wordpress_checkbox_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaREG', 
            'ID'          => 'solvemediaREG', 
            'name'        => 'solvemediaREG',
            'value'       => $solve_option['solvemediaREG'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => 'Apply SolveMedia Captcha To Registration Page'

        )
    );
    add_settings_field(  
        'solvemediaREGTHEME',                      
        'Registration Theme',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaREGTHEME', 
            'ID'          => 'solvemediaREGTHEME', 
            'name'        => 'solvemediaREGTHEME',
            'value'       => $solve_option['solvemediaREGTHEME'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'options'     => array('white' => 'White', 'black' => 'Black', 'purple' => 'Purple', 'red' => 'Red'),
            'class'       => 'sm_roptions '.$solve_reg_class
        )
    );
    add_settings_field(  
        'solvemediaREGLNG',                      
        'Registration Language',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaREGLNG', 
            'ID'          => 'solvemediaREGLNG', 
            'name'        => 'solvemediaREGLNG',
            'value'       => $solve_option['solvemediaREGLNG'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'options'     => array('en'=>'EN', 'de'=>'DE', 'fr'=>'FR', 'es'=>'ES', 'it'=>'IT', 'yi'=>'YI', 'ja'=>'JA', 'pl'=>'PL', 'hu'=>'HU', 'sv'=>'SV', 'no'=>'NO', 'pt'=>'PT', 'nl'=>'NL', 'tr'=>'TR'),
            'class'       => 'sm_roptions '.$solve_reg_class
        )
    );
    if($solve_option['solvemediaLOST'] == 'on'){
        $solve_option['solvemediaLOST'] = 'checked';
        $solve_lost_class = '';
    }else{
        $solve_lost_class = 'hide-field';
    }
    add_settings_field(  
        'solvemediaLOST',                      
        'Add To Lost Password',               
        'monetize_wordpress_checkbox_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaLOST', 
            'ID'          => 'solvemediaLOST', 
            'name'        => 'solvemediaLOST',
            'value'       => $solve_option['solvemediaLOST'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'class'       => '',
            'hint'        => 'Apply SolveMedia Captcha To Lost Password Page'

        )
    );
    add_settings_field(  
        'solvemediaLOSTTHEME',                      
        'Lost Password Theme',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaLOSTTHEME', 
            'ID'          => 'solvemediaLOSTTHEME', 
            'name'        => 'solvemediaLOSTTHEME',
            'value'       => $solve_option['solvemediaLOSTTHEME'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'options'     => array('white' => 'White', 'black' => 'Black', 'purple' => 'Purple', 'red' => 'Red'),
            'class'       => 'sm_loptions '.$solve_lost_class
        )
    );
    add_settings_field(  
        'solvemediaLOSTLNG',                      
        'Lost Password Language',               
        'monetize_wordpress_select_callback',   
        'monetize_wordpress_solvemedia',                     
        'monetize_wordpress_solvemedia',
        array (
            'label_for'   => 'solvemediaLOSTLNG', 
            'ID'          => 'solvemediaLOSTLNG', 
            'name'        => 'solvemediaLOSTLNG',
            'value'       => $solve_option['solvemediaLOSTLNG'],
            'option_name' => 'monetize_wordpress_solvemedia_details',
            'options'     => array('en'=>'EN', 'de'=>'DE', 'fr'=>'FR', 'es'=>'ES', 'it'=>'IT', 'yi'=>'YI', 'ja'=>'JA', 'pl'=>'PL', 'hu'=>'HU', 'sv'=>'SV', 'no'=>'NO', 'pt'=>'PT', 'nl'=>'NL', 'tr'=>'TR'),
            'class'       => 'sm_loptions '.$solve_lost_class
        )
    );
    add_settings_section( 
        'monetize_wordpress_coinmedia',
        'Custom Ad Network Integration',
        'monetize_wordpress_coinmedia_callback',
        'monetize_wordpress_coinmedia'
    );
    if($coinmedia_option['coinmediaONOFF'] == ''){
        $coinmedia_option['coinmediaONOFF'] = '';
    }else if($coinmedia_option['coinmediaONOFF'] == 'on'){
        $coinmedia_option['coinmediaONOFF'] = 'checked';
    }
    
    add_settings_field(  
        'coinmediaONOFF',                      
        '',               
        'monetize_wordpress_switch_callback',   
        'monetize_wordpress_coinmedia',                     
        'monetize_wordpress_coinmedia',
        array (
            'label_for'   => 'coinmediaONOFF', 
            'ID'          => 'coinmediaONOFF', 
            'name'        => 'coinmediaONOFF',
            'value'       => $coinmedia_option['coinmediaONOFF'],
            'option_name' => 'monetize_wordpress_coinmedia_details',
            'class'       => '',
            'hint'        => 'Turn Custom Ads On / Off Sitewide'
        )
    );
    add_settings_field(  
        'ExamplesAdNetworks',                      
        '',               
        'monetize_wordpress_infobox_callback',   
        'monetize_wordpress_coinmedia',                     
        'monetize_wordpress_coinmedia',
        array ( 
            'ID'          => 'ExamplesAdNetworks',
            'title'       => 'Example Ad Networks',
            'class'       => '',
            'text'        => 'Below is a list of example Ad Networks you can use to help monetize your website.
            <ul>
                <li> CPA Lead - <a href="https://cpalead.com/get-started.php?ref=705893" target="_blank"> Register Account  </a></li>
                <li> CoinMedia - <a href="https://coinmedia.co?ref=7609" target="_blank"> Register Account  </a></li>
                <li> BidVertiser - <a href="http://www.bidvertiser.com/bdv/bidvertiser/bdv_ref_publisher.dbm?Ref_Option=pub&Ref_PID=830599" target="_blank"> Register Account  </a></li>
                <li> PropellerAds - <a href="https://publishers.propellerads.com/#/pub/auth/signUp?refId=TBiI" target="_blank"> Register Account  </a></li>
                <li> Chitika - <a href="//www.chitika.com/publishers/apply?refid=bitcoinfaucet" target="_blank"> Register Account  </a></li>
                <li> <a href="https://cpalead.com/get-started.php?ref=705893" target="_blank"><img src="https://storage.googleapis.com/appspot-bucket/banner-1.gif"></a></li>
                <li> <a href="https://coinmedia.co?ref=7609" title="coinmedia.co" target="_blank"><img src="https://coinmedia.co/img/Banner_468x60.gif" alt="coinmedia.co"></a></li>
                <li> <a href="https://publishers.propellerads.com/#/pub/auth/signUp?refId=TBiI" target="_blank"><img src="http://promo.propellerads.com/468x60-popads_1.gif" alt="PropellerAds"></a></li>
                <li> <script language="JavaScript">var bdv_ref_pid=830599;var bdv_ref_type=\'i\';var bdv_ref_option=\'p\';var bdv_ref_eb=\'0\';var bdv_ref_gif_id=\'ref_468x60_black_pbl\';var bdv_ref_width=468;var bdv_ref_height=60;</script><script language="JavaScript" src="//cdn.hyperpromote.com/bidvertiser/tags/active/referral_button.html?pid=830599"></script><noscript><a href="http://www.bidvertiser.com/bdv/BidVertiser/bdv_advertiser.dbm" target="_blank">internet marketing</a></noscript></li>
                <li> <a href="//www.chitika.com/publishers/apply?refid=bitcoinfaucet" target="_blank"><img src="//images.chitika.net/ref_banners/728x90_hidden_ad.png" /></a> </li>
            </ul>'
        )
    );
    
    
    
    add_settings_section( 
        'monetize_wordpress_details',
        'Monetize WP Details',
        'monetize_wordpress_details_callback',
        'monetize_wordpress_details'
    );
    add_settings_field(  
        'mwAdFlyDETAILS',                      
        '',               
        'monetize_wordpress_infobox_callback',   
        'monetize_wordpress_details',                     
        'monetize_wordpress_details',
        array ( 
            'ID'          => 'mwAdFlyDETAILS',
            'title'       => 'AdFly',
            'class'       => '',
            'text'        => 'AdFly allows you to show their ads on your website either through top banner or fullpage with time limits by shortening specified links.'
        )
    );
    add_settings_field(  
        'mwVivAdsDETAILS',                      
        '',               
        'monetize_wordpress_infobox_callback',   
        'monetize_wordpress_details',                     
        'monetize_wordpress_details',
        array ( 
            'ID'          => 'mwVivAdsDETAILS',
            'title'       => 'VivAds',
            'class'       => '',
            'text'        => 'VivAds allows you to show their ads on your website through fullpage redirecting, shortens specified links.'
        )
    );
    add_settings_field(  
        'mwSolveMediaDETAILS',                      
        '',               
        'monetize_wordpress_infobox_callback',   
        'monetize_wordpress_details',                     
        'monetize_wordpress_details',
        array ( 
            'ID'          => 'mwSolveMediaDETAILS',
            'title'       => 'SolveMedia',
            'class'       => '',
            'text'        => 'SolveMedia allows you to generate revenue by placing captcha images on important parts of your website, login, registration, etc. You can also lock content through the full page content lockers or locking custom HTML.
            <br /> To Get your Challenge Key (C-key), Verification Key (V-key) and Authentication Hash Key (H-key) you need to set up a New Site. After you login to the SolveMedia Portal, in the menu click Configure->Sites and the click "New Site". Make sure your Preference is set to "Prefer Revenue". Once added your site will show up in the list with a Keys button that hold all 3 keys.
            <br/> <br /> To Get your Content Locker Key you will need to repeat the process by adding a New Site but this time set your preference to "Content Unlock". You need to update the following options (keep the rest either blank or default. 
            <br /> Max Tries: 999
            <br /> Timeout: 999
            <br /> Freq Cap Count: 999
            <br /> Restrict Premium Content: Checked
            <br /> When you have added your site and it has been added to the list, click Keys, your Content Locker Key will be the data-key value. Make sure you don\'t included the double quotes.'
        )
    );
    add_settings_field(  
        'mwCoinMediaDETAILS',                      
        '',               
        'monetize_wordpress_infobox_callback',   
        'monetize_wordpress_details',                     
        'monetize_wordpress_details',
        array ( 
            'ID'          => 'mwCoinMediaDETAILS',
            'title'       => 'Custom Ads',
            'class'       => '',
            'text'        => 'Add Custom HTML / Javascript from your Favourite Ad Network, from Display Ads to Offer Walls, Content Lockers + More'
        )
    );
    add_settings_field(  
        'mwErrorsDETAILS',                      
        '',               
        'monetize_wordpress_infobox_callback',   
        'monetize_wordpress_details',                     
        'monetize_wordpress_details',
        array ( 
            'ID'          => 'mwErrorsDETAILS',
            'title'       => 'Known Conflicts',
            'class'       => '',
            'text'        => 'You cannot integrate both full site link converters for AdFly and VivAds. If you want to use both to maximise revenue, uncheck \'Convert Links\' and make sure \'Display On Visit\' is checked on AdFly. You can then turn on VivAds and convert the links with VivAds'
        )
    );
    
    register_setting('monetize_wordpress_adfly', 'monetize_wordpress_adfly_details', array('sanitize_callback' => 'monetize_wordpress_adfly_sanitize'));
    register_setting('monetize_wordpress_vivads', 'monetize_wordpress_vivads_details', array('sanitize_callback' => 'monetize_wordpress_vivads_sanitize'));
    register_setting('monetize_wordpress_solvemedia', 'monetize_wordpress_solvemedia_details', array('sanitize_callback' => 'monetize_wordpress_solvemedia_sanitize'));
    register_setting('monetize_wordpress_coinmedia', 'monetize_wordpress_coinmedia_details', array('sanitize_callback' => 'monetize_wordpress_coinmedia_sanitize'));
    register_setting('monetize_wordpress_details_option', 'monetize_wordpress_details_option');

}
function monetize_wordpress_coinmedia_sanitize($input){
    //coinmediaONOFF
    if(isset($input['coinmediaONOFF'])){
        if($input['coinmediaONOFF'] != 'on'){
          add_settings_error('Invalid-coinmediaONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');  
          $input['coinmediaONOFF'] = 'off';
        }
    }else{$input['coinmediaONOFF'] = 'off';}
    return $input;
}
function monetize_wordpress_solvemedia_sanitize($input){
    $default_boolean_types = array('true', 'false');
    $default_languages = array('en', 'de', 'fr', 'es', 'it', 'yi', 'ja', 'pl', 'hu', 'sv', 'no', 'pt', 'nl', 'tr');
    $default_themes = array('white', 'black', 'purple', 'red');
    //solvemediaONOFF
    if(isset($input['solvemediaONOFF'])){
        if($input['solvemediaONOFF'] != 'on'){
          add_settings_error('Invalid-solvemediaONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');  
          $input['solvemediaONOFF'] = 'off';
        }
    }else{$input['solvemediaONOFF'] = 'off';}
    //solvemediaCKEY
    if(isset($input['solvemediaCKEY'])){
        $input['solvemediaCKEY'] = sanitize_text_field($input['solvemediaCKEY']);
    }else{add_settings_error('Not-Found-solvemediaCKEY','empty', 'Challenge Key not found, please resubmit form','error');}
    //solvemediaVKEY
    if(isset($input['solvemediaVKEY'])){
        $input['solvemediaVKEY'] = sanitize_text_field($input['solvemediaVKEY']);
    }else{add_settings_error('Not-Found-solvemediaVKEY','empty', 'Verification Key not found, please resubmit form','error');}
    //solvemediaHKEY
    if(isset($input['solvemediaHKEY'])){
        $input['solvemediaHKEY'] = sanitize_text_field($input['solvemediaHKEY']);
    }else{add_settings_error('Not-Found-solvemediaHKEY','empty', 'Authentication Hash not found, please resubmit form','error');}
    //solvemediaLKEY
    if(isset($input['solvemediaLKEY'])){
        $input['solvemediaLKEY'] = sanitize_text_field($input['solvemediaLKEY']);
    }else{add_settings_error('Not-Found-solvemediaLKEY','empty', 'Content Locker not found, please resubmit form','error');}
    //solvemediaHTTPS
    if(isset($input['solvemediaHTTPS'])){
        if(!in_array($input['solvemediaHTTPS'], $default_boolean_types)){
            add_settings_error('Invalid-solvemediaHTTPS','empty','Inncorrect Protocol Selected - Please Choose From Selected Values','updated');
            $input['solvemediaHTTPS'] = 'false';
        }
    }else{add_settings_error('Not-Found-solvemediaHTTPS','empty', 'Protocol Type not found, please resubmit form','error');}
    //solvemediaLOGIN
    if(isset($input['solvemediaLOGIN'])){
        if($input['solvemediaLOGIN'] != 'on'){
          add_settings_error('Invalid-solvemediaLOGIN','empty','Inncorrect Add To Login Value - This has been Switched off','updated');  
          $input['solvemediaLOGIN'] = 'off';
        }
    }else{$input['solvemediaLOGIN'] = 'off';}
    //solvemediaREG
    if(isset($input['solvemediaREG'])){
        if($input['solvemediaREG'] != 'on'){
          add_settings_error('Invalid-solvemediaREG','empty','Inncorrect Add To Registration Value - This has been Switched off','updated');  
          $input['solvemediaREG'] = 'off';
        }
    }else{$input['solvemediaREG'] = 'off';}
    //solvemediaLOST
    if(isset($input['solvemediaLOST'])){
        if($input['solvemediaLOST'] != 'on'){
          add_settings_error('Invalid-solvemediaLOST','empty','Inncorrect Add To Lost Password Value - This has been Switched off','updated');  
          $input['solvemediaLOST'] = 'off';
        }
    }else{$input['solvemediaLOST'] = 'off';}
    //solvemediaLOGINTHEME
    if(isset($input['solvemediaLOGINTHEME'])){
        if(!in_array($input['solvemediaLOGINTHEME'], $default_themes)){
            add_settings_error('Invalid-solvemediaLOGINTHEME','empty','Inncorrect Login Theme Selected - Please Choose From Selected Values','updated');
            $input['solvemediaLOGINTHEME'] = 'white';
        }
    }else{add_settings_error('Not-Found-solvemediaLOGINTHEME','empty', 'Login Theme not found, please resubmit form','error');}
    //solvemediaREGTHEME
    if(isset($input['solvemediaREGTHEME'])){
        if(!in_array($input['solvemediaREGTHEME'], $default_themes)){
            add_settings_error('Invalid-solvemediaREGTHEME','empty','Inncorrect Registration Theme Selected - Please Choose From Selected Values','updated');
            $input['solvemediaREGTHEME'] = 'white';
        }
    }else{add_settings_error('Not-Found-solvemediaREGTHEME','empty', 'Registration Theme not found, please resubmit form','error');}
    //solvemediaLOSTTHEME
    if(isset($input['solvemediaLOSTTHEME'])){
        if(!in_array($input['solvemediaLOSTTHEME'], $default_themes)){
            add_settings_error('Invalid-solvemediaLOSTTHEME','empty','Inncorrect Lost Password Theme Selected - Please Choose From Selected Values','updated');
            $input['solvemediaLOSTTHEME'] = 'white';
        }
    }else{add_settings_error('Not-Found-solvemediaLOSTTHEME','empty', 'Lost Password Theme not found, please resubmit form','error');}
    //solvemediaLOGINLNG
    if(isset($input['solvemediaLOGINLNG'])){
        if(!in_array($input['solvemediaLOGINLNG'], $default_languages)){
            add_settings_error('Invalid-solvemediaLOGINLNG','empty','Inncorrect Login Language Selected - Please Choose From Selected Values','updated');
            $input['solvemediaLOGINLNG'] = 'en';
        }
    }else{add_settings_error('Not-Found-solvemediaLOGINLNG','empty', 'Login Language not found, please resubmit form','error');}
    //solvemediaREGLNG
    if(isset($input['solvemediaREGLNG'])){
        if(!in_array($input['solvemediaREGLNG'], $default_languages)){
            add_settings_error('Invalid-solvemediaREGLNG','empty','Inncorrect Registration Language Selected - Please Choose From Selected Values','updated');
            $input['solvemediaREGLNG'] = 'en';
        }
    }else{add_settings_error('Not-Found-solvemediaREGLNG','empty', 'Registration Language not found, please resubmit form','error');}
    //solvemediaLOSTLNG
    if(isset($input['solvemediaLOSTLNG'])){
        if(!in_array($input['solvemediaLOSTLNG'], $default_languages)){
            add_settings_error('Invalid-solvemediaLOSTLNG','empty','Inncorrect Lost Password Language Selected - Please Choose From Selected Values','updated');
            $input['solvemediaLOSTLNG'] = 'en';
        }
    }else{add_settings_error('Not-Found-solvemediaLOSTLNG','empty', 'Lost Password Language not found, please resubmit form','error');}
    return $input;
}
function monetize_wordpress_vivads_sanitize($input){
    $default_domain_types = array('include', 'exclude');
    //vivadsONOFF
    if(isset($input['vivadsONOFF'])){
        if($input['vivadsONOFF'] != 'on'){
          add_settings_error('Invalid-vivadsONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');  
          $input['vivadsONOFF'] = 'off';
        }
    }else{$input['vivadsONOFF'] = 'off';}
    //vivadsKEY
    if(isset($input['vivadsKEY'])){
        if(!ctype_alnum($input['vivadsKEY'])){
            add_settings_error('Invalid-vivadsKEY','empty','API Token must contains alphanumeric characters only - other characters have been removed','updated');
            $input['vivadsKEY'] = preg_replace("/[^a-zA-Z0-9]/", "", $input['vivadsKEY']);
        }
    }else{add_settings_error('Not-Found-vivadsKEY','empty', 'API Token not found, please resubmit form','error');}
    //vivadsDOMAINS
    if(isset($input['vivadsDOMAINS'])){
        if(!in_array($input['vivadsDOMAINS'], $default_domain_types)){
            add_settings_error('Invalid-vivadsDOMAINS','empty','Inncorrect Domain Type Selected - Please Choose From Selected Values','updated');
            $input['vivadsDOMAINS'] = 'int';
        }
    }else{add_settings_error('Not-Found-vivadsDOMAINS','empty', 'Domain Type not found, please resubmit form','error');}
    return $input;
}
function monetize_wordpress_adfly_sanitize($input){
    $default_advert_types = array('int', 'banner');
    $default_domain_types = array('include', 'exclude');
    $default_boolean_types = array('true', 'false');
    //adflyONOFF
    if(isset($input['adflyONOFF'])){
        if($input['adflyONOFF'] != 'on'){
          add_settings_error('Invalid-adflyONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');  
          $input['adflyONOFF'] = 'off';
        }
    }else{$input['adflyONOFF'] = 'off';}
    //adflyID
    if(isset($input['adflyID'])){
        if(!is_numeric($input['adflyID'])){
            add_settings_error('Invalid-adflyID','empty','AdFly ID must contains numbers only - other characters have been removed','updated');
            $input['adflyID'] = absint($input['adflyID']);
        }
    }else{add_settings_error('Not-Found-adflyID','empty', 'AdFly ID not found, please resubmit form','error');}
    //adflyTYPE
    if(isset($input['adflyTYPE'])){
        if(!in_array($input['adflyTYPE'], $default_advert_types)){
            add_settings_error('Invalid-adflyTYPE','empty','Inncorrect Advert Type Selected - Please Choose From Selected Values','updated');
            $input['adflyTYPE'] = 'int';
        }
    }else{add_settings_error('Not-Found-adflyTYPE','empty', 'Advert Type not found, please resubmit form','error');}
    //adflyPOP
    if(isset($input['adflyPOP'])){
        if(!in_array($input['adflyPOP'], $default_boolean_types)){
            add_settings_error('Invalid-adflyPOP','empty','Inncorrect PopUp Selected - Please Choose From Selected Values','updated');
            $input['adflyPOP'] = 'false';
        }
    }else{add_settings_error('Not-Found-adflyPOP','empty', 'PopUp Type not found, please resubmit form','error');}
    //adflyLOAD
    if(isset($input['adflyLOAD'])){
        if(!in_array($input['adflyLOAD'], $default_boolean_types)){
            add_settings_error('Invalid-adflyLOAD','empty','Inncorrect Protocol Selected - Please Choose From Selected Values','updated');
            $input['adflyLOAD'] = 'true';
        }
    }else{add_settings_error('Not-Found-adflyLOAD','empty', 'Protocol Type not found, please resubmit form','error');}
    //adflyNOFOLLOW
    if(isset($input['adflyNOFOLLOW'])){
        if(!in_array($input['adflyNOFOLLOW'], $default_boolean_types)){
            add_settings_error('Invalid-adflyNOFOLLOW','empty','Inncorrect NoFollow Selected - Please Choose From Selected Values','updated');
            $input['adflyNOFOLLOW'] = 'true';
        }
    }else{add_settings_error('Not-Found-adflyNOFOLLOW','empty', 'NoFollow Type not found, please resubmit form','error');}
    //adflyFULL
    if(isset($input['adflyFULL'])){
        if($input['adflyFULL'] != 'on'){
          add_settings_error('Invalid-adflyFULL','empty','Inncorrect Convert Links Value - This has been Switched off','updated');  
          $input['adflyFULL'] = 'off';
        }
    }else{$input['adflyFULL'] = 'off';}
    //adflyDOMAINS
    if(isset($input['adflyDOMAINS'])){
        if(!in_array($input['adflyDOMAINS'], $default_domain_types)){
            add_settings_error('Invalid-adflyDOMAINS','empty','Inncorrect Domain Type Selected - Please Choose From Selected Values','updated');
            $input['adflyDOMAINS'] = 'include';
        }
    }else{add_settings_error('Not-Found-adflyDOMAINS','empty', 'Domain Type Type not found, please resubmit form','error');}  
    //adflyENTRY
    if(isset($input['adflyENTRY'])){
        if($input['adflyENTRY'] != 'on'){
          add_settings_error('Invalid-adflyENTRY','empty','Inncorrect Display On Visit Value - This has been Switched off','updated');  
          $input['adflyENTRY'] = 'off';
        }
    }else{$input['adflyENTRY'] = 'off';}
    //adflyFREQCAP
    if(isset($input['adflyFREQCAP'])){
        if(!is_numeric($input['adflyFREQCAP'])){
            add_settings_error('Invalid-adflyFREQCAP','empty','Frequency Cap must contains numbers only - other characters have been removed','updated');
            $input['adflyFREQCAP'] = absint($input['adflyFREQCAP']);
        }
    }else{add_settings_error('Not-Found-adflyFREQCAP','empty', 'Frequency Cap not found, please resubmit form','error');}
    //adflyFREQDELAY
    if(isset($input['adflyFREQDELAY'])){
        if(!is_numeric($input['adflyFREQDELAY'])){
            add_settings_error('Invalid-adflyFREQDELAY','empty','Ad Display Delay must contains numbers only - other characters have been removed','updated');
            $input['adflyFREQDELAY'] = absint($input['adflyFREQDELAY']);
        }
    }else{add_settings_error('Not-Found-adflyFREQDELAY','empty', 'Ad Display Delay not found, please resubmit form','error');}
    //adflyLOADDELAY
    if(isset($input['adflyLOADDELAY'])){
        if(!is_numeric($input['adflyLOADDELAY'])){
            add_settings_error('Invalid-adflyLOADDELAY','empty','Ad Load Delay must contains numbers only - other characters have been removed','updated');
            $input['adflyLOADDELAY'] = absint($input['adflyLOADDELAY']);
        }
    }else{add_settings_error('Not-Found-adflyLOADDELAY','empty', 'Ad Load Delay not found, please resubmit form','error');}
    return $input;
}
function monetize_wordpress_adfly_callback($args) { 
    echo '<p>Apply AdFly to all links, need an AdFly Account? <a href="https://join-adf.ly/20784483"  target="_blank"> Register Account (referral link) </a></p>';
    echo '<p>Please Note: You can only run either Ad.Fly or Vivads, not both</p>';
}
function monetize_wordpress_vivads_callback($args) { 
    echo '<p>Apply Vivads to all links, need an Vivads Account? <a href="http://vivads.net/ref/second2none"  target="_blank"> Register Account (referral link) </a></p>';
    echo '<p>Please Note: You can only run either Ad.Fly or Vivads, not both</p>';
}
function monetize_wordpress_solvemedia_callback($args) { 
    echo '<p>Integrate SolveMedia, need SolveMedia Account? <a href="https://portal.solvemedia.com/portal/public/signup"  target="_blank"> Register Account </a></p>';
}
function monetize_wordpress_coinmedia_callback($args) { 
    echo '';
}
function monetize_wordpress_details_callback() { 
    echo '<p>Easily monetize your Wordpress website with Monetize WP. Below you will find some brief descriptions about what\'s included in Monetize WP</p>'; 
}
function monetize_wordpress_switch_callback($args){
    echo '<div class="onoffswitch">
                <input type="checkbox" name="' . $args["option_name"] . '[' . $args["ID"] . ']" class="onoffswitch-checkbox" id="' . $args["ID"] . '" ' . $args["value"] . '>
                <label class="onoffswitch-label" for="' . $args["ID"] . '"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label>
          </div>';         
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p>'.$args["hint"].'</p>';
    }
}
function monetize_wordpress_textbox_callback( $args ) { 
    echo '<input type="text" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" value="' . $args["value"] . '" class="field-40"></input>';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p>'.$args["hint"].'</p>';
    }
}
function monetize_wordpress_textarea_callback( $args ) { 
    echo '<textarea id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" rows="5" class="field-40">' . $args["value"] . '</textarea> ';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p>'.$args["hint"].'</p>';
    }
}
function monetize_wordpress_checkbox_callback( $args ) { 
    echo '<input type="checkbox" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" ' . $args["value"] . ' ></input>';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p>'.$args["hint"].'</p>';
    }
}
function monetize_wordpress_infobox_callback( $args ) { 
    echo '<tr id="' . $args["ID"] . ' class="'.$args["class"].'>';
    echo '<td class="mw_d_title">'.$args["title"].'</td><td>'.$args["text"].'</td>';
    echo '</tr>';
}
function monetize_wordpress_select_callback( $args ) { 
    echo '<select id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" class="field-40">';
    foreach($args['options'] as $type => $label){
        if($args["value"] === $type){
            echo '<option value="'.$type.'" selected>'.$label.'</option>';
        }else{
            echo '<option value="'.$type.'">'.$label.'</option>';
        }
        
    }
    echo '</select>';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p>'.$args["hint"].'</p>';
    }
}
function monetize_wordpress_settings_page() {
?>
<div class="wrap">  
        <div id="icon-themes" class="icon32"></div>  
        <h2>Monetize WP</h2>  
        <div class="description">Making monetization easy for wordpress</div>
        <?php settings_errors(); ?>  

        <?php  
                $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'adfly';  
        ?>  

        <h2 class="nav-tab-wrapper">  
            <a href="?page=monetize_wordpress&tab=adfly" class="nav-tab <?php echo $active_tab == 'adfly' ? 'nav-tab-active' : ''; ?>">AdFly Integration</a>  
            <a href="?page=monetize_wordpress&tab=vivads" class="nav-tab <?php echo $active_tab == 'vivads' ? 'nav-tab-active' : ''; ?>">Vivads Integration</a>  
            <a href="?page=monetize_wordpress&tab=solvemedia" class="nav-tab <?php echo $active_tab == 'solvemedia' ? 'nav-tab-active' : ''; ?>">SolveMedia Integration</a>  
            <a href="?page=monetize_wordpress&tab=coinmedia" class="nav-tab <?php echo $active_tab == 'coinmedia' ? 'nav-tab-active' : ''; ?>">Custom Ad Integration</a>  
            <a href="?page=monetize_wordpress&tab=details" class="nav-tab <?php echo $active_tab == 'details' ? 'nav-tab-active' : ''; ?>">Monetize WP Details</a>  
        </h2>  

        <form method="post" action="options.php">  
            <?php 
            
            if( $active_tab == 'adfly' ) {  
                settings_fields( 'monetize_wordpress_adfly' );
                do_settings_sections( 'monetize_wordpress_adfly' );
                submit_button();
            } else if( $active_tab == 'vivads' ) {
                settings_fields( 'monetize_wordpress_vivads' );
                do_settings_sections( 'monetize_wordpress_vivads' );
                submit_button();
            } else if( $active_tab == 'solvemedia' ) {
                settings_fields( 'monetize_wordpress_solvemedia' );
                do_settings_sections( 'monetize_wordpress_solvemedia' );
                submit_button();
            } else if( $active_tab == 'coinmedia' ) {
                settings_fields( 'monetize_wordpress_coinmedia' );
                do_settings_sections( 'monetize_wordpress_coinmedia' );
                submit_button();
            } else if( $active_tab == 'details' ) {
            ?>
            <table id="monetize_wordpress_details" class="monetize_wordpress_details">
            <?php
                settings_fields( 'monetize_wordpress_details' );
                do_settings_sections( 'monetize_wordpress_details' ); 
            ?>
            </table>
            <?php
            }
            ?>             
        </form> 
    </div> 

<?php 
} 
add_action('admin_enqueue_scripts', 'monetize_wordpress_admin_scripts');
function monetize_wordpress_admin_scripts($args){
    $current_screen = get_current_screen();
    if( strpos($current_screen->base, 'monetize_wordpress') === false) {
        return;
    }else{
        wp_enqueue_style('monetize_wordpress_admin_css', plugins_url('css/admin_page_css.css',__FILE__ ));
        wp_enqueue_script('monetize_wordpress_admin_js', plugins_url('js/monetize_wordpress_admin_js.js',__FILE__ ), ['jquery'], '1.0', true);
    }
}
function monetize_wordpress_with_jquery(){
    $solvemedia_option = get_option('monetize_wordpress_solvemedia_details');
    if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
        wp_enqueue_script( 'monetize_wordpress_solvemedia', plugins_url( '/js/mw_solvemedia.js', __FILE__ ), array( 'jquery' ), '1.0', true);
        wp_localize_script( 'monetize_wordpress_solvemedia', 'mw_sm', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
    }
    
}
add_action( 'wp_enqueue_scripts', 'monetize_wordpress_with_jquery' );
function solvemedia_coinmedia_codemirror_fix($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }
    wp_enqueue_script( 'solvemedia_coinmedia_codemirror_fix', plugins_url('js/codemirror-fix.js',__FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'solvemedia_coinmedia_codemirror_fix' );
function mw_defer_solvemedia_on_adfly( $tag, $handle ){
    $adfly_option = get_option('monetize_wordpress_adfly_details');
    if(isset($adfly_option['adflyONOFF']) && $adfly_option['adflyONOFF'] != ''){
        if ( 'monetize_wordpress_solvemedia' !== $handle ){
            return $tag;
        }else{
            return str_replace( ' src', ' defer="defer" src', $tag );
        }
    }else{
        return $tag;
    }  
}
add_filter( 'script_loader_tag', 'mw_defer_solvemedia_on_adfly', 10, 2 );
function monetize_wordpress_client_styles($args){
    wp_enqueue_style('monetize_wordpress_css', plugins_url('css/monetize_wordpress.css',__FILE__ ), '', '1.0');
}
add_action( 'wp_enqueue_scripts', 'monetize_wordpress_client_styles' );
function monetize_wordpress_adfly_converter(){
    $option = get_option( 'monetize_wordpress_adfly_details' );
    if(isset($option['adflyONOFF']) && $option['adflyONOFF'] != ''){
        echo '<script type=\'text/javascript\'>';
        echo 'var adfly_id = '.$option['adflyID'].';';
        echo 'var adfly_advert = \''.$option['adflyTYPE'].'\';';
        echo 'var adfly_domain = \'adf.ly\';';
        
        if($option['adflyPOP'] == 'true') {
            echo 'var popunder = true;';
        }else{
            echo 'var popunder = false;';
        }
        if($option['adflyNOFOLLOW'] == 'true') {
            echo 'var adfly_nofollow = true;';
        }else{
            echo 'var adfly_nofollow = false;';
        }
        if($option['adflyLOAD'] == 'true') {
            echo 'var adfly_protocol = \'https\';';
        }else{
            echo 'var adfly_protocol = \'http\';';
        }
        if($option['adflyFULL'] === 'on'){
            if($option['adflyDOMAINS'] === 'include'){
                if($option['adflyINCLUDED'] != ''){
                    $inc = preg_split('/\r\n|[\r\n]/', $option['adflyINCLUDED']);
                    echo 'var domains = '.json_encode($inc).';';
                }
            }else{
               if($option['adflyIEXCLUDED'] != ''){
                    $exc = preg_split('/\r\n|[\r\n]/', $option['adflyIEXCLUDED']);
                    echo 'var exclude_domains = '.json_encode($exc).';';
               } 
            }
        }
        if($option['adflyENTRY'] == 'on'){
            echo 'var frequency_cap = '.$option['adflyFREQCAP'].';';
            echo 'var frequency_delay = '.$option['adflyFREQDELAY'].';';
            echo 'var init_delay = '.$option['adflyLOADDELAY'].';';
        }
        echo '</script>';
        
        
        if($option['adflyFULL'] == 'on'){        
            echo '<script src="https://cdn.adf.ly/js/link-converter.js"></script>';
        }
        if($option['adflyENTRY'] == 'on'){
            echo '<script src="https://cdn.adf.ly/js/entry.js"></script>';
        } 
    }
}
add_action('wp_head', 'monetize_wordpress_adfly_converter', 2);
function monetize_wordpress_vivads_converter(){
    $option = get_option( 'monetize_wordpress_vivads_details' );
    if(isset($option['vivadsONOFF']) && $option['vivadsONOFF'] != ''){
        $mwp_script = '<script type=\'text/javascript\'>
        var vivads_api_token = \''.$option['vivadsKEY'].'\';
        var vivads_advert = 2;
        var vivads_url = \'http://vivads.net/\';';
        if($option['vivadsDOMAINS'] === 'include'){
            if($option['vivadsINCLUDED'] != ''){
                $inc = preg_split('/\r\n|[\r\n]/', $option['vivadsINCLUDED']);
                $mwp_script .= 'var vivads_domains = '.json_encode($inc).';';
            }
        }else{
           if($option['vivadsIEXCLUDED'] != ''){
                $exc = preg_split('/\r\n|[\r\n]/', $option['vivadsIEXCLUDED']);
                $mwp_script .= 'var vivads_exclude_domains  = '.json_encode($exc).';';
           }else{
                $mwp_script.= 'var vivads_exclude_domains  = \'\';';
           }
        }
        $mwp_script .= '</script>
                        <script src="//vivads.net/js/full-page-script.js"></script>';
        echo $mwp_script;      
    }
}
add_action('wp_head', 'monetize_wordpress_vivads_converter', 2);
function monetize_wordpress_vivads_adfly_conflict() {
    $adfly_option = get_option( 'monetize_wordpress_adfly_details' );
    $vivads_option = get_option( 'monetize_wordpress_vivads_details' );
    if(isset($vivads_option['vivadsONOFF']) && $vivads_option['vivadsONOFF'] != '' && isset($adfly_option['adflyONOFF']) && $adfly_option['adflyONOFF'] != ''){
        if($adfly_option['adflyFULL'] == 'on'){        
            $class = 'notice notice-error';
        	$message = __( '<strong>CONFLICT</strong>: You currently have AdFly and VivAds shortening your links on full site', 'monetize_wordpress' );
        	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
        }
    }
	 
}
add_action( 'admin_notices', 'monetize_wordpress_vivads_adfly_conflict' );
function monetize_wordpress_dropdown_pages_multiple($output) {
    if (strpos($output, 'monetize_wordpress_solvemedia_unlock') !== false) {
        $output = str_replace( '<select name=\'widget-monetize_wordpress_solvemedia_unlock', '<select multiple=\'multiple\' name=\'widget-monetize_wordpress_solvemedia_unlock', $output);
    }elseif (strpos($output, 'monetize_wordpress_custom_ads') !== false) {
        $output = str_replace( '<select name=\'widget-monetize_wordpress_custom_ads_widget', '<select multiple=\'multiple\' name=\'widget-monetize_wordpress_custom_ads_widget', $output);
    }    
    return $output;	 
}
add_action( 'wp_dropdown_pages', 'monetize_wordpress_dropdown_pages_multiple', 10, 1 );
function monetize_wordpress_ajax_solvemedia_check() {
	$found = 0; $msg = '';
    if ( !empty( $_POST ) ) {
        if(isset($_POST['action']) && strcmp($_POST['action'], 'monetize_wordpress_ajax_solvemedia_check') === 0){
            if(isset($_POST['adcopy_challenge'])){
                if(isset($_POST['adcopy_response'])){
                    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }
                    $solvemedia_option = get_option('monetize_wordpress_solvemedia_details');
                    
                    $solvemedia_response = solvemedia_check_answer($solvemedia_option['solvemediaVKEY'], $_SERVER["REMOTE_ADDR"], sanitize_text_field($_POST["adcopy_challenge"]), sanitize_text_field($_POST["adcopy_response"]), $solvemedia_option['solvemediaHKEY']);
                    if (!$solvemedia_response->is_valid) {
                        $msg = $solvemedia_response->error;
                    }else {
                        $found = 1;
                        $msg = 'Success';
                    }								
                }else{$msg .= 'Please complete the captcha';}
            }else{$msg .= 'Data Error - adcopy_challenge';}
        }else{$msg .= 'Data Error - No action';}
    }else{$msg .= 'No Data Supplied';}
    if($found == 0){
        echo json_encode(array('Error', $msg), JSON_FORCE_OBJECT);
    }else{
       echo json_encode(array('Success', $msg), JSON_FORCE_OBJECT); 
    }
    die();
}
add_action('wp_ajax_monetize_wordpress_ajax_solvemedia_check', 'monetize_wordpress_ajax_solvemedia_check' ); 
add_action('wp_ajax_nopriv_monetize_wordpress_ajax_solvemedia_check', 'monetize_wordpress_ajax_solvemedia_check' );
function monetize_wordpress_solvemedia_login() {
    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }
        
    $solvemedia_option = get_option( 'monetize_wordpress_solvemedia_details' );
    if($solvemedia_option['solvemediaHTTPS'] == 'true'){$ssl = true;}else{$ssl = false;}   
    if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
        if(isset($solvemedia_option['solvemediaLOGIN']) && $solvemedia_option['solvemediaLOGIN'] != ''){    
            ?>
            <p>
            <label for="Captcha">Captcha  
            </p>
            <div id="solvemedia_login">
            <?php
                echo solvemedia_get_html($solvemedia_option['solvemediaCKEY'], '', $ssl, $solvemedia_option['solvemediaLOGINTHEME'], $solvemedia_option['solvemediaLOGINLNG']);
            ?> 
            </div>
            <?php 
       }  
    }
}
add_action('login_form','monetize_wordpress_solvemedia_login');
function monetize_wordpress_css() {
    wp_enqueue_style( 'custom-login', plugins_url('css/monetize_wordpress_login.css',__FILE__ ) );
}
add_action( 'login_enqueue_scripts', 'monetize_wordpress_css' );
function monetize_wordpress_solvemedia_login_check($user, $password) {
    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }
    $solvemedia_option = get_option('monetize_wordpress_solvemedia_details');
    if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
        if(isset($solvemedia_option['solvemediaLOGIN']) && $solvemedia_option['solvemediaLOGIN'] != ''){
            if(isset($_POST['adcopy_challenge'])){
                if(isset($_POST['adcopy_response'])){
                    $solvemedia_response = solvemedia_check_answer($solvemedia_option['solvemediaVKEY'], $_SERVER["REMOTE_ADDR"], sanitize_text_field($_POST["adcopy_challenge"]), sanitize_text_field($_POST["adcopy_response"]), $solvemedia_option['solvemediaHKEY']);
                    if (!$solvemedia_response->is_valid) {
                        remove_action('authenticate', 'wp_authenticate_username_password', 20);
                        $user = new WP_Error( 'denied', __("<strong>ERROR</strong>:".$solvemedia_response->error) );
                    }							
                }else{remove_action('authenticate', 'wp_authenticate_username_password', 20);$user = new WP_Error( 'denied', __("<strong>ERROR</strong>: Please complete the captchan") );}
            }else{remove_action('authenticate', 'wp_authenticate_username_password', 20);$user = new WP_Error( 'denied', __("<strong>ERROR</strong>: SolveMedia - AdCopy Error, Contact Admin") );}
            return $user;
        }
    }
    return $user;
}
add_action('wp_authenticate_user', 'monetize_wordpress_solvemedia_login_check', 10, 3);
function monetize_wordpress_solvemedia_registration() {
    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }   
    $solvemedia_option = get_option( 'monetize_wordpress_solvemedia_details' );
    if($solvemedia_option['solvemediaHTTPS'] == 'true'){$ssl = true;}else{$ssl = false;}   
    if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
        if(isset($solvemedia_option['solvemediaREG']) && $solvemedia_option['solvemediaREG'] != ''){    
            ?>
            <p>
            <label for="Captcha">Captcha  
            </p>
            <div id="solvemedia_reg">
            <?php
                echo solvemedia_get_html($solvemedia_option['solvemediaCKEY'], '', $ssl, $solvemedia_option['solvemediaREGTHEME'], $solvemedia_option['solvemediaREGLNG']);
            ?> 
            </div>
            <?php 
       }  
    }
}
add_action( 'register_form', 'monetize_wordpress_solvemedia_registration' );
function monetize_wordpress_solvemedia_registration_check( $errors) {
    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }
    $solvemedia_option = get_option('monetize_wordpress_solvemedia_details');
    if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
        if(isset($solvemedia_option['solvemediaREG']) && $solvemedia_option['solvemediaREG'] != ''){
            if(isset($_POST['adcopy_challenge'])){
                if(isset($_POST['adcopy_response'])){
                    $solvemedia_response = solvemedia_check_answer($solvemedia_option['solvemediaVKEY'], $_SERVER["REMOTE_ADDR"], sanitize_text_field($_POST["adcopy_challenge"]), sanitize_text_field($_POST["adcopy_response"]), $solvemedia_option['solvemediaHKEY']);
                    if (!$solvemedia_response->is_valid) {
                        $errors->add( 'denied', __( "<strong>ERROR</strong>:".$solvemedia_response->error) );
                    }							
                }else{$errors->add( 'denied', __( '<strong>ERROR</strong>: Please complete the captcha') );}
            }else{$errors->add( 'denied', __( '<strong>ERROR</strong>: Solve Media AdCopy Error - Contact Admin') );}
        }
    }
    
    return $errors;
}
add_filter( 'registration_errors', 'monetize_wordpress_solvemedia_registration_check', 10, 1 );
function monetize_wordpress_solvemedia_lostpassword(){
    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }   
    $solvemedia_option = get_option( 'monetize_wordpress_solvemedia_details' );
    if($solvemedia_option['solvemediaHTTPS'] == 'true'){$ssl = true;}else{$ssl = false;}   
    if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
        if(isset($solvemedia_option['solvemediaLOST']) && $solvemedia_option['solvemediaLOST'] != ''){    
            ?>
            <p>
            <label for="Captcha">Captcha  
            </p>
            <div id="solvemedia_lost">
            <?php
                echo solvemedia_get_html($solvemedia_option['solvemediaCKEY'], '', $ssl, $solvemedia_option['solvemediaLOSTTHEME'], $solvemedia_option['solvemediaLOSTLNG']);
            ?> 
            </div>
            <?php 
       }  
    }
}
add_action( 'lostpassword_form', 'monetize_wordpress_solvemedia_lostpassword' );
function monetize_wordpress_solvemedia_lostpassword_check( $errors ) {
    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }
    $solvemedia_option = get_option('monetize_wordpress_solvemedia_details');
    if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
        if(isset($solvemedia_option['solvemediaLOST']) && $solvemedia_option['solvemediaLOST'] != ''){
            if(isset($_POST['adcopy_challenge'])){
                if(isset($_POST['adcopy_response'])){
                    $solvemedia_response = solvemedia_check_answer($solvemedia_option['solvemediaVKEY'], $_SERVER["REMOTE_ADDR"], sanitize_text_field($_POST["adcopy_challenge"]), sanitize_text_field($_POST["adcopy_response"]), $solvemedia_option['solvemediaHKEY']);
                    if (!$solvemedia_response->is_valid) {
                        $errors->add( 'denied', __( "<strong>ERROR</strong>:".$solvemedia_response->error) );
                    }							
                }else{$errors->add( 'denied', __( '<strong>ERROR</strong>: Please complete the captcha') );}
            }else{$errors->add( 'denied', __( '<strong>ERROR</strong>: Solve Media AdCopy Error - Contact Admin') );}
        }
    }
    
    return $errors;
}
add_action( 'lostpassword_post', 'monetize_wordpress_solvemedia_lostpassword_check' );

function monetize_wordpress_update_content ( $content ) {
    $solvemedia_option = get_option( 'monetize_wordpress_solvemedia_details' );
        if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
                return '<div id="sv_cu_begin"></div>' . $content . '<div id="sv_cu_end"></div>';
        }else{
            return $content;
        }
    }
add_filter( 'the_content', 'monetize_wordpress_update_content', 20);
function monetize_wordpress_custom_widget( $content ) {
	if ( is_singular( array( 'post', 'page' ) ) && is_active_sidebar( 'monetize_wordpress_custom_widget' ) && is_main_query() ) {
		dynamic_sidebar('monetize_wordpress_custom_widget');
	}
	return $content;
}
add_filter( 'the_content', 'monetize_wordpress_custom_widget' );
function monetize_wordpress_update_widgets_init() {
	register_sidebar( array(
		'name'          => 'Custom Widget (Top Of Body)',
		'id'            => 'monetize_wordpress_custom_widget',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'monetize_wordpress_update_widgets_init' );
?>
