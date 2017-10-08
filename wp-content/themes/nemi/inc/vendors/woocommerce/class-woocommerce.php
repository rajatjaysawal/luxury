<?php
/**
 * Class Cropshop Woocommerce
 *
 */
class Nemi_Woocommerce{

    /**
     * Constructor to create an instance of this for processing logics render content and modules.
     */
	public function __construct(){
		add_action( 'customize_register',  array( $this, 'registerCustomizer' ), 9 );
        add_action( 'wp_enqueue_scripts', array( $this, 'loadThemeStyles' ), 15 );


        if( nemi_fnc_theme_options('is-quickview',true) ){
            add_action( 'wp_ajax_nemi_quickview', array($this,'quickview') );
            add_action( 'wp_ajax_nopriv_nemi_quickview', array($this,'quickview') );
            add_action( 'wp_footer', array($this,'quickviewModal') );
	    }

        if( nemi_fnc_theme_options( 'is-swap-effect',true ) ){
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', array( __CLASS__, 'swapImages' ),10);

        }

        //Remove link after button add to cart
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    }

    /**
     * Enable product swap image
     *
     * @static
     * @access public
     * @since Nemi 1.0
     */
    public static function swapImages(){
        global $post, $product, $woocommerce, $thumbsize;

        $placeholder_width = get_option('shop_catalog_image_size');
        $placeholder_width = $placeholder_width['width'];

        $placeholder_height = get_option('shop_catalog_image_size');
        $placeholder_height = $placeholder_height['height'];

        $output = '';
        $class = 'image-no-effect';
        $image_size = apply_filters( 'nemi_woo_shop_loop_item_image_size', 'shop_catalog' );
        if(!empty($thumbsize) && function_exists('wpb_getImageBySize')){
            $post_thumbnail = wpb_getImageBySize( array( 'post_id' => $post->ID, 'thumb_size' => $thumbsize ) );
            $output .= $post_thumbnail['thumbnail'];
        }elseif(has_post_thumbnail()){
            $attachment_ids = $product->get_gallery_image_ids();
            if ($attachment_ids && isset($attachment_ids[0])) {
                $class = 'image-hover';
                $output .= wp_get_attachment_image($attachment_ids[0], $image_size, false, array('class'=>"attachment-shop_catalog image-effect"));
            }
            $output .= get_the_post_thumbnail( $post->ID, $image_size, array( 'class'=>$class ) );
        } else {
            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'.esc_html__('Placeholder' , 'nemi').'" class="'.$class.'" width="'.$placeholder_width.'" height="'.$placeholder_height.'" />';
        }
        echo trim($output);
    }

    /**
     * Load woocommerce styles follow theme skin actived
     *
     * @static
     * @access public
     * @since Nemi 1.0
     */
    public function loadThemeStyles() {
        $current = nemi_fnc_theme_options( 'skin','default' );
        if($current == 'default'){
            $path =  get_template_directory_uri() .'/css/woocommerce.css';
        }else{
            $path =  get_template_directory_uri() .'/css/skins/'.$current.'/woocommerce.css';
        }
        wp_enqueue_style( 'nemi-woocommerce', $path , 'nemi-woocommerce-front' , NEMI, 'all' );
    }

