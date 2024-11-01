<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* 
* List products with Ticker
*
* @package WooCommerce Products Ticker.
* @since      1.0
* @author Amity Themes
*/

class WC_Product_Widget_Ticker extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'wcpt_widget', 
			__('WooCommerce Products Ticker', 'wcpt-widget'),
			array( 'description' => __( 'WooCommerce Products Ticker is a Free Widget that helps you to scroll your products bottom-to-top/top-to-bottom vertically.', 'wcpt-widget' ), 
	));
}

	public function widget($args, $instance) {

		extract( $args );

		$number  = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : '';
		$product_display = $instance['product_display'];
		$product_orderby = $instance['product_orderby'];
		$product_order = ! empty( $instance['product_order'] ) ? sanitize_title( $instance['product_order'] ) : '';
		$thumb_width  = ! empty( $instance['thumb_width'] ) ? absint( $instance['thumb_width'] ) : '';
		$thumb_height  = ! empty( $instance['thumb_height'] ) ? absint( $instance['thumb_height'] ) : '';
		$temp_layout = ! empty( $instance['temp_layout'] ) ? sanitize_title( $instance['temp_layout'] ) : '';
		$ticker_direction = ! empty( $instance['ticker_direction'] ) ? sanitize_title( $instance['ticker_direction'] ) : '';
		$ticker_easing = ! empty( $instance['ticker_easing'] ) ? sanitize_title( $instance['ticker_easing'] ) : '';
		$ticker_speed = ! empty( $instance['ticker_speed'] ) ? absint( $instance['ticker_speed'] ) : '';
		$ticker_interval = ! empty( $instance['ticker_interval'] ) ? absint( $instance['ticker_interval'] ) : '';
		$ticker_height = ! empty( $instance['ticker_height'] ) ? absint( $instance['ticker_height'] ) : '';
		$ticker_visible = ! empty( $instance['ticker_visible'] ) ? absint( $instance['ticker_visible'] ) : '';
		$ticker_mousePause = ! empty( $instance['ticker_mousePause'] ) ? absint( $instance['ticker_mousePause'] ) : '';
		$ticker_controls = ! empty( $instance['ticker_controls'] ) ? sanitize_title( $instance['ticker_controls'] ) : '';

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
			$query_args = array(
				'posts_per_page'	=> $number, // Number of Products Display
				'post_status'    	=> 'publish',
				'post_type'      	=> 'product',
				'no_found_rows'  	=> 1,
				'order'          	=> $product_order, //  Product Order/Sort
				'meta_query'     	=> array('') 
			);

			if ( empty( $instance['show_hidden_products'] ) ) {
				$query_args['meta_query'][] = WC()->query->visibility_meta_query();
				$query_args['post_parent']  = 0;
			}

			if ( ! empty( $instance['free_products_hide'] ) ) {
				$query_args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}

			$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
			$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
			
			switch ( $product_display ) {
			case 'featured' :
				$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
			break;

			case 'onsale' :
				$wc_product_ids_on_sale    = wc_get_product_ids_on_sale();
				$wc_product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $wc_product_ids_on_sale;
				break;
			} 

			switch ( $product_orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby']  = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;
			default :
				$query_args['orderby']  = 'date';
			} ?>

			<?php $wcpt_query = new WP_Query($query_args); ?> 

		 	<div id="my_<?php echo $this->id; ?>" class="wcpt-widget">
				<?php 
					if(!empty($instance['temp_layout'])) {
						$layout = $temp_layout;
					} 
					else {
						$layout = "default";
					}
					require(WCPT_TEM_FOLDER . 'template-'.$layout.'.php');
				?>
		 	</div>
		 		
		 		<script type="text/javascript">
		 			jQuery(document).ready(function() {
						jQuery('#my_<?php echo $this->id; ?>').easyTicker({
							direction: '<?php echo $ticker_direction; ?>',
							easing: 'swing',
							speed: <?php echo $ticker_speed; ?>,
							interval: <?php echo $ticker_interval; ?>,
							height: 'auto',
							visible: <?php echo $ticker_visible; ?>,
							mousePause: <?php if (empty( $instance['ticker_mousePause'])) {
												echo "1";
											} else {
												echo "0";
											}
										?>, // end mouse pause
							controls: {
								up: '',
								down: '',
								toggle: '',
								playText: 'Play',
								stopText: 'Stop'
							}
						});
					});
				</script>

			<?php echo $args['after_widget'];

        	wp_reset_query();
       	}
		
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Products', 'wcpt-widget' );
		$number = isset( $instance['number'] ) ? $instance['number'] : 5;
		$product_display = isset ( $instance['product_display'] ) ? $instance['product_display'] : '';
		$product_orderby = isset( $instance['product_orderby'] ) ? $instance['product_orderby'] : 'date';
		$product_order = isset( $instance['product_order'] ) ? $instance['product_order'] : 'asc';
		$free_products_hide = isset( $instance['free_products_hide'] ) ? $instance['free_products_hide'] : '';
		$show_hidden_products = isset( $instance['show_hidden_products'] ) ? $instance['show_hidden_products'] : '';
		$hide_thumb = isset( $instance['hide_thumb'] ) ? $instance['hide_thumb'] : '';
		$thumb_crop = isset( $instance['thumb_crop'] ) ? $instance['thumb_crop'] : '';
		$thumb_width = isset( $instance['thumb_width'] ) ? $instance['thumb_width'] : 300;
		$thumb_height = isset( $instance['thumb_height'] ) ? $instance['thumb_height'] : 600;
		$temp_layout = isset( $instance['temp_layout'] ) ? $instance['temp_layout'] : 'default';
		$ticker_direction = isset( $instance['ticker_direction'] ) ? $instance['ticker_direction'] : 'up';
		$ticker_easing = isset( $instance['ticker_easing'] ) ? $instance['ticker_easing'] : '';
		$ticker_speed = isset( $instance['ticker_speed'] ) ? $instance['ticker_speed'] : 500;
		$ticker_interval = isset( $instance['ticker_interval'] ) ? $instance['ticker_interval'] : 2000;
		$ticker_height = isset( $instance['ticker_height'] ) ? $instance['ticker_height'] : '';
		$ticker_visible = isset( $instance['ticker_visible'] ) ? $instance['ticker_visible'] : 5;
		$ticker_mousePause = isset( $instance['ticker_mousePause'] ) ? $instance['ticker_mousePause'] : '';
		$ticker_controls = isset( $instance['ticker_controls'] ) ? $instance['ticker_controls'] : '';
	?>

