<?php 

/********************************************************************************/
// 2025-11-20: Adding HTML5 support.
function register_html_support() {
    add_theme_support('html5', array('script', 'style'));
} // register_html_support
add_action('after_setup_theme', 'register_html_support');

/********************************************************************************/
// 2025-11-20: An attempt to remove trailing slashes from '<link rel' tags and such.
if (!is_admin()) {
	ob_start();
	add_action('shutdown', function () {
		$content = ob_get_clean();
		// $find_array = array(' />', '/>');
		// $replace_array = array('>', '>');
		$find_array = array(' />');
		$replace_array = array('>');
		$content = str_replace($find_array, $replace_array, $content);
		echo $content;
		exit();
	}, 0);
}

/********************************************************************************/
// 2025-11-21: To disable the 'contain-intrinsic-size' kludge that WordPress has implemented in newer versions.
add_filter('wp_img_tag_add_auto_sizes', '__return_false');

/********************************************************************************/
// 2025-11-21: To disable the 'speculationrules' script stuff.
add_filter('wp_speculation_rules_configuration', '__return_null');

/********************************************************************************/
// 2025-12-07: An attempt to figure out this lack of thumbnails stuff.
add_theme_support('post-thumbnails');

/********************************************************************************/
// 2025-12-09: Properly setting the Bootstrap CSS and JavaScript.
function load_bootstrap_files() {
	wp_register_style('bootstrap-53', get_template_directory_uri() . '/css/bootstrap-5.3.8/bootstrap.min.css', array(), '5.3.8');
	wp_enqueue_style('bootstrap-53');
	wp_register_script('bootstrap-53', get_template_directory_uri() . '/script/bootstrap-5.3.8/bootstrap.bundle.min.js', array('jquery'), '5.3.8');
	wp_enqueue_script('bootstrap-53');
} // load_bootstrap_files
add_action('wp_enqueue_scripts', 'load_bootstrap_files', 10);

/********************************************************************************/
// 2025-12-09: Properly setting the Font Awesome CSS.
function load_fontawesome_files() {
	wp_register_style('fontawesome', get_template_directory_uri() . '/fonts/font-awesome-4.7.0/css/font-awesome.min.css', array(), '4.7.0');
	wp_enqueue_style('fontawesome');
} // load_fontawesome_files
add_action('wp_enqueue_scripts', 'load_fontawesome_files', 10);

/********************************************************************************/
// 2026-04-03: Properly setting the font specific CSS.
function load_font_specific_files() {
	wp_register_style('font_specific', get_template_directory_uri() . '/style_fonts.css', array(), null);
	wp_enqueue_style('font_specific');
} // load_font_specific_files
add_action('wp_enqueue_scripts', 'load_font_specific_files', 10);

/********************************************************************************/
// 2026-03-19: Enabling excerpts on all pages.
add_post_type_support('page', 'excerpt');

/********************************************************************************/
// 2026-03-25: Attempting to sort posts by title instead of date.
// Abandoning in favor of setting this directly in the 'archive.php' code.
// add_action('pre_get_posts', 'category_sort_order');
// function category_sort_order($query){
// 	if (is_archive()) {
// 		$query->set('order', 'ASC');
// 		$query->set('orderby', 'title');
// 	} // if
// } // category_sort_order

/********************************************************************************/
// 2026-03-28: Remove the ridiculous 'Archives: ' prefix from archives pages.
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/********************************************************************************/
// 2026-03-28: Remove the post_type from 'Breadcrumb NavXT' stuff. 
// add_filter('bcn_add_post_type_arg', 'my_add_post_type_arg_filt', 10, 3);
// function my_add_post_type_arg_filt($add_query_arg, $type, $taxonomy) {
// 	return false;
// }

/********************************************************************************/
// 2026-03-31: Adjust the block heading CSS.
function adjust_block_heading_css($content, $block) {
    if (isset($block['blockName']) && str_starts_with($block['blockName'], 'core/heading')) {
    	$pattern = '/\sclass="[^"]*\bwp-block-heading\b[^"]*"/';
    	$replacement = ' class="wp-block-heading p-0 m-0"';
		$pattern = '/<(h[1-6])\s+class="wp-block-heading"(.*?)>/i';
		$replacement = '<$1 class="wp-block-heading p-0 m-0" $2>';
		$content = preg_replace($pattern, $replacement, $content);
    } // if
    return $content;
} // adjust_block_heading_css
add_filter('render_block', 'adjust_block_heading_css', 10, 2 );

/********************************************************************************/
// 2026-03-20: Adding widgets.
function szwergold_widgets_init() {
	register_sidebar(array(
		'name'          => __('Header 1'),
		'id'            => 'header-1',
		'description'   => __('Add widgets here to appear on your page header.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3"><div class="p-0 m-0 text-georgia-regular">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Header 2'),
		'id'            => 'header-2',
		'description'   => __('Add widgets here to appear on your page header.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3"><div class="p-0 m-0 px-2 text-georgia-regular">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Home Featured 1'),
		'id'            => 'home-featured-1',
		'description'   => __('Add widgets here to appear on your homepage.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="h3 text-railroadgothic col col-12 p-0 m-0 mb-1">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Home Featured 2'),
		'id'            => 'home-featured-2',
		'description'   => __('Add widgets here to appear on your homepage.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="h3 text-railroadgothic col col-12 p-0 m-0 mb-1">',
		'after_title'   => '</div>',
	));
} // szwergold_widgets_init
add_action('widgets_init', 'szwergold_widgets_init');

?>