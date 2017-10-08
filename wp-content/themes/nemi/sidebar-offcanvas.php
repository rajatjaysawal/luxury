<div id="pbr-off-canvas" class="pbr-off-canvas sidebar-offcanvas"> 
    <div class="pbr-off-canvas-body">
        <div class="offcanvas-head">
            <button type="button" class="btn btn-offcanvas btn-toggle-canvas" data-toggle="offcanvas">
                  <i class="fa fa-close"></i> 
             </button>
             <span><?php esc_html_e( 'Menu', 'nemi' ); ?></span>
        </div>
         
        <nav class="navbar navbar-offcanvas navbar-static">
            <?php
            $args = array(  'theme_location' => 'primary',
                            'container_class' => 'navbar-collapse navbar-offcanvas-collapse',
                            'menu_class' => 'nav navbar-nav',
                            'fallback_cb' => '',
                            'menu_id'         => 'main-menu-offcanvas',
                            
            );

            if( class_exists("PBR_Megamenu_Offcanvas") ){
                $args['walker'] = new PBR_Megamenu_Offcanvas();
            }
            wp_nav_menu($args);
            ?>
        </nav>  
        

    </div>
</div>