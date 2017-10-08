<?php
if( class_exists("WPBakeryShortCode") ) {
	/**
	 * Class Nemi_VC_Woocommerces
	 *
	 */
	class Nemi_VC_Woocommerce implements Vc_Vendor_Interface {

		/**
		 * register and mapping shortcodes
		 */
		public function product_category_field_search( $search_string ) {
			$data = array();
			$vc_taxonomies_types = array('product_cat');
			$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string
			) );
			if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
				foreach ( $vc_taxonomies as $t ) {
					if ( is_object( $t ) ) {
						$data[] = vc_get_term_object( $t );
					}
				}
			}
			return $data;
		}

		public function product_category_render($query) {
			$category = get_term_by('id', (int)$query['value'], 'product_cat');
			if ( ! empty( $query ) && !empty($category)) {
				$data = array();
				$data['value'] = $category->term_id;
				$data['label'] = $category->name;
				return ! empty( $data ) ? $data : false;
			}
			return false;
		}

		/**
		 * register and mapping shortcodes
		 */
		public function load(){

			$shortcodes = array( 'pbr_products', 'pbr_products_collection', 'pbr_product_categories', 'pbr_product_categories_tab');

			foreach( $shortcodes as $shortcode ){
				add_filter( 'vc_autocomplete_'. $shortcode .'_categories_callback', array($this, 'product_category_field_search'), 10, 1 );
			 	add_filter( 'vc_autocomplete_'. $shortcode .'_categories_render', array($this, 'product_category_render'), 10, 1 );
			}

			$order_by_values = array(
				'',
				esc_html__( 'Date', 'nemi' ) => 'date',
				esc_html__( 'ID', 'nemi' ) => 'ID',
				esc_html__( 'Author', 'nemi' ) => 'author',
				esc_html__( 'Title', 'nemi' ) => 'title',
				esc_html__( 'Modified', 'nemi' ) => 'modified',
				esc_html__( 'Random', 'nemi' ) => 'rand',
				esc_html__( 'Comment count', 'nemi' ) => 'comment_count',
				esc_html__( 'Menu order', 'nemi' ) => 'menu_order',
			);

			$order_way_values = array(
				'',
				esc_html__( 'Descending', 'nemi' ) => 'DESC',
				esc_html__( 'Ascending', 'nemi' ) => 'ASC',
			);
			$product_categories_dropdown = array(''=> esc_html__('None', 'nemi') );
			$block_styles = nemi_fnc_get_widget_block_styles();

			$product_columns_deal = array(1, 2, 3, 4);

			$options = array(
                esc_html__( 'Latest Product', 'nemi' ) 		=> 'recent_products',
                esc_html__( 'Sale Product', 'nemi' )   		=>'sale_products',
                esc_html__( 'Featured Product', 'nemi' ) 	=> 'featured_products',
                esc_html__( 'Best Selling', 'nemi' ) 		=> 'best_selling_products',
                esc_html__( 'Top Rate', 'nemi' ) 			=> 'top_rate',
            ); 

			if( is_admin() ){
					$args = array(
						'type' => 'post',
						'child_of' => 0,
						'parent' => '',
						'orderby' => 'name',
						'order' => 'ASC',
						'hide_empty' => false,
						'hierarchical' => 1,
						'exclude' => '',
						'number' => '',
						'taxonomy' => 'product_cat',
						'pad_counts' => false,

					);

					$categories = get_categories( $args );
					nemi_fnc_woocommerce_getcategorychilds( 0, $categories, 0, $product_categories_dropdown );

			}
		    vc_map( array(
		        "name" => esc_html__("PBR Product Deals", 'nemi'),
		        "base" => "pbr_product_deals",
		        "class" => "",
		    	"category" => esc_html__('PBR Woocommerce', 'nemi'),
		    	'description'	=> esc_html__( 'Display Product Sales with Count Down', 'nemi' ),
		        "params" => array(
		            array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Title', 'nemi'),
		                "param_name" => "title",
		            ),

		             array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Sub Title', 'nemi'),
		                "param_name" => "subtitle",
		            ),

		            array(
		                "type" => "textfield",
		                "heading" => esc_html__("Extra class name", 'nemi'),
		                "param_name" => "el_class",
		                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
		            ),
		            array(
		                "type" => "textfield",
		                "heading" => esc_html__("Number items to show", 'nemi'),
		                "param_name" => "number",
		                'std' => '1',
		                "description" => esc_html__("", 'nemi')
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__("Columns count", 'nemi'),
		                "param_name" => "columns_count",
		                "value" => $product_columns_deal,
		                'std' => '2',
		                "description" => esc_html__("Select columns count.", 'nemi')
		            ),
		            array(
		                "type" => "dropdown",
		                "heading" => esc_html__("Layout", 'nemi'),
		                "param_name" => "layout",
		                "value" => array(esc_html__('Carousel', 'nemi') => 'carousel', esc_html__('Grid', 'nemi') =>'grid' ),
		                "admin_label" => true,
		                "description" => esc_html__("Select columns count.", 'nemi')
		            )
		        )
		    ));

		    ////
		    vc_map( array(
		        "name" => esc_html__( "PBR Products On Sale", 'nemi' ),
		        "base" => "pbr_products_onsale",
		        "class" => "",
		    	"category" => esc_html__( 'PBR Woocommerce', 'nemi' ),
		    	'description'	=> esc_html__( 'Display Products Sales With Pagination', 'nemi' ),
		        "params" => array(
		            array(
		                "type" 		  => "textfield",
		                "class" 	  => "",
		                "heading" 	  => esc_html__( 'Title', 'nemi' ),
		                "param_name"  => "title",
		                "admin_label" => true
		            ),
		             array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Sub Title', 'nemi'),
		                "param_name" => "subtitle",
		            ),
		            array(
		                "type" => "textfield",
		                "heading" => esc_html__("Number items to show", 'nemi'),
		                "param_name" => "number",
		                'std' => '9',
		                "description" => esc_html__("", 'nemi'),
		                  "admin_label" => true
		            ),
		             array(
		                "type" 		  => "dropdown",
		                "heading" 	  => esc_html__( "Columns count", 'nemi' ),
		                "param_name"  => "columns_count",
		                "value" 	  => array(6,5,4,3,2,1),
		                "admin_label" => false,
		                "description" => esc_html__( "Select columns count.", 'nemi' )
		            ),

		            array(
		                "type" 		  => "textfield",
		                "heading" 	  => esc_html__( "Extra class name", 'nemi' ),
		                "param_name"  => "el_class",
		                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
		            )
		        )
		    ));

			/**
			 * pbr_productcategory
			 */
			$sidebar_product_lists = [
				esc_html__('None', 'nemi') => 'none',
				esc_html__('New Arrives', 'nemi') => 'recent_product',
				esc_html__('Special Products', 'nemi') => 'on_sale'
			];
			$product_layout = array('Grid'=>'grid','List'=>'list','Carousel'=>'carousel', 'Special'=>'special', 'List-v1' => 'list-v1');
			$product_type = array(
				'Best Selling'=>'best_selling_products',
				'Featured Products'=>'featured_products',
				'Top Rate'=>'top_rate',
				'Recent Products'=>'recent_products',
				'On Sale'=>'sale_products',
				'Recent Review' => 'recent_review' 
			);
			$product_columns = array(6 ,5 ,4 , 3, 2, 1);
			$show_tab = array(
			                array('recent', esc_html__('Latest Products', 'nemi')),
			                array( 'featured_product', esc_html__('Featured Products', 'nemi' )),
			                array('best_selling', esc_html__('BestSeller Products', 'nemi' )),
			                array('top_rate', esc_html__('TopRated Products', 'nemi' )),
			                array('on_sale', esc_html__('Special Products', 'nemi' ))
			            );

			/**
			* pbr_category_filter
			*/
			vc_map( array(
					"name"     => esc_html__("PBR Product Categories Filter", 'nemi'),
					"base"     => "pbr_category_filter",
					'description' => esc_html__( 'Show images and links of sub categories in block', 'nemi' ),
					"class"    => "",
					"category" => esc_html__('PBR Woocommerce', 'nemi'),
					"params"   => array(

					array(
						"type" => "dropdown",
						"heading" => esc_html__('Category', 'nemi'),
						"param_name" => "term_id",
						"value" =>$product_categories_dropdown,	"admin_label" => true
					),

					array(
						"type"        => "attach_image",
						"description" => esc_html__("Upload an image for categories (190px x 190px)", 'nemi'),
						"param_name"  => "image_cat",
						"value"       => '',
						'heading'     => esc_html__('Image', 'nemi' )
					),

					array(
						"type"       => "textfield",
						"heading"    => esc_html__("Number of categories to show", 'nemi'),
						"param_name" => "number",
						"value"      => '5',

					),

					array(
						"type"        => "textfield",
						"heading"     => esc_html__("Extra class name", 'nemi'),
						"param_name"  => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
			   	)
			));

			/**
			 * pbr_products
			 */
			vc_map( array(
			    "name" => esc_html__("PBR Products", 'nemi'),
			    "base" => "pbr_products",
			    'description'=> esc_html__( 'Show products as bestseller, featured in block', 'nemi' ),
			    "class" => "",
			   "category" => esc_html__('PBR Woocommerce', 'nemi'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'nemi'),
						"param_name" => "title",
						"admin_label" => true,
						"value" => ''
					),
					 array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Sub Title', 'nemi'),
		                "param_name" => "subtitle",
		            ),
					array(
						"type"        => "attach_image",
						"description" => esc_html__("Background Image", 'nemi'),
						"param_name"  => "image_bg",
						"value"       => '',
						'heading'     => esc_html__('Image', 'nemi' )
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__('Category', 'nemi'),
						"param_name" => "term_id",
						"value" =>$product_categories_dropdown,	"admin_label" => true
					),
			    	array(
						"type" => "dropdown",
						"heading" => esc_html__("Type", 'nemi'),
						"param_name" => "type",
						"value" => $product_type,
						"admin_label" => true,
						"description" => esc_html__("Select columns count.", 'nemi')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'nemi'),
						"param_name" => "style",
						"value" => $product_layout
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Columns count", 'nemi'),
						"param_name" => "columns_count",
						"value" => $product_columns,
						"admin_label" => true,
						"description" => esc_html__("Select columns count.", 'nemi')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number of products to show", 'nemi'),
						"param_name" => "number",
						"value" => '4'
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'nemi'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
			   	)
			));

			//
			/**
			 * pbr_products
			 */
			vc_map( array(
			    "name" => esc_html__("PBR Products Pagination", 'nemi'),
			    "base" => "pbr_products_pagination",
			    'description'=> esc_html__( 'Show products as bestseller, featured in block', 'nemi' ),
			    "class" => "",
			   "category" => esc_html__('PBR Woocommerce', 'nemi'),
			    "params" => array(
			    	array(
						"type" => "dropdown",
						"heading" => esc_html__("Type", 'nemi'),
						"param_name" => "type",
						"value" => $product_type,
						"admin_label" => true,
						"description" => esc_html__("Select Product type.", 'nemi')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Columns count", 'nemi'),
						"param_name" => "columns_count",
						"value" => $product_columns,
						"admin_label" => true,
						'std' => 4,
						"description" => esc_html__("Select columns count.", 'nemi')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number of products to show", 'nemi'),
						"param_name" => "number",
						"value" => '4'
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'nemi'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
			   	)
			));


			vc_map( array(
					"name"     => esc_html__("PBR Product Categories List", 'nemi'),
					"base"     => "pbr_category_list",
					"class"    => "",
					"category" => esc_html__('PBR Woocommerce', 'nemi'),
					'description' => esc_html__( 'Show Categories as menu Links', 'nemi' ),
					"params"   => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__('Title', 'nemi'),
						"param_name" => "title",
						"value"      => '',
					),
					 array(
			                "type" => "textfield",
			                "class" => "",
			                "heading" => esc_html__('Sub Title', 'nemi'),
			                "param_name" => "subtitle",
			            ),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show post counts', 'nemi' ),
						'param_name' => 'show_count',
						'description' => esc_html__( 'Enables show count total product of category.', 'nemi' ),
						'value' => array( esc_html__( 'Yes, please', 'nemi' ) => 'yes' )
					),
					array(
						"type"       => "checkbox",
						"heading"    => esc_html__("show children of the current category", 'nemi'),
						"param_name" => "show_children",
						'description' => esc_html__( 'Enables show children of the current category.', 'nemi' ),
						'value' => array( esc_html__( 'Yes, please', 'nemi' ) => 'yes' )
					),
					array(
						"type"       => "checkbox",
						"heading"    => esc_html__("Show dropdown children of the current category ", 'nemi'),
						"param_name" => "show_dropdown",
						'description' => esc_html__( 'Enables show dropdown children of the current category.', 'nemi' ),
						'value' => array( esc_html__( 'Yes, please', 'nemi' ) => 'yes' )
					),

					array(
						"type"        => "textfield",
						"heading"     => esc_html__("Extra class name", 'nemi'),
						"param_name"  => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
			   	)
			));

			/**
			 * pbr_all_products
			 */
			vc_map( array(
				'name' => esc_html__( 'PBR Product Categories ', 'nemi' ),
				'base' => 'pbr_product_categories',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'PBR Woocommerce', 'nemi' ),
				'description' => esc_html__( 'Display product categories ', 'nemi' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'nemi' ),
						'param_name' => 'title',
						'description' => esc_html__( 'Enter title ', 'nemi' ),
					),
					array(
			            "type" => "textarea_html",
			            "holder" => "div",
			            "class" => "",
			            "heading" => esc_html__( "Description", "nemi" ),
			            "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
			            "value" => esc_html__( "<p>I am test text block. Click edit button to change this text.</p>", "nemi" ),
			            "description" => esc_html__( "Enter your content.", "nemi" )
			        ),
					array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Category', 'nemi' ),
					    'value' => '',
					    'param_name' => 'categories',
					    "admin_label" => true,
					    'description' => esc_html__( 'Select Category', 'nemi' ),
					    'settings' => array(
					     'multiple' => false,
					     'unique_values' => true,
					     // In UI show results except selected. NB! You should manually check values in backend
					    ),
				   	),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Per page', 'nemi' ),
						'value' => 12,
						'param_name' => 'per_page',
						'description' => esc_html__( 'How much items per page to show', 'nemi' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Layout style', 'nemi' ),
						'param_name' => 'layout',
						'value' => array('Carousel' => 'carousel', 'Grid' =>'grid', 'List'=>'list'),
						'std' => 'grid',
						'description' => esc_html__( 'Select layout to show', 'nemi' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Columns', 'nemi' ),
						'value' => array(1,2,3,4),
						'param_name' => 'columns',
						'description' => esc_html__( 'How much columns grid', 'nemi' ),
						'dependency' => array(
							'element' => 'layout',
							'value' => array( 'grid', 'carousel'),
						),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Thumbnail size', 'nemi' ),
						'param_name' => 'thumbsize',
						'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'nemi' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__('Extra class name', 'nemi'),
						"param_name"  => "el_class",
						"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi')
					)
				)
			) );

			//Product categories tab
			vc_map( array(
				'name' => esc_html__( 'PBR Product Categories Tab ', 'nemi' ),
				'base' => 'pbr_product_categories_tab',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'PBR Woocommerce', 'nemi' ),
				'description' => esc_html__( 'Display product categories tab', 'nemi' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'nemi' ),
						'param_name' => 'title',
						'description' => esc_html__( 'Enter title ', 'nemi' ),
					),
			        array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Product type', 'nemi' ),
						'value' => $options,
						'param_name' => 'product_type',
						'default' => 'recent_products',
						'description' => esc_html__( 'Select Product type', 'nemi' ),
					),
			        
					array(
					    'type' => 'autocomplete',
					    'heading' => esc_html__( 'Categories', 'nemi' ),
					    'value' => '',
					    'param_name' => 'categories',
					    "admin_label" => true,
					    'description' => esc_html__( 'Select Category', 'nemi' ),
					    'settings' => array(
					     'multiple' => true,
					     'unique_values' => true,
					     // In UI show results except selected. NB! You should manually check values in backend
					    ),
				   	),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Per page', 'nemi' ),
						'value' => 12,
						'param_name' => 'per_page',
						'description' => esc_html__( 'How much items per page to show', 'nemi' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Columns', 'nemi' ),
						'value' => array(1,2,3,4),
						'param_name' => 'columns',
						'description' => esc_html__( 'How much columns grid', 'nemi' ),
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__('Extra class name', 'nemi'),
						"param_name"  => "el_class",
						"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nemi')
					)
				)
			) );

			vc_map( array(
				'name' => esc_html__( 'PBR Products SubCategories', 'nemi' ),
				'base' => 'pbr_productssubcats_normal',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'PBR Woocommerce', 'nemi' ),
				'description' => esc_html__( 'Display Products SubCategories', 'nemi' ),

				'params' => array(
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Title Color", 'nemi'),
						"param_name" => "titlecolor",
						"value" => '',
						'description'	=> ''
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Product per page', 'nemi' ),
						'value' => 12,
						'param_name' => 'per_page',
						'description' => esc_html__( 'How much items per page to show', 'nemi' ),

					),
					array(
						"type"        => "attach_image",
						"description" => esc_html__("Upload an image for categories (190px x 190px)", 'nemi'),
						"param_name"  => "image_cat",
						"value"       => '',
						'heading'     => esc_html__('Image', 'nemi' )
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Image Position', 'nemi' ),
						'param_name' => 'image_position',
						'value' => array( esc_html__('Left', 'nemi') => 'pull-left', esc_html__('Right', 'nemi') => 'pull-right', esc_html__('Top', 'nemi') => 'image-top' ),
						'description' =>  esc_html__( 'Display banner image on left or right', 'nemi' ),
						'std' => 'pull-left'
					),
					array(
							'type' => 'dropdown',
							'heading' => esc_html__( 'Columns', 'nemi' ),
							'value' => array(1,2,3,4),
							'param_name' => 'columns',
							'description' => esc_html__( 'How much columns grid', 'nemi' ),
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__( 'Order by', 'nemi' ),
							'param_name' => 'orderby',
							'std' => 'date',
							'value' => $order_by_values,
							'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'nemi' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__( 'Order way', 'nemi' ),
							'param_name' => 'order',
							'std' => 'DESC',
							'value' => $order_way_values,
							'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'nemi' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__( 'Category', 'nemi' ),
							'value' => $product_categories_dropdown,
							"admin_label" => true,
							'param_name' => 'category',
							'description' => esc_html__( 'Product category list', 'nemi' ),
						),
						array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Sub category to show', 'nemi' ),
						'value' => 5,
						'param_name' => 'number_subcat',
						'description' => esc_html__( 'How much sub category to show', 'nemi' ),

					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Sidebar Product List', 'nemi' ),
						'param_name' => 'sidebar_product_list',
						'value' => $sidebar_product_lists,
						'description' => esc_html__( 'Layout Type', 'nemi' ),'admin_label'	=> true
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Sidebar Product List Position', 'nemi' ),
						'param_name' => 'sidebar_position',
						'value' => array(  esc_html__('Right', 'nemi') => 'pull-right', esc_html__('Left', 'nemi') => 'pull-left' ),
						'description' =>  esc_html__( 'Display banner image on left or right', 'nemi' ),
						'std' => 'pull-right'
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__("Extra class name", 'nemi'),
						"param_name"  => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
				)
			) );

			// Category
			vc_map( array(
				'name'        => esc_html__( 'PBR Category', 'nemi' ),
				'base'        => 'pbr_category',
				'icon'        => 'icon-wpb-woocommerce',
				'category'    => esc_html__( 'PBR Woocommerce', 'nemi' ),
				'description' => esc_html__( 'Display SubCategory', 'nemi' ),

				'params' => array(
					array(
						"type"        => "attach_image",
						"description" => esc_html__("Upload an image for category", 'nemi'),
						"param_name"  => "image",
						"value"       => '',
						'heading'     => esc_html__('Image', 'nemi' )
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'nemi' ),
						'param_name' => 'style_image',
						'value'      => array(
							esc_html__('Style-default', 'nemi')         => 'style_default',
							esc_html__('Style-v1', 'nemi')              => 'style_v1',
							esc_html__('Style-v2', 'nemi')              => 'style_v2',
							esc_html__('Style-v3', 'nemi')              => 'style_v3',
							esc_html__('Style-v4', 'nemi')              => 'style_v4',
							esc_html__('Style-v5', 'nemi')              => 'style_v5',
						),
						'description' =>  esc_html__( 'Display title, description on left or right ...', 'nemi' ),
						'std'         => 'content_center'
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Effect', 'nemi' ),
						'param_name' => 'effect_image',
						'value'      => array(
							esc_html__('none', 'nemi')         => 'none',
							esc_html__('Effect-v1', 'nemi')    => 'effect_v1',
							esc_html__('Effect-v2', 'nemi')    => 'effect_v2',
						),
						'description' =>  esc_html__( 'Display title, description on left or right ...', 'nemi' ),
						'std'         => 'content_center'
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Category', 'nemi' ),
						'value' 		   => $product_categories_dropdown,
						"admin_label" 	=> true,
						'param_name' 	=> 'category',
						'description' 	=> esc_html__( 'Product category list', 'nemi' ),
					),
					array(
			            "type" => "textarea_html",
			            "holder" => "div",
			            "class" => "",
			            "heading" => esc_html__( "sub title", "nemi" ),
			            "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
			            "value" => esc_html__( "<p>I am test text block. Click edit button to change this text.</p>", "nemi" ),
			            "description" => esc_html__( "Enter your content.", "nemi" )
			        ),
					array(
						"type"        => "textarea",
						"heading"     => esc_html__("Description", 'nemi'),
						"param_name"  => "desc",
						"description" => esc_html__("Just description for Category on frontend page.", 'nemi')
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Display button shop now', 'nemi' ),
						'param_name' => 'button',
						'value'      => array(
							esc_html__('Yes', 'nemi') 	=> 1,
							esc_html__('No', 'nemi') 	=> 0
						),
						'description' =>  esc_html__( 'Display call to action button', 'nemi' ),
						'std'         => 1
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__("Extra class name", 'nemi'),
						"param_name"  => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
				)
			) );

			$allpages = array( esc_html__( ' --- Do not show --- ', 'nemi' ) => '' );
			if ( is_admin() ) {
				$args = array(
					'sort_order'  => 'desc',
					'sort_column' => 'date',
					'post_type'   => 'page',
					'post_status' => 'publish'
				);
				$pages = get_pages($args);
				if ( !empty($pages) ) {
					foreach ($pages as $page) {
						$allpages[$page->post_title] = $page->post_name;
					}
				}
			}

		 	vc_map( array(
				'name'        => esc_html__( 'PBR Our Categories', 'nemi' ),
				'base'        => 'pbr_ourcategories',
				'icon'        => 'icon-wpb-woocommerce',
				'category'    => esc_html__( 'PBR Woocommerce', 'nemi' ),
				'description' => esc_html__( 'Display Categories', 'nemi' ),

				'params' => array(
					array(
						"type"       => "textfield",
						"class"      => "",
						"heading"    => esc_html__('Title', 'nemi'),
						"param_name" => "title",
						"value"      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number per page', 'nemi' ),
						'value'       => 5,
						'param_name'  => 'per_page',
						'description' => esc_html__( 'How much items per page to show', 'nemi' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order by', 'nemi' ),
						'param_name'  => 'orderby',
						'std'         => 'date',
						'value'       => $order_by_values,
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'nemi' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order way', 'nemi' ),
						'param_name'  => 'order',
						'std'         => 'DESC',
						'value'       => $order_way_values,
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'nemi' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Layout Type', 'nemi' ),
						'param_name' => 'layout',
						'value'      => array(
							esc_html__( 'Grid', 'nemi' ) => 'grid',
							esc_html__( 'Special', 'nemi') => 'special'
						),
						'description' => esc_html__( 'Layout Type', 'nemi' ),'admin_label'	=> true
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Grid Layout Columns', 'nemi' ),
						'value'       => array(1,2,3,4,6),
						'param_name'  => 'columns',
						'description' => esc_html__( 'How much columns grid', 'nemi' ),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("All Category page", 'nemi'),
						"param_name" => "all_categories_page",
						"value" => $allpages,
						"admin_label" => true,
						"description" => esc_html__("Select a page if you want to show view more button.", 'nemi')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show Pagination', 'nemi' ),
						'param_name' => 'show_pagination',
						'value' => array(
							esc_html__( 'Yes', 'nemi' ) => '1',
							esc_html__( 'No', 'nemi') => '0'
						)
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__("Extra class name", 'nemi'),
						"param_name"  => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
				)
			) );
			/**
			 * pbr product  tabs
			 */
			vc_map( array(
			    "name" => esc_html__("PBR Products Tabs", 'nemi'),
			    "base" => "pbr_tabs_products",
			    'description'	=> esc_html__( 'Display BestSeller, TopRated ... Products In tabs', 'nemi' ),
			    "class" => "",
			   "category" => esc_html__('PBR Woocommerce', 'nemi'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'nemi'),
						"param_name" => "title",
						"value" => ''
					),
					 array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Sub Title', 'nemi'),
		                "param_name" => "subtitle",
		            ),
					array(
			            "type" => "sorted_list",
			            "heading" => esc_html__("Show Tab", 'nemi'),
			            "param_name" => "show_tab",
			            "description" => esc_html__("Control teasers look. Enable blocks and place them in desired order.", 'nemi'),
			            "value" => "recent,featured_product,best_selling",
			            "options" => $show_tab
			        ),
			        array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'nemi'),
						"param_name" => "style",
						"value" => $product_layout
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number of products to show", 'nemi'),
						"param_name" => "number",
						"value" => '4'
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Columns count", 'nemi'),
						"param_name" => "columns_count",
						"value" => $product_columns,
						"description" => esc_html__("Select columns count.", 'nemi')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'nemi'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
			   	)
			));

			/**
			 * pbr_products_carousel
			 */
			vc_map( array(
			    "name" => esc_html__("PBR Products Carousel", 'nemi'),
			    "base" => "pbr_products_carousel",
			    'description'	=> esc_html__( 'Display Special Products as Carousel Style', 'nemi' ),
			    "class" => "",
			   	"category" => esc_html__('PBR Woocommerce', 'nemi'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'nemi'),
						"param_name" => "title",
						"value" => ''
					),
					 array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Sub Title', 'nemi'),
		                "param_name" => "subtitle",
		            ),
			        array(
						"type" => "dropdown",
						"heading" => esc_html__("Style", 'nemi'),
						"param_name" => "style",
						"default"	=> 'default',
						"value" => array(
								esc_html( 'Default', 'nemi' )	=> 'default',
								esc_html( 'No Padding' )		=> 'no-padding'
							)
					),
			        array(
						"type" => "dropdown",
						"heading" => esc_html__("Pagination", 'nemi'),
						"param_name" => "pagination",
						"default"	=> "yes",
						"value" => array(
								esc_html( 'Yes', 'nemi' )	=> 'yes',
								esc_html( 'No', 'nemi' )		=> 'no'
							)
					),
			        array(
						"type" => "dropdown",
						"heading" => esc_html__("Navigation", 'nemi'),
						"param_name" => "navigation",
						"default"	=> "yes",
						"value" => array(
								esc_html( 'Yes', 'nemi' )	=> 'yes',
								esc_html( 'No', 'nemi' )		=> 'no'
							)
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number of products to show", 'nemi'),
						"param_name" => "number",
						"value" => '4',
						"default"	=> '4',
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Columns", 'nemi'),
						"param_name" => "columns",
						"value" => $product_columns,
						"description" => esc_html__("Select columns count.", 'nemi'),
						"default"	=> '4',
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'nemi'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
			   	)
			));

			/**
			 * pbr_special_product
			 */
			vc_map( array(
			    "name" => esc_html__("PBR Special Featured Products", 'nemi'),
			    "base" => "pbr_featured_special_products",
			    'description'	=> esc_html__( 'Display Featured Products Special Layout', 'nemi' ),
			    "class" => "",
			   	"category" => esc_html__('PBR Woocommerce', 'nemi'),
			    "params" => array(
			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Title", 'nemi'),
						"param_name" => "title",
						"value" => ''
					),
					array(
		                "type" => "textfield",
		                "class" => "",
		                "heading" => esc_html__('Sub Title', 'nemi'),
		                "param_name" => "subtitle",
		            ),
			        array(
						"type" => "dropdown",
						"heading" => esc_html__("Pagination", 'nemi'),
						"param_name" => "pagination",
						"default"	=> "yes",
						"value" => array(
								esc_html( 'Yes', 'nemi' )	=> 'yes',
								esc_html( 'No', 'nemi' )		=> 'no'
							)
					),
			        array(
						"type" => "dropdown",
						"heading" => esc_html__("Navigation", 'nemi'),
						"param_name" => "navigation",
						"default"	=> "yes",
						"value" => array(
								esc_html( 'Yes', 'nemi' )	=> 'yes',
								esc_html( 'No', 'nemi' )		=> 'no'
							)
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Number of products to show", 'nemi'),
						"param_name" => "number",
						"value" => 5,
						"default"	=> 5,
						'min'		=> 5,
						"description" => esc_html__("This option have to greater than 4.", 'nemi')
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order by', 'nemi' ),
						'param_name' => 'orderby',
						'value' => $order_by_values,
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'nemi' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order way', 'nemi' ),
						'param_name' => 'order',
						'value' => $order_way_values,
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'nemi' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Extra class name", 'nemi'),
						"param_name" => "el_class",
						"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nemi')
					)
			   	)
			));

		}
	}

	/**
	  * Register Woocommerce Vendor which will register list of shortcodes
	  */
	function nemi_fnc_init_vc_woocommerce_vendor(){

		$vendor = new Nemi_VC_Woocommerce();
		add_action( 'vc_after_set_mode', array(
			$vendor,
			'load'
		) );

	}
	add_action( 'after_setup_theme', 'nemi_fnc_init_vc_woocommerce_vendor' , 9 );
}


