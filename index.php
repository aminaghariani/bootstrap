
<?php get_header(); ?> 
<div class="row">  
 <div class="col-sm-8 blog-main"> 
 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>   <!-- contents of the loop --> <?php endwhile;?> <nav>
 <ul class="pager">
<li><?php next_posts_link( 'Previous' ); ?></li>
<li><?php previous_posts_link( 'Next' ); ?></li>
 </ul>
</nav> <?php endif; ?>
     <?php get_template_part( 'content', get_post_format() ); ?> 
	   </div> <!-- /.blog-main -->   <?php get_sidebar(); ?>
    <h1>Title</h1>
<?php the_title();?>
<h1>Content</h1>
<?php the_content();?>
	    </div> <!-- /.row --> <?php get_footer(); ?> 
