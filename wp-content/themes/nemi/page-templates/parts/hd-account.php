<?php if( is_user_logged_in() ){ ?>

    <?php $current_user = wp_get_current_user(); ?>

    <div class="tp_user-login text-center">
        <span class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" title="<?php esc_html_e( 'Welcome', 'nemi' ); ?> <?php echo esc_html( $current_user->display_name); ?> !">
            <span><?php esc_html_e( 'Welcome', 'nemi' ); ?> <?php echo esc_html( $current_user->display_name); ?> !</span>
        </span>
        <div class="dropdown-menu">
            <?php
                $args = array(
                    'theme_location'  => 'tpaccount',
                    'menu_class'      => 'tp_account',
                    'fallback_cb'     => '',
                    'menu_id'         => ''
                );
                wp_nav_menu($args);
            ?>                     
        </div>
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

<div class="tp_wishlist text-center">
    <?php
        $args = array(
            'theme_location'  => 'topmenu',
            'menu_class'      => 'pbr-menu-top',
            'fallback_cb'     => '',
            'menu_id'         => 'main-topmenu'
        );
        wp_nav_menu($args);
    ?> 
</div>