<div class="row category-page-row">
		<div class="col large-3 hide-for-medium <?php flatsome_sidebar_classes(); ?>">
			<div id="shop-sidebar2" class="sidebar-inner col-inner">
				<?php
				  dynamic_sidebar('product-sidebar');
				?>
			</div><!-- .sidebar-inner -->
		</div><!-- #shop-sidebar -->
		<div class="col large-9">
		<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		
		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<div class="term-description">
				<?php echo category_description();?>
			</div>
			
		<?php endif; ?>
		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			<div class="block-product-col product-small" style="padding: 0 10px;">
				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>
					
						<?php while ( have_posts() ) : the_post(); ?>

							<?php wc_get_template_part( 'content', 'product' ); ?>

						<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
			</div>
			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

		</div>
		
		<div class="sb_mobile" style="display: none;">
			<div id="shop-sidebar2" class="sidebar-inner col-inner">
				<?php
				  dynamic_sidebar('product-sidebar');
				?>
			</div><!-- .sidebar-inner -->
		</div><!-- #shop-sidebar -->
</div>
