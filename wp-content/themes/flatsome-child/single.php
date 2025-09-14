<?php
  $url = get_stylesheet_directory_uri();
  get_header(); 
?>
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <div class="page-wrapper page-right-sidebar">

        <div class="container">
          <div class="section__width">
            <div class="box__left__layout">
            <h2 class="tits"><span><?php the_title(); ?></span></h2>
      			<?php if(have_posts()) : the_post();	
      			  ?>
              
					       <?php the_content(); ?>
              <?php endif ?>

              <div id="related-post1">
   
              <h3 class="tits"><span>Bài viết liên quan</span></h3>
              <div class="box__nth__2">
                <?php
                global $post;
            $category = wp_get_object_terms( $post->ID, 'category',array('orderby' => 'parent', 'order' => 'DESC'));
                $rel = new WP_Query(array(
                'category__in' => wp_get_post_categories($post->ID),
                'showposts' => 6,
                'post__not_in' => array($post->ID)
                  ));
                    if($rel->have_posts()):
                      while($rel->have_posts()):
                          $rel->the_post();  
                  ?>
                      <div class="news-post-news">
                                  <div class="box__news__inner">
                                     <div class="box__thumb__img">
                                          <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                              <?php if(has_post_thumbnail()) the_post_thumbnail("full",array("alt" => get_the_title()));
                                               else echo ""; ?>
                                           </a>
                                      </div>
                                      <div class="box__content">
                                            <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title();?></a>
                                      </div>
                                  </div>
                                </div>
                  <?php
                      endwhile;
                      endif;
                  ?>
              </div>
                </div>
            </div>
           <!--  <div class="box__right__layout">
                <?php dynamic_sidebar( 'Sidebar' ); ?>
            </div> -->
        </div>

      </div>


    </main><!-- #main -->
  </div><!-- #primary -->

<?php

get_footer();
