<?php

function nemi_fnc_import_remote_demos() { 
	return array(
		'nemi' => array( 
         'name'      => 'nemi',  
         'source'    => 'http://demo.themeocean.net/nemi/nemi.zip',
         'preview'   => 'http://demo.themeocean.net/nemi/screenshot.png'
      ),
	);
}

add_filter( 'pbrthemer_import_remote_demos', 'nemi_fnc_import_remote_demos' );



function nemi_fnc_import_theme() {
	return 'nemi';
}
add_filter( 'pbrthemer_import_theme', 'nemi_fnc_import_theme' );

function nemi_fnc_import_demos() {
	$folderes = glob( get_template_directory().'/inc/import/*', GLOB_ONLYDIR ); 

	$output = array(); 

	foreach( $folderes as $folder ){
		$output[basename( $folder )] = basename( $folder );
	}
 	
 	return $output;
}
add_filter( 'pbrthemer_import_demos', 'nemi_fnc_import_demos' );

function nemi_fnc_import_types() {
	return array(
			'all'          => 'All',
			'content'      => 'Content',
			'widgets'      => 'Widgets',
			'page_options' => 'Theme + Page Options',
			'menus'        => 'Menus',
			'rev_slider'   => 'Revolution Slider',
			'vc_templates' => 'VC Templates'
		);
}
add_filter( 'pbrthemer_import_types', 'nemi_fnc_import_types' );


/**
 * Matching and resizing images with url.
 *
 *  $ouput = array(
 *        'allowed' => 1, // allow resize images via using GD Lib php to generate image
 *        'height'  => 900,
 *        'width'   => 800,
 *        'file_name' => 'blog_demo.jpg'
 *   ); 
 */
function nemi_import_attachment_image_size( $url ){  

   $name = basename( $url );   
 
   $ouput = array(
         'allowed' => 0
   );     
   
   if( preg_match("#product#", $name) ) {
      $ouput = array(
         'allowed'   => 1,
         'height'    => 950,
         'width'     => 730,
         'file_name' => 'product_demo.jpg'
      ); 
   }
   elseif( preg_match("#blog#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 685,
         'width'   => 1170,
         'file_name' => 'blog_demo.jpg'
      ); 
   }
   elseif( preg_match("#testimonial#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 500,
         'width'   => 500,
         'file_name' => 'testimonial_demo.png'
      ); 
   }
   elseif( preg_match("#team#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 370,
         'width'   => 270,
         'file_name' => 'team_demo.jpg'
      ); 
   }

   elseif( preg_match("#slide#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 590,
         'width'   => 1170,
         'file_name' => 'slide_demo.jpg'
      ); 
   }

   return $ouput;
}

add_filter( 'pbrthemer_import_attachment_image_size', 'nemi_import_attachment_image_size' , 1 , 999 );