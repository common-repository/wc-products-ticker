<?php //Template Name: defaults ?>

<ul class="product_list_widget">
	<?php while($wcpt_query->have_posts()) : $wcpt_query->the_post(); global $product; ?>
		<li><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		
		<?php if ( empty( $instance['hide_thumb'] ) ) : ?>
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
 				?></a>
		<?php endif; ?>

			<span class="product-title"><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>"><?php echo $product->get_title(); ?></a></span>
			<?php echo $product->get_price_html(); ?>
		</li>
	<?php endwhile; ?>
</ul>