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
// 2026-04-15: Setting a standalone 'archive page eader' function for ease of reuse.
function archive_page_header () {

    /**************************************************************************/
    // Init variables.
    $ret = null;

	$category = get_the_category();

	/**************************************************************************/
	// Get the current selected category slug.
	$page_category = get_the_category();
	$page_category_shifted = null;
	$page_category_slug = null;
	if (!empty($page_category)) {
		$page_category_shifted = array_shift($page_category);
		$page_category_name = $page_category_shifted->name;				
	} // if

	/**************************************************************************/
	// Begin the archive info area.
	$ret .= '<div class="post_nav col col-12 p-0 m-0">';

	/**************************************************************************/
	// Header begins.
	$ret .= '<div class="h1 text-clashgrotesk-semibold p-0 m-0">';
	// echo 'Posts for the ';
	if (is_archive()) {
		$ret .= get_the_archive_title();
	} // if
	else if (is_category()) {
		$ret .= $page_category_name;
	}  // else if
	else if (is_tag()) {
		$ret .= single_tag_title();
	} // else if
	else if (is_year()) {
		getthe_time('Y');
	} // else if
	else if (is_month()) {
		the_time('F Y');
	} // else if
	else if (is_day()) {
		the_time('l, F j, Y');
	} // else if
	// $ret .= ' category&hellip;</div>';
	// $ret .= '<hr class="p-0 m-0 border border-dark border-1 opacity-100">';

	/**************************************************************************/
	// Header ends
	$ret .= '<div class="h4 text-clashgrotesk-semibold">';
	if ($page_description = get_the_archive_description()) {
		$ret .= strip_tags($page_description);
	} // if
	else if ($page_description = category_description()) {
		$ret .= strip_tags($page_description);
	} // else if
	// else {
	// 	echo 'You are currently browsing posts about <strong>';
	// 	if (is_category()) {
	// 		echo '&ldquo;';
	// 		single_cat_title();
	// 		echo '.&rdquo;';
	// 	} // if
	// 	else if (is_tag()) {
	// 		echo '&ldquo;';
	// 		echo single_tag_title();
	// 		echo '.&rdquo;';
	// 	} // else if
	// 	else if (is_year()) {
	// 		the_time('Y');
	// 		echo '.';
	// 	} // else if
	// 	else if (is_month()) {
	// 		the_time('F Y');
	// 		echo '.';
	// 	} // else if
	// 	else if (is_day()) {
	// 		the_time('l, F j, Y');
	// 		echo '.';
	// 	} // else if
	// 	echo '</strong>';
	// } // else
	$ret .= '</div>';

	/**************************************************************************/
	// End the archive info area.
	$ret .= '</div>';
	// $ret .= '<hr class="p-0 m-0 mt-1 mb-2 border border-dark border-1 opacity-100">';

    /**************************************************************************/
    // Return the final value.
    return $ret;

} // archive_page_header