	/**
	 * Add settings to the Customizer.
	 *
	 * @static
	 * @access public
	 * @since Nemi 1.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public function registerCustomizer( $wp_customize ){
		$wp_customize->add_panel( 'panel_woocommerce', array(
    		'priority' => 70,
    		'capability' => 'edit_theme_options',
    		'theme_supports' => '',
    		'title' => esc_html__( 'Woocommerce', 'nemi' ),
    		'description' =>esc_html__( 'Make default setting for page, general', 'nemi' ),
    	) );

        /**
         * General Setting
         */
        $wp_customize->add_section( 'wc_general_settings', array(
            'priority' => 1,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'General Setting', 'nemi' ),
            'description' => '',
            'panel' => 'panel_woocommerce',
        ) );

        //config mini cart
        $wp_customize->add_setting('pbr_theme_options[woo-show-minicart]', array(
            'capability' => 'manage_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('pbr_theme_options[woo-show-minicart]', array(
            'settings'  => 'pbr_theme_options[woo-show-minicart]',
            'label'     => esc_html__('Enable Mini Basket', 'nemi'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox'
        ) );


        $wp_customize->add_setting('pbr_theme_options[is-quickview]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('pbr_theme_options[is-quickview]', array(
            'settings'  => 'pbr_theme_options[is-quickview]',
            'label'     => esc_html__('Enable QuickView', 'nemi'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 4,
        ) );



        $wp_customize->add_setting('pbr_theme_options[is-swap-effect]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('pbr_theme_options[is-swap-effect]', array(
            'settings'  => 'pbr_theme_options[is-swap-effect]',
            'label'     => esc_html__('Enable Swap Image', 'nemi'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 4,
        ) );

        $wp_customize->add_setting('pbr_theme_options[fillter-producttype]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('pbr_theme_options[fillter-producttype]', array(
            'settings'  => 'pbr_theme_options[fillter-producttype]',
            'label'     => esc_html__('Enable Fillter Product Type', 'nemi'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 5,
        ) );

        $wp_customize->add_setting('pbr_theme_options[product-perpage]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

         $wp_customize->add_control('pbr_theme_options[product-perpage]', array(
            'settings'  => 'pbr_theme_options[product-perpage]',
            'label'     => esc_html__('Enable Product Per Page', 'nemi'),
            'section'   => 'wc_general_settings',
            'type'      => 'checkbox',
            'transport' => 6,
        ) );

        /**
         * Archive Page Setting
         */
        $wp_customize->add_section( 'wc_archive_settings', array(
            'priority' => 2,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Archive Page Setting', 'nemi' ),
            'description' => 'Configure categories, search, shop page setting',
            'panel' => 'panel_woocommerce',
        ) );

         ///  Archive layout setting
        $wp_customize->add_setting( 'pbr_theme_options[woocommerce-archive-layout]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'mainright',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Nemi_Layout_DropDown( $wp_customize,  'pbr_theme_options[woocommerce-archive-layout]', array(
            'settings'  => 'pbr_theme_options[woocommerce-archive-layout]',
            'label'     => esc_html__('Archive Layout', 'nemi'),
            'section'   => 'wc_archive_settings',
            'priority' => 1

        ) ) );

       //sidebar archive left
        $wp_customize->add_setting( 'pbr_theme_options[woocommerce-archive-left-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-left',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[woocommerce-archive-left-sidebar]', array(
            'settings'  => 'pbr_theme_options[woocommerce-archive-left-sidebar]',
            'label'     => esc_html__('Archive Left Sidebar', 'nemi'),
            'section'   => 'wc_archive_settings' ,
             'priority' => 3
        ) ) );

          //sidebar archive right
        $wp_customize->add_setting( 'pbr_theme_options[woocommerce-archive-right-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-right',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[woocommerce-archive-right-sidebar]', array(
            'settings'  => 'pbr_theme_options[woocommerce-archive-right-sidebar]',
            'label'     => esc_html__('Archive Right Sidebar', 'nemi'),
            'section'   => 'wc_archive_settings',
             'priority' => 4
        ) ) );

        //number product per page
        $wp_customize->add_setting( 'pbr_theme_options[woo-number-page]', array(
            'type'       => 'option',
            'default'    => 12,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control( 'pbr_theme_options[woo-number-page]', array(
            'label'      => esc_html__( 'Number of Products Per Page', 'nemi' ),
            'section'    => 'wc_archive_settings',
            'priority' => 6
        ) );

        //number product per row
        $wp_customize->add_setting( 'pbr_theme_options[wc_itemsrow]', array(
            'type'       => 'option',
            'default'    => 4,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'pbr_theme_options[wc_itemsrow]', array(
            'label'      => esc_html__( 'Number of Products Per Row', 'nemi' ),
            'section'    => 'wc_archive_settings',
            'type'       => 'select',
            'choices'     => array(
                '2' => esc_html__('2 Items', 'nemi' ),
                '3' => esc_html__('3 Items', 'nemi' ),
                '4' => esc_html__('4 Items', 'nemi' ),
                '6' => esc_html__('6 Items', 'nemi' ),
            ),
            'priority' => 7
        ) );

        /*
         * Custom Breadcrumb Image
         */
         $wp_customize->add_setting('pbr_theme_options[wc-banner]', array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'manage_options',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pbr_theme_options[wc-banner]', array(
            'label'    => esc_html__('Top Banner', 'nemi'),
            'section'  => 'wc_archive_settings',
            'settings' => 'pbr_theme_options[wc-banner]',
            'priority' => 8,
        ) ) );


        /**
    	 * Product Single Setting
    	 */
    	$wp_customize->add_section( 'wc_product_settings', array(
    		'priority' => 12,
    		'capability' => 'edit_theme_options',
    		'theme_supports' => '',
    		'title' => esc_html__( 'Single Product Page Setting', 'nemi' ),
    		'description' => 'Configure single product page',
    		'panel' => 'panel_woocommerce',
    	) );
        ///  single layout setting
        $wp_customize->add_setting( 'pbr_theme_options[woocommerce-single-layout]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'mainright',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Select layout
        $wp_customize->add_control( new Nemi_Layout_DropDown( $wp_customize,  'pbr_theme_options[woocommerce-single-layout]', array(
            'settings'  => 'pbr_theme_options[woocommerce-single-layout]',
            'label'     => esc_html__('Product Detail Layout', 'nemi'),
            'section'   => 'wc_product_settings',
            'priority' => 1
        ) ) );


        $wp_customize->add_setting( 'pbr_theme_options[woocommerce-single-left-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Sidebar left
        $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[woocommerce-single-left-sidebar]', array(
            'settings'  => 'pbr_theme_options[woocommerce-single-left-sidebar]',
            'label'     => esc_html__('Product Detail Left Sidebar', 'nemi'),
            'section'   => 'wc_product_settings',
            'priority' => 2
        ) ) );

        $wp_customize->add_setting( 'pbr_theme_options[woocommerce-single-right-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-right',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        // Sidebar right
        $wp_customize->add_control( new Nemi_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[woocommerce-single-right-sidebar]', array(
            'settings'  => 'pbr_theme_options[woocommerce-single-right-sidebar]',
            'label'     => esc_html__('Product Detail Right Sidebar', 'nemi'),
            'section'   => 'wc_product_settings',
            'priority' => 3
        ) ) );

        // Product Header Layout Version
        $wp_customize->add_setting( 'pbr_theme_options[woocommerce-single-header-layout]', array(
            'capability'        => 'edit_theme_options',
            'type'              => 'option',
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control( new Nemi_Header_Layout_DropDown( $wp_customize,  'pbr_theme_options[woocommerce-single-header-layout]', array(
            'settings'  => 'pbr_theme_options[woocommerce-single-header-layout]',
            'label'     => esc_html__('Product Header Layout', 'nemi'),
            'section'   => 'wc_product_settings',
            'priority'  => 3
        ) ) );

        //Show related product
        $wp_customize->add_setting('pbr_theme_options[wc_show_related]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 0,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('pbr_theme_options[wc_show_related]', array(
            'settings'  => 'pbr_theme_options[wc_show_related]',
            'label'     => esc_html__('Disable show related product', 'nemi'),
            'section'   => 'wc_product_settings',
            'type'      => 'checkbox',
            'priority' => 4
        ) );
         //Show upsells product
        $wp_customize->add_setting('pbr_theme_options[wc_show_upsells]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 0,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('pbr_theme_options[wc_show_upsells]', array(
            'settings'  => 'pbr_theme_options[wc_show_upsells]',
            'label'     => esc_html__('Disable show upsells product', 'nemi'),
            'section'   => 'wc_product_settings',
            'type'      => 'checkbox',
            'transport' => 3,
            'priority' => 5
        ) );

        //number of product per row
        $wp_customize->add_setting( 'pbr_theme_options[product-number-columns]', array(
            'type'       => 'option',
            'default'    => 3,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'pbr_theme_options[product-number-columns]', array(
            'label'      => esc_html__( 'Number of Product Per Row', 'nemi' ),
            'section'    => 'wc_product_settings',
            'type'       => 'select',
            'choices'     => array(
                '2' => esc_html__('2 Items', 'nemi' ),
                '3' => esc_html__('3 Items', 'nemi' ),
                '4' => esc_html__('4 Items', 'nemi' ),
                '5' => esc_html__('5 Items', 'nemi' ),
                '6' => esc_html__('6 Items', 'nemi' )
            ),
            'priority' => 6
        ) );

        //Number of product to show
        $wp_customize->add_setting( 'pbr_theme_options[woo-number-product-single]', array(
            'type'       => 'option',
            'default'	 => 6,
            'capability' => 'manage_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 'pbr_theme_options[woo-number-product-single]', array(
            'label'      => esc_html__( 'Number of Products to Show', 'nemi' ),
            'section'    => 'wc_product_settings',
            'priority' => 7
        ) );

        //Show Social share product
        $wp_customize->add_setting('pbr_theme_options[wc_show_share_social]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control('pbr_theme_options[wc_show_share_social]', array(
            'settings'  => 'pbr_theme_options[wc_show_share_social]',
            'label'     => esc_html__('Show Social share product', 'nemi'),
            'section'   => 'wc_product_settings',
            'type'      => 'checkbox',
            'priority' => 8
        ) );
	}

    public function quickview(){
        $args = array(
                'post_type'=>'product',
                'product'=>$_GET['productslug']
            );
        $query = new WP_Query($args);
        if($query->have_posts()){
            while($query->have_posts()): $query->the_post(); $product = wc_get_product( get_the_ID() ); ?>
                <?php
                    add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'print_wishlist_button' ), 34 );
                    if ( class_exists( 'YITH_Woocompare' ) ) {
                        global $yith_woocompare;
                        add_action( 'woocommerce_after_add_to_cart_form', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
                    }
                ?>
                <div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
                    <div id="single-product" class="product-info woocommerce">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <?php
                                    /**
                                     * woocommerce_before_single_product_summary hook
                                     *
                                     * @hooked woocommerce_show_product_sale_flash - 10
                                     * @hooked woocommerce_show_product_images - 20
                                     */
                                    //do_action( 'woocommerce_before_single_product_summary' );
                                    wc_get_template( 'single-product/product-image-carousel.php' );
                                ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="summary entry-summary">
                                    <?php
                                        /**
                                        * woocommerce_single_product_summary hook
                                        *
                                        * @hooked woocommerce_template_single_title - 5
                                        * @hooked woocommerce_template_single_rating - 10
                                        * @hooked woocommerce_template_single_price - 10
                                        * @hooked woocommerce_template_single_excerpt - 20
                                        * @hooked woocommerce_template_single_add_to_cart - 30
                                        * @hooked woocommerce_template_single_meta - 40
                                        * @hooked woocommerce_template_single_sharing - 50
                                        */
                                        woocommerce_template_single_title();
                                        woocommerce_template_single_rating();
                                        printf( _n( '(%s review)', '(%s reviews)', $product->get_review_count(), 'nemi' ), '<span itemprop="reviewCount" class="count">' . $product->get_review_count() . '</span>' );
                                        woocommerce_template_single_price();
                                        woocommerce_template_single_excerpt();
                                        woocommerce_template_single_add_to_cart();
                                        ?>
                                    <?php
                                        woocommerce_template_single_meta();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- #product-<?php the_ID(); ?> -->
                <?php
                    remove_action( 'woocommerce_after_add_to_cart_form', array( $this, 'print_wishlist_button' ), 34 );
                    if ( class_exists( 'YITH_Woocompare' ) ) {
                        global $yith_woocompare;
                        remove_action( 'woocommerce_after_add_to_cart_form', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
                    }
                ?>
            <?php endwhile;
        }


            wp_reset_postdata();
        die;
    }

    public function print_wishlist_button() {
        if( class_exists( 'YITH_WCWL' ) ) {
            echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
        }
    }

    public function quickviewModal(){
    ?>
    <div class="modal fade" id="pbr-quickview-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btn btn-close" data-dismiss="modal" aria-hidden="true">
                        <i class="icon-close icons"></i>
                    </button>
                </div>
                <div class="modal-body"><span class="spinner"></span></div>
            </div>
        </div>
    </div>

    <?php
    }
}

new Nemi_Woocommerce();