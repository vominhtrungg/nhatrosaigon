<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Check stock status.
$out_of_stock = get_post_meta( $post->ID, '_stock_status', true ) == 'outofstock';

// Extra post classes.
$classes   = array();
$classes[] = 'product-small';
$classes[] = 'col';
$classes[] = 'has-hover';

if ( $out_of_stock ) $classes[] = 'out-of-stock';

?>

<div class="col-4">
	<div class="col-inner">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<div class="product-small box <?php echo flatsome_product_box_class(); ?>">
		<div class="box-image">
			<div class="<?php echo flatsome_product_box_image_class(); ?>">
				<a href="<?php echo get_the_permalink(); ?>">
					<?php
						/**
						 *
						 * @hooked woocommerce_get_alt_product_thumbnail - 11
						 * @hooked woocommerce_template_loop_product_thumbnail - 10
						 */
						do_action( 'flatsome_woocommerce_shop_loop_images' );
					?>
				</a>
			</div>
			<?php 
                 if ($product->is_on_sale()){
                     $per = round((( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
                        echo "<span class='sale'>-$per%</span>";
                  } 
            ?>
            <?php 
				$san_pham_hot = get_field('san_pham_hot_ph');
			    if(!empty($san_pham_hot)){
			    	?>
			    	<div class="hot_p">Hot</div>
			    	<?php
			    }
			?>
		</div><!-- box-image -->

		<div class="box-text <?php echo flatsome_product_box_text_class(); ?>">
			<?php
				do_action( 'woocommerce_before_shop_loop_item_title' );

				echo '<div class="title-wrapper">';
				do_action( 'woocommerce_shop_loop_item_title' );
				echo '</div>';
				?>
                <?php

				echo '<div class="box-p">';
                    $gia  = $product->regular_price;
                    $giakm  = $product->sale_price;
                    global $product;
                      $gia  = $product->regular_price;
                      $giakm  = $product->sale_price;
                      echo '<p class="price_pro">';
                        if( ! empty( $giakm ) && ! empty( $gia ) ) {
                          echo "<del> <span>" . number_format($gia,0,'','.') . "đ</span></del> <ins> <span>" . number_format($giakm,0,'','.')."đ </span></ins> ";
                        } else {
                          echo "<span>";
                          if(!empty($gia)) echo "" . number_format($gia,0,'','.')."đ"; else echo "Liên Hệ";
                          echo "</span>"; 
                        }
                      echo "</p>";
                  echo '</div>';
				//do_action( 'rt_add_to_cart' ); 
				//do_action( 'flatsome_product_box_after' );
			?>
		</div><!-- box-text -->
	</div><!-- box -->
	<?php //do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div><!-- .col-inner -->
</div><!-- col -->
