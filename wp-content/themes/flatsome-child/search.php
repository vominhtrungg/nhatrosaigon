<?php
/**
 * The blog template file.
 *
 * @package flatsome
 */

get_header();
?>

	<div id="content" class="blog-wrapper blog-archive page-wrapper">
		<div class="sb_block row category-page-row" style="padding-top: 0;display: block;">
			<div class="sb_right col large-9">
					<h2 class="heading"><span>Kết quả tìm kiếm : <?php echo get_query_var('s'); ?></span></h2>
				<?php if ( function_exists( 'WC' ) ) { ?>
					<div class="block-product-col product-small">
						<ul class="products">
							<?php
							    if(have_posts()) {
						        while(have_posts()){
						        	the_post();
									get_template_part( 'woocommerce/content', 'product' );
							       	}//End while
						  			wp_reset_postdata();
							    }else{
							    	echo "Không tìm thấy sản phẩm phù hợp với kết quả tìm kiếm của bạn";
							    }
							?>
						</ul>
					</div>
				<?php }else{ ?>
					<div class="search-value row">
						<?php
						    if(have_posts()) {
					        while(have_posts()){
					        the_post();
						?>
							<div class="news-post col-md-4">
							    <a href="<?php the_permalink();?>" title="<?php the_title();?>">
							    <?php if(has_post_thumbnail()) the_post_thumbnail("medium",array("alt" => get_the_title()));
							         else echo $no_thum; ?>
							    </a>
							    <a class="title" href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title();?></a>
							</div>
						<?php
						       	}//End while
						    }else{
						    	echo "Không tìm thấy bài viết phù hợp với kết quả tìm kiếm của bạn";
						    }
						?>
					</div>
				<?php } ?>
					
			</div>
			<div class="sb_left post-sidebar col large-3">
				<?php dynamic_sidebar('sidebar'); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
	
