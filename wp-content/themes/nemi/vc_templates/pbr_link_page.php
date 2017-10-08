<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $title_align 
 * @var $descript
 * @var $size
 * @var $font_color
 * @var $el_class 
 * @var $heading_style 
 * Shortcode class
 * @var $this WPBakeryShortCode_pbr_link_page
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>

<div class="pbr-page-link <?php echo esc_attr( $el_class ); ?>">
	<?php if($title!=''): ?>
        <h3 class="widget-heading <?php echo esc_attr( isset( $style ) ? ' ' . $style : '' ) ?>" <?php if($font_color!=''): ?> style="color: <?php echo esc_attr( $font_color ); ?>;"<?php endif; ?>>
           <a href="<?php echo esc_url( get_permalink( get_page_by_path( $page_link ) ) ); ?>">
                <span><span class="sub"><?php echo esc_attr( $sub_title ); ?></span> <?php echo esc_attr( $title ); ?></span>
           </a>
        </h3>
    <?php endif; ?>
</div>