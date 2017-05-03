<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <?php get_header(); ?>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <?php //post_class(); ?>
    </head>

    <body>
        <main>
            <!-- section --> 
            <section>
                <!-- article -->
                <article id="post-<?php the_ID(); ?>">
                    <!-- post thumbnail -->
                    <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php the_post_thumbnail(); // Fullsize image for the single post ?>
                    </a>
                    <?php endif; ?>
                    <!-- /post thumbnail --><!-- post title -->
                </article>
            </section>
        </main>
        <h1> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
        <!-- /post title --><!-- post details --> <span class="date"><?php the_time('F j, Y'); ?><?php the_time('g:i a'); ?>
        </span>
        <span class="author">
            <?php _e( 'Publicado por ', 'html5blank' ); ?><?php the_author_posts_link(); ?>
        </span>
        <span class="comments">
            <?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); ?>
        </span>
        <!-- /post details -->
            <?php the_content(); // Dynamic Content ?>
            <?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>
        <p>
            <?php _e( 'Categorised in: ', 'html5blank' ); the_category(', '); // Separated by commas ?> 
        </p>
        <p>
            <?php _e( 'Esta nota fué escrita por ', 'html5blank' ); the_author(); ?>
        </p>
        <?php edit_post_link(); // Always handy to have Edit Post Links available ?><?php comments_template(); ?><!-- /article --><?php endwhile; ?><?php else: ?><!-- article -->

        <article>

        </article>
        <h1>
            <?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?>
        </h1>
        <!-- /article -->
        <?php endif; ?>
    <!-- /section -->
        <?php get_sidebar(); ?><?php get_footer(); ?>
    </body>
</html>