<?php
  $url = get_stylesheet_directory_uri();
  get_header();
?>
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <div class="page-wrapper page-right-sidebar">
        
        <div class="container">
          <div class="section__width">
            <div class="new_cnt_project">
                <div class="left">
                    <?php
                      the_post_thumbnail();
                    ?>
                </div>
                <div class="right">
                    <h1 class="heading-title-single"><?php the_title(); ?></h1>
                    <!-- <p class="location"><span>Location:</span> <?php the_field('location'); ?></p>
                    <div class="fbs">
                       <div class="fb-like" data-href="https://www.facebook.com/0974.80.80.80.webRT" data-width="" data-layout="button" data-action="like" data-size="small" data-share="false"></div>

                       <div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    </div> -->

                    <div class="thong_tin_da">
                      <h4>THÔNG TIN DỰ ÁN</h4>
                      <div class="left">
                          <p><span>Ngày:</span> <?php the_field('date_rt'); ?></p>
                          <p><span>Vị trí:</span> <?php the_field('location'); ?></p>
                          <p><span>Khu vực:</span> <?php the_field('area_rt'); ?></p>
                          <p><span>Khách hàng:</span> <?php the_field('client_rt'); ?></p>
                          <p><span>Loại:</span> 
                            <?php 
                              $terms = get_the_terms( $post->ID, 'project' );
                                if ( $terms && ! is_wp_error( $terms ) ) :
                                    $draught_links = array();
                                    foreach ( $terms as $term ) {
                                        $draught_links[] = $term->name;
                                      }
                                      $on_draught = join( ", ", $draught_links );
                                      echo $on_draught;
                                  ?> 
                              <?php endif; ?>
                          </p>
                      </div>
                      
                    </div>
                </div>
                
            </div>

            <h2 class="tits"><span style="text-transform: initial;">Mô tả dự án</span></h2>
      			<?php if(have_posts()) : the_post();	
      			  ?>
              
					       <?php the_content(); ?>
              <?php endif ?>

              <div class="nav-single">
                 <span class="nav-previous">
                 <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( 'Dự án trước', 'Previous post link', '' ) . '</span> %title' ); ?>
                 </span>
                 <span><a href="https://noithatwin.vn/project/tat-ca-du-an/">Xem tất cả dự án</a></span>
                 <span class="nav-next">
                 <?php next_post_link( '%link', '<span class="meta-nav">' . _x( 'Dự án sau', 'Next post link', '' ) . '</span> %title' ); ?>
                 </span>
               </div><!-- .nav-single -->

              <div id="related-post1">
   
                <?php
                    $taxonomy = 'project';  // or whatever you want
                    $category = wp_get_object_terms( $post->ID, $taxonomy,array('orderby' => 'term_group', 'order' => 'DESC'));
                    // echo "<pre>";
                    // print_r($category);
                    // echo "</pre>";

                    $args = array(
                    'post_type' => 'project-post',
                    'tax_query' => array(
                    array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'id',
                    'terms'     => $category[0]->term_id
                    )
                    ),
                    'post__not_in' => array($post->ID),
                    'showposts' => 8 // Number of related posts that will be shown.
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

      </div>


    </main><!-- #main -->
  </div><!-- #primary -->

<?php

get_footer();
