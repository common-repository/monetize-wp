<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/*
Plugin Name: Monetize WP
Plugin URI: http://wordpress.plustime.com.au/monetize-wordpress/
Description: Wordpress Plugin that helps you monetize your wordpress site easily.
Version: 1.3
Author: second2none
Author URI: http://wordpress.plustime.com.au/
License: GPL2
*/

include( plugin_dir_path( __FILE__ ) . 'options.php');
add_action( 'plugins_loaded', 'monetize_wordpress_init_plugin');

include( plugin_dir_path( __FILE__ ) . 'wordpress-money-solvemedia-fullpage-locker-widget.php');
add_action('widgets_init', create_function('', 'register_widget("monetize_wordpress_solvemedia_fullpage_locker_Widget");'));

include( plugin_dir_path( __FILE__ ) . 'wordpress-money-solvemedia-custom-locker-widget.php');
add_action('widgets_init', create_function('', 'register_widget("monetize_wordpress_solvemedia_custom_locker_Widget");'));


include( plugin_dir_path( __FILE__ ) . 'wordpress-money-custom-ads-widget.php');
add_action('widgets_init', create_function('', 'register_widget("monetize_wordpress_custom_ads_Widget");'));

function monetize_wordpress_activate() {
    $pre_in = get_option('monetize_wordpress_installed');
    if($pre_in !== '1'){
        update_option('monetize_wordpress_installed', '1');
    }
}
add_shortcode( 'mw_sm_custom_locker', 'monetize_wordpress_solvemedia_custom_locker_shortcode' );
function monetize_wordpress_solvemedia_custom_locker_shortcode($atts, $content=null) {
            $found = 0;
            $wdets = '';
        	$lock_screen = '';
            global $wp_registered_widgets;
            $id = 'monetize_wordpress_solvemedia_unlock_custom-'.$atts['id'];  // example
            if ( isset($wp_registered_widgets[$id]) ) {
                $widget = $wp_registered_widgets[$id]['callback'][0];
                $settings = $widget->get_settings();
                foreach($widget->get_settings() as $w_id => $dets){
                    if($w_id == $atts['id']){
                        $wdets = $dets;
                        $found = 1;
                    }
                }
                if($found === 1){
                    if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }
                    $solvemedia_option = get_option( 'monetize_wordpress_solvemedia_details' );
                    
                    if(is_array($wdets)){
                        $atts = shortcode_atts( array(
                            'id' => '',
                    		'solvemediaLKEY' => '',
                    		'protocol' => 'http',
                    		'title' => 'Locked Content',
                    		'instructions' => 'Enter Phrase To Unlock Content',
                    		'button-text' => 'Unlock Content',
                    		'locked-content' => '',
                    		'page-id' => ''
                    	), $wdets, 'mw_sm_custom_locker' );
                        $start_div = $id.'_start';
                        $end_div = $id.'_end'; 
                        if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
                            $lock_screen = '<div id="'.$start_div.'"></div>'.$wdets['locked-content'].'<div id="'.$end_div.'"></div>';
                            $current_page = get_the_ID();
                            if(is_array($atts['page-id'])){
                                foreach($atts['page-id'] as $pageid){
                                    if($pageid == $current_page || $pageid == 0){
                                        $display = 1;
                                    }
                                }
                            }else{
                                if($atts['page-id'] == $current_page || $pageid == 0){
                                    $display = 1;
                                }    
                            } 
                            if($display == 1){
                                add_action( 'wp_footer', function() use ($start_div, $end_div, $atts, $solvemedia_option ) {
                                    if($atts['protocol'] == 'http'){
                                        $protocol_url = 'api.contentunlock.net';
                                    }else{
                                        $protocol_url = 'api-secure.contentunlock.net';
                                    }
                                  $locked = '<ins class="acunlock"
            data-key="'.$solvemedia_option['solvemediaLKEY'].'"
            data-server="'.$protocol_url.'"
            data-protocol="'.$atts['protocol'].'"
            data-xpath-body=\'//div[@id="'.$start_div.'"]\'
            data-xpath-foot=\'//div[@id="'.$end_div.'"]\'
            data-tease-header="'.$atts['title'].'"
            data-unlock-instuctions="'.$atts['instructions'].'"
            data-unlock-button-text="'.$atts['button-text'].'"
            data-premium-lock="true"
            ></ins>
            <script async src="http://'.$protocol_url.'/js/cu.js" type="text/javascript"></script>';
                                    echo $locked;
                                });
                            }
                               
                            
                        }
                    }
                }          
            }
            return $lock_screen;
}
add_shortcode( 'mw_sm_custom_ad', 'monetize_wordpress_custom_ads_shortcode' );
function monetize_wordpress_custom_ads_shortcode($atts, $content=null) {
            $found = 0;
            $wdets = '';
        	$custom_ads_html = '';
            global $wp_registered_widgets;
            $id = 'monetize_wordpress_custom_ads_widget-'.$atts['id'];  // example
            if ( isset($wp_registered_widgets[$id]) ) {
                $widget = $wp_registered_widgets[$id]['callback'][0];
                $settings = $widget->get_settings();
                foreach($widget->get_settings() as $w_id => $dets){
                    if($w_id == $atts['id']){
                        $wdets = $dets;
                        $found = 1;
                    }
                }
                if($found === 1){
                    $custom_ads = get_option( 'monetize_wordpress_coinmedia_details' );
                    
                    if(is_array($wdets)){
                        $atts = shortcode_atts( array(
                            'title'     => 'Custom Ads', 
                            'ad-code'   => '', 
                            'show-title'   => 'off', 
                            'page-id[]' => array()
                    	), $wdets, 'mw_sm_custom_ad' );

                        if(isset($custom_ads['coinmediaONOFF']) && $custom_ads['coinmediaONOFF'] != ''){
                            $current_page = get_the_ID();
                            if(is_array($atts['page-id'])){
                                foreach($atts['page-id'] as $pageid){
                                    if($pageid == $current_page || $pageid == 0){
                                        $display = 1;
                                    }
                                }
                            }else{
                                if($atts['page-id'] == $current_page || $pageid == 0){
                                    $display = 1;
                                }    
                            } 
                            if($display == 1){
                                $custom_ads = get_option( 'monetize_wordpress_coinmedia_details' );
                                
                                if(isset($custom_ads['coinmediaONOFF']) && $custom_ads['coinmediaONOFF'] != ''){
                                    if($atts['show-title'] == 'on'){
                                        $title = '<div class="coinmedia_title">
                                                    '. $atts['title'].'
                                                    </div>';
                                    }
                                    
                                    $custom_ads_html .= '<div class="coinmedia_con">
                                                            ' . $title . '
                                                            <div class="coinmedia_ad">
                                                            ' . $atts['ad-code'] . '
                                                            </div>
                                                        </div>';
                                }
                            }
                               
                            
                        }
                    }
                }          
            }
            return $custom_ads_html;
}
register_activation_hook( __FILE__, 'monetize_wordpress_activate' );



?>