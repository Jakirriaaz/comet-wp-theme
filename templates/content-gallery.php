<article class="post-single">
    <div class="post-info">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <h6 class="upper"><span>By</span><a href="<?php the_author(); ?>"><?php the_author(); ?></a><span class="dot"></span><span><?php the_time("d F y"); ?></span><span class="dot"></span><a href="#" class="post-tag">Startups</a></h6>
    </div>
    <div class="post-media">
        <div data-options="{&quot;animation&quot;: &quot;slide&quot;, &quot;controlNav&quot;: true" class="flexslider nav-outside">
        <ul class="slides">

            <?php 
            $images = get_post_meta(get_the_id(), '_for-gallery', true);
            
            foreach($images as $image): ?>

            <li><img src="<?php echo $image; ?>" alt=""></li>

            <?php endforeach; ?>


        </ul>
        </div>
    </div>
    <div class="post-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae ut ratione similique temporibus tempora dicta soluta? Qui hic, voluptatem nemo quo corporis dignissimos voluptatum debitis cumque fugiat mollitia quasi quod. Repudiandae
        possimus quas odio nisi optio asperiores, vitae error laudantium, ratione odit ipsa obcaecati debitis deleniti minus, illo maiores placeat omnis magnam.</p>
        <p><a href="#" class="btn btn-color btn-sm">Read More</a>
        </p>
    </div>
</article>