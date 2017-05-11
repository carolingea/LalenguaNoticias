<script src="<?php echo get_template_directory_uri(); ?>/js/devrama.slider/jquery.devrama.slider.min-0.9.4.js" type="text/javascript"></script>

                    
<div id="my-slide">
    <a href="http://devrama.com"><img data-lazy-src="http://devrama.com/static/devrama-slider/images/265740754_141774705b_b.png" /></a>
    <a href="http://event.devrama.com"><img data-lazy-src="http://devrama.com/static/devrama-slider/images/4247776023_81a3f048ca_b.png" /></a>
    <a href="http://google.com"><img data-lazy-src="http://devrama.com/static/devrama-slider/images/4277941123_044d26b6df_b.png" /></a>
    <a href="http://yahoo.com"><img data-lazy-src="http://devrama.com/static/devrama-slider/images/4432435310_d5010f8efc_b.png" /></a>
    <a href="http://facebook.com"><img data-lazy-src="http://devrama.com/static/devrama-slider/images/6240134386_db0f314ef6_b.png" /></a>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#sliderHome').DrSlider({
            width: 500, //slide width
            height: 250  //slide height
        });
    });
    
</script>

<div id="sliderHome">
    <?php  query_posts("category_name=extraordinarias"); ?>
    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <div>
        <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
            <?php the_post_thumbnail(); // Declare pixel size you need inside the array ?>                
        <?php endif; ?>
        <div data-pos="['56%', '-40%', '56%', '11%']" data-duration="300" data-effect="move">
            <?php html5wp_excerpt('html5wp_index'); ?>
            
        </div>
        
    </div>
    <?php endwhile; ?>

    <?php else: ?>
        <?php _e( 'Lo sentimos, no hay notas', 'html5blank' ); ?>       
    <?php endif; ?>

</div>
               




    