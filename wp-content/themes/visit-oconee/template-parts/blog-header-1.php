<div class="blog-header blog-header-1 text-center">
	<div style="display:table;width:100%;height:100%;">
		<div style="display:table-cell;vertical-align:middle;">
	    	<div style="text-align:center;">
		    	<?php
			    global $title;
			    if (is_home()) {
				    $title = get_the_title( get_option('page_for_posts', true) );
			    } else {
				    $title = single_term_title("", false);
			    }	
			    ?>
		    	<h1 class="entry-title entry-title-ul"><?php echo $title; ?></h1>
				<?php get_template_part('template-parts/blog', 'search-cats'); ?>
	    	</div>
		</div>
	</div>
</div> <!-- blog-header -->