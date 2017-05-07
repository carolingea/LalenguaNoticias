<?php get_header(); ?>

<main role="main">
    <div class="container">
        <div class="row" style="border:1px solid">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="col-lg-8 col-md-8 col-xs-8">
                <?php dynamic_sidebar('destacado'); ?>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Sed feugiat et neque a condimentum. 
                Mauris dignissim enim sagittis ante posuere, vel aliquam arcu sagittis. 
            </div>
            </div>
            
        </div>
        
        <!-- Columna de noticias de 3-->
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
        <div class="paginacion">
            <?php get_template_part('pagination'); ?>
        </div>
        
        
        
        
    </div>
</main>

<div style="background: yellow">
    
</div>


<?php get_footer(); ?>
