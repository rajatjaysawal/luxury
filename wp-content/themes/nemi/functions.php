<?php
/**
 * Cropshop functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link https://codex.wordpress.org/Plugin_API
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */
define( 'NEMI', '1.0' );

/**
 * Set up the content width value based on the theme's design.
 *
 * @see nemi_fnc_content_width()
 *
 * @since Nemi 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

function nemi_fnc_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nemi_fnc_content_width', 810 );
}
add_action( 'after_setup_theme', 'nemi_fnc_content_width', 0 );

if ( ! function_exists( 'nemi_fnc_setup' ) ) :
	/**
	 * Cropshop setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since Nemi 1.0
	 */
	function nemi_fnc_setup() {

		/*
		 * Make Cropshop available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Cropshop, use a find and
		 * replace to change 'nemi' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'nemi', get_template_directory() . '/languages' );

		// This theme styles the visual editor to resemble the theme style.


		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 672, 372, true );

		add_editor_style();
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'       => esc_html__( 'Main menu', 'nemi' ),
			'headermenu'    => esc_html__( 'Header menu', 'nemi' ),
			'topmenu'	    => esc_html__( 'Topbar Menu', 'nemi' ),
			'tpaccount'	    => esc_html__( 'Topbar Account Menu', 'nemi' )
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
		// add support woocommerce

		add_theme_support( "woocommerce" );
		/*
		 * Enable support for Post Formats.
		 * See https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'nemi_fnc_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// add support for display browser title
		add_theme_support( 'title-tag' );
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		nemi_fnc_get_load_plugins();

	}
endif; // nemi_fnc_setup
add_action( 'after_setup_theme', 'nemi_fnc_setup' );

/**
 * Get Theme Option Value.
 * @param String $name : name of prameters
 */
function nemi_fnc_theme_options( $name, $default = false ) {

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


//Update logo wordpress 4.5
if ( version_compare( $GLOBALS['wp_version'], '4.5', '>=' ) ) {
	function nemit_fnc_setup_logo() {
	    add_theme_support( 'custom-logo' );
	}
	add_action( 'after_setup_theme', 'nemit_fnc_setup_logo' );
}

/**
 * Require function for including 3rd plugins
 *
 */
require_once( get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php' );

function nemi_fnc_get_load_plugins(){

	$plugins[] =(array(
		'name'                     => esc_html__('MetaBox','nemi'), // The plugin name
	    'slug'                     => 'meta-box', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	));

	$plugins[] =(array(
		'name'                     => esc_html__('WooCommerce','nemi'), // The plugin name
	    'slug'                     => 'woocommerce', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	));


	$plugins[] =(array(
		'name'                     => esc_html__('MailChimp for WordPress','nemi'), // The plugin name
	    'slug'                     => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
	    'required'                 =>  true
	));

	$plugins[] =(array(
		'name'                     => esc_html__('Contact Form 7','nemi'), // The plugin name
	    'slug'                     => 'contact-form-7', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	));

	$plugins[] =(array(
		'name'                     => esc_html__('WPBakery Visual Composer','nemi'), // The plugin name
	    'slug'                     => 'js_composer', // The plugin slug (typically the folder name)
	    'required'                 => true,
	    'source'				   => esc_url( 'http://themeocean.net/plugins/js_composer.zip' )
	));

	$plugins[] =(array(
		'name'                     => esc_html__('Revolution Slider','nemi'), // The plugin name
        'slug'                     => 'revslider', // The plugin slug (typically the folder name)
        'required'                 => true ,
        'source'				   => esc_url( 'http://themeocean.net/plugins/revslider.zip' )
	));

	$plugins[] =(array(
		'name'                     =>   esc_html__('Ocean Framework For Themes','nemi'), // The plugin name
        'slug'                     =>  'pbrthemer', // The plugin slug (typically the folder name)
        'required'                 =>  true ,
        'source'				   =>  esc_url( 'http://www.themeocean.net/plugins/pbrthemer.zip' )
	));

    $plugins[] =(array(
		'name'                     =>   esc_html__('YITH WooCommerce Wishlist','nemi'), // The plugin name
	    'slug'                     =>  'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
	    'required'                 =>   true
	));

	$plugins[] =(array(
		'name'                     => esc_html__('YITH Woocommerce Compare','nemi'), // The plugin name
        'slug'                     => 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
        'required'                 => true
	));

	tgmpa( $plugins );
}

/**
 * Register three Cropshop widget areas.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_registart_widgets_sidebars() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar Default', 'nemi' ),
			'id'            => 'sidebar-default',
			'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));
	register_sidebar(
		array(
			'name'          => esc_html__( 'Newsletter' , 'nemi'),
			'id'            => 'newsletter',
			'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget  clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
		'name'          => esc_html__( 'Text Header' , 'nemi'),
		'id'            => 'text-header',
		'description'   => esc_html__( 'Appears on content in the sidebar.', 'nemi'),
		'before_widget' => '<aside id="%1$s" class="clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar(
		array(
		'name'          => esc_html__( 'Social Header' , 'nemi'),
		'id'            => 'social-header',
		'description'   => esc_html__( 'Appears on content in the sidebar.', 'nemi'),
		'before_widget' => '<aside id="%1$s" class="clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Left Sidebar' , 'nemi'),
			'id'            => 'sidebar-left',
			'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style  clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Right Sidebar' , 'nemi'),
			'id'            => 'sidebar-right',
			'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Left Sidebar' , 'nemi'),
			'id'            => 'blog-sidebar-left',
			'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Right Sidebar', 'nemi'),
			'id'            => 'blog-sidebar-right',
			'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Contact' , 'nemi'),
			'id'            => 'footer-contact',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Newsletter' , 'nemi'),
			'id'            => 'footer-newletter',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Logo' , 'nemi'),
			'id'            => 'footer-logo',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Menu' , 'nemi'),
			'id'            => 'footer-menu',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Social' , 'nemi'),
			'id'            => 'footer-social',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Copyright' , 'nemi'),
			'id'            => 'custom-copyright',
			'description'   => esc_html__( 'Appears in the copyright section of the site.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		));

	register_sidebar(
		array(
			'name'          => esc_html__( 'Mass Footer Body' , 'nemi'),
			'id'            => 'mass-footer-body',
			'description'   => esc_html__( 'Appears in the end of footer section of the site.', 'nemi'),
			'before_widget' => '<aside id="%1$s" class="widget-footer clearfix %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title hide"><span>',
			'after_title'   => '</span></h3>',
		));
}
add_action( 'widgets_init', 'nemi_fnc_registart_widgets_sidebars' );

/**
 * Register Lato Google font for nemi.
 *
 * @since Nemi 1.0
 *
 * @return string
 */
function nemi_fnc_font_url() {

	$fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
    $montserrat = _x( 'on', 'Montserrat font: on or off', 'nemi' );

    if ( 'off' !== $montserrat ) {
        $font_families = array();

        if ( 'off' !== $montserrat ) {
            $font_families[] = 'Montserrat:300,400,500,600,700';
        }

        $query_args = array(
            'family' => ( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

 		$protocol = is_ssl() ? 'https:' : 'http:';
        $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_scripts() {
	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'nemi-open-sans', nemi_fnc_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'nemi-fa', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '3.0.3' );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'nemi-simpleline', get_template_directory_uri() . '/css/simple-line-icons.css', array());

	if(isset($_GET['pbr-skin']) && $_GET['pbr-skin']) {
		$currentSkin = $_GET['pbr-skin'];
	}else{
		$currentSkin = str_replace( '.css','', nemi_fnc_theme_options('skin','default') );
	}
	if( is_rtl() ){
		if( !empty($currentSkin) && $currentSkin != 'default' ){
			wp_enqueue_style( 'nemi-'.$currentSkin.'-style', get_template_directory_uri() . '/css/skins/rtl-'.$currentSkin.'/style.css' );
		}else {
			// Load our main stylesheet.
			wp_enqueue_style( 'nemi-style', get_template_directory_uri() . '/css/rtl-style.css' );
		}
	}
	else {
		if( !empty($currentSkin) && $currentSkin != 'default' ){
			wp_enqueue_style( 'nemi-'.$currentSkin.'-style', get_template_directory_uri() . '/css/skins/'.$currentSkin.'/style.css' );
		}else {
			// Load our main stylesheet.
			wp_enqueue_style( 'nemi-style', get_template_directory_uri() . '/css/style.css' );
		}
	}

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'nemi-ie', get_template_directory_uri() . '/css/ie.css', array( 'nemi-style' ), '20131205' );
	wp_style_add_data( 'nemi-ie', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'bootstrap-min', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20130402' );

	wp_enqueue_script( 'masonry-js', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array( 'jquery' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.css');
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.js', array( 'jquery' ), '20150315', true );

	wp_enqueue_script('prettyphoto-js',	get_template_directory_uri().'/js/jquery.prettyPhoto.js',array(),false,true);

	wp_enqueue_style( 'prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css');

	wp_register_script( 'nemi-functions-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150315', true );

	wp_localize_script( 'nemi-functions-script', 'nemiAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	wp_enqueue_script( 'nemi-functions-script' );

}
add_action( 'wp_enqueue_scripts', 'nemi_fnc_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_admin_fonts() {
	wp_enqueue_style( 'nemi-lato', nemi_fnc_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'nemi_fnc_admin_fonts' );

/**
 * Implement rick meta box for post and page, custom post types. These 're used with metabox plugins
 */
if( is_admin() ){
	require_once(  get_template_directory() . '/inc/admin/function.php' );
	require_once(  get_template_directory() . '/inc/admin/metabox/pagepost.php' );
}

require_once(  get_template_directory() . '/inc/custom-header.php' );
require_once(  get_template_directory() . '/inc/customizer.php' );
require_once(  get_template_directory() . '/inc/function-post.php' );
require_once(  get_template_directory() . '/inc/function-unilty.php' );
require_once(  get_template_directory() . '/inc/functions-import.php' );
require_once(  get_template_directory() . '/inc/template.php' );

/**
 * Check and load to support visual composer
 */
if( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && class_exists('WPBakeryVisualComposerAbstract') ){
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/class-vc-elements.php' );
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/class-vc-theme.php' );
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/function-vc.php' );
}

/**
 * Check to support woocommerce
 */
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	add_theme_support( 'woocommerce');
	require_once(  get_template_directory() . '/inc/vendors/woocommerce/class-vc-woocommerce.php' );
	require_once(  get_template_directory() . '/inc/vendors/woocommerce/class-woocommerce.php' );
	require_once(  get_template_directory() . '/inc/vendors/woocommerce/function-hook.php' );
	require_once(  get_template_directory() . '/inc/vendors/woocommerce/function-logic.php' );
}

if(class_exists('PBR_User_Account')){
	new PBR_User_Account();
}