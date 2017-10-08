<section id="pbr-topbar" class="pbr-topbar">
	<div class="container">
        <div class="topbar-inner d_grid d_grid_4">

            <?php if( is_user_logged_in() ){ ?>

                <?php $current_user = wp_get_current_user(); ?>

                <div class="tp_user-login text-center">
                    <span class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" title="<?php esc_html_e( 'Welcome', 'nemi' ); ?> <?php echo esc_html( $current_user->display_name); ?> !" aria-expanded="false">
                        <span><?php esc_html_e( 'Welcome', 'nemi' ); ?> <?php echo esc_html( $current_user->display_name); ?> !</span>
                    </span>
                </div>
            <?php } else { ?>
                <div class="tp_user-login text-center">
                    <span class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" title="login">
                        <i class="icon-user icons"></i>
                    </span>
                    <div class="dropdown-menu">
                        <ul>
                            <?php do_action('opal-account-buttons'); ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>

            <nav data-duration="<?php echo nemi_fnc_theme_options('megamenu-duration',400); ?>" class="pbr-megamenu <?php echo nemi_fnc_theme_options('magemenu-animation','slide'); ?> animate navbar navbar-mega">                 
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

            <div id="search-container" class="tp_search">
                <?php get_search_form(); ?>                        
            </div>
            
    	</div>
    </div>	
</section>