
<ul class="media-list main-list">
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
    <li class="media">
        
        <a class="pull-left" href="<?php the_permalink() ?>">
            <img class="media-object" height="90" width="150" src="<?php the_post_thumbnail_url() ?>" alt="">
        </a>
        <div class="media-body">
            <a class="pull-left" href="<?php the_permalink() ?>"><?php the_title() ?></a> 
            <br>
            <il class="fa  fa-calendar-times-o"></il>
            <?php the_date() ?>
            <?php the_category() ?>
            
        </div>
    </li>
      
<?php endwhile; ?>
    

<?php else: ?>
    
<?php endif; ?>
</ul>