<div class="wcpt-wedget">
	<div class="wcpt-widget-title"><h2>Widget Options</h2></div>
	<div data-accordion-group>
		
		<!-- == Basic Options == -->
		<div id="1" class="wcpt-accordion" data-accordion>
	    	<div class="wcpt-control" data-control><?php _e( 'Basic Options', 'wcpt-widget'  ); ?></div>
	        <div data-content>
	        		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:', 'wcpt-widget'  ); ?></label>
						<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" 
								name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" /></p>
			
					<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Products to Display:', 'wcpt-widget'); ?></label>
						<input class="widefat" type="number" id="<?php echo $this->get_field_id( 'number' ); ?>" 
								name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr( $number ); ?>" /></p>
	        </div>
	    </div>
		<!-- == End Basic Options == -->
		
	    <div id="2" class="wcpt-accordion" data-accordion>
	    	<div class="wcpt-control" data-control><?php _e( 'Filtering Options', 'wcpt-widget'); ?></div>
	        <div data-content>
					<p>
						<label for="<?php echo $this->get_field_id( 'product_display' ); ?>"><?php _e( 'Display Product:', 'wcpt-widget'); ?></label>
						
						<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'product_display' ) ); ?>" 
								name="<?php echo $this->get_field_name( 'product_display' ); ?>">

						<?php $pd = array( ''=>'All Products', 'featured'=>'Featured Products', 'onsale'=>'On-sale Products');
							foreach($pd as $k => $v) { ?>
						
						<?php if ( isset( $instance[ 'product_display' ] ) ) { ?>
 							<option <?php if ( $instance['product_display'] == $k ) echo 'selected="selected"'; ?> value="<?php echo $k; ?>">
 								<?php echo $v; ?>
 							</option>
            				
            				<?php } else { ?>
                		
                		<option  value="<?php echo $k; ?>"><?php echo $v; ?></option>
            			<?php }} ?>  
							
						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'product_orderby' ); ?>"><?php _e( 'Order By:', 'wcpt-widget'); ?></label>

						<select class="widefat" id="<?php echo $this->get_field_id( 'product_orderby' ); ?>" 
								name="<?php echo $this->get_field_name( 'product_orderby' ); ?>">

						<?php $orderby = array( 'date'=>'Date', 'price'=>'Price', 'sales'=>'Sales', 'rand'=>'Rand');
							foreach($orderby as $k => $v) { ?>
 					
 						<?php if ( isset( $instance[ 'product_orderby' ] ) ) { ?>
 						 
 						 <option <?php if ( $instance['product_orderby'] == $k ) echo 'selected="selected"'; ?> value="<?php echo $k; ?>">
 							<?php echo $v; ?>
 						 </option>
            				
            				<?php } else { ?>
                		
                		<option  value="<?php echo $k; ?>"><?php echo $v; ?></option>
            			<?php }} ?>      

						</select>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'product_order' ); ?>"><?php _e( 'Product Order:', 'wcpt-widget'); ?></label>
						
						<select class="widefat" id="<?php echo $this->get_field_id( 'product_order' ); ?>" 
							name="<?php echo $this->get_field_name( 'product_order' ); ?>">

						<?php $orders = array( 'asc'=>'ASC', 'desc'=>'DESC');

								foreach($orders as $k => $v) { ?>

 						<?php if ( isset( $instance[ 'product_order' ] ) ) { ?>
						
						<option <?php if ( $instance['product_order'] == $k ) echo 'selected="selected"'; ?> value="<?php echo $k; ?>">
 							<?php echo $v; ?>
 						</option>

            			<?php } else { ?>

                		<option  value="<?php echo $k; ?>"><?php echo $v; ?></option>

            			<?php }} ?>   

						</select>
					</p>

						<p><input type="checkbox" id="<?php echo $this->get_field_id( 'free_products_hide' ); ?>" 
								name="<?php echo $this->get_field_name( 'free_products_hide' ); ?>" value="1" <?php checked( '1', $free_products_hide ); ?> />
							<label for="<?php echo $this->get_field_id( 'free_products_hide' ); ?>"><?php _e( 'Hide Free Products', 'wcpt-widget'); ?></label>
						</p>
					
						<p><input type="checkbox" id="<?php echo $this->get_field_id( 'show_hidden_products' ); ?>" 
							name="<?php echo $this->get_field_name( 'show_hidden_products' ); ?>" value="1" <?php checked( '1', $show_hidden_products ); ?> />
							<label for="<?php echo $this->get_field_id( 'show_hidden_products' ); ?>"><?php _e( 'Show All Hidden Products', 'wcpt-widget'); ?></label>
						</p>
	        </div>
	   </div>

	   	<div id="3" class="wcpt-accordion" data-accordion>
	    	<div class="wcpt-control" data-control><?php _e( 'Thumbnail Options', 'wcpt-widget'); ?></div>
	        <div data-content>
					
					<p>
					<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_thumb' ); ?>" 
						name="<?php echo $this->get_field_name( 'hide_thumb' ); ?>" value="1" <?php checked( '1', $hide_thumb ); ?> />
					<label for="<?php echo $this->get_field_id( 'hide_thumb' ); ?>"><?php _e( 'Hide Product Thumbnail', 'wcpt-widget'); ?></label>
					</p>

					<p>
					<input type="checkbox" id="<?php echo $this->get_field_id( 'thumb_crop' ); ?>" 
						name="<?php echo $this->get_field_name( 'thumb_crop' ); ?>" value="1" <?php checked( '1', $thumb_crop ); ?> />
					<label for="<?php echo $this->get_field_id( 'thumb_crop' ); ?>"><?php _e( 'Thumbnail Auto Crop Off', 'wcpt-widget'); ?></label>
					</p>

					<p>
					<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e( 'Thumbnail Width:', 'wcpt-widget'); ?></label>
						<input class="widefat" type="number" id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" 
							name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo esc_attr( $thumb_width ); ?>" />
					</p>

					<p>
					<label for="<?php echo $this->get_field_id( 'thumb_height' ); ?>"><?php _e( 'Thumbnail Height:', 'wcpt-widget'); ?></label>
						<input class="widefat" type="number" id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" 
							name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" value="<?php echo esc_attr( $thumb_height ); ?>" />
					</p>
	        </div>
	   </div>

	   <div id="4" class="wcpt-accordion" data-accordion>
	    	<div class="wcpt-control" data-control><?php _e( 'Layout Options', 'wcpt-widget'); ?></div>
		        <div data-content>
		    		<fieldset class="layouts-field" id="<?php echo $this->get_field_id( 'temp_layout' ); ?>">
						<p class="col"><input type="radio" name="<?php echo $this->get_field_name( 'temp_layout' ); ?>" value="default" <?php checked( 'default', $temp_layout ); ?> />
						<label for="<?php echo $this->get_field_id( 'temp_layout' ); ?>"><?php _e( 'Default', 'wcpt-widget'); ?></label></p>
		        			
						<p class="col"><input type="radio" name="<?php echo $this->get_field_name( 'temp_layout' ); ?>" value="layout1" <?php checked( 'layout1', $temp_layout ); ?> />
						<label for="<?php echo $this->get_field_id( 'temp_layout' ); ?>"><?php _e( 'Layout 1', 'wcpt-widget'); ?></label></p>
					</fieldset>
		        </div>
	   </div>

	   <div id="5" class="wcpt-accordion" data-accordion>
	    	<div class="wcpt-control" data-control><?php _e( 'Ticker Options', 'wcpt-widget'); ?></div>
	        <div data-content>
				<p><label for="<?php echo $this->get_field_id( 'ticker_direction' ); ?>"><?php _e( 'Display Product:', 'wcpt-widget'); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'ticker_direction' ); ?>" 
							name="<?php echo $this->get_field_name( 'ticker_direction' ); ?>">
						
						<?php $td = array( 'up'=>'UP', 'down'=>'DOWN');

								foreach($td as $k => $v) { ?>

						<?php if ( isset( $instance[ 'ticker_direction' ] ) ) { ?>
						
						<option <?php if ( $instance['ticker_direction'] == $k ) echo 'selected="selected"'; ?> value="<?php echo $k; ?>">
 							<?php echo $v; ?>
 						</option>

            			<?php } else { ?>

                		<option  value="<?php echo $k; ?>"><?php echo $v; ?></option>

            			<?php }} ?>

					</select></p>

						<p>
						<label for="<?php echo $this->get_field_id('ticker_speed'); ?>"><?php _e( 'Ticker Speed', 'wcpt-widget'); ?></label>
						<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'ticker_speed' ); ?>" 
							name="<?php echo $this->get_field_name( 'ticker_speed' ); ?>" value="<?php echo esc_attr( $ticker_speed ); ?>" />
						</p>
						
						<p>
						<label for="<?php echo $this->get_field_id('ticker_interval'); ?>"><?php _e( 'Ticker Duration', 'wcpt-widget'); ?></label>
						<input class="widefat" type="number" id="<?php echo $this->get_field_id( 'ticker_interval' ); ?>" 
							name="<?php echo $this->get_field_name( 'ticker_interval' ); ?>" value="<?php echo esc_attr( $ticker_interval ); ?>" />
						</p>

						<p>
						<label for="<?php echo $this->get_field_id('ticker_visible'); ?>"><?php _e( 'Number of Products to Visible', 'wcpt-widget'); ?></label>
						<input class="widefat" type="number" id="<?php echo $this->get_field_id( 'ticker_visible' ); ?>" 
							name="<?php echo $this->get_field_name( 'ticker_visible' ); ?>" value="<?php echo esc_attr( $ticker_visible ); ?>" />
						</p>

						<p>
							<input type="checkbox" id="<?php echo $this->get_field_id( 'ticker_mousePause' ); ?>" 
								name="<?php echo $this->get_field_name( 'ticker_mousePause' ); ?>" value="1" <?php checked( '1', $ticker_mousePause ); ?> />
							<label for="<?php echo $this->get_field_id( 'ticker_mousePause' ); ?>"><?php _e( 'Off Mouse Hover', 'wcpt-widget'); ?></label>
						</p>
	        </div>
	    </div>

	   <div id="6" class="wcpt-accordion" data-accordion>
	    	<div class="wcpt-control" data-control><?php _e( 'Miscellaneous', 'wcpt-widget'); ?></div>
	        <div data-content>
	        	<div class="misce-inner">
	        		<h2>Thank You For Using My Plugin...</h2>
					<h3>I am here to help. Drop me a message. <a href="http://fahim.xyz/#contact">Click Here</a></p>
					<p>Hire Me <a href="http://www.fahim.xyz">[CLICK HERE]</a></h3>
				</div>
	        </div>
	   </div>

	</div>
