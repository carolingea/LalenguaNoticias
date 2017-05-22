<script src="<?php echo get_template_directory_uri(); ?>/js/devrama.slider/jquery.devrama.slider.min-0.9.4.js" type="text/javascript"></script>
<link href="<?php echo get_template_directory_uri(); ?>/js/devrama.slider/devrama-slider.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#sliderHome').DrSlider({
            width: '100%',
            height: '350px'            
        });
    });
    
</script>
<style>
    #sliderHome h3{
        display: block; 
        position: absolute; 
        bottom: 0; 
        left: 0%; 
        opacity: 0.5;
    }
    
    #sliderHome .view-article{
        display: none;
    }
</style>
<div class="" style="width: 100%">
    <div id="sliderHome">
        <?php  query_posts("category_name=extraordinarias"); ?>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        
        <div data-lazy-background="<?php the_post_thumbnail_url() ?>">
            <h3 data-pos="['100%', '0%', '78%', '0%']" data-duration="500" data-effect="move">
                <a href="<?php the_permalink() ?>" style="color:#FFFFFF; text-decoration: none">
                    <?php html5wp_excerpt('html5wp_index'); ?>
                </a>
                
            </h3>
        </div>
            
        <?php endwhile; ?>

        <?php else: ?>
            <?php _e( 'Lo sentimos, no hay notas', 'html5blank' ); ?>       
        <?php endif; ?>

    </div>
</div>
               




    