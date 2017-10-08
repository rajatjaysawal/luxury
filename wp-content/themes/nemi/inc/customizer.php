<?php
 /**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     ENGOTHEME Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 engotheme.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://engotheme.com
 * @support  http://engotheme.com.
 */

/**
 * ENGOTHEME Category Drop Down List Class
 * modified dropdown-pages from wp-includes/class-wp-customize-control.php
 *
 * @since ENGOTHEME v1.0
 */
if(  class_exists("WP_Customize_Control") ){

    class Nemi_Header_Layout_DropDown extends WP_Customize_Control{

        public function render_content(){

            $headerlayouts = array(
                    ''          => esc_html( 'Standard', 'nemi' ),
                    'senior'    => esc_html( 'Senior', 'nemi' )
                );

            $output = array();

            foreach( $headerlayouts as $layout => $text ){
                $selected = ( $this->value() == $layout )?' selected="selected" ': '';
                $output[] = '<option value="'. $layout .'" '.$selected.'>' . $text . '</option>';
            }

            $dropdown = '<select>'.implode( " ", $output ).'</select>';
            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );

        }
    }

    class Nemi_Sidebar_DropDown extends WP_Customize_Control{

        public function render_content(){

            global $wp_registered_sidebars;

            $output = array();

            $output[] = '<option value="">'.esc_html__( 'No Sidebar', 'nemi' ).'</option>';

            foreach( $wp_registered_sidebars as $sidebar ){
                $selected = ($this->value() == $sidebar['id'])?' selected="selected" ': '';
                $output[] = '<option value="'.$sidebar['id'].'" '.$selected.'>'.$sidebar['name'].'</option>';
            }

            $dropdown = '<select>'.implode( " ", $output ).'</select>';
            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );

        }
    }

    ///
    class Nemi_Layout_DropDown extends WP_Customize_Control{
        public $type="PBR_Layout";
        public function render_content(){

            $layouts = array(
                'fullwidth' => esc_html__('Full width', 'nemi'),
                'leftmain' => esc_html__('Left - Main Sidebar', 'nemi'),
                'mainright' => esc_html__('Main - Right Sidebar', 'nemi'),

            );
             printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span>',
                 $this->label

            );
            ?>
            <div class="page-layout">


            <?php
            $output = array();

            foreach( $layouts as $key => $layout ){
                $v = $this->value() ? $this->value() : 'fullwidth' ;
                $selected = ( $v == $key)?' selected="selected" ': '';
                $output[] = '<option value="'.$key.'" '.$selected.'>'.$layout.'</option>';
            }

            $dropdown = '<select>'.implode( " ", $output ).'</select>';
            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

            printf(
                '%s</label>',

                $dropdown
            ).'</div>';
        }
    }

}
if ( class_exists( 'WP_Customize_Control' ) ) {
    class Nemi_Customize_Dropdown_Categories_Control extends WP_Customize_Control {
        public $type = 'dropdown-categories';

        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'             => '_customize-dropdown-categories-' . $this->id,
                    'echo'             => 0,
                    'hide_empty'       => false,
                    'show_option_none' => '&mdash; ' . esc_html__('Select', 'nemi') . ' &mdash;',
                    'hide_if_empty'    => false,
                    'selected'         => $this->value(),
                )
            );

            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown );

            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}

/**
 * ENGOTHEME TextArea Control Class
 * create custom textarea input field
 *
 * @since ENGOTHEME v0.5
 **/

if ( class_exists( 'WP_Customize_Control' ) ) {
    # Adds textarea support to the theme customizer
    class Nemi_TextAreaControl extends WP_Customize_Control {
        public $type = 'textarea'; # can change to 'number' for input[type=number] field
        public function __construct( $manager, $id, $args = array() ) {
            $this->statuses = array( '' => esc_html__( 'Default', 'nemi' ) );
            parent::__construct( $manager, $id, $args );
        }

        public function render_content() {
            echo '<label>
                <span class="customize-control-title">' . esc_html( $this->label ) . '</span>
                <textarea rows="5" style="width:100%;" ';
            $this->link();
            echo '>' . esc_textarea( $this->value() ) . '</textarea>
                </label>';
        }
    }

}

