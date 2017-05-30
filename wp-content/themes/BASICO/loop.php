<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>
        <div>
            <span class="fecha"><?php the_date() ?> | </span>  
            <span class="categorias"><?php the_category() ?></span> 
        </div>
        
        <div class="miniatura">
            <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php  the_post_thumbnail('medium', array('class' => 'thumbnail')); ?>
                    <?php //the_post_thumbnail(array(290,250)); // Declare pixel size you need inside the array ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="date"><?php //the_time('F j, Y'); ?> <?php //the_time('g:i a'); ?></div>
        <div class="author"><?php //_e( 'Publicado por ', 'html5blank' ); ?> <?php //the_author_posts_link(); ?></div>
        <div class="comments"><?php //if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); ?></div>
        <?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
        
        <?php //edit_post_link(); ?>
    </article>
<?php endwhile; ?>

<?php else: ?>
    <article>
        <h2><?php _e( 'Lo sentimos, no hay notas', 'html5blank' ); ?></h2>
    </article>
<?php endif; ?>


