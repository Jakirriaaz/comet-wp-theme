<?php


class comet_latest_post extends WP_Widget {

    public function __construct() {

        parent::__construct('comet_latest_post', 'Comet Latest Posts', array(
            'descripton'    => 'Custom Latest Widget by self - Comet'
        ));
    }

    public function widget($akono, $another){ ?>
           <?php echo $akono['before_widget']; ?>
                <?php echo $akono['before_title']; ?>Latest Posts<?php echo $akono['after_title'];?>

                <?php 
                    $posts = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => $another['post_count']
                    ));
                ?>
                    <ul class="nav">
                    <?php while($posts->have_posts()) : $posts->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?><i class="ti-arrow-right"></i>
                        <?php if(!empty($another['date'])) : ?>
                            <span><?php the_time('d M Y'); ?></span>
                        <?php endif; ?></a></li>
                    <?php endwhile; ?>
                    </ul>
            <?php echo $akono['after_widget']; ?>
    <?php }

    public function form($showdata){ ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $showdata['title']; ?>">
            </p>

            <p>
                <label for="<?php echo $this->get_field_id['post_count']; ?>">Number of posts to show:</label>
                <input class="tiny-text" id="<?php echo $this->get_field_id['post_count']; ?>" name="<?php echo $this->get_field_name['post_count']; ?>" type="number" step="1" min="1" value="<?php echo $showdata['post_count']; ?>" size="3">
                </p>

            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" value="showdate" <?php if(!empty($showdata['date'])){echo "checked= 'checked'";} ?>>
                <label for="<?php echo $this->get_field_id('date'); ?>">Show Date of Time</label>
            </p>

            <?php 

                if($showdata['date'] == 'show'){
                    $show =  "checked = 'checked'";
                }else{
                    $hide = "checked = 'checked'";
                }

            ?>

            <p>
                <input type="radio" id="<?php echo $this->get_field_id('dateshow'); ?>" name="<?php echo $this->get_field_name('date'); ?>" value="show" 
                
                <?php if(isset($show)){echo $show;}?>>
                
                <label for="<?php echo $this->get_field_id('dateshow'); ?>">Show Date</label>
                <br>
            </p>
            <p>
                <input type="radio" id="<?php echo $this->get_field_id('datehide'); ?>" name="<?php echo $this->get_field_name('date'); ?>" value="show" 
                
                <?php if(isset($hide)){echo $hide;}?>>

                <label for="<?php echo $this->get_field_id('datehide'); ?>">Hide Date</label>
            </p>
            
    <?php }

    
}

add_action('widgets_init', 'latest_post_widget');

function latest_post_widget(){

    register_widget('comet_latest_post');
}