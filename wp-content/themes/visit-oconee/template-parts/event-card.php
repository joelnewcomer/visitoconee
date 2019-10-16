	    		    	<?
		    		    global $post;
		    		    $today = time();
		    		    $start_date_past = false;
		    		    $current_month = date('j', $today);
		    		    // If the event start date is in the past, set the start date to today
		    		    if ($start_date < $today) {
			    			$start_date = $today;
			    			$start_date_past = true;
			    		}
		    		    $start_date = get_post_meta($post->ID, "start_date", true);
		    		    $end_date = get_post_meta($post->ID, "end_date", true);
		    		    $social = array();
		    		    $link = get_field('more_info_link');
		    		    $target = 'target="_blank"';
		    		    if ($link == '') {
			    		    $link = get_permalink($post->ID);
			    		    $target = '';
			    		} 
		    		    if (get_field('social_instagram') != '') {
			    		    $social['instagram'] = get_field('social_instagram');
			    		}
			    		if (get_field('social_facebook') != '') {
			    		    $social['facebook'] = get_field('social_facebook');
			    		}
			    		if (get_field('social_twitter') != '') {
			    		    $social['twitter'] = get_field('social_twitter');
			    		}
		    		    $terms = wp_get_post_terms( $post->ID, 'events_cats', array("fields" => "slugs") );
		    		    $classes = implode(" ", $terms);
		    		    ?>
						<div class="large-4 medium-6 cell event-card month-<?php echo date('n', $start_date); ?> transition <?php echo $classes; ?>">
							<a href="<?php echo $link; ?>" <?php echo $target; ?> class="event-card-month text-center">
								<?php echo date('F', $start_date); ?>
							</a>
							<a href="<?php echo $link; ?>" <?php echo $target; ?>>
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</a>
							<div class="event-card-content">
								
								<?php
								$two_dates = '';
								if ($start_date != $end_date && $end_date != '') {
									$two_dates = 'two-dates';
								}
								?>
								<div class="date-range <?php echo $two_dates; ?>">
									<?php echo date('j', $start_date); ?><?php if ($start_date != $end_date && $end_date != '') : ?>- <?php echo date('j', $end_date); ?><?php endif; ?>
								</div>
								<a href="<?php echo $link; ?>" <?php echo $target; ?>>
									<h3><?php the_title(); ?></h3>
								</a>
								<div class="description-container">
									<p><?php echo get_field('short_description'); ?></p>
								</div>
								
								<div class="event-links">
									<a href="<?php echo $link; ?>" <?php echo $target; ?> class="event-link event-more">More Info</a>
								</div> <!-- event-links -->
								<div class="event-social">
								<?php foreach( $social as $social_name => $social_url ) : ?>
									<?php
									echo '<a href="' . $social_url . '" class="' . $social_name . '" target="_blank">';
									get_template_part('assets/images/social/' . $social_name , 'official.svg');
									echo '</a>';
									?>
								<?php endforeach; ?>
								</div> <!-- event-social -->
								<a class="corner-link" href="<?php echo $link; ?>" <?php echo $target; ?>></a>
							</div> <!-- event-card-content -->
						</div> <!-- event-card -->
