<?php $locations = get_theme_mod( 'locations' ); ?>
<?php if ($locations) : ?>
	<?php foreach( $locations as $location ) : ?>
		<?php if( $location['loc_title'] ): ?>
			<!-- <span class="title"><?php echo $location['loc_title'];?></span> -->
		<?php endif; ?>
		<h2>
			<?php // function drum_smart_phone($phone, $phone_text, $phone_label)
			echo drum_smart_phone($location['loc_phone'], $location['loc_phone'], ''); ?>
		</h2>
		<p>
			<?php // function drum_smart_address($address,$address_line_2,$city,$state,$zip)
			echo drum_smart_address($location['loc_address'],$location['loc_address_2'],$location['loc_city'],$location['loc_state'],$location['loc_zip']); ?><br />
			<?php if( $location['loc_email'] ): ?>
				<a href="mailto:<?php echo $location['loc_email'];?>" class="email"><?php echo $location['loc_email'];?></a><br />
			<?php endif; ?>		
		</p>
	<?php endforeach; ?>
<?php endif; ?>