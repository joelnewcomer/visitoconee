<!--Used in template-parts/fullscreen-menu.php and footer.php -->
<?php $newsletter_gfid = get_theme_mod( 'newsletter_gfid' ); ?>
<?php if ($newsletter_gfid) : ?>
	<div class="subscribe-form">
		<?php echo do_shortcode('[gravityform id="' . $newsletter_gfid . '" title="false" description="false" ajax="true" tabindex="50"]'); ?>
	</div> <!-- subscribe-form -->
<?php endif; ?>