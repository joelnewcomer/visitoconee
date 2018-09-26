<?php
/**
 * The template for displaying search results pages.
 *
 * @package DrumRoll
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
		<div class="blurred-container"><div class="blurred-bg"></div><div class="blurred-overlay"></div></div>
		<?php $blurred_image = wp_get_attachment_image_src($image_id,'featured'); ?>
		<script>
		 	jQuery( document ).ready(function() {
		    	jQuery('.blurred-bg').backgroundBlur({
		        	imageURL : '<?php echo $blurred_image[0]; ?>',
					blurAmount : 7,
					imageClass : 'bg-blur'
		     	});
		 	});
		</script>	
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
							</div>
						</div> <!-- grid-container -->
					</section> <!-- breadcrumbs -->
					<div class="blog-header single-header text-center search-and-cats">
						<div style="display:table;width:100%;height:100%;">
							<div style="display:table-cell;vertical-align:middle;">
						    	<div style="text-align:center;">
							    	<h1 class="entry-title single-title-ul"><?php _e( 'Search', 'drumroll' ); ?></h1>
							    	<!-- Search -->
									<form role="search" method="get" id="blog-search" action="<?php echo home_url( '/' ); ?>">
										<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_attr_e( 'Search Blog', 'drumroll' ); ?>">
										<input type="submit" class="search" id="searchsubmit" value="">
									</form>
						    	</div>
							</div>
						</div>
					</div> <!-- blog-header -->
				</div> <!-- overlay -->
			</div> <!-- blog-landing-featured -->
		</div> <!-- row -->
	</div> <!-- featured-container -->

<div class="search-results-container">
    <div class="grid-container">
	    <div class="grid-wrapper">
			<div class="large-12 cell" role="main">
				<h2 class="entry-title"><?php echo $wp_query->found_posts; ?> <?php _e( 'Results for', 'drumroll' ); ?> "<?php echo get_search_query(); ?>"</h2>			
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="blog-card blog-card-wide">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail( array( 'width' => 640, 'height' => 370, 'crop' => true ) ) ?>
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
				<?php endif;?>
			
				<?php if ( function_exists( 'drumroll_pagination' ) ) { drumroll_pagination(); } else if ( is_paged() ) { ?>			
					<nav id="post-nav">
						<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'drumroll' ) ); ?></div>
						<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'drumroll' ) ); ?></div>
					</nav>
				<?php } ?>
			
			</div>
	    </div> <!-- grid-wrapper -->
	</div> <!-- grid-container -->
</div> <!--search-container -->

<?php get_footer();
