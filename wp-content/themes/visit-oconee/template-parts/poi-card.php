	    		    	<?php
		    		    $detect = new Mobile_Detect;
		    		    $website = get_field('website');
		    		    $address = get_field('address');
		    		    $phone = get_field('phone');
		    		    $social = array();
		    		    $share_link = get_permalink($post->ID);
		    		    $desc = get_field('more_info');
		    		    $title = get_the_title($post);
		    		    if (get_field('social_instagram') != '') {
			    		    $social['instagram'] = get_field('social_instagram');
			    		}
			    		if (get_field('social_facebook') != '') {
			    		    $social['facebook'] = get_field('social_facebook');
			    		}
			    		if (get_field('social_twitter') != '') {
			    		    $social['twitter'] = get_field('social_twitter');
			    		}
		    		    $terms = wp_get_post_terms( $post->ID, 'poi_cats', array("fields" => "slugs") );
		    		    $classes = implode(" ", $terms);
		    		    ?>
						<div class="large-4 medium-6 cell poi-card transition <?php echo $classes; ?>">
							<div class="poi-photo-wrapper">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
								<?php $caption = get_post(get_post_thumbnail_id())->post_excerpt; ?>
								<?php if ($caption != '') : ?>
									<div class="poi-caption"><?php echo $caption; ?></div>
								<?php endif; ?>
														<?php
						echo '<div class="img-social transition">Share: ';
						
						// Facebook
						echo '<a href="https://www.facebook.com/sharer.php?u=' . $share_link . '" target="_blank" onclick="ga(\'send\', \'event\', \'Social\', \'Click\', \'Social Media – Facebook\');">';
						get_template_part('assets/images/social/facebook','official.svg');
						echo '</a>';
						// Twitter
						echo '<a href="https://twitter.com/intent/tweet?url=' .$share_link . '&text=' . urlencode($desc) . '" target="_blank" onclick="ga(\'send\', \'event\', \'Social\', \'Click\', \'Social Media – Twitter\');">';
						get_template_part('assets/images/social/twitter','official.svg');
						echo '</a>';
						// Email
						echo '<a href="mailto:?body=' . $title . '%0D%0A%0D%0A' . $desc . '%0D%0A%0D%0A' . $share_link . '&subject=Check this out!" target="_blank">';
						get_template_part('assets/images/email','icon.svg');
						echo '</a>';				
						// Text
						// if ( $detect->isMobile() ) {
							echo '<a href="sms:1&body=' . $title . '%0a%0a' . $desc . '%0a%0a' . $share_link . '" target="_blank">';
							get_template_part('assets/images/texting','icon.svg');
							echo '</a>';
						// }	
					echo '</div>';
					?>	
								
							</div> <!-- poi-photo-wrapper --> 
							<div class="poi-card-content">
								<h3><?php the_title(); ?></h3>
								<?php
								$address = get_field('address');
								
								$clean_address = urlencode( strip_tags($address) );
								if( $detect->isiOS() ) : ?>
								    <a class="address" href="http://maps.apple.com/?daddr=<?php echo $clean_address; ?>">
								<?php else : ?>
								    <a class="address" href="http://maps.google.com/?q=<?php echo $clean_address; ?>" target="_blank">
								<?php endif; ?>
								    <?php echo $address; ?>
								</a>
								<div class="poi-itinerary" data-itinerary="<?php echo $post->ID; ?>">
									<?php get_template_part('assets/images/itinerary', 'icon.svg'); ?>
									<div><span class="caps">Add<span class="added">ed</span></span> to My Itinerary</div>
								</div>
								<div class="poi-social">
								<?php foreach( $social as $social_name => $social_url ) : ?>
									<?php
									echo '<a href="' . $social_url . '" class="' . $social_name . '" target="_blank">';
									get_template_part('assets/images/social/' . $social_name , 'official.svg');
									echo '</a>';
									?>
								<?php endforeach; ?>
								</div> <!-- poi-social -->	
								<?php
								$url = get_field('google_business_url');
								$website = get_field('website');
								$more_info = get_field('more_info');
								$poi_text = "More Info";
								?>
								<?php if ($more_info == '') :?>
	 								<?php
		 							if ($website != '') {
		 								$url = $website;
		 								$poi_text = "Website";
	 								}
	 								?>
	 								<a href="<?php echo $url; ?>" target="_blank" class="poi-more-info"><?php echo $poi_text; ?></a>
	 							<?php else : ?>
	 								<a href="#" class="poi-more-info toggle-shade"><?php echo $poi_text; ?></a>
	 							<?php endif; ?>
							</div> <!-- poi-card-content -->
							<?php if ($more_info != '') :?>
								<div class="poi-shade transition">
									<div class="toggle-shade close-shade">&times;</div>
									<h3><?php the_title(); ?></h3>
									<p><?php echo get_field('more_info'); ?></p>
									<?php if ($website != '') : ?>
										<div class="text-center">
											<div class="button small reverse"><a href="<?php echo $website; ?>" target="_blank">Website</a></div>
										</div>
									<?php endif; ?>
									<div class="shade-left">
										<div class="poi-itinerary" data-itinerary="<?php echo $post->ID; ?>">
											<?php get_template_part('assets/images/itinerary', 'icon.svg'); ?>
											<div><span class="caps">Add<span class="added">ed</span></span> to My Itinerary</div>
										</div>										
									</div>
									<?php if ($url != '') : ?>
									<div class="shade-right text-right">
										<a href="<?php echo $url; ?>" target="_blank">Get Directions</a>
									</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div> <!-- poi-card -->
