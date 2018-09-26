<style>
    .no-fouc {display: none;}
	#preloader {
    	position: fixed;
    	top: 0;
    	left: 0;
    	right: 0;
    	bottom: 0;
    	background: #ccc;
    	z-index: 800;
    	height: 100vh;
    	width: 100%;
    }
	.no-js #preloader, .oldie #preloader {
    	display: none;
	}	    
</style>

<script>
    document.documentElement.className = 'no-fouc';
</script>
	
<div id="preloader">
	<div class="loading-inner">
    	<?php get_template_part('template-parts/site-logo'); ?>
    	<div class="load-awesome la-timer"><div></div></div>
    </div> <!-- loading-inner -->
</div> <!-- preloader -->