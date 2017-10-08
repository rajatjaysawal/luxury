<?php

 /**
  * Register Woocommerce Vendor which will register list of shortcodes
  */
function nemi_fnc_init_vc_vendors(){
	
	$vendor = new Nemi_VC_News();
	add_action( 'vc_after_set_mode', array(
		$vendor,
		'load'
	), 99 );


	$vendor = new Nemi_VC_Theme();
	add_action( 'vc_after_set_mode', array(
		$vendor,
		'load'
	), 99 );

	$vendor = new Nemi_VC_Elements();
	add_action( 'vc_after_set_mode', array(
		$vendor,
		'load'
	), 99 );

	
}
add_action( 'after_setup_theme', 'nemi_fnc_init_vc_vendors' , 99 );   

/**
 * Add parameters for row
 */
function nemi_fnc_add_params(){

 	/**
	 * add new params for row
	 */
	vc_add_param( 'vc_row', array(
	    "type" => "checkbox",
	    "heading" => esc_html__("Parallax", 'nemi'),
	    "param_name" => "parallax",
	    "value" => array(
	        'Yes, please' => true
	    )
	));

	$row_class =  array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Background Styles', 'nemi' ),
        'param_name' => 'bgstyle',
        'description'	=> esc_html__('Use Styles Supported In Theme, Select No Use For Customizing on Tab Design Options', 'nemi'),
        'value' => array(
			esc_html__( 'No Use', 'nemi' ) => '',
			esc_html__( 'Background Color Primary', 'nemi' ) => 'bg-primary',
			esc_html__( 'Background Color Info', 'nemi' ) 	 => 'bg-info',
			esc_html__( 'Background Color Danger', 'nemi' )  => 'bg-danger',
			esc_html__( 'Background Color Warning', 'nemi' ) => 'bg-warning',
			esc_html__( 'Background Color Success', 'nemi' ) => 'bg-success',
			esc_html__( 'Background Color Theme', 'nemi' ) 	 => 'bg-theme',
		    esc_html__( 'Background Image 1 Dark', 'nemi' ) => 'bg-style-v1',
			esc_html__( 'Background Image 2 Dark', 'nemi' ) => 'bg-style-v2',
			esc_html__( 'Background Image 3 Blue', 'nemi' ) => 'bg-style-v3',
			esc_html__( 'Background Image 4 Red', 'nemi' ) => 'bg-style-v4',
        )
    ) ;

	vc_add_param( 'vc_row', $row_class );
	vc_add_param( 'vc_row_inner', $row_class );
 

	 vc_add_param( 'vc_row', array(
	     "type" => "dropdown",
	     "heading" => esc_html__("Is Boxed", 'nemi'),
	     "param_name" => "isfullwidth",
	     "value" => array(
	     				esc_html__('Yes, Boxed', 'nemi') => '1',
	     				esc_html__('No, Wide', 'nemi') => '0'
	     			)
	));

	vc_add_param( 'vc_row', array(
	    "type" => "textfield",
	    "heading" => esc_html__("Icon", 'nemi'),
	    "param_name" => "icon",
	    "value" => '',
		'description'	=> esc_html__( 'This support display icon from FontAwsome, Please click', 'nemi' )
						. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://fortawesome.github.io/Font-Awesome/" target="_blank">'
						. esc_html__( 'here to see the list, and use class icons-lg, icons-md, icons-sm to change its size', 'nemi' ) . '</a>'
	));
	// add param for image elements

	 vc_add_param( 'vc_single_image', array(
	     "type" => "textarea",
	     "heading" => esc_html__("Image Description", 'nemi'),
	     "param_name" => "description",
	     "value" => "",
	     'priority'	
	));
}
add_action( 'after_setup_theme', 'nemi_fnc_add_params', 99 );
 
 /** 
  * Replace pagebuilder columns and rows class by bootstrap classes
  */
function nemi_wpo_change_bootstrap_class( $class_string,$tag ){
 
	if ($tag=='vc_column' || $tag=='vc_column_inner') {
		$class_string = preg_replace('/vc_span(\d{1,2})/', 'col-md-$1', $class_string);
		$class_string = preg_replace('/vc_hidden-(\w)/', 'hidden-$1', $class_string);
		$class_string = preg_replace('/vc_col-(\w)/', 'col-$1', $class_string);
		$class_string = str_replace('wpb_column', '', $class_string);
		$class_string = str_replace('column_container', '', $class_string);
	}
	return $class_string;
}

/*add_filter( 'vc_shortcodes_css_class', 'nemi_wpo_change_bootstrap_class',10,2);*/