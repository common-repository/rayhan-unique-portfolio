<?php
/*
Plugin Name:Rayhan Unique Portfolio
Description:Image portfolio with grid view.On hover shows title.Click and see full image with title and description.Different type of views.
Version 1.1
Author: Abu Rayhan
Author URI: http://binarycubeit.com/
*/


add_action('wp_enqueue_scripts', 'rayhan_portfolio_register_scripts');
add_action('wp_enqueue_scripts', 'rayhan_portfolio_register_styles');


function rayhan_portfolio_register_scripts() {
    if (!is_admin()) {
        // register
         wp_register_script('rayhan_portfolio_script_1', plugins_url('js/plugins.js', __FILE__));
         wp_register_script('rayhan_portfolio_script_2', plugins_url('js/scripts.js', __FILE__), array('jquery') );

        // enqueue
         wp_enqueue_script('rayhan_portfolio_script_1');
         wp_enqueue_script('rayhan_portfolio_script_2');
    }
}

function rayhan_portfolio_register_styles() {
    // register
    wp_register_style('rayhan_portfolio_style', plugins_url('css/styles.css', __FILE__));

    // enqueue
    wp_enqueue_style('rayhan_portfolio_style');

}


register_activation_hook(__FILE__, 'rayhan_portfolio_activation');
register_deactivation_hook(__FILE__, 'rayhan_portfolio_deactivation');

function rayhan_portfolio_activation() {

    //actions to perform once on plugin activation go here

    //register uninstaller
    register_uninstall_hook(__FILE__, 'rayhan_portfolio_uninstall');
}

function rayhan_portfolio_uninstall(){

    //actions to perform once on plugin uninstall go here
}



function rayhan_port() {
    $args = array(
        'public' => true,
        'labels' => array(
        'name' => __( 'Unique Portfolios' ),
        'singular_name' => __( 'Unique Portfolio' ),
        'add_new'            => _x( 'Add Portfolio', 'Portfolio' ),
        'add_new_item'       => __( 'Add New Portfolio' ),
        'edit_item'          => __( 'Edit Portfolio' ),
        'new_item'           => __( 'New Portfolio' ),
        ),
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ),
        'has_archive' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'portfolios'),
    );
    register_post_type('rayhan_port', $args);
}
    add_action('init', 'rayhan_port');



function rayhan_portfolio(){?>

                <?php
                $args = array( 'post_type' => 'rayhan_port','order'=>'asc' );
                $the_query = new WP_Query( $args ); ?>


  <div id="gallery-container">

    <ul class="items--small">


    <?php if ( $the_query->have_posts() ) : ?>
     <?php while ( $the_query->have_posts() ) : $the_query->the_post();?>
    <li class="item"><a href="#">
    <figure>
         <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" />

        <figcaption>
            <h3><?php echo get_the_title(); ?></h3>
        </figcaption>
    </figure>
    </a>
    </li>

     <?php endwhile; ?>
     <?php endif; ?>
    </ul>




    <ul class="items--big">
    <?php if ( $the_query->have_posts() ) : ?>
     <?php while ( $the_query->have_posts() ) : $the_query->the_post();?>
      <li class="item--big">
        <a href="#">
          <figure>
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" />
            <figcaption class="img-caption">
              <h2 class="port-title"><?php echo get_the_title(); ?></h2>
              <p><?php echo get_the_content(); ?></p>
            </figcaption>
          </figure>
          </a>
      </li>
      <?php endwhile; ?>
     <?php endif; ?>
    </ul>

    <div class="controls">
      <span class="control icon-arrow-left" data-direction="previous"></span>
      <span class="control icon-arrow-right" data-direction="next"></span>
      <span class="grid icon-grid"></span>
      <span class="fs-toggle icon-fullscreen"></span>
    </div>

  </div>

  <script>
    jQuery(document).ready(function(){
     jQuery('#gallery-container').sGallery({
        fullScreenEnabled: true
      });
    });
  </script>

<?php }

add_shortcode('rayhan_unique_portfolio','rayhan_portfolio');

?>
