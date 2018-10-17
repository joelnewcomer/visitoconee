<?php
session_start();
include '../../../wp-load.php';
$itinerary = $_REQUEST['itinerary'];
// reference the Dompdf namespace
use Dompdf\Dompdf;

// PDF Content
$content = '
	<html>
		<body>
			<link rel="stylesheet" id="main-stylesheet-css"  href="' . get_template_directory_uri() . '/assets/stylesheets/dist/foundation.css" type="text/css" media="all" />
			<div style="width: 100%; height: 100px; text-align: center; margin-bottom: 64px;">
				<img width="300" src="' . get_site_url() . '/wp-content/uploads/2018/09/visit-oconee-logo-horiz.png" alt="Visit Oconee South Carolina Logo" style="margin: 15px 0;"><br>
				<h1 style="color: #664D39">My Itinerary</h1>
			</div>';
foreach ($itinerary as $post_id) {
	$content .= '<div class="poi-card" style="display: block; height: 101px; width: 100%; margin-bottom: 20px; padding-top: 4px; background: rgba(102, 77, 57, 0.1);">';
	$content .= '<img src="' . get_the_post_thumbnail_url( $post_id, 'thumbnail' ) . '" width="200" style="float: left; margin-top: -4px; margin-right: 20px;">';
	$content .= '<h3 style="margin-top: 10px">' . get_the_title($post_id). '</h3>';
	$content .= '<p>' . get_field('address', $post_id) . '</p>';
	$content .= '</div>';
}
$content .= '</body></html>';
 
 
 
  
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->set_option('defaultFont', 'Helvetica');
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->loadHtml($content);
 
// (Optional) Setup the paper size and orientation
$dompdf->set_paper( 'letter' , 'portrait' );
 
// Render the HTML as PDF
$dompdf->render();
 
$output = $dompdf->output();

// Create the itineraries folder if it doesn't exist
if (!is_dir(dirname(__FILE__) . '/../../../wp-content/uploads/itineraries')) {
	mkdir(dirname(__FILE__) . '/../../../wp-content/uploads/itineraries');
}

$filename = dirname(__FILE__) . '/../../../wp-content/uploads/itineraries/my-itinerary-' . session_id() . '.pdf';
file_put_contents($filename, $output);

// Delete PDFs after 30 days
$files = glob(dirname(__FILE__) . '/../../../wp-content/uploads/itineraries/'."*");
$now  = time();
foreach ($files as $file) {
    if (is_file($file)) {
    	if ($now - filemtime($file) >= 60 * 60 * 24 * 30) { // 30 days
			unlink($file);
    	}
    }
}
 
return $filename;
?>