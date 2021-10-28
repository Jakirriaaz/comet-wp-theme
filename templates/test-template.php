<?php 
/*
Template Name: Test-Template 
*/

get_header(); ?>


<?php 

    
$current = get_query_var('paged') ? get_query_var('paged') : 1;

        $portfolio = new WP_Query(array(
            'post_type'     => 'comet-portfolio',
            'post_per_page' => 2,
            'paged'         => $current,
        ));

    while($portfolio->have_posts()): $portfolio->the_post();

?>

<?php the_title(); ?>

<?php endwhile; ?>

<?php 


    $maxpage = $portfolio->max_num_pages;

echo paginate_links(array(
    'current'       => $current,
    'total'         => $maxpage,
    'show_all'      => true
)); ?>



<?php get_footer(); ?>