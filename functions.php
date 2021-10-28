<?php
/**
 * Comet 2021 functions and definitions
 *
 * Here is all functions of comet 2021

 * Comet 2021 only works in WordPress 4.7 or later.
 */

 //Required
 
if(file_exists(dirname(__FILE__). '/gallery.php')){
    require_once( dirname(__FILE__). '/gallery.php' );
}

if(file_exists(dirname(__FILE__). '/custom-widgets/latest-posts.php')){
    require_once( dirname(__FILE__). '/custom-widgets/latest-posts.php' );
}

if(file_exists(dirname(__FILE__). '/lib/Redux/ReduxCore/framework.php')){
    require_once( dirname(__FILE__). '/lib/Redux/ReduxCore/framework.php' );
}

if(file_exists(dirname(__FILE__). '/lib/Redux/sample/config.php')){
    require_once( dirname(__FILE__). '/lib/Redux/sample/config.php' );
}

if(file_exists(dirname(__FILE__). '/lib/CMB2/config.php')){
    require_once( dirname(__FILE__). '/lib/CMB2/config.php' );
}

if(file_exists(dirname(__FILE__). '/lib/CMB2/init.php')){
    require_once( dirname(__FILE__). '/lib/CMB2/init.php' );
}

if(file_exists(dirname(__FILE__). '/custom_nav_walker.php')){
    require_once(dirname(__FILE__). '/custom_nav_walker.php');
}

if(file_exists(dirname(__FILE__). '/shortcodes/shortcodes.php')){
    require_once(dirname(__FILE__). '/shortcodes/shortcodes.php');
}
if(file_exists(dirname(__FILE__). '/lib/TGM-Plugin/required-plugin.php')){
    require_once(dirname(__FILE__). '/lib/TGM-Plugin/required-plugin.php');
}


//Theme setup functions
 add_action('after_setup_theme', 'comet_functions');

 function comet_functions(){

    //Text Domain

    load_theme_textdomain('comet', get_template_directory().'/lang');

    //Theme support

    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    add_theme_support('woocommerce');

    add_theme_support('post-formats', array(
        'aside',
        'video',
        'audio',
        'image',
        'quote',
        'gallery'
    ));

     //Database table create 
     global $wpdb;

     $prefix = $wpdb->prefix;
 
     $table = $prefix. 'jakir';
     require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
 
     dbDelta("CREATE TABLE $table (id INT AUTO_INCREMENT, name varchar(250), UNIQUE KEY id (id))");


    //Custome Post Type here
    register_post_type('comet-portfolio', array(
        'labels'    => array(
            'name'          => __('Portfolio', 'comet'),
            'add_new'       => __('Add New Portfolio', 'comet'),
            'add_new_item'  => __('Add New portfolio', 'comet'),
        ),
        'public'    => true,
        'supports'  => array('title', 'editor', 'thumbnail')
    ));

    register_taxonomy('portfolio-category', 'comet-portfolio', array(
        'labels'        => array(
            'name'      => 'Category',
            'add_new'   => 'Add New Category',
            'add_new_item'=> 'Add New Category Item'
        ),
        'public'        => true,
        'hierarchical'  => true
    ));

    //Nav Menu
    register_nav_menu('main-menu', __('Main Menu', 'comet'));

    //Slider post type
    register_post_type('comet-slider', array(
        'labels'    => array(
            'name'              => __('Sliders', 'comet'),
            'add_new'           => __('Add New Slider', 'comet'),
            'add_new_item'      => __('Add New Slider', 'comet')
        ),
        'public'    => true,
        'supports'  => array('title', 'editor', 'thumbnail')
    ));

    //Filtering
    // if(current_user_can('manage_options')){
    //     register_post_type('filter-isotop', array(
    //         'labels'        => array(
    //             'name'      => 'Filters',
    //             'add_new'   => 'Add New Filter',
    //             'add_new_item'=> 'Add new Item'
    //         ),
    //         'public'        => true,
    //         'supports'      => array('title', 'editor', 'thumbnail')
    //     ));
    // }

 }


 //Adding Fonts

 function get_comet_fonts(){

        $fonts = array();

        $fonts[] = 'Montserrat:400,700';
        $fonts[] = 'Raleway:300,400,500';
        $fonts[] = 'Halant:300,400';

    $comet_fonts = add_query_arg(array(
        'family'    => urlencode(implode('|', $fonts)),
        'subset'    => 'latin'
    ), 'https://fonts.googleapis.com/css');


    return $comet_fonts;
 }

 //Including the Style

 add_action('wp_enqueue_scripts', 'comet_style');

 function comet_style(){
    wp_enqueue_style('bundle', get_template_directory_uri().'/css/bundle.css');

    wp_enqueue_style('style', get_template_directory_uri().'/css/style.css');
    wp_enqueue_style('fonts', get_comet_fonts());

    wp_enqueue_style('stylesheet', get_stylesheet_uri());

    wp_enqueue_style('comment_reply');
 }

// //  add_action('wp_enqueue_scripts', 'conditional_scripts');

