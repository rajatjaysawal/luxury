<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Engotheme Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 engotheme.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://engotheme.com
 * @support  http://engotheme.com.
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( ! isset( $category ) ) {
	return;
}
$term = get_term_by( 'slug', $category, 'product_cat' );

if ( ! $term ) return;

if( isset( $image ) ) {
    $image = wp_get_attachment_image_src( $image, 'full' );
} else {
    $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
    $image = wp_get_attachment_image_src( $thumbnail_id, 'full');
}

?>

<div class="widget <?php echo (($el_class!='')?' '.esc_attr( $el_class ):''); ?>">
    <div class="widget-content">
        <div class="ocean-woo-category<?php echo esc_attr( isset( $style_image ) ? ' ' . $style_image : '' ) ?> <?php echo esc_attr( isset( $effect_image ) ? ' ' . $effect_image : '' ) ?>">
            <?php if ( isset( $image[0] ) && $image[0] ) : ?>
        	<header class="entry-header">
        		<a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ) ?>">
        			<img src="<?php echo esc_url_raw( $image[0] ); ?>" alt="<?php echo esc_attr($term->name); ?>" title="<?php echo esc_attr($term->name); ?>" />
        		</a>
        	</header>
            <?php endif; ?>

        	<div class="entry-body">
        		<div class="inner">
                    <h3 class="title"><?php echo esc_html( $term->name ); ?></h3>
                    
                    <?php if ( isset( $content )  && $content) : ?>
                        <span class="sub-title"><?php echo trim( $content ); ?></span>
                    <?php endif; ?>    

                    <?php if ( isset( $desc )  && $desc) : ?>
                        <div class="desc"><?php echo esc_html( $desc ) ?></div>
                    <?php endif; ?>      
                </div>

	        	<?php if ( isset( $button ) && $button ) : ?>
	        		<a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ) ?>" class="btn btn-category"><?php esc_html_e( 'DISCOVERY', 'nemi' ); ?></a>
	        	<?php endif; ?>
        	</div>
        </div>
    </div>
</div>