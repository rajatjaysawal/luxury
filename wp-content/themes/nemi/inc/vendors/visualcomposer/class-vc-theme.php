<?php 

class Nemi_VC_Theme implements Vc_Vendor_Interface {

	public function load(){
		

		/*********************************************************************************************************************
		 *  Vertical menu
		 *********************************************************************************************************************/
		$option_menu  = array(); 
		if( is_admin() ){
			$menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
		    $option_menu = array('---Select Menu---'=>'');
		    foreach ($menus as $menu) {
		    	$option_menu[$menu->name]=$menu->term_id;
		    }
		}    
		vc_map( array(
		    "name" => esc_html__("PBR Quick Links Menu", 'nemi'),
		    "base" => "pbr_quicklinksmenu",
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'nemi'),
		    'description'	=> esc_html__( 'Show Quick Links To Access', 'nemi'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'nemi'),
					"param_name" => "title",
					"value" => 'Quick To Go'
				),
		    	array(
					"type" => "dropdown",
					"heading" => esc_html__("Menu", 'nemi'),
					"param_name" => "menu",
					"value" => $option_menu,
					"description" => esc_html__("Select menu.", 'nemi')
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
		 *  Vertical menu
		 *********************************************************************************************************************/
	 
		vc_map( array(
		    "name" => esc_html__("PBR Vertical MegaMenu", 'nemi'),
		    "base" => "pbr_verticalmenu",
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'nemi'),
		    "params" => array(

		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'nemi'),
					"param_name" => "title",
					"value" => 'Vertical Menu',
					"admin_label"	=> true
				),

		    	array(
					"type" => "dropdown",
					"heading" => esc_html__("Menu", 'nemi'),
					"param_name" => "menu",
					"value" => $option_menu,
					"description" => esc_html__("Select menu.", 'nemi')
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Position", 'nemi'),
					"param_name" => "postion",
					"value" => array(
							'left'=>'left',
							'right'=>'right'
						),
					'std' => 'left',
					"description" => esc_html__("Postion Menu Vertical.", 'nemi')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'nemi'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
				)
		   	)
		));
		 
		vc_map( array(
		    "name" => esc_html__("Fixed Show Vertical Menu ", 'nemi'),
		    "base" => "pbr_verticalmenu_show",
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'nemi'),
		    "description" => esc_html__( 'Always showing vertical menu on top', 'nemi' ),
		    "params" => array(
		  
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'nemi'),
					"param_name" => "title",
					"description" => esc_html__("When enabled vertical megamenu widget on main navition and its menu content will be showed by this module. This module will work with header:Martket, Market-V2, Market-V3" , 'nemi')
				)
		   	)
		));
		
	 

		/* Heading Text Block
		---------------------------------------------------------- */
		vc_map( array(
			'name'        => esc_html__( 'PBR Widget Heading', 'nemi'),
			'base'        => 'pbr_title_heading',
			"class"       => "",
			"category" => esc_html__('PBR Widgets', 'nemi'),
			'description' => esc_html__( 'Create title for one Widget', 'nemi' ),
			"params"      => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'nemi' ),
					'param_name' => 'title',
					'value'       => esc_html__( 'Title', 'nemi' ),
					'description' => esc_html__( 'Enter heading title.', 'nemi' ),
					"admin_label" => true
				),
				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Title Color', 'nemi' ),
				    'param_name' => 'font_color',
				    'description' => esc_html__( 'Select font color', 'nemi' )
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Heading Style", 'nemi'),
					"param_name" => "heading_style",
					'value' 	=> array(
						esc_html__('Default', 'nemi') => 'default', 
						esc_html__('Small', 'nemi') => 'small',
						esc_html__('Extra Small', 'nemi') => 'extrasmall',
					),
					'std' => ''
				),
				 
				array(
					"type" => "textarea",
					'heading' => esc_html__( 'Description', 'nemi' ),
					"param_name" => "descript",
					"value" => '',
					'description' => esc_html__( 'Enter description for title.', 'nemi' )
			    ),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'nemi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi' )
				)
			),
		));
		
		/* Heading Text Block
		---------------------------------------------------------- */
		vc_map( array(
			'name'        => esc_html__( 'PBR Banner CountDown', 'nemi'),
			'base'        => 'pbr_banner_countdown',
			"class"       => "",
			"category" => esc_html__('PBR Widgets', 'nemi'),
			'description' => esc_html__( 'Show CountDown with banner', 'nemi' ),
			"params"      => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'nemi' ),
					'param_name' => 'title',
					'value'       => esc_html__( 'Title', 'nemi' ),
					'description' => esc_html__( 'Enter heading title.', 'nemi' ),
					"admin_label" => true
				),


				array(
					"type" => "attach_image",
					"description" => esc_html__("If you upload an image, icon will not show.", 'nemi'),
					"param_name" => "image",
					"value" => '',
					'heading'	=> esc_html__('Image', 'nemi' )
				),


				array(
				    'type' => 'textfield',
				    'heading' => esc_html__( 'Date Expired', 'nemi' ),
				    'param_name' => 'input_datetime',
				    'description' => esc_html__( 'Select font color', 'nemi' ),
				),
				 

				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Title Color', 'nemi' ),
				    'param_name' => 'font_color',
				    'description' => esc_html__( 'Select font color', 'nemi' ),
				    'class'	=> 'hacongtien'
				),
				 
				array(
					"type" => "textarea",
					'heading' => esc_html__( 'Description', 'nemi' ),
					"param_name" => "descript",
					"value" => '',
					'description' => esc_html__( 'Enter description for title.', 'nemi' )
			    ),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'nemi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi' )
				),


				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Text Link', 'nemi' ),
					'param_name' => 'text_link',
					'value'		 => 'Find Out More',
					'description' => esc_html__( 'Enter your link text', 'nemi' )
				),


				
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Link', 'nemi' ),
					'param_name' => 'link',
					'value'		 => 'http://',
					'description' => esc_html__( 'Enter your link to redirect', 'nemi' )
				)
			),
		));

		$allpages = array( esc_html__( ' --- Do not show --- ', 'nemi' ) => '' );
		if ( is_admin() ) {
			$args = array(
				'sort_order' => 'desc',
				'sort_column' => 'date',
				'post_type' => 'page',
				'post_status' => 'publish'
			); 
			$pages = get_pages($args);
			if ( !empty($pages) ) {
				foreach ($pages as $page) {
					$allpages[$page->post_title] = $page->post_name;
				}
			}
		}

		/* PBR Link Page
		---------------------------------------------------------- */
		vc_map( array(
			'name'        => esc_html__( 'PBR Link Page', 'nemi'),
			'base'        => 'pbr_link_page',
			"class"       => "",
			"category" => esc_html__('PBR Widgets', 'nemi'),
			'description' => esc_html__( 'Create Banner with link to page', 'nemi' ),
			"params"      => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'nemi' ),
					'param_name' => 'title',
					'value'       => esc_html__( 'Title', 'nemi' ),
					'description' => esc_html__( 'Enter heading title.', 'nemi' ),
					"admin_label" => true
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Sub title', 'nemi' ),
					'param_name' => 'sub_title',
					'value'       => esc_html__( 'Sub Title', 'nemi' ),
					'description' => esc_html__( 'Enter heading title.', 'nemi' ),
					"admin_label" => true
				),
				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Title Color', 'nemi' ),
				    'param_name' => 'font_color',
				    'description' => esc_html__( 'Select font color', 'nemi' )
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'nemi'),
					"param_name" => "style",
					'value' 	=> array(
						esc_html__('none', 'nemi') => 'none',
						esc_html__('style 1', 'nemi') => 'style_v1',
						esc_html__('style 2', 'nemi') => 'style_v2',
					),

					'std' => ''
				),
				array(
						"type" => "dropdown",
						"heading" => esc_html__("Page link", 'nemi'),
						"param_name" => "page_link",
						"value" => $allpages,
						"admin_label" => true,
						"description" => esc_html__("Select a page link.", 'nemi')
					),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'nemi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi' )
				)
			),
		));

	}
}