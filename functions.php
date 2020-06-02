<?php 

function gWorks_files() {
	wp_enqueue_style('Vinkel', '');
	wp_enqueue_style('gWorks_main_styles', get_stylesheet_uri());
	#jos javascript niin tulee wp_enqueue_script
}

add_action('wp_enqueue_scripts', 'gWorks_files');


?>

