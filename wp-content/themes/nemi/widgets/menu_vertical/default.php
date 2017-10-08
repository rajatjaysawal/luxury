<?php
$nav_menu = ( $menu !='' ) ? wp_get_nav_menu_object( $menu ) : false;


if(!$nav_menu) return false;
$postion_class = ($position=='left')?'menu-left':'menu-right';
$args = array(  'menu' => $nav_menu,
                'container_class' => 'navbar-collapse navbar-ex1-collapse vertical-menu '.$postion_class,
                'menu_class' => 'nav navbar-nav megamenu',
                'fallback_cb' => ''
        );

if(class_exists('PBR_bootstrap_navwalker')){
	$args['walker'] = new PBR_bootstrap_navwalker($nav_menu->term_id);
}

if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}
?>
<?php wp_nav_menu($args); ?>
<style type="text/css">
<?php
	$posts = wp_get_nav_menu_items($menu);
	foreach($posts as $post){
		if(!empty( $post->megamenu_profile )){
			 $shortcodes_custom_css = get_post_meta( $post->megamenu_profile, '_wpb_shortcodes_custom_css', true );
			if ( ! empty( $shortcodes_custom_css ) ) {
			     echo esc_attr( $shortcodes_custom_css );
			}
		}
	}
?>
</style>