</div>
<script>
	jQuery('.wcpt-accordion').accordion({
		"transitionSpeed"	: 400,
		"singleOpen"		: true
	});
</script>
<?php }
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();	
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = $new_instance['number'];
		$instance['product_display'] = $new_instance['product_display'];
		$instance['product_orderby'] = $new_instance['product_orderby'];
		$instance['product_order'] = $new_instance['product_order'];
		$instance['free_products_hide'] = $new_instance['free_products_hide'];
		$instance['show_hidden_products'] = $new_instance['show_hidden_products'];
		$instance['hide_thumb'] = $new_instance['hide_thumb'];
		$instance['thumb_crop'] = $new_instance['thumb_crop'];
		$instance['thumb_width'] = $new_instance['thumb_width'];
		$instance['thumb_height'] = $new_instance['thumb_height'];
		$instance['temp_layout'] = $new_instance['temp_layout'];
		$instance['ticker_direction'] = $new_instance['ticker_direction'];
		$instance['ticker_easing'] = $new_instance['ticker_easing'];
		$instance['ticker_speed'] = $new_instance['ticker_speed']; 
		$instance['ticker_interval'] = $new_instance['ticker_interval'];
		$instance['ticker_height'] = $new_instance['ticker_height'];
		$instance['ticker_visible'] = $new_instance['ticker_visible'];
		$instance['ticker_mousePause'] = $new_instance['ticker_mousePause'];
		$instance['ticker_controls'] = $new_instance['ticker_controls'];
		return $instance;
	}
}