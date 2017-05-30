<?php  query_posts("category_name=tecnologia&category__not_in=extraordinaria"); ?>


<ul class="post2">
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
    <li class="post2-articulos">
        
        <a class="post2-link" href="<?php the_permalink() ?>">
            <?php the_title() ?>
        </a>
        <div class="post2-descripcion">
            <?php the_excerpt() ?>
        </div>
        
    </li>
      
<?php endwhile; ?>
    

<?php else: ?>
    
<?php endif; ?>
</ul>





