<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <?php get_header(); ?>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <?php //post_class(); ?>
    </head>

    <body>
        <div class="single col-md-7 col-md-offset-2">
            <h1><?php the_title(); ?></h1>
            
            <div class="row">
                <div class="col-md-6">
                    <span class="author">
                        <i class="fa fa-user-o" aria-hidden=""></i>
                        <?php _e( 'Publicado por ', 'html5blank' ); ?><?php the_author_posts_link(); ?>
                    </span>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <span class="date">
                        <il class="fa  fa-calendar-times-o"></il>
                        <?php the_time('F j, Y'); ?><?php the_time('g:i a'); ?>
                    </span>
                </div>
            </div>
            
            <span class="comments">
                <?php //if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); ?>
            </span>
            
            <main>
                <section>
                    <article id="post-<?php the_ID(); ?>" style="text-align: center">
                        <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <?php the_post_thumbnail(); // Fullsize image for the single post ?>
                        </a>
                        <?php endif; ?>
                    </article>
                </section>
            </main>
            <div class="contenido">
                <?php the_content(); // Dynamic Content ?>
                <?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>
            </div>
            
            
            <div class="row">
                <div class="col-md-6">
                    <span class="author">
                        <i class="fa fa-user-o" aria-hidden=""></i>
                        <?php _e( 'Escrito por ', 'html5blank' ); the_author_posts_link(); //the_author(); ?>
                    </span>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <span class="date">
                        <il class="fa  fa-calendar-times-o"></il>
                        <?php _e( 'Categorías: ', 'html5blank' ); the_category(', '); // Separated by commas ?> 
                    </span>
                </div>
            </div>
            
            <?php //edit_post_link(); ?>
            
            <div class="comentarios">
                <?php comments_template(); ?>
            </div>
            
            <?php endwhile; ?>

        <?php else: ?>

            <h1>
                <?php _e( 'Pronto tendremos algo para ti.', 'html5blank' ); ?>
            </h1>

            <?php endif; ?>

            <?php get_sidebar(); ?>
            
        </div>
        <?php if ( function_exists( "get_yuzo_related_posts" ) ) { get_yuzo_related_posts(); } ?>
        <?php //get_footer(); ?>
    </body>
</html>