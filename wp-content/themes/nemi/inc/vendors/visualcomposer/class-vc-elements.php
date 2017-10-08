<?php
class Nemi_VC_News implements Vc_Vendor_Interface  {

	public function load(){

		$newssupported = true;

			/**********************************************************************************
			 * Front Page Posts
			 **********************************************************************************/

		// front page 9
		vc_map( array(
			'name' => esc_html__( '(News) FrontPage 9', 'nemi' ),
			'base' => 'pbr_frontpageposts9',
			'icon' => 'icon-wpb-news-9',
			"category" => esc_html__('PBR Widgets', 'nemi'),
			'description' => esc_html__( 'Create Post having blog styles', 'nemi' ),

			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'nemi' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'nemi' ),
					"admin_label" => true
				),

				array(
					'type' => 'loop',
					'heading' => esc_html__( 'Grids content', 'nemi' ),
					'param_name' => 'loop',
					'settings' => array(
						'size' => array( 'hidden' => false, 'value' => 4 ),
						'order_by' => array( 'value' => 'date' ),
					),
					'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'nemi' )
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Grid Columns", 'nemi'),
					"param_name" => "grid_columns",
					"value" => array( 1 , 2 , 3 , 4 , 5 , 6),
					"std" => 1
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination Links', 'nemi' ),
					'param_name' => 'show_pagination',
					'description' => esc_html__( 'Enables to show paginations to next new page.', 'nemi' ),
					'value' => array( esc_html__( 'Yes, please', 'nemi' ) => 'yes' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Thumbnail size', 'nemi' ),
					'param_name' => 'thumbsize',
					'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'nemi' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'nemi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi' )
				)
			)
		) );


		vc_map( array(
			'name' => esc_html__( '(News) FrontPage 3', 'nemi' ),
			'base' => 'pbr_frontpageposts3',
			'icon' => 'icon-wpb-news-3',
			"category" => esc_html__('PBR Widgets', 'nemi'),
			'description' => esc_html__( 'Create Post having blog styles', 'nemi' ),

			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'nemi' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'nemi' ),
					"admin_label" => true
				),



				array(
					'type' => 'loop',
					'heading' => esc_html__( 'Grids content', 'nemi' ),
					'param_name' => 'loop',
					'settings' => array(
						'size' => array( 'hidden' => false, 'value' => 4 ),
						'order_by' => array( 'value' => 'date' ),
					),
					'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'nemi' )
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Number Main Posts", 'nemi'),
					"param_name" => "num_mainpost",
					'std' => '1',
			        "description" => esc_html__("", 'nemi')

				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination Links', 'nemi' ),
					'param_name' => 'show_pagination',
					'description' => esc_html__( 'Enables to show paginations to next new page.', 'nemi' ),
					'value' => array( esc_html__( 'Yes, please', 'nemi' ) => 'yes' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Thumbnail size', 'nemi' ),
					'param_name' => 'thumbsize',
					'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'nemi' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'nemi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi' )
				)
			)
		) );

		vc_map( array(
			'name' => esc_html__( '(News) FrontPage 4', 'nemi' ),
			'base' => 'pbr_frontpageposts4',
			'icon' => 'icon-wpb-news-4',
			"category" => esc_html__('PBR Widgets', 'nemi'),
			'description' => esc_html__( 'Create Post having blog styles', 'nemi' ),

			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'nemi' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'nemi' ),
					"admin_label" => true
				),

				array(
					'type' => 'loop',
					'heading' => esc_html__( 'Grids content', 'nemi' ),
					'param_name' => 'loop',
					'settings' => array(
						'size' => array( 'hidden' => false, 'value' => 4 ),
						'order_by' => array( 'value' => 'date' ),
					),
					'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'nemi' )
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination Links', 'nemi' ),
					'param_name' => 'show_pagination',
					'description' => esc_html__( 'Enables to show paginations to next new page.', 'nemi' ),
					'value' => array( esc_html__( 'Yes, please', 'nemi' ) => 'yes' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Thumbnail size', 'nemi' ),
					'param_name' => 'thumbsize',
					'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'nemi' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'nemi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi' )
				)
			)
		) );

	}
}

