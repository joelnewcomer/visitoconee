<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage DrumRoll
 * @since DrumRoll 1.0.0
 */
get_header(); 

$image_id = get_post_thumbnail_id(get_option('page_for_posts'));
// Default Featured Image
if ($image_id == null) {
	$image_id = get_theme_mod( 'default_featured' );
}
?>

<div class="featured-container">	
	<div class="grid-container">
		<div class="featured-image blog-landing-featured">
			<?php echo wp_get_attachment_image($image_id,'featured'); ?>
			<div class="overlay">
				<section class="breadcrumbs">
					<div class="grid-container">
						<div class="large-12 cell">
							<?php
							if ( function_exists('yoast_breadcrumb') ) {
								yoast_breadcrumb('<p id="breadcrumbs">','</p>');
							}
							?>
						</div> <!-- grid-container -->
					</div>
				</section>
				<?php // get_template_part('template-parts/blog', 'header-1'); ?>
				<!-- Header Version 2 has featured article and featured categories -->
				<?php get_template_part('template-parts/blog', 'header-2'); ?>
			</div> <!-- overlay -->
		</div> <!-- blog-landing-featured -->
	</div> <!-- grid-container -->
</div> <!-- featured-container -->

<div id="page" role="main" class="blog-grid">
    <div class="grid-container">
	    <div class="grid-wrapper">
		    <div class="blog-content-header grid-x">
		        <div class="large-6 medium-6 cell small-text-center">
			        <h2><?php _e( 'Our Latest Articles', 'drumroll' ); ?></h2>
		        </div>
		        <div class="large-6 medium-6 cell text-right small-text-center">
			        <?php $count_posts = wp_count_posts(); ?>
			        <p class="blog-count"><?php echo $wp_query->found_posts; ?> <?php _e( 'Articles', 'drumroll' ); ?></p>
		        </div>		    
		    </div>
    	    <article class="grid-x grid-margin-x clear">
    	    	<?php if ( have_posts() ) : ?>
		    	    <?php while ( have_posts() ) : the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="large-4 medium-6 cell blog-card">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail( 'thumbnail'); ?>
							<?php endif; ?>
							<div class="blog-card-content">
								<h3><?php the_title(); ?></h3>
								<?php if (has_post_thumbnail()) : ?>
									<?php echo wpautop(drum_excerpt(15), false); ?>
								<?php else : ?>
									<?php echo wpautop(drum_excerpt(45), false); ?>
								<?php endif; ?>
							</div> <!-- blog-card-content -->
						</a>
					<?php endwhile; ?>
    	    	<?php else : ?>
    	    	    <?php get_template_part( 'template-parts/content', 'none' ); ?>
    	    	<?php endif; // End have_posts() check. ?>
    	    	
    	    	<?php
		        // Pagination - library/foundation.php
		        drumroll_pagination();
		        ?>
    	    </article>
    	</div> <!-- grid-wrapper -->
    </div> <!-- grid-container -->
</div>

<?php get_footer(); ?>
