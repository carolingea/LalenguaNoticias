
<!-- Tab panes -->

    <?php
        $orig_post = $post;
        global $post;
        $tags = wp_get_post_tags($post->ID);

        if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag) 
            $tag_ids[] = $individual_tag->term_id;

        $args=array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page'=>3, // Número de entradas relacionadas a mostrar.
        'caller_get_posts'=>1
        );

        $my_query = new wp_query( $args );

        while( $my_query->have_posts() ) {
        $my_query->the_post();
    ?>

    <div class="tab-post-list-wrap clearfix">
        <div class="tab-post-thumb pull-left">
            <figure>
                <a href="<?php the_permalink() ?>">
                    <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
                </a>
            </figure>
        </div>
        <div class="tab-post-title">
            <h6><a href="<?php the_permalink() ?>"><?php the_title() ?></a>
            </h6>
            <span><?php the_date() ?></span>
        </div>
    </div>

    <?php }
    }
        $post = $orig_post;
        wp_reset_query();
    ?>