/******************************************************************************/
// 2026-04-14: Setting a standalone 'single post' function for ease of reuse.
function single_post () {

    /**************************************************************************/
    // Init variables.
    $header = null;
    $content = null;

	/**************************************************************************/
	// Get the post.
	the_post();

	global $authordata;

	/**************************************************************************/
	// Set the item info variables.
	$the_ID = get_the_ID();
	$permalink = get_the_permalink();
	$title = get_the_title();
	$title_attribute = the_title_attribute(array('echo' => false));
	$excerpt = get_the_excerpt();
	$the_author = $authordata->display_name;
	$the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
	$update_date = get_the_time('F j, Y');
	$update_time = get_the_time('g:i:sa');

	/**************************************************************************/
	// Get the current selected category slug.
	$page_category = get_the_category();
	$page_category_shifted = null;
	$page_category_slug = null;
	if (!empty($page_category)) {
		$page_category_shifted = array_shift($page_category);
		$page_category_slug = $page_category_shifted->slug;				
	} // if

	/**************************************************************************/
	// Show the title.
	$header .= '<div class="h4 text-helvetica-light p-0 m-0">'
			 . '<a href="' . $permalink . '" rel="bookmark" title="Go to &ldquo;' . $title_attribute . '.&rdquo;" class="text-dark text-decoration-none">'
			 . $title
			 . '</a>'
			 . '</div>'
			 ;

	/**************************************************************************/
	// Show the author, date and time.
	if (!empty($the_author) || !empty($update_date)) {
		// $header .= '<div class="h5 p-0 m-0 text-clashgrotesk-regular">'
		// 		 . 'By ' . $the_author
		// 		 . '</div>'
		// 		 ;
		// if (!empty($update_date)) {
		// 	$header .= '<div class="h6 text-georgia-regular p-0 m-0 mt-1">'
		// 			 . '<span class="me-2 fa fa-calendar"></span>'
		// 			 . $update_date
		// 			 ;
		// 	// if (!empty($update_time)) {
		// 	// 	$header .= ' at ' . $update_time;
		// 	// } // if
		// 	$header .= '</div>';
		// } // if
	} // if

	/**************************************************************************/
	// Get the content.
	$content .= get_the_content();

    /**************************************************************************/
    // Return the final value.
    return array($header, $content, $page_category_slug, $the_ID);

} // single_post

/******************************************************************************/
// 2026-04-14: Setting a standalone 'render_archive_items' function to be neat.
function render_archive_items($query_vars = array()) {

	/**************************************************************************/
	// Init variables.
	$ret = array();

	/**************************************************************************/
	// If any of these items are empty, bail.
	if (empty($query_vars)) {
		return $ret;
	} // if

	/**************************************************************************/
	// Run 'query_posts' and retrieve the items.
	query_posts($query_vars);			

	/**************************************************************************/
	// If there are posts, do something with them.
	if (have_posts()) {
		while (have_posts()) {

			/******************************************************************/
			// Get the post.
			the_post();

			/******************************************************************/
			// Set the post related values.
			$post_name = get_post_field('post_name');
			$post_ID = get_the_ID();
			$post_name_slug = get_post_field('post_name') . '_' . $post_ID;

			/******************************************************************/
			// Set the category
			$categories = get_the_category();

			/******************************************************************/
			// Process the categories to set the parent value as the key.
			foreach ($categories as $key => $value) {
				$new_key = $value->parent;
				$categories[$new_key] = $value;
			} // foreach

			/******************************************************************/
			// Set the subcategory slug.
			$subcategory_slug = $post_name;
			if (count($categories) > 0) {
				$subcategory = array_shift($categories);
				$subcategory_slug = $subcategory->slug;
			} // if

			/******************************************************************/
			// Set the title values.
			$title = get_the_title();
			$title_attribute = the_title_attribute(array('echo' => false));

			/******************************************************************/
			// Set the temp array values.
			$temp = array();
			$temp['permalink'] = get_the_permalink();
			$temp['post_name'] = $post_name;
			$temp['title'] = $title;
			$temp['title_attribute'] = $title_attribute;
			$temp['excerpt'] = get_the_excerpt();
			$temp['date'] = get_the_time('F j, Y');
			$temp['time'] = get_the_time('g:i:sa');

			/******************************************************************/
			// Set the content array values.
			$ret[$subcategory_slug][$post_name_slug] = $temp;

		} // while
	} // if

	/**************************************************************************/
	// Return the final return value.
	return $ret;

} // render_archive_items

/********************************************************************************/
// 2026-04-21: Adding menu support.
register_nav_menus(array(
	'primary' => __('Beller Primary Menu')
));

/********************************************************************************/
// 2026-04-21: Adding menu support.
function __primaryMenu (){
	if (has_nav_menu('primary')){
		wp_nav_menu( array(
			'menu'				=> 'primary',
			'theme_location'	=> 'primary',
			'container_class'	=> 'collapse navbar-collapse p-0 m-0',
			'container_id'		=> 'main-nav',
			'menu_class'		=> 'navbar-nav p-0 m-0',
			'depth'				=> 4,
			'walker'			=> new Dropdown_Walker_Nav_Menu(),
		) );
	}
}

