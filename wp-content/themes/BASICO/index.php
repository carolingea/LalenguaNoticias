<?php get_header(); ?>


<main role="main">
    <div class="container">
                      
        <div class="row">
            <div class="col-xs-8 col-md-8 col-sm-8">
                <h1><?php //_e( 'Latest Posts', 'html5blank' ); ?></h1>
                <?php get_template_part('loop'); ?>
            </div>
            <div class="col-xs-4 col-md-4 col-sm-4">
                Espacio para contenido de Tercera columna
            </div> 
            
        </div>
        <div class="paginacion">
            <?php get_template_part('pagination'); ?>
        </div>
        
    </div>

    
    <!-- section -->
    <!--
    <section>
        <h1><?php //_e( 'Latest Posts', 'html5blank' ); ?></h1>

        <?php //get_template_part('loop'); ?>

        <?php //get_template_part('pagination'); ?>

    </section>
    -->
    <!-- /section -->
</main>
<div>------------------------------------------------</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
