
<?php if( $title){ ?>
<h3 class="widget-title"><span><?php echo trim($title); ?></span></h3>
<?php } ?>
<ul class="social list-inline">
    <?php foreach( $socials as $key=>$social):
            if( isset($social['status']) && !empty($social['page_url']) ): ?>
                <li>
                    <a href="<?php echo esc_url($social['page_url']);?>" class="<?php echo esc_attr($key); ?>">
                        <i class="fa fa-<?php echo esc_attr($key); ?> bo-social-<?php echo esc_attr($key); ?>"></i> <!-- <span><?php echo trim($social['name']); ?></span> -->
                    </a>
                </li>
    <?php
            endif;
        endforeach;
    ?>
</ul>