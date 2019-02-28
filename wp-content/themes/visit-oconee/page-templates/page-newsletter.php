<?php
/*
Template Name: Newsletter
*/
get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>
<?php // get_template_part( 'template-parts/featured-image-parallax' ); ?>

<div id="page" role="main">
	<section class="newsletters">
		<div class="grid-container">
	   		<div class="grid-x">
		   		<div class="large-3 medium-4 cell text-center current-nl">
			   		<a href="<?php echo get_field('current_link'); ?>" target="_blank"><span class="caps"><?php echo get_field('current_month'); ?></span> Newsletter<br />
			   			<?php echo wp_get_attachment_image(get_field('current_thumbnail'), 'full'); ?><br />
			   			<i>Click to view in your browser</i>
			   		</a>
		   		</div>
		   		<div class="large-9 medium-8 cell nl-archive">
			   		<?php echo get_field('newsletters_intro'); ?>
			   		<h2>Newsletter Archive</h2>
			   		<?php $months = array("Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"); ?>
			   		<?php if(get_field('add_year')): ?>
			   			<?php while(has_sub_field('add_year')): ?>
			   				<div class="year-row">
				   				<span class="year"><?php echo get_sub_field('year'); ?></span>
				   				<?php
					   			foreach ($months as $month) {
						   			$url = get_sub_field(strtolower($month));
						   			$active = '';
						   			if ($url != '') {
							   			if ($url == get_field('current_link')) {
								   			$active = ' active';
							   			}
						   				echo '<a class="nl-month' . $active . '" href="' . $url . '" target="_blank">' . $month . '</a>';
					   				} else {
						   				echo '<span class="nl-month no-link">' . $month . '</span>';
					   				}
				   				}
				   				?>
			   				</div>
			   			<?php endwhile; ?>
			   		<?php endif; ?>
		   		</div>
	   		</div>
		</div>
	</section>
	
</div> <!-- #page -->


<?php get_footer();