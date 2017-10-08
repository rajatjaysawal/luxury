<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     ENGOTHEME Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 engotheme.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://engotheme.com
 * @support  http://engotheme.com.
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $wp_query, $post, $woocommerce;
$children_cat = array();
$_total = 0;
$parent_cat = get_terms( 'product_cat', array( 'fields' => 'ids', 'parent' => 0, 'hierarchical' => false, 'hide_empty' => false ) );
$i =0;
?>

<div class="widget pbr-category-list <?php echo (($el_class!='')?' '.$el_class:''); ?>">
    <div class="widget-content">
        <?php if( !empty($title)): ?>
            <h3 class="widget-title">
                <span><?php echo esc_attr( $title ); ?></span>
            </h3>
        <?php endif; ?>
        <div class="category-filter-content" id="pbr-accordion-categories" role="tablist" aria-multiselectable="true">
        <ul>
        <?php if ( !empty($parent_cat) && !is_wp_error($parent_cat) ):
                foreach( $parent_cat as $cat_id ):
                    $i++;
                    $term = get_term( $cat_id, 'product_cat' );
                    $args = array(
                      'taxonomy'     => 'product_cat',
                      'child_of'     => 0,
                      'parent'       => $cat_id
                    );
                    $sub_cats = get_categories( $args );
                    $_total = $term->count;
                    if( $sub_cats && !empty($sub_cats)) {
                        foreach($sub_cats as $sub){
                            $_total += $sub->count;
                        }
                    }
                    if($_total > 0):
                        $category_link = get_term_link( $term->term_id, 'product_cat' );
        ?>
                <!-- <div class="panel panel-default"> -->
                    <li class="category-title" role="tab" id="category-<?php echo esc_attr($cat_id); ?>">
                        <a href="<?php echo esc_url( $category_link); ?>"><?php echo esc_attr( $term->name ); ?>
                            <?php if($show_count){ ?>
                                <span class="total-product"><?php echo '( '.$_total.' )';?></span>
                            <?php } ?>
                        </a>
                        <?php if($show_dropdown && $show_children && !empty($sub_cats) ){ ?>
                            <a class="collapsed dropdown" data-toggle="collapse" data-parent="#pbr-accordion-categories" href="#collapse-<?php echo esc_attr($cat_id); ?>" aria-expanded="true" aria-controls="collapse-<?php echo esc_attr($cat_id); ?>">
                                <i class="fa fa-plus"></i>
                            </a>
                        <?php } ?>
                        <?php if($show_children){
                            if( $sub_cats && !empty($sub_cats)){ ?>
                            <ul id="collapse-<?php echo esc_attr($cat_id); ?>" class="panel-collapse collapse <?php echo ($i==1?'in':''); ?> " role="tabpanel" aria-labelledby="category-<?php echo esc_attr($cat_id); ?>">
                            <?php
                                foreach($sub_cats as $cat):
                                    $cat_link = get_term_link( $cat->slug, 'product_cat' );
                                    if( $cat->count > 0 ): ?>
                                          <li class="category-title">
                                            <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_attr( $cat->name ); ?>
                                            <?php if($show_count){ ?>
                                                <span class="total-product"><?php echo '( '.$cat->count.' )';?></span>
                                            <?php } ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;
                                endforeach; ?>
                            </ul>
                            <?php
                                }
                            }
                        ?>
                    </li>
                    
                <!-- </div> -->
            <?php
                    endif;
                endforeach;
            endif; 
            ?>
            </ul>
        </div>
    </div>
</div>
