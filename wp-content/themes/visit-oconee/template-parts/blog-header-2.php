<div class="blog-header blog-header-2">
	<div class="grid-container">
		<div class="grid-x">
			<div class="blog-header-left large-8 medium-7 cell small-text-center">
				<div style="display:table;width:100%;height:100%;">
					<div style="display:table-cell;vertical-align:middle;">
				    	<div>
					    	<?php
						    global $title;
						    if (is_home()) {
							    $title = get_the_title( get_option('page_for_posts', true) );
						    } else {
							    $title = single_term_title("", false);
						    }	
						    ?>
					    	<h1 class="entry-title"><?php echo $title; ?></h1>
							<?php					    	
							$args = array(
								'posts_per_page' => '1',
							);
							$query = new WP_query ( $args );
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ) : $query->the_post();
									global $blog_header_two;
									$blog_header_two = true;
									echo '<h2>';
									the_title();
									echo '</h2>';
									echo wpautop(drum_excerpt(15), false);
								endwhile;
								rewind_posts();
							} ?>
				    	</div>
					</div>
				</div>
			</div>
			<div class="blog-header-right large-4 medium-5 cell">
				<div style="display:table;width:100%;height:100%;">
					<div style="display:table-cell;vertical-align:middle;">
				    	<div class="text-center">
					    	<?php get_template_part('template-parts/blog', 'search-cats'); ?>
					    	<div class="featured-cats text-left">
					    	<h3><?php _e( 'Featured Categories', 'drumroll' ); ?></h3>
					    		<ul>
					    		<?php
								$terms = get_terms( array(
									'hide_empty' => false,
									'meta_key' => 'featured_category',
									'meta_value' => 1,
									'number' => 5
								));
								foreach ($terms as $term) {
									echo '<li><a href="' . get_term_link($term) . '" class="transition">' . $term->name . '</a></li>';
								}
								?>
								</ul>
					    	</div> <!-- featured-cats -->
				  		</div>
					</div>
				</div>	
			</div>
		</div> <!-- grid-x -->
	</div> <!-- grid-container -->
</div> <!-- blog-header -->