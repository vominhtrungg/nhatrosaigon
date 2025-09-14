<?php
  $url = get_stylesheet_directory_uri();
  get_header(); 
?>
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <div class="page-wrapper page-right-sidebar">
        <div class="container">
          <div class="section__width">
            <div class="box__left__layout2">
            <h2 class="tits"><span><?php the_title(); ?></span></h2>
      			<?php if(have_posts()) : the_post();	
      			  ?>
              
					       <?php the_content(); ?>
              <?php endif ?>

              <div id="related-post1">
   
                <?php
                    $taxonomy = 'service';  // or whatever you want
                    $category = wp_get_object_terms( $post->ID, $taxonomy,array('orderby' => 'term_group', 'order' => 'DESC'));
                    // echo "<pre>";
                    // print_r($category);
                    // echo "</pre>";

                    $args = array(
                    'post_type' => 'service-post',
                    'tax_query' => array(
                    array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'id',
                    'terms'     => $category[0]->term_id
                    )
                    ),
                    'post__not_in' => array($post->ID),
                    'showposts' => 6 // Number of related posts that will be shown.
                    );
                    // var_dump($category);
                    $query = new WP_Query($args);
                     if($query->have_posts()){
                    echo '<h4 class="tits"><span>Dự án liên quan</span></h4>';
                    ?>
                    <div class="box__nth__2">
                    <?php
                        while($query->have_posts()):
                        $query->the_post();
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
                              <?php ?>
                    <?php
                        endwhile;
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class="box__right__layout2">
                <?php dynamic_sidebar( 'Menu chi tiết dịch vụ' ); ?>
            </div>
        </div>

      </div>


    </main><!-- #main -->
  </div><!-- #primary -->

<?php

get_footer();
