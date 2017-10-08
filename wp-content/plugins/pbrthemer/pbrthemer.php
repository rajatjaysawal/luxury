<?php 
/*
  Plugin Name: Ocean Framework For Themes
  Plugin URI: http://themeocean.net/
  Description: Implement rich functions for themes base on prestabrain wordpress framework and load widgets for theme used, this is required.
  Version: 1.1.2
  Author: Themeocean
  Author URI: http://themeocean.net/
  License: GPLv2 or later
  Updated: August, 13,2017
 */

 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author     Wordpress Opal  Team <opalwordpress@gmail.com>
  * @copyright  Copyright (C) 2015 www.themeocean.net. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.themeocean.net
  * @support  http://www.themeocean.net/questions/
  */

  define( 'PBR_THEMER_PLUGIN_THEMER_URL', plugin_dir_url( __FILE__ ) );
  define( 'PBR_THEMER_PLUGIN_THEMER_DIR', plugin_dir_path( __FILE__ )  );
  define( 'PBR_THEMER_PLUGIN_THEMER_TEMPLATE_DIR', PBR_THEMER_PLUGIN_THEMER_DIR.'metabox_templates/' );

  include_once( dirname( __FILE__ ) . '/import/import.php' );
  include_once( dirname( __FILE__ ) . '/export/export.php' );
  require_once( dirname( __FILE__ ) . '/classes/account.php' );
  require_once( dirname( __FILE__ ) . '/classes/nav.php' );
  require_once( dirname( __FILE__ ) . '/classes/offcanvas-menu.php' );

  require 'plugin-updates/plugin-update-checker.php';
  $ExampleUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://www.themeocean.net/plugins/pbrthemer.json',
    __FILE__,
    'pbrthemer'
  ); 
  /**
   * Loading Widgets
   */
  function pbrthemer_load_custom_wp_admin_style() {
    wp_enqueue_style( 'pbrthemer-admin-css', PBR_THEMER_PLUGIN_THEMER_URL.'assets/css/admin.css');
    wp_enqueue_style( 'pbrthemer-admin-css' );
  }
  add_action( 'admin_enqueue_scripts', 'pbrthemer_load_custom_wp_admin_style' );
  function pbr_themer_widgets_init(){ 

    if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
        require( PBR_THEMER_PLUGIN_THEMER_DIR.'woocommerce.php' );
    }

      require( PBR_THEMER_PLUGIN_THEMER_DIR.'function.templates.php' );
      require( PBR_THEMER_PLUGIN_THEMER_DIR.'setting.class.php' );
      require( PBR_THEMER_PLUGIN_THEMER_DIR.'widget.class.php' );
      
      define( "PBR_THEMER_PLUGIN_THEMER", true );
      define( 'PBR_THEMER_PLUGIN_THEMER_WIDGET_TEMPLATES', get_template_directory().'/'  );

      $widgets = apply_filters( 'pbr_themer_load_widgets', array( 'contact-info', 'twitter','posts','featured_post','top_rate','sliders','recent_comment','recent_post','tabs','flickr', 'video', 'socials', 'menu_vertical', 'socials_siderbar','popupnewsletter') );


      if( !empty($widgets) ){
          foreach( $widgets as $opt => $key ){

              $file = str_replace( 'enable_', '', $key );
              $filepath = PBR_THEMER_PLUGIN_THEMER_DIR.'widgets/'.$file.'.php'; 
              if( file_exists($filepath) ){ 
                  require_once( $filepath );
              }
          }  
      }
  }
  add_action( 'widgets_init', 'pbr_themer_widgets_init' );

    
  /**
   * Loading Post Types
   */
  function pbr_themer_load_posttypes_setup(){
       

      $opts = apply_filters( 'pbr_themer_load_posttypes', get_option( 'pbr_themer_posttype' ) );
      if( !empty($opts) ){

          foreach( $opts as $opt => $key ){

              $file = str_replace( 'enable_', '', $opt );
              $filepath = PBR_THEMER_PLUGIN_THEMER_DIR.'posttypes/'.$file.'.php'; 
              if( file_exists($filepath) ){
                  require_once( $filepath );
              }
          }  
      }
  }   
  add_action( 'init', 'pbr_themer_load_posttypes_setup', 1 );   
  

if(!function_exists('pbr_string_limit_words')){
  function pbr_string_limit_words($string, $word_limit)
  {
    $words = explode(' ', $string, ($word_limit + 1));

    if(count($words) > $word_limit) {
      array_pop($words);
    }

    return implode(' ', $words);
  }
}


add_action( 'init', 'pbrthemer_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function pbrthemer_load_textdomain() {
  load_plugin_textdomain( 'pbrthemer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

/**
 * Function for remove srcset (WP4.4)
 *
 */
function pbrthemer_fnc_disable_srcset( $sources ) {
    return false;
}
add_filter( 'wp_calculate_image_srcset', 'pbrthemer_fnc_disable_srcset' );


function pbrthemer_fnc_theme_options($name, $default = false) {
  
    // get the meta from the database
    $options = ( get_option( 'pbr_theme_options' ) ) ? get_option( 'pbr_theme_options' ) : null;

    
   
    // return the option if it exists
    if ( isset( $options[$name] ) ) {
        return apply_filters( 'pbr_theme_options_$name', $options[ $name ] );
    }
    if( get_option( $name ) ){
        return get_option( $name );
    }
    // return default if nothing else
    return apply_filters( 'pbr_theme_options_$name', $default );
}