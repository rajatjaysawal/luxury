<nav data-duration="<?php echo nemi_fnc_theme_options('megamenu-duration',400); ?>" class="pbr-megamenu <?php echo nemi_fnc_theme_options('magemenu-animation','slide'); ?> animate navbar navbar-mega">
	    
        <button aria-expanded="true" data-target=".navbar-mega-collapse" data-toggle="collapse" type="button" class="navbar-toggle hidden">
		    <span class="sr-only">Toggle navigation</span>
		    <span class="icon-menu icons"></span>
	  	</button>
 
         
	    <?php
	        $args = array(  'theme_location'  => 'headermenu',
	                        'container_class' => 'collapse navbar-collapse navbar-mega-collapse',
	                        'menu_class'      => 'nav navbar-nav headermenu',
	                        'fallback_cb'     => '',
	                        'menu_id'         => 'headermenu',
                     );
	        if(class_exists('PBR_bootstrap_navwalker')){
	        	$args['walker'] = new PBR_bootstrap_navwalker();
        	}
	        wp_nav_menu($args);
	    ?>
</nav>