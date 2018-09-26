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
			<div class="grid-container">
				<div class="grid-x">
					<div class="large-4 medium-4 cell">
						<div class="copyright small-text-center">						
							<?php get_template_part('template-parts/site-logo','link'); ?>
						</div>
						<div class="address">
							<?php get_template_part('template-parts/locations'); ?>
						</div> <!-- address -->
					</div>
					<div class="large-3 medium-3 cell hide-for-print small-text-center">
						<?php drumroll_footer_menu(); ?>
					</div>
					<div class="large-5 medium-5 cell hide-for-print small-text-center social-subscribe">
						<h3><?php _e( 'Follow Us', 'drumroll' ); ?></h3>
						<?php get_template_part('template-parts/social'); ?>
						<?php get_template_part('template-parts/subscribe-form'); ?>
					</div>
				</div> <!-- grid-x -->
			</div> <!-- grid-container -->
		</div> <!-- main-footer -->
		<div class="sub-footer">
			<div class="grid-container">
				<div class="grid-x">
					<div class="large-7 medium-7 cell drum hide-on-print small-text-center">
						<p>&copy;<?php echo date('Y'); ?> <?php bloginfo('name'); ?>.  <span class="no-break"><?php _e( 'All rights reserved.', 'textdomain' ); ?></span>
							<?php
							$terms_page = get_theme_mod( 'terms_page' );
							$privacy_page = get_theme_mod( 'privacy_page' );
							?>
							<span class="hide-for-print">
							<?php if ($terms_page) : ?>
								&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo get_permalink($terms_page); ?>"><?php _e( 'Terms', 'drumroll' ); ?></a>
							<?php endif; ?>
							<?php if ($privacy_page) : ?>
								&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo get_permalink($privacy_page); ?>"><?php _e( 'Privacy', 'drumroll' ); ?></a>
							<?php endif; ?>
							&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo get_site_url(); ?>/sitemap"><?php _e( 'Sitemap', 'drumroll' ); ?></a>
							</span> <!-- hide-for-print -->
						</p>
					</div>
					<div class="large-5 medium-5 cell drum hide-on-print text-right small-text-center">
						<p><a href="http://www.drumcreative.com" target="_blank"><?php _e( 'Web Design by: Drum Creative' ); ?></a> &nbsp;| &nbsp; Icons provided by FlatIcon.com</p>
					</div>					
				</div> <!-- grid-x -->
			</div> <!-- grid-container -->			
		</div> <!-- sub-footer -->
	</footer>
	
	<?php get_template_part( 'template-parts/search-modal' ); ?>
	<?php get_template_part( 'template-parts/fullscreen-menu' ); ?>	
	<a class="cd-top"><?php _e( 'Top', 'textdomain' ); ?></a>

<?php wp_footer(); ?>

</body>
</html>