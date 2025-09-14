<?php
    $url = get_stylesheet_directory_uri();
    $term = $wp_query->get_queried_object();
    $category_id = $term->term_id;
     get_header(); 
?>
      <div class="page-wrapper page-right-sidebar">
        <div class="container">
               <div class="section__width">

                <div class="box__left__layout__full">
<!--                   <h1 class="heading">
                            <?php echo $term->name ;?>
                  </h1> -->

                 <div class="new-list">
                  <div class="box__colum__images">
                      <?php
                          $x = 1;
                           $arg = array(
                          'post_type' => 'project-post',
                          'tax_query' => array(
                              array(
                                  'taxonomy' => 'project',
                                  'field' => 'id',
                                  'terms' => $category_id
                              )
                          ),
                          'paged'=> get_query_var('paged'),
                          );
                          $news_post = new WP_Query($arg);
                          while($news_post -> have_posts()) :
                          $news_post -> the_post();
                          ?>
                            <div class="news-post-image">
                              <div class="box__news__inner">
                                 <div class="box__thumb__img">
                                    <div>
                                      <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                          <?php if(has_post_thumbnail()) the_post_thumbnail("full",array("alt" => get_the_title()));
                                           else echo ""; ?>
                                      </a>
                                      
                                    </div>
                                  </div>
                                  <div class="cnt">
                                      <a class="view" href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                      <a href="<?php the_permalink();?>" class="view2">Xem thêm hình ảnh</a>
                                  </div>
                              </div>
                            </div>
                          <?php
                           $x++;
                          endwhile; 
                          wp_reset_postdata();

                         flatsome_posts_pagination();
                          ?>
                  </div>
              
            </div>


              </div> <!-- .large-9 -->


       </div>
        </div>

      </div>

<?php

get_footer();
