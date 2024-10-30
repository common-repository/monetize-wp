<?php 
class monetize_wordpress_custom_ads_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array( 
    		'classname' => 'monetize_wordpress_custom_ads_widget',
    		'description' => 'Place Customs Ads With Widget',
    	);
    	parent::__construct( 'monetize_wordpress_custom_ads_widget', 'Custom Ads', $widget_ops );
    }

    public function widget( $args, $instance ) {
        $display = 0;
        $title = '';
        $custom_ads = get_option( 'monetize_wordpress_coinmedia_details' );
        if(isset($custom_ads['coinmediaONOFF']) && $custom_ads['coinmediaONOFF'] != ''){
            if($instance['page-id'] === 0){
                $display = 1;
            }else{
                $current_page = get_the_ID();
                if(is_array($instance['page-id']) && !empty($instance['page-id'])){
                    foreach($instance['page-id'] as $pageid){
                        if($pageid == $current_page){
                            $display = 1;
                        }
                    }
                }else{
                    if($instance['page-id'] == $current_page){
                        $display = 1;
                    }    
                }
            }
            
            if($display == 1){
                if($instance['show-title'] == 'on'){
                    $title = '<div class="coinmedia_title">
                                '.$args['before_title'] . $instance['title'] . $args['after_title'].'
                                </div>';
                }
                echo $args['before_widget'];
                $custom_ad_html = '<div class="coinmedia_con">
                                    ' . $title .'
                                    <div class="coinmedia_ad">
                                    '.$instance['ad-code'].'
                                    </div>
                                </div>';
                echo __( $custom_ad_html, 'monetize_wordpress_domain' );
                echo $args['after_widget'];
            }
        }
    }
                 
    public function form( $instance ) {
        $wid_id = str_replace('monetize_wordpress_custom_ads_widget-', '', $this->id);
        $textarea_id = $this->get_field_id( 'ad-code' );
        $shortcode = 1;
        $show_title = '';
        if($wid_id == '__i__'){
            //create temp ID
            $wid_id = rand();
            $textarea_id = str_replace('__i__', $wid_id, $textarea_id);
            $shortcode = 0;
        }        
        $defaults = array( 'title' => 'Custom Ads', 'ad-code'=>'', 'page-id[]'=>array(), 'show-title'=>'off');    
        $instance = wp_parse_args( (array) $instance, $defaults );
        if($instance['show-title'] == 'on'){
            $show_title = 'checked';
        }
         //insert custom ads
        ?>
        <script type="text/javascript">
            (function ($) {
                $(document).ready( function(){
                      var coinmedi_es_<?php echo $wid_id; ?> = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                        coinmedi_es_<?php echo $wid_id; ?>.codemirror = _.extend(
                            {},
                            coinmedi_es_<?php echo $wid_id; ?>.codemirror,
                            {
                                lineNumbers: true,
                                indentUnit: 2,
                                tabSize: 2,
                                autoRefresh:true
                                
                            }
                        );
                    var cm_editor_<?php echo $wid_id; ?> = wp.codeEditor.initialize($('#<?php echo $textarea_id; ?>') , coinmedi_es_<?php echo $wid_id; ?> );
                    
                    $(document).on('keyup', '.CodeMirror-code', function(){
                        $('#<?php echo $textarea_id; ?>').text(cm_editor_<?php echo $wid_id; ?>.codemirror.getValue());
                        $('#<?php echo $textarea_id; ?>').trigger('change');
                    });
    
                });
            })(jQuery);
        </script>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'show-title' ); ?>"><?php _e( 'Show Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'show-title' ); ?>" name="<?php echo $this->get_field_name( 'show-title' ); ?>" type="checkbox" <?php echo $show_title; ?>/>
        </p>
        <p>
        <label for="adcode"><?php _e( 'Ad Code:' ); ?></label>
         <textarea id="<?php echo $textarea_id; ?>" name="<?php echo $this->get_field_name( 'ad-code' ); ?>" class="widefat"><?php echo esc_textarea( $instance['ad-code'] ); ?> </textarea>
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'page-id[]' ); ?>"><?php _e( 'Select Pages:' ); ?></label>

        <?php 
        
        $args = array(
                'depth'                 => 0,
                'echo'                  => 0,
                'name'                  => $this->get_field_name('page-id[]'),
                'id'                    => $this->get_field_id('page-id'),
                'class'                 => 'widefat'
            );
       $page_select = wp_dropdown_pages( $args );
       $homepage_ID = get_option('page_on_front');
       if($homepage_ID === 0){$homepage_ID = 1;}
        if (strpos($page_select, '<option class="level-0" value="'.$homepage_ID.'">') === false) {
            $page_select = preg_replace('/(.*)-page-id\'>/', '$1-page-id\'><option class="level-0" value="0">None</option><option class="level-0" value="1">Home Page</option>', $page_select);
        }else{
            $page_select = str_replace('<option class="level-0" value="'.$homepage_ID.'">', '<option class="level-0" value="0">None / Shortcode Only</option><option class="level-0" value="'.$homepage_ID.'"> (Home Page)', $page_select);
        }
       if(is_array($instance['page-id'])){
            foreach($instance['page-id'] as $pageid){
                $page_select = str_replace('value="'.$pageid.'"', 'value="'.$pageid.'" selected="selected"', $page_select);
            }
        }else{
            if($instance['page-id'] != ''){
                $page_select = str_replace('value="'.$instance['page-id'].'"', 'value="'.$instance['page-id'].'" selected="selected"', $page_select);
            }    
        }
        echo $page_select;
        ?>
        </p>
        <?php if($shortcode === 1) {
         ?>
         <p>Shortcode: [mw_sm_custom_ad id=<?php echo $wid_id; ?>]</p>
        <?php   
        }?> 
        <?php 
    }     
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['show-title'] = ( ! empty( $new_instance['show-title'] ) ) ? $new_instance['show-title'] : 'off';
        $instance['ad-code'] = ( ! empty( $new_instance['ad-code'] ) ) ? $new_instance['ad-code'] : '';
        $instance['page-id'] = esc_sql($new_instance['page-id']);
        return $instance;
    }
    
}
?>