//  function conditional_scripts(){
//      wp_enqueue_scripts('html5shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array(), '', false);
//      wp_scripts_add_data('html5shim', 'conditional', 'lt IE 9');

//      wp_enqueue_scripts('respond', 'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js', array(), '', false);
//     //  wp_scripts_add_data('respond', 'conditional', 'lt IE 9');
//  }

 add_action('wp_enqueue_scripts', 'comet_scripts');

 function comet_scripts(){
    //  wp_enqueue_scripts('jq', get_template_directory_uri().'/js/jquery.js');
     wp_enqueue_script('bundle', get_template_directory_uri().'/js/bundle.js', array('jquery'), '', true);
     wp_enqueue_script('google-map', get_template_directory_uri().'https://maps.googleapis.com/maps/api/js?v=3.exp', array('jquery'), '', true);
     wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery', 'bundle'), '', true);

     wp_enqueue_script('comment-reply');
     
 }

 //SWitch Metabox
 add_action('admin_print_scripts', 'metabox_switch_scripts', 1000);

 function metabox_switch_scripts(){ ?>

    <?php if(get_post_type() == 'post'): ?>
    <script>

        jQuery(document).ready(function(){
            
            var id = jQuery('input[name="post_format"]:checked').attr('id');

            if(id == 'post-format-video'){
                jQuery('.cmb2-id--for-video').show();
            }else{
                jQuery('.cmb2-id--for-video').hide();
            }

            if(id == 'post-format-audio'){
                jQuery('.cmb2-id--for-audio').show();
            }else{
                jQuery('.cmb2-id--for-audio').hide();
            }

            if(id == 'post-format-gallery'){
                jQuery('.cmb2-id--for-gallery').show();
            }else{
                jQuery('.cmb2-id--for-gallery').hide();
            }


            jQuery('input[name="post_format"]').change(function(){
                jQuery('.cmb2-id--for-video').hide();
                jQuery('.cmb2-id--for-audio').hide();
                jQuery('.cmb2-id--for-gallery').hide();

                var id = jQuery('input[name="post_format"]:checked').attr('id');

                if(id == 'post-format-video'){
                    jQuery('.cmb2-id--for-video').show();
                }else{
                    jQuery('.cmb2-id--for-video').hide();
                }

                if(id == 'post-format-audio'){
                    jQuery('.cmb2-id--for-audio').show();
                }else{
                    jQuery('.cmb2-id--for-audio').hide();
                }

                if(id == 'post-format-gallery'){
                    jQuery('.cmb2-id--for-gallery').show();
                }else{
                    jQuery('.cmb2-id--for-gallery').hide();
                }
            })
        })

    </script>
    <?php endif; ?>

 <?php }


//  Widgets Area

 add_action('widgets_init', 'sidebar_areas');

 function sidebar_areas(){
     register_sidebar(array(
        'name'          => __('Right Sidebar', 'comet'),
        'description'   => __('You made add your right sidebar widgets here', 'comet'),
        'id'            => 'right-sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="upper">',
        'after_title'   => '</h6>'

     ));

     register_sidebar(array(
        'name'          => __('Footer Left', 'comet'),
        'description'   => __('You may add your footer left widgets here', 'comet'),
        'id'            => 'footer-left',
        'before_widget' => '<div class="col-sm-4"><div class="widget">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h6 class="upper">',
        'after_title'   => '</h6>'

     ));

     register_sidebar(array(
        'name'          => __('Footer Right', 'comet'),
        'description'   => __('You may add your footer Right widgets here', 'comet'),
        'id'            => 'footer-right',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="upper">',
        'after_title'   => '</h6>'

     ));
 }


 register_activation_hook(__FiLE__, 'activation_hoook_added');

 function activation_hoook_added(){
     register_activation_hook();
 }


 add_action('cv_before_init', 'set_as_theme_vc');

 function set_as_theme_vc(){
     vc_set_as_theme();
 }


 vc_map(array(
     'name'     => 'Comet Slider',
     'base'     => 'home-slider',
 ));


remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);


add_action('woocommerce_before_shop_loop_item', 'comet_shop_products', 10);


 add_filter('woocommerce_show_page_title', function(){
     return;
 });

 add_filter('woocommerce_loop_add_to_cart_link', function(){

    global $product;
    return sprintf(
		'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'btn btn-color-out btn-sm' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
	);
 });



 register_activation_hook(__FILE__, function(){

 });

 register_deactivation_hook(__FILE__, function(){

 });


 global $wpdb;

 if(isset($_POST['submit'])){
     $tablename = $wpdb->prefix . 'jakir';
     $name = $_POST['naam'];

     $wpdb->insert($tablename, array(
         'name' => $name
     ));
 }


 $id = $_GET['edit'];
 $tablename = $wpdb->prefix . 'jakir';
 $data = $_POST['naam'];

 if(isset($_POST['submit'])){

    $wpdb->update($tablename, array(
        'name'  => $data
    ),
    array(
        'id'    => $id
    ));
 }
?>


<?php