if( class_exists("WPBakeryShortCode") ){

	class WPBakeryShortCode_PBR_Tabs_Products extends WPBakeryShortCode {

		public function getListQuery( $atts ){
			$this->atts  = $atts;
			$list_query = array();
			$types = explode(',', $this->atts['show_tab']);
			foreach ($types as $type) {
				$list_query[$type] = $this->getTabTitle($type);
			}


			return $list_query;
		}

		public function getTabTitle($type){
			switch ($type) {
				case 'recent':
					return array('title'=>esc_html__('Latest Products', 'nemi'),'title_tab'=>esc_html__('Latest', 'nemi'));
				case 'featured_product':
					return array('title'=>esc_html__('Featured Products', 'nemi'),'title_tab'=>esc_html__('Featured', 'nemi'));
				case 'top_rate':
					return array('title'=> esc_html__('Top Rated Products', 'nemi'),'title_tab'=>esc_html__('Top Rated', 'nemi'));
				case 'best_selling':
					return array('title'=>esc_html__('BestSeller Products', 'nemi'),'title_tab'=>esc_html__('BestSeller', 'nemi'));
				case 'on_sale':
					return array('title'=>esc_html__('Special Products', 'nemi'),'title_tab'=>esc_html__('Special', 'nemi'));
			}
		}
	}

	/**
	 *
	 */
	class WPBakeryShortCode_Pbr_product_deals extends WPBakeryShortCode {}

	/**
	 *
	 */
 	class WPBakeryShortCode_Pbr_products_onsale extends WPBakeryShortCode {}

	class WPBakeryShortCode_Pbr_category_filter extends WPBakeryShortCode {}

	class WPBakeryShortCode_Pbr_products extends WPBakeryShortCode {}

	class WPBakeryShortCode_Pbr_category_list extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_product_categories extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_productssubcats_normal extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_ourcategories extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_Category extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_Products_Carousel extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_Featured_Special_Products extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_Product_Categories_Tab extends WPBakeryShortCode {}
	class WPBakeryShortCode_Pbr_Products_Pagination extends WPBakeryShortCode {}
	


 }