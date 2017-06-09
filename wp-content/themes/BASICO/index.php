<?php get_header(); ?>

<main role="main">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="col-lg-7 col-md-7 col-xs-7">
                <?php  //query_posts("category_name=extraordinaria"); ?>
                <?php dynamic_sidebar("Destacado") //get_template_part('extraordinaria'); ?>
                <?php get_template_part('sliderHome'); ?>  
            </div>
            
            <div class="col-lg-5 col-md-5 col-xs-5">
                <?php query_posts('blog=wordpress&showposts=3'); ?>
                <?php get_template_part("post1") ?>
            </div>
            </div>    
        </div>
        
        <!-- Columna de noticias de 3-->
        <div class="row">
            <div style="margin-top:25px"></div>
            
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="col-lg-8 col-md-8 col-xs-8">
                    
                    <div class="art-home col-lg-6 col-md-6 col-xs-5">
                        <?php  query_posts("category_name=bogota"); ?>
                        <?php get_template_part('loop'); ?>
                    </div>
                    
                    <div></div>
                    
                    <div class="art-home col-lg-6 col-md-6 col-xs-6">
                        <?php  query_posts("category_name=colombia,politica"); ?>
                        <?php get_template_part('loop'); ?>
                    </div>
                   
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
