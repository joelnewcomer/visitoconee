	    		    	<?
		    		    $website = get_field('website');
		    		    $address = get_field('address');
		    		    $phone = get_field('phone');
		    		    $social = array();
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
							<?php the_post_thumbnail( 'thumbnail' ); ?>
							<?php $caption = get_post(get_post_thumbnail_id())->post_excerpt; ?>
							<?php if ($caption != '') : ?>
								<div class="poi-caption"><?php echo $caption; ?></div>
							<?php endif; ?> 
							<div class="poi-card-content">
								<h3><?php the_title(); ?></h3>
								<?php
								$address = get_field('address');
								$detect = new Mobile_Detect;
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
