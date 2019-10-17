<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage DrumRoll
 * @since DrumRoll 1.0.0
 */
get_header(); ?>

<?php // get_template_part( 'template-parts/featured-image' ); ?>
<?php // get_template_part( 'template-parts/featured-image-parallax' ); ?>

<div id="page" role="main">
		<div class="grid-container">
    	<div class="grid-wrapper">
        	<article class="grid-x grid-margin-x clear">
	
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/event', 'card' ); ?>
		<?php get_template_part('template-parts/content', 'columns'); ?>
	<?php endwhile;?>
        	</article>
    	</div>
		</div>
		
</div> <!-- #page -->


<?php get_footer(); ?>