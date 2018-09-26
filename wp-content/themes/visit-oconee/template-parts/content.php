<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('blogpost-entry entry-content sr'); ?>>
	<header>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php drum_entry_meta(); ?>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-image">
				<?php the_post_thumbnail( array( 'width' => 770, 'height' => 420, 'crop' => true )); ?>
			</div>
		<?php endif; ?>
	</header>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
	<footer>
		<?php $tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
	<hr />
</div>