if (  class_exists( 'WP_Customize_Control' ) ) {


    /**
     * Class to create a custom tags control
     */
    class Nemi_Text_Editor_Custom_Control extends WP_Customize_Control
    {
          /**
           * Render the content on the theme customizer page
           */
          public function render_content()
           {
                ?>
                    <label>
                      <span class="customize-text_editor"><?php echo esc_html( $this->label ); ?></span>
                      <?php
                        $settings = array(
                          'textarea_name' => $this->id
                          );

                        wp_editor($this->value(), $this->id, $settings );
                      ?>
                    </label>
                <?php
           }
    }

}

/**
 * ENGOTHEME Google Front Control Class
 *
 * @since ENGOTHEME v2.1
 **/
if ( class_exists( 'WP_Customize_Control' ) ) {
    # Adds textarea support to the theme customizer
    class Nemi_GoogleFontControl extends WP_Customize_Control {

        private $fonts = false;

        public function __construct($manager, $id, $args = array(), $options = array()){
            $this->fonts = get_transient( 'google_font_names_');

            if ( ! is_array( $this->fonts ) )
                $this->fonts = $this->get_font_names();

            if ( ! $this->fonts ) return;

            parent::__construct( $manager, $id, $args );

        }

        public function render_content() {
            if(!empty($this->fonts)) { ?>
                <label>
                    <span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>
                    <select <?php $this->link(); ?>>
                <?php
                foreach ( $this->fonts as $key => $value ) {
                    printf('<option value="%s">%s</option>',
                        $key,
                        $value);
                }
                ?>
                    </select>
                </label>
            <?php
            }
        }

        public function get_font_names() {

            $font_name_list = get_transient( 'google_font_names_');

            if ( $font_name_list )
                return $font_name_list;

            $json_name_list = @wp_remote_get( 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyBWVfrVgpz5SYM-inIZL4SpzCzTPi4Dhrg' );

            if ( !isset( $json_name_list ) )
                return;

            $decoded_name_list = @json_decode( $json_name_list[ 'body'] );

            $font_name_list[ 'none' ] = 'none';

            if ( is_object( $decoded_name_list ) )
                foreach ( $decoded_name_list->items as $font_name )
                    $font_name_list[ str_replace( ' ', '+', $font_name->family ) ] = $font_name->family;

            set_transient( 'google_font_names_', $font_name_list, 60 * 60 *24 );
            return $font_name_list;
        }
    }
}
?>
<?php
/**
 * Cropshop Customizer support
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */

/**
 * Implement Customizer additions and adjustments.
 *
 * @since Nemi 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function nemi_fnc_customize_register( $wp_customize ) {
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'nemi' );

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'nemi' );

	// Add custom description to Colors and Background controls or sections.
	if ( property_exists( $wp_customize->get_control( 'background_color' ), 'description' ) ) {
		$wp_customize->get_control( 'background_color' )->description = esc_html__( 'May only be visible on wide screens.', 'nemi' );
		$wp_customize->get_control( 'background_image' )->description = esc_html__( 'May only be visible on wide screens.', 'nemi' );
	} else {
		$wp_customize->get_section( 'colors' )->description           = esc_html__( 'Background may only be visible on wide screens.', 'nemi' );
		$wp_customize->get_section( 'background_image' )->description = esc_html__( 'Background may only be visible on wide screens.', 'nemi' );
	}


    $wp_customize->add_setting('topbar_bg', array(
        'default'    => get_option('topbar_bg'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('topbar_bg', array(
        'label'    => esc_html__('Topbar Background', 'nemi'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );
    $wp_customize->add_setting('topbar_color', array(
        'default'    => get_option('footer_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('topbar_color', array(
        'label'    => esc_html__('Topbar Text Color', 'nemi'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );


    /////
    $wp_customize->add_setting('page_bg', array(
        'default'    => get_option('page_bg'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('page_bg', array(
        'label'    => esc_html__('Page Container Background', 'nemi'),
        'section'  => 'colors',
        'type'      => 'color',
        'default'   => '#FFFFFF'
    ) );

    //

    $wp_customize->add_setting('footer_bg', array(
        'default'    => get_option('footer_bg'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('footer_bg', array(
        'label'    => esc_html__('Footer Background', 'nemi'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );

    $wp_customize->add_setting('footer_heading_color', array(
        'default'    => get_option('footer_heading_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('footer_heading_color', array(
        'label'    => esc_html__('Footer Heading Color', 'nemi'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );


    $wp_customize->add_setting('footer_color', array(
        'default'    => get_option('footer_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('footer_color', array(
        'label'    => esc_html__('Footer Text Color', 'nemi'),
        'section'  => 'colors',
        'type'      => 'color',
    ) );


    ///

    $wp_customize->add_setting('header_image_link', array(
        'default'    => get_option('footer_color'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'esc_url_raw',
        'default'   => '#'
    ) );

    $wp_customize->add_control('header_image_link', array(
        'label'    => esc_html__('Image Link', 'nemi'),
        'section'  => 'header_image',
        'type'      => 'text',
        'default'   => '#'
    ) );
}

add_action( 'customize_register', 'nemi_fnc_customize_register' );


function nemi_fnc_sanitize_textarea( $content ){
    return wp_kses_post( force_balance_tags( $content ) );
}

/**
 *
 */
add_action( 'customize_register', 'nemi_fnc_cst_customizer' );

function nemi_fnc_cst_customizer($wp_customize){

    # General Settings
    // Panel Header
    $wp_customize->add_section('pbr_cst_general_settings', array(
        'title'      => esc_html__('General Settings', 'nemi'),
        'description'    => esc_html__('Website General Settings', 'nemi'),
        'transport'  => 'postMessage',
        'priority'   => 10,
    ));

    // Parameter Options
    $wp_customize->add_setting('blogname', array(
        'default'    => get_option('blogname'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('blogname', array(
        'label'    => esc_html__('Site Title', 'nemi'),
        'section'  => 'pbr_cst_general_settings',
        'priority' => 1,
    ) );

    //
    $wp_customize->add_setting('blogdescription', array(
        'default'    => get_option('blogdescription'),
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('blogdescription', array(
        'label'    => esc_html__('Tagline', 'nemi'),
        'section'  => 'pbr_cst_general_settings',
        'priority' => 2,
    ) );

    //
    $wp_customize->add_setting('display_header_text', array(
        'default'    => 1,
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    $wp_customize->add_control( 'display_header_text', array(
        'settings' => 'header_textcolor',
        'label'    => esc_html__( 'Show Title & Tagline', 'nemi' ),
        'section'  => 'pbr_cst_general_settings',
        'type'     => 'checkbox',
        'priority' => 4,
    ) );


    /*
     * Custom Logo
     */
    if ( version_compare( $GLOBALS['wp_version'], '4.5', '<' ) ) {
         $wp_customize->add_setting('pbr_theme_options[logo]', array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'manage_options',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pbr_theme_options[logo]', array(
            'label'    => esc_html__('Logo', 'nemi'),
            'section'  => 'pbr_cst_general_settings',
            'settings' => 'pbr_theme_options[logo]',
            'priority' => 10,
        ) ) );
     }

    //
    $wp_customize->add_setting('pbr_theme_options[copyright_text]', array(
        'default'    => 'Copyright 2015 - Mixtheme - All Rights Reserved.',
        'type'       => 'option',
        'transport'=>'refresh',
         'sanitize_callback' => 'nemi_fnc_sanitize_textarea',
    ) );

    $wp_customize->add_control( new Nemi_TextAreaControl( $wp_customize, 'pbr_theme_options[copyright_text]', array(
        'label'    => esc_html__('Copyright text', 'nemi'),
        'section'  => 'pbr_cst_general_settings',
        'settings' => 'pbr_theme_options[copyright_text]',
        'priority' => 12,
    ) ) );

    /*
     * Custom Logo
     */
     $wp_customize->add_setting('pbr_theme_options[top-banner]', array(
        'default'    => '',
        'type'       => 'option',
        'capability' => 'manage_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pbr_theme_options[top-banner]', array(
        'label'    => esc_html__('Top Banner', 'nemi'),
        'section'  => 'pbr_cst_general_settings',
        'settings' => 'pbr_theme_options[top-banner]',
        'priority' => 10,
    ) ) );
   /***************************************************************************
    * Theme Settings
    ***************************************************************************/


   /**
     * General Setting
     */
    $wp_customize->add_section( 'ts_general_settings', array(
        'priority' => 12,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Themes And Layouts Setting', 'nemi' ),
        'description' => '',
    ) );

    //
    $wp_customize->add_setting( 'pbr_theme_options[skin]', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'default'  => 'default',
         'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'pbr_theme_options[skin]', array(
        'label'      => esc_html__( 'Active Skin', 'nemi' ),
        'section'    => 'ts_general_settings',
        'type'    => 'select',
        'choices'    => nemi_fnc_cst_skins(),
    ) );

     $wp_customize->add_setting( 'pbr_theme_options[headerlayout]', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'default'  => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'pbr_theme_options[headerlayout]', array(
        'label'      => esc_html__( 'Header Layout Style', 'nemi' ),
        'section'    => 'ts_general_settings',
        'type'    => 'select',
         'choices' => array(''=>'Default'),
         'choices'    => nemi_fnc_get_header_layouts(),
    ) );


    $wp_customize->add_setting( 'pbr_theme_options[footer-style]', array(
        'type'           => 'option',
        'capability'     => 'manage_options',
        'default'        => 'default'   ,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

     $wp_customize->add_control( 'pbr_theme_options[footer-style]', array(
        'label'      => esc_html__( 'Footer Styles Builder', 'nemi' ),
        'section'    => 'ts_general_settings',
        'type'       => 'select',
        'choices'    => nemi_fnc_get_footer_profiles()
    ) );



    /******************************************************************
     * Social share
     ******************************************************************/
    $wp_customize->add_section( 'social_share_settings', array(
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Social Share setting', 'nemi' ),
        'description' => '',
    ) );

    // Share facebook
    nemi_fnc_social_config( $wp_customize, 'facebook_share_blog', esc_html__('Share facebook ', 'nemi'), 'social_share_settings');
    //share twitter
    nemi_fnc_social_config( $wp_customize, 'twitter_share_blog', esc_html__('Share twitter ', 'nemi'), 'social_share_settings');
    //share linkedin
    nemi_fnc_social_config( $wp_customize, 'linkedin_share_blog', esc_html__('Share linkedin ', 'nemi'), 'social_share_settings');
    //share tumblr
    nemi_fnc_social_config( $wp_customize, 'tumblr_share_blog', esc_html__('Share tumblr ', 'nemi'), 'social_share_settings');
    //share google plus
    nemi_fnc_social_config( $wp_customize, 'google_share_blog', esc_html__('Share google plus ', 'nemi'), 'social_share_settings');
    //share pinterest
    nemi_fnc_social_config( $wp_customize, 'pinterest_share_blog', esc_html__('Share pinterest ', 'nemi'), 'social_share_settings');
    //share mail
    nemi_fnc_social_config( $wp_customize, 'mail_share_blog', esc_html__('Share mail ', 'nemi'), 'social_share_settings');


    /******************************************************************
     * Navigation
     ******************************************************************/

     # Sticky Top Bar Option
    $wp_customize->add_setting('pbr_theme_options[verticalmenu]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('pbr_theme_options[verticalmenu]', array(
        'settings'  => 'pbr_theme_options[verticalmenu]',
        'label'     => esc_html__('Vertical Megamenu', 'nemi'),
        'section'   => 'nav',
        'type'      => 'select',
        'choices' => nemi_fnc_get_menugroups(),
    ) );



    # Sticky Top Bar Option
    $wp_customize->add_setting('pbr_theme_options[megamenu-is-sticky]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('pbr_theme_options[megamenu-is-sticky]', array(
        'settings'  => 'pbr_theme_options[megamenu-is-sticky]',
        'label'     => esc_html__('Sticky Top Bar', 'nemi'),
        'section'   => 'nav',
        'type'      => 'checkbox',
        'transport' => 4,
    ) );

    $wp_customize->add_setting( 'pbr_theme_options[megamenu-duration]', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'default'  => '300',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'pbr_theme_options[megamenu-duration]', array(
        'label'      => esc_html__(  'Megamenu Duration', 'nemi' ),
        'section'    => 'nav',
        'type'    => 'text'
    ) );

    /*****************************************************************
     * Front Page Settings Panel
     *****************************************************************/
    $wp_customize->add_section( 'static_front_page', array(
        'title'          => esc_html__( 'Front Page Settings', 'nemi' ),
        'priority'       => 120,
        'description'    => esc_html__( 'Your theme supports a static front page.', 'nemi'),
    ) );

    $wp_customize->add_setting( 'pbr_theme_options[sidebar_position]', array(
        'default' => 'left',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'pbr_theme_options[sidebar_position]', array(
        'type' => 'radio',
        'label' => 'Sidebar Position',
        'section' => 'static_front_page',
        'priority' => 1,
        'choices' => array(
            'left' => 'Left',
            'right' => 'Right',
        ),
    ) );

    $wp_customize->add_setting( 'show_on_front', array(
        'default'        => get_option( 'show_on_front' ),
        'capability'     => 'manage_options',
        'type'           => 'option',
        //  'theme_supports' => 'static-front-page',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'show_on_front', array(
        'label'   => esc_html__( 'Front page displays', 'nemi' ),
        'section' => 'static_front_page',
        'type'    => 'radio',
        'choices' => array(
            'posts' => esc_html__( 'Your latest posts', 'nemi' ),
            'page'  => esc_html__( 'A static page', 'nemi' ),
        ),
    ) );

    $wp_customize->add_setting( 'page_on_front', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'page_on_front', array(
        'label'      => esc_html__( 'Front page', 'nemi' ),
        'section'    => 'static_front_page',
        'type'       => 'dropdown-pages',
    ) );

    $wp_customize->add_setting( 'page_for_posts', array(
        'type'           => 'option',
        'capability'     => 'manage_options',
        //  'theme_supports' => 'static-front-page',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'page_for_posts', array(
        'label'      => esc_html__( 'Posts page', 'nemi' ),
        'section'    => 'static_front_page',
        'type'       => 'dropdown-pages',
    ) );

    /*
     /*****************************************************************
     * Front Page Settings Panel
     *****************************************************************/
    $wp_customize->add_section( 'pages_setting', array(
        'title'          => esc_html__( 'Pages Settings', 'nemi' ),
        'priority'       => 120,
        'description'    => esc_html__( 'Your theme supports a static front page.', 'nemi'),
    ) );

    // 404 setting
    $wp_customize->add_setting( 'pbr_theme_options[404_post]', array(
        'type'           => 'option',
        'capability'     => 'manage_options',
        'default'        => ''   ,
        'sanitize_callback' => 'sanitize_text_field'
        //  'theme_supports' => 'static-front-page',
    ) );

    $wp_customize->add_control( 'pbr_theme_options[404_post]', array(
        'label'      => esc_html__( '404 Page', 'nemi' ),
        'section'    => 'pages_setting',
        'type'       => 'dropdown-pages',
    ) );

    // Page setting sidebar
    $wp_customize->add_setting( 'pbr_theme_options[page-left-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[page-left-sidebar]', array(
        'settings'  => 'pbr_theme_options[page-left-sidebar]',
        'label'     => esc_html__('Page Left Sidebar', 'nemi'),
        'section'   => 'pages_setting'
    ) ) );

    $wp_customize->add_setting( 'pbr_theme_options[page-right-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[page-right-sidebar]', array(
        'settings'  => 'pbr_theme_options[page-right-sidebar]',
        'label'     => esc_html__('Page Right Sidebar', 'nemi'),
        'section'   => 'pages_setting'
    ) ) );
}

function nemi_fnc_social_config( $wp_customize, $id, $name_social, $section){
    $wp_customize->add_setting('pbr_theme_options['.$id.']', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 1,
        'checked' => 1,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('pbr_theme_options['.$id.']', array(
        'settings'  => 'pbr_theme_options['.$id.']',
        'label'     => $name_social,
        'section'   => $section,
        'type'      => 'checkbox',
        'transport' => 4,
    ) );
}

add_action( 'customize_register', 'nemi_fnc_blog_settings' );
function nemi_fnc_blog_settings( $wp_customize ){

    $wp_customize->add_panel( 'panel_blog', array(
        'priority' => 80,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Blog & Post', 'nemi' ),
        'description' =>esc_html__( 'Make default setting for page, general', 'nemi' ),
    ) );

    /**
     * General Setting
     */
    $wp_customize->add_section( 'blog_general_settings', array(
        'priority' => 10,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'General Setting', 'nemi' ),
        'description' => '',
        'panel' => 'panel_blog',
    ) );

    /**
     * Archive Setting
     */
    $wp_customize->add_section( 'archive_general_settings', array(
        'priority' => 11,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Archive & Categgory Setting', 'nemi' ),
        'description' => '',
        'panel' => 'panel_blog',
    ) );

    $wp_customize->add_setting('pbr_theme_options[blog-archive-column]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '1',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'pbr_theme_options[blog-archive-column]', array(
        'label'      => esc_html__( 'Select column', 'nemi' ),
        'section'    => 'archive_general_settings',
        'type'       => 'select',
        'choices'     => array(
            '1' => esc_html__('1 column', 'nemi' ),
            '2' => esc_html__('2 columns', 'nemi' ),
            '3' => esc_html__('3 columns', 'nemi' ),
            '4' => esc_html__('4 columns', 'nemi' ),
            '6' => esc_html__('6 columns', 'nemi' ),
        )
    ) );

      ///  Archive layout setting
    $wp_customize->add_setting( 'pbr_theme_options[blog-archive-layout]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 'mainright',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Nemi_Layout_DropDown( $wp_customize, 'pbr_theme_options[blog-archive-layout]', array(
        'settings'  => 'pbr_theme_options[blog-archive-layout]',
        'label'     => esc_html__('Archive Layout', 'nemi'),
        'section'   => 'archive_general_settings',
        'priority' => 1

    ) ) );




    $wp_customize->add_setting( 'pbr_theme_options[blog-archive-left-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 'blog-sidebar-left',
        'sanitize_callback' => 'sanitize_text_field'
    ) );


    $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize, 'pbr_theme_options[blog-archive-left-sidebar]', array(
        'settings'  => 'pbr_theme_options[blog-archive-left-sidebar]',
        'label'     => esc_html__('Archive Left Sidebar', 'nemi'),
        'section'   => 'archive_general_settings' ,
         'priority' => 2
    ) ) );

     ///
    $wp_customize->add_setting( 'pbr_theme_options[blog-archive-right-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 'blog-sidebar-right',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize, 'pbr_theme_options[blog-archive-right-sidebar]', array(
        'settings'  => 'pbr_theme_options[blog-archive-right-sidebar]',
        'label'     => esc_html__('Archive Right Sidebar', 'nemi'),
        'section'   => 'archive_general_settings',
         'priority' => 2
    ) ) );

    /**
     * Single post Setting
     */
    $wp_customize->add_section( 'blog_single_settings', array(
        'priority' => 12,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Single post Setting', 'nemi' ),
        'description' => '',
        'panel' => 'panel_blog',
    ) );


    $wp_customize->add_setting('pbr_theme_options[blog-show-share-post]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 0,
        'checked' => 0,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('pbr_theme_options[blog-show-share-post]', array(
        'settings'  => 'pbr_theme_options[blog-show-share-post]',
        'label'     => esc_html__('Show share post', 'nemi'),
        'section'   => 'blog_single_settings',
        'type'      => 'checkbox',
        'transport' => 4,
    ) );

    $wp_customize->add_setting('pbr_theme_options[blog-show-related-post]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => 1,
        'checked' => 1,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control('pbr_theme_options[blog-show-related-post]', array(
        'settings'  => 'pbr_theme_options[blog-show-related-post]',
        'label'     => esc_html__('Show related post', 'nemi'),
        'section'   => 'blog_single_settings',
        'type'      => 'checkbox',
        'transport' => 4,
    ) );


    $wp_customize->add_setting( 'pbr_theme_options[blog-items-show]', array(
        'type'       => 'option',
        'default'    => 4,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'pbr_theme_options[blog-items-show]', array(
        'label'      => esc_html__( 'Number of related posts to show', 'nemi' ),
        'section'    => 'blog_single_settings',
        'type'       => 'select',
        'choices'     => array(
            '2' => esc_html__('2 posts', 'nemi' ),
            '3' => esc_html__('3 posts', 'nemi' ),
            '4' => esc_html__('4 posts', 'nemi' ),
            '6' => esc_html__('6 posts', 'nemi' ),
        )
    ) );

    /// single layout setting
    $wp_customize->add_setting( 'pbr_theme_options[blog-single-layout]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Nemi_Layout_DropDown( $wp_customize,  'pbr_theme_options[blog-single-layout]', array(
        'settings'  => 'pbr_theme_options[blog-single-layout]',
        'label'     => esc_html__('Single Blog Layout', 'nemi'),
        'section'   => 'blog_single_settings'
    ) ) );

    $wp_customize->add_setting( 'pbr_theme_options[blog-single-left-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[blog-single-left-sidebar]', array(
        'settings'  => 'pbr_theme_options[blog-single-left-sidebar]',
        'label'     => esc_html__('Single blog Left Sidebar', 'nemi'),
        'section'   => 'blog_single_settings'
    ) ) );

    $wp_customize->add_setting( 'pbr_theme_options[blog-single-right-sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[blog-single-right-sidebar]', array(
        'settings'  => 'pbr_theme_options[blog-single-right-sidebar]',
        'label'     => esc_html__('Single blog Right Sidebar', 'nemi'),
        'section'   => 'blog_single_settings'
    ) ) );

}

