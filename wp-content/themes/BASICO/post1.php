<?php if (have_posts()): while (have_posts()) : the_post(); ?>
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
            <span><?php the_excerpt() ?></span>
        </div>
    </div>
<?php endwhile; ?>

<?php else: ?>
    <article>
        <h2><?php _e( 'Lo sentimos, no hay notas', 'html5blank' ); ?></h2>
    </article>
<?php endif; ?>
