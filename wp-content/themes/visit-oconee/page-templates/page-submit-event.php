<?php
/*
Template Name: Submit Event
*/
get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>
<?php // get_template_part( 'template-parts/featured-image-parallax' ); ?>

<div id="page" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(array('main-content')) ?> id="post-<?php the_ID(); ?>">
			<div class="entry-content">
        		<section  class="default-background section-1">
	        		<div class="grid-container">
    	    			<div class="grid-x grid-padding-x">
							<div class="large-12 cell entry-content">
								<?php gravity_form(5, false, false, false, '', true); ?>		
							</div>
    	    			</div>
	        		</div>
        		</section>
			</div> <!-- entry-content -->
		</article>
	<?php endwhile;?>
</div> <!-- #page -->

<?php get_footer();