<div class="relacionadas">
<h3>Entradas relacionadas</h3>
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
        
        <div class="miniaturarelacionada">
            <a rel="external" href="<? the_permalink()?>"><?php the_post_thumbnail(array(150,100)); ?><br />
            <?php the_title(); ?>
            </a>
            <?php post_e ?>
        </div>
        


        <?php }
        }
            $post = $orig_post;
            wp_reset_query();
        ?>
</div>

<div class="populat-post-tab">
                    <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                    <a href="#home" aria-controls="home" role="tab"
                                       data-toggle="tab">Popular</a>
                            </li>
                            <li role="presentation">
                                    <a href="#profile" aria-controls="profile" role="tab"
                                       data-toggle="tab">Latest</a>
                            </li>
                            <li role="presentation">
                                    <a href="#messages" aria-controls="messages" role="tab"
                                       data-toggle="tab">Comments</a>
                            </li>
                        </ul>
</div>

