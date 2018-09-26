<?php
/**
 * Entry meta information for posts
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */

if ( ! function_exists( 'drumroll_entry_meta' ) ) :
	function drum_entry_meta() {
		global $post;
		echo '<ul class="post-meta group">';
			echo '<li>';
			// Get categories but exclude Uncategorized
			$cats = wp_get_post_categories($post->ID, array('exclude' => 1));
			$num_cats = count($cats);
			$counter = 1;
			foreach ($cats as $cat) {
				echo '<a href="' . get_category_link($cat) . '">' . get_cat_name($cat) . '</a>';
				if ($num_cats > 1 && $counter < $num_cats) {
					echo ' / ';
				}
				$counter++;
			}
			echo '</li>';
			echo '<li>';
			get_template_part("assets/images/clock-o.svg");
			echo '<time class="updated" datetime="'. get_the_time( 'c' ) .'">'. sprintf( __( '%s', 'drumroll' ), get_the_date() ) .'</time></li>';
			echo '<li><div id="estimated-time"><span>Reading Time: <div class="eta"></div></div></li>';
			if ( get_comments_number() > 0 ) : ?>
				<li>
				<?php if (is_single()) : ?>
					<a href="#comments"><?php get_template_part('assets/images/comment.svg'); ?><?php echo get_comments_number(); ?></a>
				<?php else : ?>
					<a href="<?php the_permalink(); ?>#comments"><?php get_template_part('assets/images/comment.svg'); ?><?php echo get_comments_number(); ?></a>
				<?php endif; ?>
				</li>
			<?php endif; ?>
		</ul> <!-- post-meta -->
	<?php }
endif; ?>