<?php get_header(); ?>

<main role="main">
    <div class="container">
                      
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <?php //_e( 'Latest Posts', 'html5blank' ); ?>
                    <?php get_template_part('loop'); ?>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4">
                    <!-- Barra lateral derecha-->
                    <?php get_template_part('barra_derecha'); ?>

                </div> 

            </div>
            
        </div>
        <div class="row">
            <?php get_sidebar(); ?>
        </div>
        <div class="paginacion">
            <?php get_template_part('pagination'); ?>
        </div>
        
    </div>
</main>

<div style="background: yellow">
    
</div>


<?php get_footer(); ?>
