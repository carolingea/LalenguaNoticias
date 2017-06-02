<?php get_header(); ?>
    <main role="main">
        <section class="single col-md-7 col-md-offset-2">
            <h1><?php echo sprintf( __( '%s Resultados para: ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>

            <?php get_template_part('categoria_loop'); ?>

            <?php get_template_part('pagination'); ?>
        </section>
    </main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
