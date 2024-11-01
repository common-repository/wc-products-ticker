<?php //Template Name: layout1 ?>

<ul class="product-list layout1">
	<?php while($wcpt_query->have_posts()) : $wcpt_query->the_post(); global $product; ?>
		
	<li><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<div class="product-inner">
		<?php if ( empty( $instance['hide_thumb'] ) ) : ?>
			<div class="product-thumb">
				<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
					<?php
						if (!empty( $instance['thumb_crop'] ) ) {
							$crop = true;
						} else {
							$crop = false;
						}

						if( has_post_thumbnail() ) {
							$thumb = get_post_thumbnail_id();
							$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
							$image = aq_resize( $img_url, $thumb_width, $thumb_height, $crop ); //resize & crop img
								echo '<img src="'.$image.'"  alt="'.esc_attr( $product->get_title() ).'">';
						}
						else {
							echo '<img src="'.WCPT_NO_THUMB.'" alt="'.esc_attr( $product->get_title() ).'">';
						}
	 				?>
	 			</a>
 			</div>
		<?php endif; ?>
			
			<div class="product-details">
				<div class="product-title">
					<h3><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
						<?php echo $product->get_title(); ?></a></h3>
				</div>
				<div class="price">
					<?php echo $product->get_price_html(); ?>
				</div>
			</div>
		</div>
	</li>
	<?php endwhile; ?>
</ul>