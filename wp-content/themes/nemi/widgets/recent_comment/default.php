<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Themeocean Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 http://engotheme.com/. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://engotheme.com/
 * @support  http://engotheme.com.
 */
// Display the widget title
if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}
?>

<div class="comment-widget widget-content">
    <?php
    $number = $instance['number_comment'];
    $all_comments = get_comments( array('status' => 'approve', 'number'=>$number) );
    if(is_array( $all_comments)){
        foreach($all_comments as $comment) { ?>
        <article class="clearfix media">
            <div class="avatar-comment-widget pull-left">
                <?php echo get_avatar($comment, '60'); ?>
            </div>
            <div class="content-comment-widget media-body">
                <h6>
                    <?php echo strip_tags($comment->comment_author); ?> <?php esc_html_e('says', 'nemi' ); ?>:
                </h6>
                <a class="comment-text-side" href="<?php echo esc_url( get_permalink($comment->ID) ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo esc_html( $comment->post_title ); ?>">
                    <?php echo nemi_pbr_string_limit_words(strip_tags($comment->comment_content), 12); ?>...
                </a>
            </div>
        </article>
    <?php } 
    } ?>
</div>