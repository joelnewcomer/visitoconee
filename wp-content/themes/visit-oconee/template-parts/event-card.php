	    		    	<?
		    		    global $post;
		    		    global $detect;
		    		    $today = time();
		    		    $start_date_past = false;
		    		    $current_month = date('F', $today);
		    		    $start_date = get_post_meta($post->ID, "start_date", true);
		    		    $end_date = get_post_meta($post->ID, "end_date", true);
		    		    $start_month = date('F', $start_date);
		    		    $end_month = date('F', $end_date);
		    		    // If the event start date is in the past, set the start date to today
		    		    if ($start_date < $today) {
			    			$start_date = $today;
			    			$start_date_past = true;
			    		}
		    		    $social = array();
		    		    $link = get_field('more_info_link');
		    		    $share_link = get_permalink($post->ID);
		    		    $target = 'target="_blank"';
		    		    if ($link == '') {
			    		    // $link = get_permalink($post->ID);
			    		    // $target = '';
			    		    $link = '#';
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
		    		    $caption = get_field('short_description');
		    		    $title = get_the_title($post);
		    		    ?>
						<div class="large-4 medium-6 cell event-card month-<?php echo date('n', $start_date); ?> transition <?php echo $classes; ?>">
							<a href="<?php echo $link; ?>" <?php echo $target; ?> class="event-card-month text-center">
								<?php echo date('F', $start_date); ?>
							</a>
							<div class="event-photo-wrapper">
								<a href="<?php echo $link; ?>" <?php echo $target; ?>>
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</a>
						<?php
						echo '<div class="img-social transition">Share: ';
						
						// Facebook
						echo '<a href="https://www.facebook.com/sharer.php?u=' . $share_link . '" target="_blank" onclick="ga(\'send\', \'event\', \'Social\', \'Click\', \'Social Media – Facebook\');">';
						get_template_part('assets/images/social/facebook','official.svg');
						echo '</a>';
						// Twitter
						echo '<a href="https://twitter.com/intent/tweet?url=' .$share_link . '&text=' . urlencode($caption) . '" target="_blank" onclick="ga(\'send\', \'event\', \'Social\', \'Click\', \'Social Media – Twitter\');">';
						get_template_part('assets/images/social/twitter','official.svg');
						echo '</a>';
						// Email
						echo '<a href="mailto:?body=' . $title . '%0D%0A%0D%0A' . $caption . '%0D%0A%0D%0A' . $share_link . '&subject=Check out this event!" target="_blank">';
						get_template_part('assets/images/email','icon.svg');
						echo '</a>';				
						// Text
						if ( $detect->isMobile() ) {
							echo '<a href="sms:1&body=' . $title . '%0D%0A%0D%0A' . $caption . '%0D%0A%0D%0A' . $share_link . '" target="_blank">';
							get_template_part('assets/images/texting','icon.svg');
							echo '</a>';
						}	
					echo '</div>';
					?>								
							</div>
							<div class="event-card-content">
								
								<?php
								$two_dates = '';
								if ($start_date != $end_date && $end_date != '' && $current_month == $start_month && $end_month == $start_month) {
									$two_dates = 'two-dates';
								}
								if ($current_month != $start_month && $current_month != $end_month && $current_month != $start_month) {
									$two_dates = 'no-dates';
								}
								?>
								<div class="date-range <?php echo $two_dates; ?>">
										<?php if ($start_month == $current_month) : ?><?php echo date('j', $start_date); ?><?php endif; ?><?php if ($start_date != $end_date && $end_date != '' && $current_month == $end_month) : ?>- <?php echo date('j', $end_date); ?><?php endif; ?>
								</div>
								<a href="<?php echo $link; ?>" <?php echo $target; ?>>
									<h3><?php the_title(); ?></h3>
								</a>
								<div class="description-container">
									<p><?php echo get_field('short_description'); ?></p>
								</div>
								<?php if ($link != '#') : ?>
								<div class="event-links">
									<a href="<?php echo $link; ?>" <?php echo $target; ?> class="event-link event-more">More Info</a>
								</div> <!-- event-links -->
								<?php endif; ?>
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
