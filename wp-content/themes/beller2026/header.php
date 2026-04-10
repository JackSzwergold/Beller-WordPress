<?php

	/****************************************************************************************/
	// Set the page title.
	$page_title = null;
	if (is_single()) {
		$page_title = get_the_title();
	} // if
	else if (is_page()) {
		$page_title = get_the_title();
	} // else if
	else if (is_archive()) {
		$page_title = get_the_archive_title();
	} // else if
	else if (is_category()) {
		$page_title = single_cat_title();
	}  // else if
	else if (is_tag()) {
		$page_title = single_tag_title();
	} // else if
	else if (is_year()) {
		$page_title = the_time('Y');
	} // else if
	else if (is_month()) {
		$page_title = the_time('F Y');
	} // else if
	else if (is_day()) {
		$page_title = the_time('l, F j, Y');
	} // else if

	/****************************************************************************************/
	// If we are on the front page, no need for the page title.
	if (is_front_page() && !empty($page_title)) {
		$page_title = null;
	} // if

	/****************************************************************************************/
	// Set the page description.
	$page_description = null;
	if (is_single()) {
		$page_description = get_the_excerpt();
	} // if
	else if (is_page() && !is_front_page()) {
		$page_description = get_the_excerpt();
	} // else if
	else if (is_front_page()) {
		$page_description = get_bloginfo('description');
	} // else if
	else if (is_archive()) {
		$page_description = get_the_archive_description();
	} // else if
	else if (is_category()) {
		$page_description = category_description();
	}  // else if

	/****************************************************************************************/
	// Set the template directory and related blog info valiables.
	$blog_name = get_bloginfo('name');
	$blog_description = get_bloginfo('description');

	/****************************************************************************************/
	// Set the template directory and related blog info valiables.
	$template_directory = get_bloginfo('template_directory');
	$stylesheet_url = get_bloginfo('stylesheet_url');
	$atom_url = get_bloginfo('atom_url');
	$rss2_url = get_bloginfo('rss2_url');
	$url = get_bloginfo('url');
	$pingback_url = get_bloginfo('pingback_url');

	global $post;

	/**********************************************************************/
	// Get the current selected post slug.
	$post_slug = null;
	if (!empty($post)) {
		$post_slug = $post->post_name;
	} // if

	/**********************************************************************/
	// Get the current selected category info.
	// if (is_archive() || is_single()) {
	if (is_single()) {
		$page_category = get_the_category();
		$page_category_shifted = array();
		$page_category_parent_ID = null;
		$page_category_slug = null;
		$page_category_name = null;
		if (!empty($page_category)) {
			$page_category = array_shift($page_category);
			$page_category_parent_ID = isset($page_category->parent) ? $page_category->parent : null;
			$page_category_slug = isset($page_category->slug) ? $page_category->slug : null;
			$page_category_name = isset($page_category->name) ? $page_category->name : null;
		} // if
	} // if
	else {
		$page_category_ID = get_query_var('cat');
		$page_category = get_category($page_category_ID);
		$page_category_parent_ID = null;
		$page_category_slug = null;
		$page_category_name = null;
		if (!empty($page_category)) {
			$page_category_parent_ID = isset($page_category->parent) ? $page_category->parent : null;
			$page_category_slug = isset($page_category->slug) ? $page_category->slug : null;
			$page_category_name = isset($page_category->name) ? $page_category->name : null;
		} // if
	} // else

	/**********************************************************************/
	// Get the current selected parent category info.
	$page_parent_category = get_category($page_category_parent_ID);
	$page_parent_category_shifted = array();
	$page_parent_category_slug = null;
	$page_parent_category_name = null;
	if (!empty($page_parent_category)) {
		$page_parent_category_slug = isset($page_parent_category->slug) ? $page_parent_category->slug : null;
		$page_parent_category_name = isset($page_parent_category->name) ? $page_parent_category->name : null;
	} // if

	/**********************************************************************/
	// Set the page slugs string.
	$page_slugs_array = array();
	$page_slugs_string = null;
	if (!empty($page_category_slug)) {
		$page_slugs_array[] = $page_category_slug;
	} // if
	if (!empty($page_parent_category_slug)) {
		$page_slugs_array[] = $page_parent_category_slug;
	} // if
	if (!empty($post_slug)) {
		$page_slugs_array[] = $post_slug;
	} // if
	if (!empty($page_slugs_array)) {
		$page_slugs_string = implode(' ', $page_slugs_array);
	} // if

	/**********************************************************************/
	// Set the page title string.
	$page_title_array = array();
	$page_title_string = null;
	if (!empty($page_title) && (is_page() || is_single())) {
		$page_title_array[] = $page_title;
	} // if
	if (!empty($page_category_name)) {
		$page_title_array[] = $page_category_name;
	} // if
	if (!empty($page_parent_category_name)) {
		$page_title_array[] = $page_parent_category_name;
	} // if
	if (!empty($blog_name)) {
		$page_title_array[] = $blog_name;
	} // if
	if (!empty($page_title_array)) {
		$page_title_string = implode(' | ', $page_title_array);
	} // if

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
	<?php

		/****************************************************************************************/
		// Render the page description.
		echo '<meta name="description" content="' . $page_description . '">';

		/****************************************************************************************/
		// Render the page title.
		echo '<title>' . $page_title_string . '</title>';

		/****************************************************************************************/
		// Set the different 'link' items.
		$link_array = array();
		$link_array[] = '<link rel="stylesheet" href="' . $stylesheet_url . '?version=1.1.20" media="screen">';
		$link_array[] = '<link rel="alternate" type="application/atom+xml" title="' . $name . ' Atom" href="' . $atom_url . '">';
		$link_array[] = '<link rel="alternate" type="application/rss+xml" title="' . $name . ' RSS" href="' . $rss2_url . '">';
		$link_array[] = '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="' . $url . '/xmlrpc.php?rsd">';
		$link_array[] = '<link rel="pingback" href="' . $pingback_url . '">';
		// $link_array[] = '<link rel="shortcut icon" type="image/png" href="' . $template_directory . '/favicons/favicon.ico">';
		$link_array[] = '<link rel="shortcut icon" href="' . $template_directory . '/favicons/favicon.ico">';
		$link_array[] = '<link rel="apple-touch-icon-precomposed" href="' . $template_directory . '/favicons/apple-touch-icon-precomposed.png">';
		$link_array[] = '<link rel="apple-touch-icon" sizes="300x300" href="' . $template_directory . '/favicons/apple-touch-icon.png">';

		/****************************************************************************************/
		// Render the different 'link' items.
		echo implode('', $link_array);

		/****************************************************************************************/
		// This 'wp_head' call sets all of the JavaScript and metadata that WordPress needs to insert in the page.
		echo '<!-- WordPress HEADER STUFF BEGIN -->';
		wp_head();
		echo '<!-- WordPress HEADER STUFF END -->';

		/****************************************************************************************/
		// Set the blog name.
		$blog_name =
			  '<div class="h1 text-railroadgothic p-0 m-0">'
			. '<a href="' . $url . '" class="text-offwhite">'
			. $blog_name
			// . '<div class="spinner-border text-offwhite p-0 m-0 ms-2" role="status">'
			// . '<span class="visually-hidden">Loading...</span>'
			// . '</div>'
			. '</a>'
			. '</div>'
			;

		/****************************************************************************************/
		// Set the blog description.
		$blog_description =
			  '<div class="h4 text-georgia-regular p-0 m-0 d-none d-md-block">'
			. '<a href="' . $url . '" class="text-offwhite">'
			. '<span class="fst-italic">'
			. $blog_description
			. '</span>'
			. '</a>'
			. '</div>'
			. '<div class="h5 text-georgia-regular p-0 m-0 d-md-none">'
			. '<a href="' . $url . '" class="text-offwhite">'
			. '<span class="small fst-italic">'
			. $blog_description
			. '</span>'
			. '</a>'
			. '</div>'
			;

	?>
</head>
<body id="top" class="p-0 m-0 <?php echo $page_slugs_string; ?>">

	<nav class="header p-0 m-0 px-2 bg-darkblue">
		<div class="sticky-top col col-12 p-0 m-0 pt-2 px-3 bg-darkblue z-1">
			<?php
				echo $blog_name;
			?>
		</div>
		<div class="sticky-top col col-12 p-0 m-0 pb-3 px-3 bg-darkblue z-0">
			<?php
				echo $blog_description;
			?>
		</div>
	</nav>

	<!-- Content Core BEGIN -->
	<div class="container">
		<div class="row">
			<div class="col px-3 px-md-4 mx-3 mx-md-0 my-3 my-md-4 bg-offwhite border border-2 border-darkblue rounded-3">

				<div class="container">
					<div class="row">
						<div class="col py-3 py-md-4 text-left">

							<?php

								/**********************************************************************************************/
								// If we have a widget header, show the widget header.
								if (is_active_sidebar('header-1')) {
									dynamic_sidebar('header-1');
								} // if

								/**********************************************************************************************/
								// If we have a widget header, show the widget header.
								if (is_active_sidebar('header-2')) {
									dynamic_sidebar('header-2');
								} // if

							?>