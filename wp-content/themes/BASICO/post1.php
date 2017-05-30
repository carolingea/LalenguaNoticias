
<ul class="media-list main-list post1">
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
    <li class="media">
        
        <a class="pull-left" href="<?php the_permalink() ?>">
            <img class="media-object img-rounded" height="60" width="90" src="<?php the_post_thumbnail_url() ?>" alt="">
        </a>
        <div class="media-body">
            <span class="fecha"><?php the_date() ?> | </span>  
            <span class="categorias"><?php the_category() ?></span>  
            <div>
                <a class="pull-left titulo" href="<?php the_permalink() ?>"><?php the_title() ?></a> 
            </div>
        </div>
    </li>
      
<?php endwhile; ?>
    

<?php else: ?>
    
<?php endif; ?>
</ul>

