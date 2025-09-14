<div class="row content-row row-divided row-large row-reverse" style="max-width: 1170px !important;">
	<h1 class="telle_head"><?php the_title(); ?></h1>
	<div id="product-sidebar" class="col large-3 hide-for-medium shop-sidebar <?php flatsome_sidebar_classes(); ?>">
		<?php
			do_action('flatsome_before_product_sidebar');
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			dynamic_sidebar('Shop sidebar');
		?>
	</div><!-- col large-3 -->
	<div class="col large-9">
		<div class="product-main">
		<div class="row">
			<div class="large-7 col">
				<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
			?>

			</div>


			<div class="product-info summary entry-summary col col-fit <?php flatsome_product_summary_classes();?>">
				<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
				<div class="rt_hotline_ctsp"><?php dynamic_sidebar( 'Hotline chi tiết sản phẩm' ); ?></div>

			</div><!-- .summary -->
		</div><!-- .row -->
		</div><!-- .product-main -->
		<div class="product-footer">
			<?php
					/**
					 * woocommerce_after_single_product_summary hook
					 *
					 * @hooked woocommerce_output_product_data_tabs - 10
					 * @hooked woocommerce_upsell_display - 15
					 * @hooked woocommerce_output_related_products - 20
					 */
					do_action( 'woocommerce_after_single_product_summary' );
				?>
		</div>
	
    </div><!-- col large-9 -->
    <div class="product_splq">
    	<?php 
		do_action('sp_lquan');
		?>
    </div>
    <div class="product_spdx">
		<?php dynamic_sidebar( 'Sản phẩm đã xem' ); ?>
    </div>
</div><!-- .row -->
