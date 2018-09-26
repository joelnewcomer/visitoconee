<?php $social_networks = get_theme_mod( 'social_networks' ); ?>
<?php if ($social_networks) : ?>
	<div class="social text-right small-text-center">
		<?php foreach( $social_networks as $network ) : ?>
			<?php
			$social_url = $network['link_url'];
			$social = $network['network_select'];
			echo '<a href="' . $social_url . '" class="' . $social . '" target="_blank">';
			get_template_part('assets/images/social/' . $social , 'official.svg');
			echo '</a>';
			?>
		<?php endforeach; ?>
	</div> <!-- social -->
<?php endif; ?>