/********************************************************************************/
// 2026-04-21: Adding menu support.
class Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {

	/****************************************************************************/
	// The 'start_lvl' method.
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n" . $indent . '<ul class="navbar-nav p-0 m-0 text-left rounded-0 bg-info">';
	} // start_lvl

	/****************************************************************************/
	// The 'end_lvl' method.
	function end_lvl( &$output, $depth = 0, $args = null ) {
		if (isset( $args->item_spacing ) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} // if
		else {
			$t = "\t";
			$n = "\n";
		} // else
		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	} // end_lvl

	/****************************************************************************/
	// The 'start_el' method.
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

		/************************************************************************/
		// Set the indent.
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		/************************************************************************/
		// Set the classes.
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		if ($depth === 0 && $args->walker->has_children) {
			$classes[] = 'nav-item dropdown text-nowrap p-0 m-0 mx-5 bg-danger';
		} // if
		else if ($depth > 0 && $args->walker->has_children) {
			$classes[] = 'nav-item text-nowrap p-0 m-0 mx-5 bg-info';
		} // else if
		else {
			$classes[] = 'nav-item text-nowrap p-0 m-0 mx-5 bg-warning';
		} // else
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? esc_attr($class_names) : '';

		/************************************************************************/
		// Set the output.
		$output .=
			  $indent
			. '<li class="' . $class_names . '"">'
			;

		/************************************************************************/
		// 2026-04-21: Set a custom class for the selected menu item.
		if ($depth === 0 && $args->walker->has_children) {
			$toggle_link = !empty($item->url) ? $item->url : '#';
			$output .=
				  '<a href="' . esc_url($toggle_link) . '" class="dropdown-toggle nav-link' . $class_names . '" data-submenu="' . $item->ID . '">'
				. $item->title
				. '</a>'
				;
		} // if
		else if ($depth > 0 && $args->walker->has_children) { 
			$toggle_link = !empty($item->url) ? $item->url : '#';
			$output .=
			  '<a href="' . esc_url($toggle_link) . '" class="dropdown-toggle nav-link' . $class_names . '" data-submenu="' . $item->ID . '">'
			. $item->title
			. '</a>'
			;
		} // else if
		else {
		    $output .= 
				  '<a href="' . $item->url . '" class="nav-link">'
				. $item->title
				. '</a>'
				;
		} // else

	} // start_el

	/****************************************************************************/
	// The 'end_el' method.
	function end_el( &$output, $data_object, $depth = 0, $args = null) {
		if (isset( $args->item_spacing ) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} // if
		else {
			$t = "\t";
			$n = "\n";
		} // else
		$output .= "</li>{$n}";
	} // end_el
    
} // Dropdown_Walker_Nav_Menu

/********************************************************************************/
// 2026-04-21: Set a custom class for the selected menu item.
function custom_nav_class($classes, $item){
    $classes[] = "m-pageHeaderNavItem";
    if (in_array('current-menu-item', $classes) || in_array('current-post-parent', $classes)){
        $classes[] = 'active text-helvetica-bold';
    }
    else {
    	$classes[] = 'text-helvetica-light';
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'custom_nav_class' , 10 , 2);

/******************************************************************************/
// 2026-03-20: Adding widgets.
function szwergold_widgets_init() {
	register_sidebar(array(
		'name'          => __('Home Featured 1'),
		'id'            => 'home-featured-1',
		'description'   => __('Add widgets here to appear on your homepage.', 'szwergold'),
		// 'before_widget' => '<div id="%1$s" class="widget %2$s sticky-top col col-12 p-0 m-0 mb-3 bg-warning">',
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 p-0 m-0 mb-5">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="h4 text-helvetica-light col col-12 p-0 m-0 mb-2">',
		'after_title'   => '</div>',
	));
} // szwergold_widgets_init
add_action('widgets_init', 'szwergold_widgets_init');

?>