/**
 * Sanitize the Featured Content layout value.
 *
 * @since Nemi 1.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (grid|slider).
 */
function nemi_fnc_sanitize_layout( $layout ) {
	if ( ! in_array( $layout, array( 'grid', 'slider' ) ) ) {
		$layout = 'grid';
	}

	return $layout;
}

/**
 * Bind JS handlers to make Customizer preview reload changes asynchronously.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_customize_preview_js() {
	wp_enqueue_script( 'nemi_fnc_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'nemi_fnc_customize_preview_js' );

/**
 * Add contextual help to the Themes and Post edit screens.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_contextual_help() {
	if ( 'admin_head-edit.php' === current_filter() && 'post' !== $GLOBALS['typenow'] ) {
		return;
	}

	get_current_screen()->add_help_tab( array(
		'id'      => 'nemi',
		'title'   => esc_html__( 'Nemi', 'nemi' ),
		'content' =>
			'<ul>' .
				'<li>' . sprintf( wp_kses_post( __( 'The home page features your choice of up to 6 posts prominently displayed in a grid or slider, controlled by a <a href="%1$s">tag</a>; you can change the tag and layout in <a href="%2$s">Appearance &rarr; Customize</a>. If no posts match the tag, <a href="%3$s">sticky posts</a> will be displayed instead.', 'nemi' ) ), esc_url( add_query_arg( 'tag', _x( 'featured', 'featured content default tag slug', 'nemi' ), admin_url( 'edit.php' ) ) ), admin_url( 'customize.php' ), admin_url( 'edit.php?show_sticky=1' ) ) . '</li>' .
				'<li>' . sprintf( wp_kses_post( __( 'Enhance your site design by using <a href="%s">Featured Images</a> for posts you&rsquo;d like to stand out (also known as post thumbnails). This allows you to associate an image with your post without inserting it. Cropshop uses featured images for posts and pages&mdash;above the title&mdash;and in the Featured Content area on the home page.', 'nemi' ) ), 'https://codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail' ) . '</li>' .
				'<li>' . sprintf( wp_kses_post( __( 'For an in-depth tutorial, and more tips and tricks, visit the <a href="%s">Nemi documentation</a>.', 'nemi' ) ), 'http://engotheme.com/guides/nemi/' ) . '</li>' .
			'</ul>',
	) );
}
add_action( 'admin_head-themes.php', 'nemi_fnc_contextual_help' );
add_action( 'admin_head-edit.php',   'nemi_fnc_contextual_help' );
