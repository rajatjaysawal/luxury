<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<div class="products products-<?php if ( isset($_GET['display']) && $_GET['display'] == 'list' ) { ?>list<?php }else{ ?>grid<?php } ?>">