class Nemi_VC_Elements implements Vc_Vendor_Interface {

	public function load(){

		/*********************************************************************************************************************
		 *  Our Service
		 *********************************************************************************************************************/
		vc_map( array(
		    "name" => esc_html__("PBR Featured Box", 'nemi'),
		    "base" => "pbr_featuredbox",

		    "description"=> esc_html__('Decreale Service Info', 'nemi'),
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'nemi'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'nemi'),
					"param_name" => "title",
					"value" => '',    "admin_label" => true,
				),
				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Title Color', 'nemi' ),
				    'param_name' => 'title_color',
				    'description' => esc_html__( 'Select font color', 'nemi' )
				),

		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Sub Title", 'nemi'),
					"param_name" => "subtitle",
					"value" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'nemi'),
					"param_name" => "style",
					'value' 	=> array(
						esc_html__('Default', 'nemi') => 'default',
						esc_html__('Version 1', 'nemi') => 'v1',
						esc_html__('Version 2', 'nemi') => 'v2',
						esc_html__('Version 3', 'nemi' )=> 'v3',
						esc_html__('Version 4', 'nemi') => 'v4'
					),
					'std' => ''
				),

				array(
					"type" => "attach_image",
					"heading" => esc_html__("Background Image", 'nemi'),
					"param_name" => "background",
					"value" => '',
					'description'	=> esc_html__('Select background image for element', 'nemi')
				),

				array(
					'type'                           => 'dropdown',
					'heading'                        => esc_html__( 'Title Alignment', 'nemi' ),
					'param_name'                     => 'title_align',
					'value'                          => array(
					esc_html__( 'Align left', 'nemi' )   => 'separator_align_left',
					esc_html__( 'Align center', 'nemi' ) => 'separator_align_center',
					esc_html__( 'Align right', 'nemi' )  => 'separator_align_right'
					),
					'std' => 'separator_align_left'
				),

			 	array(
					"type" => "textfield",
					"heading" => esc_html__("FontAwsome Icon", 'nemi'),
					"param_name" => "icon",
					"value" => 'fa fa-gear',
					'description'	=> esc_html__( 'This support display icon from FontAwsome, Please click', 'nemi' )
									. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://fortawesome.github.io/Font-Awesome/" target="_blank">'
									. esc_html__( 'here to see the list', 'nemi' ) . '</a>'
				),
				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Icon Color', 'nemi' ),
				    'param_name' => 'color',
				    'description' => esc_html__( 'Select font color', 'nemi' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Background Icon', 'nemi' ),
					'param_name' => 'background',
					'value' => array(
						esc_html__( 'None', 'nemi' ) => 'nostyle',
						esc_html__( 'Success', 'nemi' ) => 'bg-success',
						esc_html__( 'Info', 'nemi' ) => 'bg-info',
						esc_html__( 'Danger', 'nemi' ) => 'bg-danger',
						esc_html__( 'Warning', 'nemi' ) => 'bg-warning',
						esc_html__( 'Light', 'nemi' ) => 'bg-default',
					),
					'std' => 'nostyle',
				),

				array(
					"type" => "attach_image",
					"heading" => esc_html__("Photo", 'nemi'),
					"param_name" => "photo",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textarea",
					"heading" => esc_html__("information", 'nemi'),
					"param_name" => "information",
					"value" => 'Your Description Here',
					'description'	=> esc_html__('Allow  put html tags', 'nemi' )
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'nemi'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
				)
		   	)
		));

	   	/*********************************************************************************************************************
		 * Pricing Table
		 *********************************************************************************************************************/
		vc_map( array(
		    "name" => esc_html__("PBR Pricing", 'nemi'),
		    "base" => "pbr_pricing",
		    "description" => esc_html__('Make Plan for membership', 'nemi' ),
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'nemi'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'nemi'),
					"param_name" => "title",
					"value" => '',
						"admin_label" => true
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Price", 'nemi'),
					"param_name" => "price",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Currency", 'nemi'),
					"param_name" => "currency",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Period", 'nemi'),
					"param_name" => "period",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Subtitle", 'nemi'),
					"param_name" => "subtitle",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Is Featured", 'nemi'),
					"param_name" => "featured",
					'value' 	=> array(  esc_html__('No', 'nemi') => 0,  esc_html__('Yes', 'nemi') => 1 ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Skin", 'nemi'),
					"param_name" => "skin",
					'value' 	=> array(  esc_html__('Skin 1', 'nemi') => 'v1',  esc_html__('Skin 2', 'nemi') => 'v2', esc_html__('Skin 3', 'nemi') => 'v3' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Box Style", 'nemi'),
					"param_name" => "style",
					'value' 	=> array( 'boxed' => esc_html__('Boxed', 'nemi')),
				),

				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Content", 'nemi'),
					"param_name" => "content",
					"value" => '',
					'description'	=> esc_html__('Allow  put html tags', 'nemi')
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Title", 'nemi'),
					"param_name" => "linktitle",
					"value" => 'SignUp',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Link", 'nemi'),
					"param_name" => "link",
					"value" => 'http://yourdomain.com',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'nemi'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
				)
		   	)
		));


 		/*********************************************************************************************************************
		 *  PBR Counter
		 *********************************************************************************************************************/
		vc_map( array(
		    "name" => esc_html__("PBR Counter", 'nemi'),
		    "base" => "pbr_counter",
		    "class" => "",
		    "description"=> esc_html__('Counting number with your term', 'nemi'),
		    "category" => esc_html__('PBR Widgets', 'nemi'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'nemi'),
					"param_name" => "title",
					"value" => '',
					"admin_label"	=> true
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Description", 'nemi'),
					"param_name" => "description",
					"value" => '',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Number", 'nemi'),
					"param_name" => "number",
					"value" => ''
				),

			 	array(
					"type" => "textfield",
					"heading" => esc_html__("FontAwsome Icon", 'nemi'),
					"param_name" => "icon",
					"value" => '',
					'description'	=> esc_html__( 'This support display icon from FontAwsome, Please click', 'nemi' )
									. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://fortawesome.github.io/Font-Awesome/" target="_blank">'
									. esc_html__( 'here to see the list', 'nemi' ) . '</a>'
				),


				array(
					"type" => "attach_image",
					"description" => esc_html__("If you upload an image, icon will not show.", 'nemi'),
					"param_name" => "image",
					"value" => '',
					'heading'	=> esc_html__('Image', 'nemi' )
				),



				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Text Color", 'nemi'),
					"param_name" => "text_color",
					'value' 	=> '',
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'nemi'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
				)
		   	)
		));


 		/*********************************************************************************************************************
		 *  Social Links
		 *********************************************************************************************************************/
		vc_map( array(
			'name'        => esc_html__( 'PBR Social Links', 'nemi'),
			'base'        => 'pbr_social_links',
			"class"       => "",
			"category" => esc_html__('PBR Widgets', 'nemi'),
			'description' => esc_html__( 'Show social link for site', 'nemi' ),
			"params"      => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'nemi' ),
					'param_name' => 'title',
					'value'       => esc_html__( 'Find us on social networks', 'nemi' ),
					'description' => esc_html__( 'Enter heading title.', 'nemi' ),
					"admin_label" => true
				),
				//facebook
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show Facebook", 'nemi'),
	                "param_name" => "show_facebook",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => true
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Facebook", 'nemi'),
					"param_name" => "link_facebook",
					"value" => "",
					'std' => 'https://www.facebook.com/engotheme',
					'description' => esc_html__('Facebook page url. Example: https://www.facebook.com/engotheme', 'nemi')
				),
				//instagram
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show Instagram", 'nemi'),
	                "param_name" => "show_instagram",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => true
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Instagram", 'nemi'),
					"param_name" => "link_instagram",
					"value" => "",
					'std' => 'https://www.instagram.com/engotheme',
					'description' => esc_html__('Facebook page url. Example: https://www.instagram.com/engotheme', 'nemi')
				),
				//Youtube
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show Youtube", 'nemi'),
	                "param_name" => "show_youtube",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => true
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Youtube ", 'nemi'),
					"param_name" => "link_youtube",
					"value" => "",
					'description' => esc_html__('Insert the YouTube link. Example: https://www.youtube.com/user/engotheme', 'nemi'),
					'std' => 'https://www.youtube.com/user/engotheme'
				),
				//tumblr
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show Tumblr", 'nemi'),
	                "param_name" => "show_tumblr",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => true
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Tumblr ", 'nemi'),
					"param_name" => "link_tumblr",
					"value" => "",
					'description' => esc_html__('Insert the YouTube link. Example: https://www.tumblr.com/engotheme', 'nemi'),
					'std' => 'https://www.tumblr.com/engotheme'
				),
				//twitter
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show Twitter", 'nemi'),
	                "param_name" => "show_twitter",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => true
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Twitter", 'nemi'),
					"param_name" => "link_twitter",
					"value" => "",
					'std' => 'https://twitter.com/engotheme',
					'description'	=> esc_html__('Insert the Twitter link. Example: https://twitter.com/engotheme', 'nemi')
				),
				//Pinterest
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show Pinterest", 'nemi'),
	                "param_name" => "show_pinterest",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => true
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Pinterest ", 'nemi'),
					"param_name" => "link_pinterest",
					"value" => "",
					'std' => 'https://www.pinterest.com/engotheme/',
					'description' => esc_html__('Insert the Pinterest link. Example: https://www.youtube.com/user/engotheme', 'nemi'),
				),

				//Google plus
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show Google plus", 'nemi'),
	                "param_name" => "show_google_plus",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => true
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Google plus", 'nemi'),
					"param_name" => "link_google_plus",
					"value" => "#",
					'std' => 'https://plus.google.com/+WPOpal',
					'description' => esc_html__('Insert the Pinterest link. Example: https://plus.google.com/+WPOpal', 'nemi'),
				),

				// LinkedIn
				array(
	                "type" => "checkbox",
	                "heading" => esc_html__("Show LinkedIn", 'nemi'),
	                "param_name" => "show_linkedIn",
	                "value" => array(
	                    esc_html__('Yes, please', 'nemi') => true
	                ),
	                'std' => false
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link LinkedIn", 'nemi'),
					"param_name" => "link_linkedIn",
					"value" => "#",
					'description' => esc_html__('Insert the Pinterest link. Example: https://www.linkedin.com/pub/opal-wordpress/67/a25/565', 'nemi'),
					'std' => 'https://www.linkedin.com/pub/opal-wordpress/67/a25/565'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'nemi'),
					"param_name" => "style",
					'value' 	=> array(
						esc_html__('Style v1', 'nemi') => 'style-1',
						esc_html__('Style v2', 'nemi') => 'style-2'
					),
					'std' => 'style-1'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'nemi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi' )
				),

			),
		));

	}
}



require_once  vc_path_dir('SHORTCODES_DIR', 'vc-posts-grid.php')  ;
class WPBakeryShortCode_PBR_Frontpageposts3 extends WPBakeryShortCode_VC_Posts_Grid {}
class WPBakeryShortCode_PBR_frontpageposts4 extends WPBakeryShortCode_VC_Posts_Grid {}
class WPBakeryShortCode_PBR_frontpageposts9 extends WPBakeryShortCode_VC_Posts_Grid {}


/**
 * Elements
 */
class WPBakeryShortCode_Pbr_featuredbox  extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_pricing 	 extends WPBakeryShortCode {}
/**
 * Themes
 */
class WPBakeryShortCode_Pbr_title_heading   extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_verticalmenu extends WPBakeryShortCode {}

class WPBakeryShortCode_Pbr_banner_countdown extends WPBakeryShortCode {}
class WPBakeryShortCode_pbr_social_links extends WPBakeryShortCode {}

class WPBakeryShortCode_pbr_counter extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_Link_Page extends WPBakeryShortCode {}