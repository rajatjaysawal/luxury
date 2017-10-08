<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb )) {

	$delimiter = '<span></span>';

	

	$end = '' ;
	$title = '';
	$html = '';

	foreach ( $breadcrumb as $key => $crumb ) {

		$html .= trim($before);
		$html .= '<li>';

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			$html .= '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			$html .= esc_html( $crumb[0] );
		}

		
		if( is_product() && ! empty( $crumb[1] ) && sizeof( $breadcrumb ) == $key + 2 ) {
			$title = esc_html( $crumb[0] );
			$_tag = 'h2'; 
		} else if(is_shop() || is_product_category() || is_product_tag() ){
			$title = esc_html( $crumb[0] );
			$_tag = 'h1';
		}

		$html .= trim($after);
		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			$html .= trim( $delimiter );
		}
		$html .= '</li>';

		$end = esc_html( $crumb[0] );
	}
	echo trim($wrap_before);

		printf('<li class="active"><'.$_tag.' class="title-active page-title">%s</'.$_tag.'></li>', $title);

		echo trim($html);
		
	echo trim($wrap_after);

}