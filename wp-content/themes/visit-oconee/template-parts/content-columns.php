<?php
/**
 * The template for displaying column contents
 *
 * @subpackage DrumStarter
 * @since DrumStarter 1.0
 */

$tabs_counter = 1;
$row_counter = 1;
$background = "";

// echo '<pre>';
// print_r( get_field('content') );
// echo '</pre>';

// check if the flexible content field has rows of data
if( have_rows('content') ):
     // loop through the rows of data
    while ( have_rows('content') ) : the_row();
    	
    	// Set up section variables, parallax, classes, and id
	    $section_header = get_sub_field('section_header');
	    $section_classes = '';
	    $section_id = '';
	    $section_parallax = '';
	    $bg_color = get_sub_field('custom_options')['background_color'];
	    if (get_sub_field('custom_options')['custom_background'] == 'Parallax Image Background' && get_sub_field("custom_options")["parallax_image"] != '') {
		    $section_classes .= 'parallax-window';
		    $section_parallax = 'data-paroller-factor="0.5" style="background: url(' . wp_get_attachment_image_url(get_sub_field("custom_options")["parallax_image"], "full") . '"';
	    }
	    if ($bg_color != '' && !is_array($bg_color))	{
		    $section_classes = $bg_color;
        } else {
	    	$section_classes = 'default-background';
        }
		$section_id = get_sub_field('custom_options')['section_id'];
		if ($section_id != null) { 
			$section_id = 'id="' . $section_id . '"' ;
		} 
		$is_white_text = get_sub_field('custom_options')['white_text'];
		if ($is_white_text) {
			$section_classes .= ' white-text';
		}

        $section_classes .= ' section-' . $row_counter;
        
        
        if( get_row_layout() == 'one_column' ): ?>
			<!-- One Column -->
        	<section <?php echo $section_id; ?> class="<?php echo $section_classes; ?>" <?php echo $section_parallax; ?>>
	        	<div class="grid-container">
    	    		<div class="grid-x grid-padding-x">
						<?php if ($section_header != null) : ?>
							<div class="large-12 cell text-center">
						   		<h2><?php echo $section_header; ?></h2>
							</div>
						<?php endif; ?>
	        			<div class="large-12 cell entry-content">
	        				<?php echo get_sub_field('column_1')['content']; ?>
						</div>
    	    		</div> <!-- grid-x -->
	        	</div> <!-- grid-container -->
			</section>

        
        <?php elseif( get_row_layout() == 'two_columns' ): ?>
        	<!-- Two Columns -->
        	<section <?php echo $section_id; ?> class="<?php echo $section_classes; ?>" <?php echo $section_parallax; ?>>
	        	<div class="grid-container">
		    		<div class="grid-x grid-padding-x">
						<?php if ($section_header != null) : ?>
							<div class="large-12 cell text-center">
								<h2><?php echo $section_header; ?></h2>
							</div>
						<?php endif; ?>			        		
	        			<div class="large-6 medium-6 cell entry-content">
	        				<?php echo get_sub_field('column_1')['content']; ?>
	        			</div>
	        			<div class="large-6 medium-6 cell entry-content">
	        				<?php echo get_sub_field('column_2')['content']; ?>
	        			</div>
		    		</div> <!-- grid-x -->
	        	</div> <!-- grid-container -->
        	</section>

        <?php elseif( get_row_layout() == 'three_columns' ): ?>
			 <!-- Three Columns -->
			<section <?php echo $section_id; ?> class="<?php echo $section_classes; ?>">
				<div class="grid-container">
					<div class="grid-x grid-padding-x">
						<?php if ($section_header != null) : ?>
							<div class="large-12 cell text-center">
								<h2><?php echo $section_header; ?></h2>
							</div>
						<?php endif; ?>						
	        			<div class="large-4 medium-4 cell entry-content">
	        				<?php echo get_sub_field('column_1')['content']; ?>
	        			</div>
	        			<div class="large-4 medium-4 cell entry-content">
	        				<?php echo get_sub_field('column_2')['content']; ?>
	        			</div>
	        			<div class="large-4 medium-4 cell entry-content">
	        				<?php echo get_sub_field('column_3')['content']; ?>
	        			</div>
					</div> <!-- grid-x -->
				</div> <!-- grid-container -->
			</section>
			
        <?php elseif( get_row_layout() == 'four_columns' ): ?>
        	<!-- Four Columns -->
        	<section <?php echo $section_id; ?> class="<?php echo $section_classes; ?>">
	        	<div class="grid-container">
		        	<div class="grid-x grid-padding-x">
						<?php if ($section_header != null) : ?>
							<div class="large-12 cell text-center">
								<h2><?php echo $section_header; ?></h2>
							</div>
						<?php endif; ?>			        	
	        			<div class="large-3 medium-3 cell entry-content">
	        				<?php echo get_sub_field('column_1')['content']; ?>
	        			</div>
	        			<div class="large-3 medium-3 cell entry-content">
	        				<?php echo get_sub_field('column_2')['content']; ?>
	        			</div>
	        			<div class="large-3 medium-3 cell entry-content">
	        				<?php echo get_sub_field('column_3')['content']; ?>
	        			</div>
	        			<div class="large-3 medium-3 cell entry-content">
	        				<?php echo get_sub_field('column_4')['content']; ?>
	        			</div>
		        	</div> <!-- grid-x -->
	        	</div> <!-- grid-container -->
        	</section>
        	
        <?php elseif( get_row_layout() == 'right_sidebar' ): ?>
			<!-- Right Sidebar -->
        	<section <?php echo $section_id; ?> class="<?php echo $section_classes; ?>">
	        	<div class="grid-container">
		        	<div class="grid-x grid-padding-x">
						<?php if ($section_header != null) : ?>
							<div class="large-12 cell text-center">
								<h2><?php echo $section_header; ?></h2>
							</div>
						<?php endif; ?>			        	
	        			<div class="large-8 medium-8 cell entry-content">
	        				<?php echo get_sub_field('column_1')['content']; ?>
	        			</div>
	        			<div class="large-4 medium-4 cell entry-content">
	        				<?php echo get_sub_field('column_2')['content']; ?>
	        			</div>
		        	</div> <!-- grid-x -->
	        	</div> <!-- grid-container -->
        	</section>
        	
        <?php elseif( get_row_layout() == 'left_sidebar' ): ?>
			<!-- Left Sidebar -->
			<section <?php echo $section_id; ?> class="<?php echo $section_classes; ?>">
				<div class="grid-container">
					<div class="grid-x grid-padding-x">
						<?php if ($section_header != null) : ?>
							<div class="large-12 cell text-center">
								<h2><?php echo $section_header; ?></h2>
							</div>
						<?php endif; ?>						
	        			<div class="large-4 medium-4 cell entry-content">
	        				<?php echo get_sub_field('column_1')['content']; ?>
	        			</div>
	        			<div class="large-8 medium-8 cell entry-content">
	        				<?php echo get_sub_field('column_2')['content']; ?>
	        			</div>
					</div> <!-- grid-x -->
				</div> <!-- grid-container -->
			</section>
		
						
        <?php elseif( get_row_layout() == 'tabs' ): ?>
        	<!-- Tabs/Accordion -->
        	<?php $type = get_sub_field('type'); ?>
			<section <?php echo $section_id; ?> class="<?php echo $section_classes; ?>">
				<div class="grid-container">
					<div class="grid-x grid-padding-x">
						<?php if ($section_header != null) : ?>
							<div class="large-12 cell text-center">
								<h2><?php echo $section_header; ?></h2>
							</div>
						<?php endif; ?>						
	        			<div class="large-12 cell">
		        			<div class="tabs-container">
		        				<div id="tabs-<?php echo $tabs_counter; ?>">
								<?php if(get_sub_field('tabs')): ?>
									<ul class="resp-tabs-list tabs-<?php echo $tabs_counter; ?>">
									<?php while(has_sub_field('tabs')): ?>
										<li><?php the_sub_field('tab_title'); ?><?php get_template_part('assets/images/acc', 'arrow.svg'); ?></li>
									<?php endwhile; ?>
									</ul> <!-- resp-tabs-list -->
									<div class="resp-tabs-container tabs-<?php echo $tabs_counter; ?>">
									<?php while(has_sub_field('tabs')): ?>
										<div><div class="tab-content-inner entry-content"><?php the_sub_field('tab_content'); ?></div></div>
									<?php endwhile; ?>
									</div> <!-- resp-tabs-container -->
								<?php endif; ?>
		        				</div>  <!-- tabs -->
		        			</div> <!-- tabs-container -->
		        			<script>
			    		    	jQuery( document ).ready(function() {
			    		    		jQuery('#tabs-<?php echo $tabs_counter; ?>').easyResponsiveTabs({
				    		    		type: '<?php echo $type; ?>',
										tabidentify: 'tabs-<?php echo $tabs_counter; ?>', // The tab groups identifier
        							});
			    		    	});
			    		    </script>
	        			</div> <!-- columns -->
					</div> <!-- grid-x -->
				</div> <!-- grid-container -->
			</section> <!-- sr -->
			<?php $tabs_counter++; ?>
        <?php endif;
	    $row_counter++;
    endwhile;
endif;
?>