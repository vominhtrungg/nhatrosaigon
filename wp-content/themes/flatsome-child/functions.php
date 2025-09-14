<?php

add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
/*
 * Ví dụ về thêm shortcode cho UX Builder
 * Hiển thị 1 số tùy chỉnh
 * Author hoangcuong
 */
function devvn_ux_builder_element(){
    add_ux_builder_shortcode('devvn_viewnumber', array(
        'name'      => __('Block 1'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        //  'ids' => array(
        //     'type' => 'select',
        //     'heading' => 'Custom Posts',
        //     'param_name' => 'ids',
        //     'config' => array(
        //         'multiple' => true,
        //         'placeholder' => 'Select..',
        //         'postSelect' => array(
        //             'post_type' => array('post')
        //         ),
        //     )
        // ),
        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            // 'conditions' => 'ids === ""',
            'default' => '',
            'config' => array(
                // 'multiple' => true,
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'post',
                    'taxonomies' => 'category'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element');

 
function devvn_viewnumber_func($atts){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();

    // var_dump($atts);
    ?>
     <div class="news-widget-sidebar-widget">
    <?php
     $x = 1;
      $arg = array(
        'post_type' => 'post',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
            if ($x == 1) {
                ?>
                  <div class="news-item-sidebar">
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
                  <div class="right">
              <?php 
            }else {
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
                          </div>
                    </div>
                         
                  </div>
              <?php 
            }

           $x++;
      endwhile;
    wp_reset_postdata();
?>
  </div>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber', 'devvn_viewnumber_func');




function devvn_ux_builder_element2(){
    add_ux_builder_shortcode('devvn_viewnumber_2', array(
        'name'      => __('Block 2'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        //  'ids' => array(
        //     'type' => 'select',
        //     'heading' => 'Custom Posts',
        //     'param_name' => 'ids',
        //     'config' => array(
        //         'multiple' => true,
        //         'placeholder' => 'Select..',
        //         'postSelect' => array(
        //             'post_type' => array('post')
        //         ),
        //     )
        // ),

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            // 'conditions' => 'ids === ""',
            'default' => '',
            'config' => array(
                // 'multiple' => true,
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'post',
                    'taxonomies' => 'category'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element2');

 
function devvn_viewnumber_func_2($atts){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();

    // var_dump($atts);
    ?>
    <h2 class="heading">
    <a href="<?php echo get_category_link($cat); ?>">
          <?php echo get_cat_name($cat); ?>
        </a>
    </h2>
    <div class="news-widget-widget news-style-2">
    <?php
     $x = 1;
      $arg = array(
        'post_type' => 'post',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
                    if ($x == 1) {
                      echo '<div class="box_first_posts">';
                        ?>
                          <div class="news-item-posts">
                            <div class="boxx__innner">
                               <div class="news-thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                                            </a>               
                                  </div>
                                  <div class="box__slider">
                                     <h4><a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="date">
                                          <i class="fas fa-calendar-alt"></i> <?php echo the_time('d/m/Y h:s'); ?>
                                        </div>
                                  </div>
                            </div>
                          </div>
                      <?php 
                    }elseif ($x == 2) {
                      ?>
                          <div class="news-item-posts">
                            <div class="boxx__innner">
                               <div class="news-thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                                            </a>               
                                  </div>
                                  <div class="box__slider">
                                     <h4><a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="date">
                                         <i class="fas fa-calendar-alt"></i> <?php echo the_time('d/m/Y h:s'); ?>
                                        </div>
                                  </div>
                            </div>
                          </div>
                      <?php
                    }
                    elseif ($x == 3) {
                      echo '</div><div class="box__second_posts">';
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
                                          <div class="date">
                                              <i class="fas fa-calendar-alt"></i> <?php echo the_time('d/m/Y h:s'); ?>
                                          </div>
                                    </div>
                              </div>
                          </div>
                      <?php
                    }
                    else {
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
                                          <div class="date">
                                              <i class="fas fa-calendar-alt"></i> <?php echo the_time('d/m/Y h:s'); ?>
                                          </div>
                                    </div>
                              </div>
                          </div>
                      <?php 
                    }
                    if ($x == $number) {
                      echo '</div>';
                    }

           $x++;
      endwhile;
    wp_reset_postdata();
?>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_2', 'devvn_viewnumber_func_2');




// block 3
function devvn_ux_builder_element_3(){
    add_ux_builder_shortcode('devvn_viewnumber_3', array(
        'name'      => __('Dự án'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        //  'ids' => array(
        //     'type' => 'select',
        //     'heading' => 'Custom Posts',
        //     'param_name' => 'ids',
        //     'config' => array(
        //         'multiple' => true,
        //         'placeholder' => 'Select..',
        //         'postSelect' => array(
        //             'post_type' => array('post')
        //         ),
        //     )
        // ),

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            // 'conditions' => 'ids === ""',
            'default' => '',
            'config' => array(
                // 'multiple' => true,
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'project-post',
                    'taxonomies' => 'project'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_3');

function devvn_viewnumber_func_3($atts){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();

    // var_dump($atts);
    ?>
     <div class="news-style-3 box__nth__2">
    <?php
     $x = 1;
      $arg = array(
        'post_type' => 'project-post',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'project',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
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

           $x++;
      endwhile;
    wp_reset_postdata();
?>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_3', 'devvn_viewnumber_func_3');


// block 4

function devvn_ux_builder_element_4(){
    add_ux_builder_shortcode('devvn_viewnumber_4', array(
        'name'      => __('Tin tức 2'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        //  'ids' => array(
        //     'type' => 'select',
        //     'heading' => 'Custom Posts',
        //     'param_name' => 'ids',
        //     'config' => array(
        //         'multiple' => true,
        //         'placeholder' => 'Select..',
        //         'postSelect' => array(
        //             'post_type' => array('post')
        //         ),
        //     )
        // ),

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            // 'conditions' => 'ids === ""',
            'default' => '',
            'config' => array(
                // 'multiple' => true,
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'post',
                    'taxonomies' => 'category'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_4');

function devvn_viewnumber_func_4($atts){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();

    // var_dump($atts);
    ?>
    <!-- <h2 class="heading">
    <a href="<?php echo get_category_link($cat); ?>">
          <?php echo get_cat_name($cat); ?>
        </a>
    </h2> -->
    <div class="slogan"><?php echo category_description( $cat );?></div>
    <div class="news-block-widget-style-4">
    <div class='box__colum__left'>
    <?php
     $x = 1;
      $arg = array(
        'post_type' => 'post',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
              ?>
              <div class="news-item">
                <div class="boxx__innner">
                   <div class="news-thumb">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                        </a>
                     <!--    <div class="date">
                          <p><?php the_time('M'); ?></p>
                          <p><?php the_time('Y'); ?></p>
                          <p><?php the_time('d'); ?></p>
                        </div>  -->           
                   </div>
                  <!--  <div class="news-text">
                     <a href="<?php the_permalink(); ?>">Tin HOT</a>
                   </div> -->
                   <div class="box__slider">
                         <h4><a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                          <div class="box__description">
                                <?php echo the_excerpt(); ?>
                          </div>
                          <div class="clear__views"><a class="views_all" href="<?php the_permalink(); ?>">Xem thêm</a></div>
                   </div>
                </div>
              </div>
              <?php

           $x++;
      endwhile;
    wp_reset_postdata();
?>
  </div></div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_4', 'devvn_viewnumber_func_4');


// block 5

function devvn_ux_builder_element_5(){
    add_ux_builder_shortcode('devvn_viewnumber_5', array(
        'name'      => __('Block 5'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        //  'ids' => array(
        //     'type' => 'select',
        //     'heading' => 'Custom Posts',
        //     'param_name' => 'ids',
        //     'config' => array(
        //         'multiple' => true,
        //         'placeholder' => 'Select..',
        //         'postSelect' => array(
        //             'post_type' => array('post')
        //         ),
        //     )
        // ),

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            // 'conditions' => 'ids === ""',
            'default' => '',
            'config' => array(
                // 'multiple' => true,
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'post',
                    'taxonomies' => 'category'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_5');

function devvn_viewnumber_func_5($atts){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();

    // var_dump($atts);
    ?>
    <div class="news-widget-style-5">
    <?php
      $arg = array(
        'post_type' => 'post',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
        ?>
           <div class="news-item-clear">
              <div class="boxx__innner">
                 <div class="news-thumb">
                              <a href="<?php the_permalink(); ?>">
                                  <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                              </a>               
                  </div>
              </div>     
          </div>
        <?php
      endwhile;
    wp_reset_postdata();
?>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_5', 'devvn_viewnumber_func_5');



// block 5

function devvn_ux_builder_element_6(){
    add_ux_builder_shortcode('devvn_viewnumber_6', array(
        'name'      => __('Tin tức'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        //  'ids' => array(
        //     'type' => 'select',
        //     'heading' => 'Custom Posts',
        //     'param_name' => 'ids',
        //     'config' => array(
        //         'multiple' => true,
        //         'placeholder' => 'Select..',
        //         'postSelect' => array(
        //             'post_type' => array('post')
        //         ),
        //     )
        // ),

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            // 'conditions' => 'ids === ""',
            'default' => '',
            'config' => array(
                // 'multiple' => true,
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'post',
                    'taxonomies' => 'category'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_6');

function devvn_viewnumber_func_6($atts){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();

    // var_dump($atts);
    ?>
    <h2 class="heading">
    <a href="<?php echo get_category_link($cat); ?>">
          <?php echo get_cat_name($cat); ?>
        </a>
    </h2>
  <div class="news-block-widget-style-6">
    <?php
      $arg = array(
        'post_type' => 'post',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
                            if ($x = 1) {
                      echo "<div class='box__colum__left'>";
                        ?>
                          <div class="news-item">
                            <div class="boxx__innner">
                               <div class="news-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                                    </a>
                                    <div class="date">
                                      <p><?php the_time('F'); ?></p>
                                      <p><?php the_time('Y'); ?></p>
                                      <p><?php the_time('j'); ?></p>
                                    </div>            
                               </div>
                               <div class="news-text">
                                 <a href="<?php the_permalink(); ?>">Tin HOT</a>
                               </div>
                               <div class="box__slider">
                                     <h4><a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                      <div class="box__description">
                                            <?php echo the_excerpt(); ?>
                                      </div>
                                      <div class="clear__views"><a class="views_all" href="<?php the_permalink(); ?>">Xem thêm</a></div>
                               </div>
                            </div>
                                 
                          </div>
                      <?php 
                    }elseif ($x == 2) {
                      echo "</div><div class='box__colum__right'>";
                      ?>
                          <div class="news-item-clear">
                            <div class="boxx__innner">
                              <div class="news-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                                    </a>
                                    <div class="date">
                                      <p><?php the_time('F'); ?></p>
                                      <p><?php the_time('Y'); ?></p>
                                      <p><?php the_time('j'); ?></p>
                                    </div>               
                               </div>
                               <div class="box__slider">
                                     <h4><a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                     <p><span>By <?php the_author_posts_link(); ?></span> <span><?php the_time('d/m/Y'); ?></span></p>
                                      <div class="box__description">
                                            <?php echo the_excerpt(); ?>
                                      </div>
                                      <div class="clear__views"><a class="views_all" href="<?php the_permalink(); ?>">Đọc thêm</a></div>
                               </div>
                            </div>    
                          </div>
                      <?php
                    }
                    else {
                    ?>
                          <div class="news-item-clear">
                            <div class="boxx__innner">
                               <div class="news-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail("large",array("title" => get_the_title())) ?>               
                                    </a>
                                    <div class="date">
                                      <p><?php the_time('F'); ?></p>
                                      <p><?php the_time('Y'); ?></p>
                                      <p><?php the_time('j'); ?></p>
                                    </div>                 
                               </div>
                               <div class="box__slider">
                                     <h4><a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                     <p><span>By <?php the_author_posts_link(); ?></span> <span><?php the_time('d/m/Y'); ?></span></p>
                                      <div class="box__description">
                                            <?php echo the_excerpt(); ?>
                                      </div>
                                      <div class="clear__views"><a class="views_all" href="<?php the_permalink(); ?>">Đọc thêm</a></div>
                               </div>
                            </div>
                                 
                          </div>
                      <?php 
                    }
                    if ($x == $number) {
                      echo "</div>";
                    }

           $x++;
      endwhile;
    wp_reset_postdata();
?>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_6', 'devvn_viewnumber_func_6');



/*
 * Ví dụ về thêm shortcode cho UX Builder
 * Hiển thị 1 số tùy chỉnh
 * Author levantoan.com
 */

add_filter( 'add_to_cart_text', 'woo_custom_product_add_to_cart_text' );            // < 2.1
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_product_add_to_cart_text' );  // 2.1 +

  
function woo_custom_product_add_to_cart_text() {
  
    return __( 'Xem chi tiết', 'woocommerce' );
  
}

function flatsome_woocommerce_shop_loop_button() {
    if ( flatsome_option( 'add_to_cart_icon' ) !== "button" ) {
      return;
    }
    global $product;

    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
      sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" class="%s %s product_type_%s button %s is-%s mb-0 is-%s">%s</a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( $product->get_id() ),
        esc_attr( $product->is_type( 'variable' ) || $product->is_type( 'grouped' ) ? '' : 'ajax_add_to_cart' ),
        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
        esc_attr( $product->get_type() ),
        esc_attr( 'primary' ), // Button color
        esc_attr( get_theme_mod( 'add_to_cart_style', 'outline' ) ), // Button style
        esc_attr( 'small' ), // Button size
        esc_html( $product->add_to_cart_text() ) ),
      $product );
  }
add_action( 'rt_add_to_cart', 'flatsome_woocommerce_shop_loop_button', 10 );


// Shortcode to display a single product
function devvn_ux_builder_element_product(){
    add_ux_builder_shortcode('devvn_viewnumber_product', array(
        'name'      => __('Sản phẩm dạng 1'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            'default' => '',
            'config' => array(
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'product',
                    'taxonomies' => 'product_cat'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_product');

 
function devvn_viewnumber_func_product($atts){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();
  $getcat = get_term_by( 'id', $cat , 'product_cat' );
    // var_dump($atts);
    ?>
  <h2 class="heading">
        <a href="<?php echo get_term_link( (int) $cat, 'product_cat'); ?>">
          <?php echo $getcat->name; ?>
        </a>
    </h2>
     <div class="block-product-1 block-product-col block-product-col-4">
    <?php
      $arg = array(
        'post_type' => 'product',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      $i=0;
      while($news_post -> have_posts()) :
      $news_post -> the_post();
      $i++;
      if($i == 1){
    global $product;
          // Check stock status.
    $out_of_stock = get_post_meta( $post->ID, '_stock_status', true ) == 'outofstock';

    // Extra post classes.
    $classes   = array();
    $classes[] = 'product-small';
    $classes[] = 'col col-3';
    $classes[] = 'has-hover';

    if ( $out_of_stock ) $classes[] = 'out-of-stock';
    ?>
      <div class="spd1_box_left <?php echo $i; ?>">
        <div <?php fl_woocommerce_version_check( '3.4.0' ) ? wc_product_class( $classes ) : post_class( $classes ); ?>>
          <div class="col-inner">
            <?php echo woocommerce_show_product_loop_sale_flash(); ?>
            <div class="product-small <?php echo implode(' ', $classes_box); ?>">
              <div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
                <div class="<?php echo implode(' ', $classes_image); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
                  <a href="<?php echo get_the_permalink(); ?>">
                    <?php
                      if($back_image) echo flatsome_woocommerce_get_alt_product_thumbnail($image_size);
                      echo woocommerce_get_product_thumbnail($image_size);
                    ?>
                  </a>
                  <?php if($image_overlay){ ?><div class="overlay fill" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
                   <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                </div>
                <div class="image-tools top right show-on-hover">
                  <?php do_action('flatsome_product_box_tools_top'); ?>
                </div>
                <?php if($style !== 'shade' && $style !== 'overlay') { ?>
                  <div class="image-tools <?php echo flatsome_product_box_actions_class(); ?>">
                    <?php  do_action('flatsome_product_box_actions'); ?>
                  </div>
                <?php } ?>
                <?php if($out_of_stock) { ?><div class="out-of-stock-label"><?php _e( 'Out of stock', 'woocommerce' ); ?></div><?php }?>
              </div><!-- box-image -->

              <div class="box-text <?php echo implode(' ', $classes_text); ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
                <?php
                  do_action( 'woocommerce_before_shop_loop_item_title' );

                  echo '<div class="title-wrapper">';
                  do_action( 'woocommerce_shop_loop_item_title' );
                  echo '</div>';

                  echo '<div class="price-wrapper">';
                  do_action( 'woocommerce_after_shop_loop_item_title' );
                  echo '</div>';

                  if($style == 'shade' || $style == 'overlay') {
                  echo '<div class="overlay-tools">';
                    do_action('flatsome_product_box_actions');
                  echo '</div>';
                  }

                ?>
                  <div class="rt_add_to_cart clearfix">
                    <?php do_action( 'rt_add_to_cart' ); ?>
                  </div>
              </div><!-- box-text -->
            </div><!-- box -->
          </div><!-- .col-inner -->
        </div><!-- col -->
      </div>
      <div class="spd1_box_right <?php echo $i; ?>">
      <?php }else{ ?>
          <div <?php fl_woocommerce_version_check( '3.4.0' ) ? wc_product_class( $classes ) : post_class( $classes ); ?>>
            <div class="col-inner">
              <?php echo woocommerce_show_product_loop_sale_flash(); ?>
              <div class="product-small <?php echo implode(' ', $classes_box); ?>">
                <div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
                  <div class="<?php echo implode(' ', $classes_image); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
                    <a href="<?php echo get_the_permalink(); ?>">
                      <?php
                        if($back_image) echo flatsome_woocommerce_get_alt_product_thumbnail($image_size);
                        echo woocommerce_get_product_thumbnail($image_size);
                      ?>
                    </a>
                    <?php if($image_overlay){ ?><div class="overlay fill" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
                     <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                  </div>
                  <div class="image-tools top right show-on-hover">
                    <?php do_action('flatsome_product_box_tools_top'); ?>
                  </div>
                  <?php if($style !== 'shade' && $style !== 'overlay') { ?>
                    <div class="image-tools <?php echo flatsome_product_box_actions_class(); ?>">
                      <?php  do_action('flatsome_product_box_actions'); ?>
                    </div>
                  <?php } ?>
                  <?php if($out_of_stock) { ?><div class="out-of-stock-label"><?php _e( 'Out of stock', 'woocommerce' ); ?></div><?php }?>
                </div><!-- box-image -->

                <div class="box-text <?php echo implode(' ', $classes_text); ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
                  <?php
                    do_action( 'woocommerce_before_shop_loop_item_title' );

                    echo '<div class="title-wrapper">';
                    do_action( 'woocommerce_shop_loop_item_title' );
                    echo '</div>';

                    echo '<div class="price-wrapper">';
                    do_action( 'woocommerce_after_shop_loop_item_title' );
                    echo '</div>';

                    if($style == 'shade' || $style == 'overlay') {
                    echo '<div class="overlay-tools">';
                      do_action('flatsome_product_box_actions');
                    echo '</div>';
                    }

                  ?>
                </div><!-- box-text -->
              </div><!-- box -->
            </div><!-- .col-inner -->
          </div><!-- col -->
      <?php } ?>
              <?php 
      endwhile;
    wp_reset_postdata();
?>
    </div></div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_product', 'devvn_viewnumber_func_product');


//**************************************************************//
function devvn_ux_builder_element_product_2(){
    add_ux_builder_shortcode('devvn_viewnumber_product_2', array(
        'name'      => __('Sản phẩm dạng 2'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            'default' => '',
            'config' => array(
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'product',
                    'taxonomies' => 'product_cat'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_product_2');

function devvn_viewnumber_func_product_2($atts2){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts2));
    ob_start();
  $getcat = get_term_by( 'id', $cat , 'product_cat' );
    // var_dump($atts);
    ?>
  <h2 class="hds clear">
        <a href="<?php echo get_term_link( (int) $cat, 'product_cat'); ?>">
          <?php echo $getcat->name; ?>
        </a>
    </h2>
     <div class="block-product-1 block-product-col block-product-col-4">
    <?php
      $arg = array(
        'post_type' => 'product',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
      global $product;
          // Check stock status.
    $out_of_stock = get_post_meta( $post->ID, '_stock_status', true ) == 'outofstock';

    // Extra post classes.
    $classes   = array();
    $classes[] = 'product-small';
    $classes[] = 'col col-3';
    $classes[] = 'has-hover';

    if ( $out_of_stock ) $classes[] = 'out-of-stock';
    ?>
                <div <?php fl_woocommerce_version_check( '3.4.0' ) ? wc_product_class( $classes ) : post_class( $classes ); ?>>
            <div class="col-inner">
            <?php echo woocommerce_show_product_loop_sale_flash(); ?>
            <div class="product-small <?php echo implode(' ', $classes_box); ?>">
              <div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
                <div class="<?php echo implode(' ', $classes_image); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
                  <a href="<?php echo get_the_permalink(); ?>">
                    <?php
                      if($back_image) echo flatsome_woocommerce_get_alt_product_thumbnail($image_size);
                      echo woocommerce_get_product_thumbnail($image_size);
                    ?>
                  </a>
                  <?php if($image_overlay){ ?><div class="overlay fill" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
                   <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                </div>
              </div><!-- box-image -->

              <div class="box-text <?php echo implode(' ', $classes_text); ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
                <?php
                  do_action( 'woocommerce_before_shop_loop_item_title' );

                  echo '<div class="title-wrapper">';
                  do_action( 'woocommerce_shop_loop_item_title' );
                  echo '</div>';

                  echo '<div class="box-p">';
                    $gia  = $product->regular_price;
                    $giakm  = $product->sale_price;
                    global $product;
                      $gia  = $product->regular_price;
                      $giakm  = $product->sale_price;
                      echo '<p class="price_pro">';
                        if( ! empty( $giakm ) && ! empty( $gia ) ) {
                          echo "<ins> <span>" . number_format($giakm,0,'','.')."đ </span></ins> <del> <span>" . number_format($gia,0,'','.') . "đ</span></del>";
                        } else {
                          echo "<span>";
                          if(!empty($gia)) echo "" . number_format($gia,0,'','.')."đ"; else echo "Liên Hệ";
                          echo "</span>"; 
                        }
                      echo "</p>";
                  echo '</div>';

                ?>
                  <!-- <div class="rt_add_to_cart clearfix">
                    <a href="<?php the_permalink(); ?>" class="view_product"><?php echo esc_html__( 'Chi tiết', 'rt' ); ?></a>
                    <?php do_action( 'rt_add_to_cart' ); ?>
                  </div> -->
              </div><!-- box-text -->
            </div><!-- box -->
          </div><!-- .col-inner -->
        </div><!-- col -->
              <?php 
      endwhile;
    wp_reset_postdata();
?>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_product_2', 'devvn_viewnumber_func_product_2');

//**************************************************************//
function devvn_ux_builder_element_product_3(){
    add_ux_builder_shortcode('devvn_viewnumber_product_3', array(
        'name'      => __('Sản phẩm dạng 3'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            'default' => '',
            'config' => array(
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'product',
                    'taxonomies' => 'product_cat'
                ),
            )
        ),

        // 'number'    =>  array(
        //         'type' => 'scrubfield',
        //         'heading' => 'Numbers',
        //         'default' => '1',
        //         'step' => '1',
        //         'unit' => '',
        //         'min'   =>  1,
        //     ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_product_3');

function devvn_viewnumber_func_product_3($atts3){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts3));
    ob_start();
  $getcat = get_term_by( 'id', $cat , 'product_cat' );
    // var_dump($atts);
    ?>
    <h2 class="heading clear">
        <a href="<?php echo get_term_link( (int) $cat, 'product_cat'); ?>">
          <?php echo $getcat->name; ?>
        </a>
    </h2>
     <div class="block-product-3 block-product-32 block-product-col block-product-col-4">

      <div class="box_2">
    <?php
      $arg = array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'tax_query' => array(
            array(
          'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      $x = 0;
      while($news_post -> have_posts()) :
      $x++;
      $news_post -> the_post();
      global $product;
          // Check stock status.
    $out_of_stock = get_post_meta( $post->ID, '_stock_status', true ) == 'outofstock';

    // Extra post classes.
    $classes   = array();
    $classes[] = 'product-small';
    $classes[] = 'col col-4';
    $classes[] = 'has-hover';

    if ( $out_of_stock ) $classes[] = 'out-of-stock';
    ?>
                <div <?php fl_woocommerce_version_check( '3.4.0' ) ? wc_product_class( $classes ) : post_class( $classes ); ?>>
            <div class="col-inner">
            <?php echo woocommerce_show_product_loop_sale_flash(); ?>
            <div class="product-small <?php echo implode(' ', $classes_box); ?>">
              <div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
                <div class="<?php echo implode(' ', $classes_image); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
                  <a href="<?php echo get_the_permalink(); ?>">
                    <?php
                      if($back_image) echo flatsome_woocommerce_get_alt_product_thumbnail($image_size);
                      echo woocommerce_get_product_thumbnail($image_size);
                    ?>
                  </a>
                  <?php if($image_overlay){ ?><div class="overlay fill" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
                   <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                </div>
                <div class="image-tools top right show-on-hover">
                  <?php do_action('flatsome_product_box_tools_top'); ?>
                </div>
                <?php if($style !== 'shade' && $style !== 'overlay') { ?>
                <?php } ?>
                <?php if($out_of_stock) { ?><div class="out-of-stock-label"><?php _e( 'Out of stock', 'woocommerce' ); ?></div><?php }?>
              </div><!-- box-image -->

              <div class="box-text <?php echo implode(' ', $classes_text); ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
                <?php
                  echo '<div class="title-wrapper">';
                  do_action( 'woocommerce_shop_loop_item_title' );
                  echo '</div>';
                ?>
              </div><!-- box-text -->
            </div><!-- box -->
          </div><!-- .col-inner -->
        </div><!-- col -->
              <?php 
              if(!empty($x == 2)){
                echo "</div><div class='box_2'>";
              }
              if(!empty($x == 4)){
                echo "</div><div class='box_2'>";
              }
              if(!empty($x == 6)){
                echo "</div><div class='box_2'>";
              }
              if(!empty($x == 8)){
                echo "</div><div class='box_2'>";
              }
              if(!empty($x == 10)){
                echo "</div><div class='box_2'>";
              }
      endwhile;
    wp_reset_postdata();
?>
    </div>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_product_3', 'devvn_viewnumber_func_product_3');


//**************************************************************//
function devvn_ux_builder_element_product_4(){
    add_ux_builder_shortcode('devvn_viewnumber_product_4', array(
        'name'      => __('Sản phẩm dạng 4'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            'default' => '',
            'config' => array(
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'product',
                    'taxonomies' => 'product_cat'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_product_4');

function devvn_viewnumber_func_product_4($atts4){
  global $post;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts4));
    ob_start();
  $getcat = get_term_by( 'id', $cat , 'product_cat' );
    // var_dump($atts);
    ?>
  <h2 class="heading clear">
        <a href="<?php echo get_term_link( (int) $cat, 'product_cat'); ?>">
          <?php echo $getcat->name; ?>
        </a>
    </h2>
     <div class="block-product-3 block-product-col block-product-col-4">
    <?php
      $arg = array(
        'post_type' => 'product',
        'posts_per_page' => $number,
        'tax_query' => array(
            array(
          'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $cat
            )
        ),
      );
      $news_post = new WP_Query($arg);
      while($news_post -> have_posts()) :
      $news_post -> the_post();
      global $product;
          // Check stock status.
    $out_of_stock = get_post_meta( $post->ID, '_stock_status', true ) == 'outofstock';

    // Extra post classes.
    $classes   = array();
    $classes[] = 'product-small';
    $classes[] = 'col col-4';
    $classes[] = 'has-hover';

    if ( $out_of_stock ) $classes[] = 'out-of-stock';
    ?>
                <div <?php fl_woocommerce_version_check( '3.4.0' ) ? wc_product_class( $classes ) : post_class( $classes ); ?>>
            <div class="col-inner">
            <?php echo woocommerce_show_product_loop_sale_flash(); ?>
            <div class="product-small <?php echo implode(' ', $classes_box); ?>">
              <div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
                <div class="<?php echo implode(' ', $classes_image); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
                  <a href="<?php echo get_the_permalink(); ?>">
                    <?php
                      if($back_image) echo flatsome_woocommerce_get_alt_product_thumbnail($image_size);
                      echo woocommerce_get_product_thumbnail($image_size);
                    ?>
                  </a>
                  <?php if($image_overlay){ ?><div class="overlay fill" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
                   <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                </div>
                <div class="image-tools top right show-on-hover">
                  <?php do_action('flatsome_product_box_tools_top'); ?>
                </div>
                <?php if($style !== 'shade' && $style !== 'overlay') { ?>
                <?php } ?>
                <?php if($out_of_stock) { ?><div class="out-of-stock-label"><?php _e( 'Out of stock', 'woocommerce' ); ?></div><?php }?>
              </div><!-- box-image -->

              <div class="box-text <?php echo implode(' ', $classes_text); ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
                <?php
                  echo '<div class="title-wrapper">';
                  do_action( 'woocommerce_shop_loop_item_title' );
                  echo '</div>';
                ?>
              </div><!-- box-text -->
            </div><!-- box -->
          </div><!-- .col-inner -->
        </div><!-- col -->
              <?php 
      endwhile;
    wp_reset_postdata();
?>
  </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_product_4', 'devvn_viewnumber_func_product_4');

function my_custom_translations( $strings ) {
$text = array(
'Quick View' => 'Xem nhanh'
);
$strings = str_ireplace( array_keys( $text ), $text, $strings );
return $strings;
}
add_filter( 'gettext', 'my_custom_translations', 20 );

// thêm chi tiết mua hàng vào product
function readmore() {
  ?>
  <div class="rt_add_to_cart clearfix">
    <a href="<?php the_permalink(); ?>" class="view_product"><?php echo esc_html__( 'Chi tiết', 'rt' ); ?></a><br>
    <?php do_action( 'rt_add_to_cart' ); ?>
  </div>
  <?php
}
//add_action('woocommerce_before_shop_loop_item_title','readmore',1);



//remove tabs woocommerce
function woo_remove_product_tabs( $tabs ) {

    //unset( $tabs['description'] );        // Remove the description tab
    //unset( $tabs['reviews'] );      // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab

    return $tabs;

}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function rt_woocommerce_product_tabs( $tabs = array() ) {
  global $product, $post;

  // Description tab - shows product content
  if ( $post->post_content ) {
    $tabs['description'] = array(
      'title'    => esc_html__( 'Mô tả sản phẩm', 'rt' ),
      'priority' => 10,
      'callback' => 'woocommerce_product_description_tab',
    );
  }
  return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'rt_woocommerce_product_tabs' );

function woocommerce_product_description_tab2(){
  the_field('danh_gia');
}

// like share
function rt_social_sharing_buttons($content) {
    global $post;
    if(is_single()){
    
      // Get current page URL 
      $rtURL = urlencode(get_permalink());
   
      // Get current page title
      $rtTitle = str_replace( ' ', '%20', get_the_title());
      
      // Get Post Thumbnail for pinterest
      $rtThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
   
      // Construct sharing URL without using any script
      $twitterURL = 'https://twitter.com/intent/tweet?text='.$rtTitle.'&amp;url='.$rtURL.'&amp;via=rt';
      $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$rtURL;
      $googleURL = 'https://plus.google.com/share?url='.$rtURL;
      $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$rtURL.'&amp;media='.$rtThumbnail[0].'&amp;description='.$rtTitle;
   
      // Add sharing button at the end of page/page content
      $content .= '<div class="rt-social">';
      $content .= '<a class="rt-link rt-facebook" href="'.$facebookURL.'" target="_blank">Facebook</a>';
      $content .= '<a class="rt-link rt-twitter" href="'. $twitterURL .'" target="_blank">Twitter</a>';
      $content .= '<a class="rt-link rt-googleplus" href="'.$googleURL.'" target="_blank">Google+</a>';
      $content .= '<a class="rt-link rt-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank">Pin It</a>';
      $content .= '</div>';

      $content .= '<div class="rt-cmfb">';
      $content .= '</div>';
      
      return $content;
    }else{
      
      return $content;
    }

  };
  //add_filter( 'the_content', 'rt_social_sharing_buttons');

// cmfb
function woo_new_product_tab_content() {
    ?>
    <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
      <div class="fb-comments" data-href="<?php the_permalink() ;?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
    <?php
    }
//add_action('woocommerce_after_single_product_summary','woo_new_product_tab_content',11);

// single
function rt_woocommerce_single_product_summary() { 
  global $rt_option;
  ?>
  <div class="rt_woocommerce_single_product_summary clearfix">
    <div>
      <?php 
          msp1();
          ?>
            <div class="rt_th">
              <?php 
              global $product;
              $thuong_hieu = get_field('thuong_hieu');
                if ($thuong_hieu) {
                  ?><h4><i class="fa fa-check-circle"></i> Thương hiệu : <p><?php the_field('thuong_hieu'); ?></p></h4><?php
                }
              ?>
            </div>
            <div class ="rt_tu_khoa">
              <?php 
                global $post, $product; $tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) ); echo $product->
                get_tags( ' ', '<span class="tagged_as">' . _n( 'Thương hiệu:', '<i class="fa fa-check-circle"></i> Thẻ:', $tag_count, 'woocommerce' ) . ' ', '</span>' );
              ?>
            </div>
          <?php
          woocommerce_template_single_price();
          woocommerce_template_single_excerpt();
          rt_qv_woocommerce_template_single_price();
          woocommerce_template_single_add_to_cart();
      ?>

    </div>
  </div>
<?php
}
add_action( 'woocommerce_single_product_summary', 'rt_woocommerce_single_product_summary', 20 );

function rt_qv_woocommerce_template_single_price() {
  global $product;
  $gia  = $product->regular_price;
  $giakm  = $product->sale_price;
  echo '<p class="price2">';
    if( ! empty( $giakm ) && ! empty( $gia ) ) {
      echo "<ins><span>" . number_format($giakm,0,'','.')."đ </span></ins> <del><span>" . number_format($gia,0,'','.') . "đ</span></del>";
      ?>
       <!--  <p class="salep">Tiết kiệm đến <?php echo add_percent_sale(); ?></p> -->
      <?php
    } else {
      echo "<span>";
      if(!empty($gia)) echo "" . number_format($gia,0,'','.')."đ"; else echo "Liên Hệ";
      echo "</span>"; 
    }
  echo "</p>";

}
function add_percent_sale(){
  global $product;
  if ($product->is_on_sale()){
    $per = round(( $product->regular_price - $product->sale_price ));
    echo "<span class='percent'>$per đ</span>";
  }
}
function msp1(){
  global $product;
  ?>
    <p class="rt_msp"><span><i class="fa fa-check-circle"></i> Mã sản phẩm: </span><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></p>
  <?php
}
add_action('woocommerce_after_shop_loop_item','add_percent_sale');

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'sp_lquan', 'woocommerce_output_related_products' );

// search
function search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
        $query->set('post_type', array( 'post', 'product' ) );
    }
  }
}
add_action('pre_get_posts','search_filter');

// Tìm kiếm theo danh mục
function hocwp_theme_custom_limit_search_title_only($search, $wp_query) {
    global $wpdb;
    if(empty($search)) {
        return $search;
    }
    $q = $wp_query->query_vars;
    $n = !empty($q['exact']) ? '' : '%';
    $search = '';
    $searchand = '';
    $terms = (array)$q['search_terms'];
    foreach($terms as $term) {
        $term = esc_sql($wpdb->esc_like($term));
        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
        $searchand = ' AND ';
    }
    if(!empty($search)) {
        $search = " AND ({$search}) ";
        if(!is_user_logged_in()) {
            $search .= " AND ($wpdb->posts.post_password = '') ";
        }
    }
    return $search;
}
add_filter('posts_search', 'hocwp_theme_custom_limit_search_title_only', 500, 2);


function add_hotline(){
  ?>
  <a class="hotline_logo" href="tel:0999999999999">Hotline: 0979 789 789</a>
  <?php
}
//add_action('add_hotline_ph','add_hotline');


function cswp_post_views($post_ID) {
    $count_key = 'post_views_count'; 
    $count = get_post_meta($post_ID, $count_key, true);
    if($count == ''){
        $count = 0;
        delete_post_meta($post_ID, $count_key);
        add_post_meta($post_ID, $count_key, '0');
        return $count . '';
    }else{
        $count++;
        update_post_meta($post_ID, $count_key, $count);
        return $count . '';
        }
}

////// custom taxonomy tin tức
///
add_action('init', 'cptui_register_my_cpt_duan');
function cptui_register_my_cpt_duan() {
register_post_type('project-post', array(
  'label' => 'Dự án',
  'description' => '',
  'public' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'capability_type' => 'post',
  'map_meta_cap' => true,
  'hierarchical' => false,
  'rewrite' => array('slug' => 'project-post', 'with_front' => true),
  'query_var' => true,
  'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
  'labels' => array (
    'name' => 'Dự án',
    'singular_name' => 'Dự án',
    'menu_name' => 'Dự án',
    'add_new' => 'Đăng Dự án',
    'add_new_item' => 'Đăng Dự án',
    'edit' => 'Sửa',
    'edit_item' => 'Sửa',
    'new_item' => 'Đăng Dự án',
    'view' => 'Xem bài',
    'view_item' => 'Xem bài',
    'search_items' => 'Tìm',
    'not_found' => 'Không thấy',
    'not_found_in_trash' => 'Không thấy',
    'parent' => 'Cha',
  )
) ); }

// Add danh muc tin tức

add_action('init', 'cptui_register_my_taxes_project');
function cptui_register_my_taxes_project() {
register_taxonomy( 'project',array (
  0 => 'project-post',
),
array( 'hierarchical' => true,
  'label' => 'Dự án category',
  'show_ui' => true,
  'query_var' => true,
  'show_admin_column' => true,
  'labels' => array (
  'search_items' => 'Dự án',
  'popular_items' => 'Nổi bật',
  'all_items' => 'Tất cả',
  'parent_item' => 'Cha',
  'parent_item_colon' => 'Cha',
  'edit_item' => 'Sửa',
  'update_item' => 'Cập nhật',
  'add_new_item' => 'Thêm',
  'new_item_name' => 'Thêm',
  'separate_items_with_commas' => 'Cách nhau bằng dấu phẩy',
  'add_or_remove_items' => 'Thêm hoặc xóa',
  'choose_from_most_used' => 'Chọn nổi bật nhất',
)
) );
}
add_shortcode( 'slider__post', 'add__slidernews' );


////// custom taxonomy service
///
add_action('init', 'cptui_register_my_cpt_service');
function cptui_register_my_cpt_service() {
register_post_type('service-post', array(
  'label' => 'Dịch vụ',
  'description' => '',
  'public' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'capability_type' => 'post',
  'map_meta_cap' => true,
  'hierarchical' => false,
  'rewrite' => array('slug' => 'service-post', 'with_front' => true),
  'query_var' => true,
  'supports' => array('title','editor','excerpt','custom-fields','comments','revisions','thumbnail','author'),
  'labels' => array (
    'name' => 'Dịch vụ',
    'singular_name' => 'Dịch vụ',
    'menu_name' => 'Dịch vụ',
    'add_new' => 'Đăng Dịch vụ',
    'add_new_item' => 'Đăng Dịch vụ',
    'edit' => 'Sửa',
    'edit_item' => 'Sửa',
    'new_item' => 'Đăng Dịch vụ',
    'view' => 'Xem bài',
    'view_item' => 'Xem bài',
    'search_items' => 'Tìm',
    'not_found' => 'Không thấy',
    'not_found_in_trash' => 'Không thấy',
    'parent' => 'Cha',
  )
) ); }

// Add danh muc service

add_action('init', 'cptui_register_my_taxes_service');
function cptui_register_my_taxes_service() {
register_taxonomy( 'service',array (
  0 => 'service-post',
),
array( 'hierarchical' => true,
  'label' => 'Dịch vụ category',
  'show_ui' => true,
  'query_var' => true,
  'show_admin_column' => true,
  'labels' => array (
  'search_items' => 'Dịch vụ',
  'popular_items' => 'Nổi bật',
  'all_items' => 'Tất cả',
  'parent_item' => 'Cha',
  'parent_item_colon' => 'Cha',
  'edit_item' => 'Sửa',
  'update_item' => 'Cập nhật',
  'add_new_item' => 'Thêm',
  'new_item_name' => 'Thêm',
  'separate_items_with_commas' => 'Cách nhau bằng dấu phẩy',
  'add_or_remove_items' => 'Thêm hoặc xóa',
  'choose_from_most_used' => 'Chọn nổi bật nhất',
)
) );
}


if ( ! function_exists( 'hiepdesign_mce_text_sizes' ) ) {
    function hiepdesign_mce_text_sizes( $initArray ){
        $initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 17px 18px 19px 20px 21px 24px 28px 32px 36px";
        return $initArray;
    }
    add_filter( 'tiny_mce_before_init', 'hiepdesign_mce_text_sizes', 99 );
}

// breadcrumb
function rt_breadcrumb() {
  ?>
  <?php
  if(!is_home()) {
    if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb('<p class="rt-breadcrumbs">','</p>');
    }
  }
}
add_action( 'flatsome_after_header2', 'rt_breadcrumb', 1  );

function add_title(){
   $terms = get_terms( array(
          'taxonomy' => 'category',
          'hide_empty' => false,
      ) );
      $terms_lv = get_terms( array(
          'taxonomy' => 'project',
          'hide_empty' => false,
      ) );
      if (is_tax($taxonomy='project')) {
        // echo "<pre>";
        // print_r($terms_lv);
        // echo "</pre>";

      $queried_object = get_queried_object();
      $idwoo = $queried_object->term_id;
      $getcat = get_term_by( 'id', $idwoo , 'project' );
      ?>
            <h2 class="hdb">
              <span><?php echo $getcat->name; ?></span>
            </h2>
  <?php
      }

    $terms_lv1 = get_terms( array(
          'taxonomy' => 'service',
          'hide_empty' => false,
      ) );
      if (is_tax($taxonomy='service')) {
        // echo "<pre>";
        // print_r($terms_lv);
        // echo "</pre>";

      $queried_object1 = get_queried_object();
      $idwoo1 = $queried_object1->term_id;
      $getcat1 = get_term_by( 'id', $idwoo1 , 'service' );
      ?>
            <h2 class="hdb">
              <span><?php echo $getcat1->name; ?></span>
            </h2>
  <?php
      }

    if (is_category()) {
    echo "<h2 class='hdb'><span>";
    //news
    echo single_cat_title(); 
    echo "</span></h2>";
    }

    if(is_page()){
      echo "<h2 class='hdb'><span>";
      echo the_title();
      echo "</span></h2>";
    }

    if (is_single()) {
      echo "<h2 class='hdb'><span>";
      echo the_title();
      echo "</span></h2>";
    }
}
 add_action( 'rt_before_add_title', 'add_title');


 function rt_banner(){
    ?>
      <div class="rt_banner">
          <div class="container">
            <div class="row" style="padding: 0 15px;">
                <?php do_action( 'rt_before_add_title' );?>
                <?php do_action('flatsome_after_header2'); ?>
            </div>
        </div>
      </div>
    <?php
 }
add_action( 'flatsome_after_header', 'rt_banner', 1 );

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page('home-setting');
}


function uu_diem(){
  ?>
        
        



        



<div class="tab tab_quy_trinh">
  <?php
      $uu_diem_rt = get_field('uu_diem_rt','option');
        $i = 0;
        foreach ($uu_diem_rt as $id__value) {
          $i++;
          $ud_anh = $id__value['ud_anh'];
          $text_so = $id__value['text_so'];
          $ud_tieu_de = $id__value['ud_tieu_de'];

          if($i==1){
            ?>
              <div class="tablinks active" onclick="openCity(event,<?php echo $i; ?>)">
                  <div class="box">
                    <p><?php echo $text_so; ?></p>
                    <img src="<?php echo $ud_anh; ?>">
                  </div>
                  <div class="titles"><span><?php echo $ud_tieu_de; ?></span></div>
              </div>
            <?php
          }else{
            ?>
              <div class="tablinks" onclick="openCity(event,<?php echo $i; ?>)">
                  <div class="box">
                    <p><?php echo $text_so; ?></p>
                    <img src="<?php echo $ud_anh; ?>">
                  </div>
                  <div class="titles"><span><?php echo $ud_tieu_de; ?></span></div>
              </div>
            <?php
          }
        ?>
        
        <?php
      }     
  ?>
  
</div>

    <?php
        $uu_diem_rt = get_field('uu_diem_rt','option');
          $i = 0;
          foreach ($uu_diem_rt as $id__value) {
            $i++;
            $ud_anh = $id__value['ud_anh'];
            $ud_tieu_de = $id__value['ud_tieu_de'];
            $ud_noidung = $id__value['ud_noidung'];

            if($i==1){
            ?>
              
              <div id="<?php echo $i; ?>" class="tabcontent " style="display: block;">
                <div class="tabcontent_qt">
                    <?php echo $ud_noidung; ?>
                </div>
                
              </div>
            <?php
          }else{
            ?>
              
              <div id="<?php echo $i; ?>" class="tabcontent tabcontent_qt" style="display: none;">
                <div class="tabcontent_qt">
                    <?php echo $ud_noidung; ?>
                </div>
              </div>
            <?php
          }
          ?>
          

          <?php
        }     
    ?>



<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

  <?php
}
add_shortcode('show_uu_diem', 'uu_diem');

/* check out */
function custom_override_checkout_fields( $fields ) {
  unset( $fields['billing']['billing_last_name'] );
  unset( $fields['billing']['billing_company'] );
  unset( $fields['billing']['billing_postcode'] );
  unset( $fields['billing']['billing_city'] );
  unset( $fields['billing']['billing_state'] );
  unset( $fields['billing']['billing_country'] );
  unset( $fields['billing']['billing_address_2'] );
  unset( $fields['shipping']['shipping_last_name'] );
  unset( $fields['shipping']['shipping_company'] );
  unset( $fields['shipping']['shipping_postcode'] );
  unset( $fields['shipping']['shipping_city'] );
  unset( $fields['billing']['billing_email'] );

  $fields['billing']['billing_first_name']['class'] = array();
  $fields['billing']['billing_first_name']['label'] = esc_html( 'Họ và Tên', 'RT' );
  $fields['billing']['billing_first_name']['placeholder'] = esc_html( 'Họ và Tên', 'RT' );
  $fields['billing']['billing_address_1']['placeholder'] = esc_html( 'Địa chỉ của bạn', 'RT' );
  $fields['billing']['billing_address_1']['label'] = esc_html( 'Địa chỉ của bạn', 'RT' );
  $fields['billing']['billing_email']['label'] = esc_html( 'Địa chỉ email của bạn', 'RT' );

  $fields['shipping']['shipping_first_name']['class'] = array();
  $fields['shipping']['shipping_first_name']['label'] = esc_html( 'Họ và Tên', 'RT' );
  $fields['shipping']['shipping_first_name']['placeholder'] = esc_html( 'Họ và Tên', 'RT' );
  $fields['shipping']['shipping_address_1']['placeholder'] = esc_html( 'Địa chỉ của bạn', 'RT' );
  $fields['shipping']['shipping_address_1']['label'] = esc_html( 'Địa chỉ của bạn', 'RT' );
  $fields['shipping']['shipping_phone']['class'] = array();
  $fields['shipping']['shipping_phone']['label'] = sprintf( 'Số điện thoại %s', '<abbr class="required" title="bắt buộc">*</abbr>' );
  $fields['shipping']['shipping_email']['class'] = array();
  $fields['shipping']['shipping_email']['label'] = sprintf( 'Địa chỉ Email %s', '<abbr class="required" title="bắt buộc">*</abbr>' );

  return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );


function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer 3', 'textdomain' ),
        'id'            => 'Footer 3',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="widget-title">',
        'after_title'   => '</span>',
    ) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );