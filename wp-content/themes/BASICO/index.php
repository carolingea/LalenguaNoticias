<?php get_header(); ?>

<main role="main">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="col-lg-8 col-md-8 col-xs-8">
                <?php  //query_posts("category_name=extraordinaria"); ?>
                <?php dynamic_sidebar("Destacado") //get_template_part('extraordinaria'); ?>
                
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
            <div style="margin-top:25px"></div>
            
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="col-lg-8 col-md-8 col-xs-8">
                    
                    <div class="art-home col-lg-5 col-md-5 col-xs-5">
                        <?php  query_posts("category_name=bogota"); ?>
                        <?php get_template_part('loop'); ?>
                    </div>
                    
                    <div></div>
                    
                    <div class="art-home col-lg-5 col-md-5 col-xs-5">
                        <?php  query_posts("category_name=colombia,politica"); ?>
                        <?php get_template_part('loop'); ?>
                    </div>
                   
                </div>
                <div class="col-lg-5 col-md-5 col-xs-5">
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
