<?php 
class monetize_wordpress_solvemedia_fullpage_locker_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array( 
    		'classname' => 'monetize_wordpress_solvemedia_unlock',
    		'description' => 'Lock Full Pages With SolveMedia',
    	);
    	parent::__construct( 'monetize_wordpress_solvemedia_unlock', 'SolveMedia Page Locker', $widget_ops );
    }
    
    public function widget( $args, $instance ) {
        if(!defined('ADCOPY_API_SERVER')){ require_once(plugin_dir_path( __FILE__ )."php_libraries/solvemedialib.php"); }
        $display = 0;
        $solvemedia_option = get_option( 'monetize_wordpress_solvemedia_details' );
        if($solvemedia_option['solvemediaHTTPS'] == 'true'){$ssl = true;}else{$ssl = false;}
        if(isset($solvemedia_option['solvemediaONOFF']) && $solvemedia_option['solvemediaONOFF'] != ''){
            $current_page = get_the_ID();
            if(is_array($instance['page-id'])){
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
            if($display == 1){
                add_action( 'wp_footer', function() use ( $args, $instance, $solvemedia_option ) {
                    if($instance['protocol'] == 'http'){
                        $protocol_url = 'api.contentunlock.net';
                    }else{
                        $protocol_url = 'api-secure.contentunlock.net';
                    }
                  $locked = '<ins class="acunlock"
    data-key="'.$solvemedia_option['solvemediaLKEY'].'"
    data-server="'.$protocol_url.'"
    data-protocol="'.$instance['protocol'].'"
    data-xpath-body=\'//div[@id="sv_cu_begin"]\'
    data-xpath-foot=\'//div[@id="sv_cu_end"]\'
    data-tease-header="'.$instance['title'].'"
    data-unlock-instuctions="'.$instance['instructions'].'"
    data-unlock-button-text="'.$instance['button-text'].'"
    data-premium-lock="true"
></ins>
<script async src="http://'.$protocol_url.'/js/cu.js" type="text/javascript"></script>';
                    echo $locked;
                });                
            }
            
        }
    }
                 
        // Widget Backend 
    public function form( $instance ) { 
        $defaults = array( 'title' => 'Content Locker', 'page-id[]'=>array(), 'button-text'=>'Unlock Content', 'instructions'=> 'Please type the phrase shown below.', 'protocol'=>'http');    
        $default_protocol = array('http', 'https');
        $instance = wp_parse_args( (array) $instance, $defaults );
       
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
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
            $page_select = preg_replace('/(.*)-page-id\'>/', '$1-page-id\'><option class="level-0" value="1">Home Page</option>', $page_select);
        }else{
            $page_select = str_replace('<option class="level-0" value="'.$homepage_ID.'">', '<option class="level-0" value="'.$homepage_ID.'"> (Home Page)', $page_select);
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
        <p>
        <label for="<?php echo $this->get_field_id( 'button-text' ); ?>"><?php _e( 'Button Text:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'button-text' ); ?>" name="<?php echo $this->get_field_name( 'button-text' ); ?>" type="text" value="<?php echo esc_attr( $instance['button-text'] ); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'instructions' ); ?>"><?php _e( 'User Instructions:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'instructions' ); ?>" name="<?php echo $this->get_field_name( 'instructions' ); ?>" type="text" value="<?php echo esc_attr( $instance['instructions'] ); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'protocol' ); ?>"><?php _e( 'Protocol:' ); ?></label>
        <select name="<?php echo $this->get_field_name('protocol'); ?>" id="<?php echo $this->get_field_id('protocol'); ?>" class="widefat">
        <?php
        foreach ($default_protocol as $proto) {
            echo '<option value="' . $proto . '"', esc_attr( $instance['protocol'] ) == $proto ? ' selected="selected"' : '', '>', strtoupper($proto), '</option>';
        }
        ?>
        </select>
        </p>
        <?php 
    }     
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['page-id'] = esc_sql($new_instance['page-id']);
        $instance['button-text'] = ( ! empty( $new_instance['button-text'] ) ) ? strip_tags( $new_instance['button-text'] ) : '';
        $instance['instructions'] = ( ! empty( $new_instance['instructions'] ) ) ? strip_tags( $new_instance['instructions'] ) : '';
        $instance['protocol'] = ( ! empty( $new_instance['protocol'] ) ) ? strip_tags( $new_instance['protocol'] ) : '';
        return $instance;
    }
    
}
?>