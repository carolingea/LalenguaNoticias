<?php get_header(); ?>
<div class="container-fluid">
    <main role="main">   
        <section class="single col-md-7 col-md-offset-2">
            
            <h1><?php single_cat_title(); ?></h1>
            
            <?php get_template_part('categoria_loop'); ?>

            <?php get_template_part('pagination'); ?>
        </section>
    </main>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
