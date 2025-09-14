<?php
/**
 * The blog template file.
 *
 * @package flatsome
 */

get_header();
	$term = $wp_query->get_queried_object();
	$catid = $term->term_id;
?>

	<div id="content" class="blog-wrapper blog-archive page-wrapper" style="padding-top: 10px;">
		<div class="sb_block row category-page-row" style="padding-top: 0;display: block;">
      <div class="section__width" style="overflow: hidden;padding: 0 15px;">
  			<div class="box__left__layout">
<!--   					<h1 class="heading">
  						<?php echo get_cat_name( $catid );?>
  					</h1> -->
  					<div class="new-list">
  						<?php 
  							$arg = array(
  			                    'post_type' => 'post',
  			                    'tax_query' => array(
  			                        array(
  			                        'taxonomy' => 'category',
  			                        'field' => 'id',
  			                        'terms' => $catid
  			                        )
  			                    ),
  			                    'paged'=> get_query_var('paged'),
  			                    );
  							$x = 1;
  							$news_post = new WP_Query($arg);
  							while($news_post -> have_posts()) :
  	                    	$news_post -> the_post();
  							?>
                <div class="news-item-sidebar-clear">
                    <div class="boxx__innner">
                       <div class="news-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                                    </a>               
                          </div>
                          <div class="box__slider">
                             <h4><a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                             <div class="box__description">
                                <?php echo the_excerpt(); ?>
                            </div>
                          </div>
                    </div>
                </div>
                <?php
  							$x++; 
  							endwhile;
  							
  						?>
  					</div>
  					<?php flatsome_posts_pagination();
  		                    wp_reset_postdata(); ?>
  					
  			</div>
<!--         <div class="box__right__layout">
            <?php dynamic_sidebar( 'Sidebar' ); ?>
        </div> -->
      </div>
		</div>
	</div>

<?php get_footer(); ?>
	
