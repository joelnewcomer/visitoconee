<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
?>
	</main> <!-- .container -->
				
	<footer id="footer" role="contentinfo">
		<div class="main-footer">
			<img class="hide-for-print" src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-bg.jpg" alt="Scenic Oconee Lake"> 
			<div class="footer-overlay">
				<div class="grid-container">
					<div class="grid-x">
						<div class="large-9 medium-9 cell hide-for-print small-text-center social-subscribe">
							<?php get_template_part('template-parts/social'); ?>
							<?php get_template_part('template-parts/subscribe-form'); ?>
						</div>
					</div> <!-- grid-x -->
				</div> <!-- grid-container -->
			</div>
		</div> <!-- main-footer -->
		<div class="sub-footer">
			<div class="map-container">
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="large-offset-4 medium-offset-4 large-4 medium-4 cell text-center footer-about hide-for-print">
						<?php get_template_part('template-parts/site-logo','link'); ?>
						<p>Oconee County is located in the northwestern corner of Upstate SC and borders the mountains of NC and Northeast GA.</p>
					</div>
					<div class="large-4 medium-4 cell drum hide-on-print text-right small-text-center hide-for-print">
						<a class="footer-brochure-image" href="#">
							<img src=" <?php echo get_template_directory_uri(); ?>/assets/images/footer-brochure.jpg" alt="Visit Oconee Visitor's Guide">
						</a>
						<a class="footer-brochure" href="#">
							Download Our <span class="no-wrap">Visitor's Guide</span>
						</a>
						
					</div>
					<div class="large-9 medium-12 medium-down-text-center cell">
						<p class="copyright">Copyright &copy; <?php echo date('Y'); ?> Visit Oconee SC.  <span class="no-break"><?php _e( 'All rights reserved.', 'textdomain' ); ?></span>
							<?php
							$terms_page = get_theme_mod( 'terms_page' );
							$privacy_page = get_theme_mod( 'privacy_page' );
							?>
							<span class="hide-for-print no-break">
							<?php if ($terms_page) : ?>
								&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo get_permalink($terms_page); ?>"><?php _e( 'Terms', 'drumroll' ); ?></a>
							<?php endif; ?>
							<?php if ($privacy_page) : ?>
								&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo get_permalink($privacy_page); ?>"><?php _e( 'Privacy', 'drumroll' ); ?></a>
							<?php endif; ?>
							&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo get_site_url(); ?>/sitemap"><?php _e( 'Sitemap', 'drumroll' ); ?></a>
							</span> <!-- hide-for-print no-break -->
						</p>			
					</div>
					<div class="large-3 medium-12 cell drum medium-down-text-center hide-on-print hide-for-print">
						<p class="drum"><a href="http://www.drumcreative.com" target="_blank"><?php _e( 'Web Design by: Drum Creative' ); ?></a></p>
					</div>
				</div> <!-- grid-x -->
			</div> <!-- grid-container -->
			</div> <!-- map-container -->	
		</div> <!-- sub-footer -->
	</footer>
	
	<?php get_template_part( 'template-parts/search-modal' ); ?>
	<a class="cd-top"><?php _e( 'Top', 'textdomain' ); ?></a>

<?php wp_footer(); ?>

</body>
</html>