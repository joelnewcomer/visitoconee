<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
get_header(); ?>

<section>
	<div class="grid-container">
		<div class="grid-x">
			<div class="large-12 cell text-center" role="main">
				<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<header>
						<h1 class="entry-title error-404"><?php _e( '404', 'drumroll' ); ?></h1>
					</header>
					<div class="entry-content">
						<h2><?php _e( 'Sorry, we couldn’t locate that page.', 'drumroll' ); ?></h2>
						<div class="button"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Take Me Home', 'drumroll' ); ?></a></div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>

<?php get_footer();
