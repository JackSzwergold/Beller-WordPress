<?php

	/******************************************************************************/
	// Set the header.
	get_header();

	/******************************************************************************/
	/******************************************************************************/
	/******************************************************************************/

	/******************************************************************************/
	// Get the archive page header.

	/******************************************************************************/
	// Begin the archive info area.
	echo '<div class="post_nav col col-12 p-0 m-0">';

	/******************************************************************************/
	// Header begins.
	echo '<div class="h1 text-georgia-regular p-0 m-0">';
	// echo 'Posts for the ';
	if (is_archive()) {
		// echo '&ldquo;';
		echo get_the_archive_title();
		// echo '&rdquo;';
	} // if
	else if (is_category()) {
		// echo '&ldquo;';
		single_cat_title();
		// echo '&rdquo;';
	}  // else if
	else if (is_tag()) {
		// echo '&ldquo;';
		echo single_tag_title();
		// echo '&rdquo;';
	} // else if
	else if (is_year()) {
		the_time('Y');
	} // else if
	else if (is_month()) {
		the_time('F Y');
	} // else if
	else if (is_day()) {
		the_time('l, F j, Y');
	} // else if
	// echo ' category&hellip;</div>';
	echo '<hr class="p-0 m-0 border border-dark border-1 opacity-100">';

	/******************************************************************************/
	// Header ends
	echo '<div class="h4 text-georgia-regular">';
	if ($page_description = get_the_archive_description()) {
		echo strip_tags($page_description);
	} // if

	else if ($page_description = category_description()) {
		echo strip_tags($page_description);
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
	echo '</div>';

	/******************************************************************************/
	// End the archive info area.
	echo '</div>';
	// echo '<hr class="p-0 m-0 mt-1 mb-2 border border-dark border-1 opacity-100">';

	/******************************************************************************/
	/******************************************************************************/
	/******************************************************************************/

	// /******************************************************************************/
	// // Get the single post content.
	// list($header, $content, $page_category_slug) = single_post();

	// /******************************************************************************/
	// // Set the text CSS.
	// $text_css = null;
	// if (!empty($page_category_slug) && in_array($page_category_slug, array('notes'))) {
	// 	$text_css = 'fs-3 lh-base fst-italic';
	// } // if

	// /******************************************************************************/
	// // Wrap the header.
	// $header = '<header class="col col-12 p-0 m-0 pb-2">'
	// 		. $header
	// 		. '<hr class="p-0 m-0 my-2 border border-dark border-1 opacity-100">'
	// 		. '</header>'
	// 		;

	// /******************************************************************************/
	// // Render the header.
	// echo $header;

	// /******************************************************************************/
	// // Wrap the content.
	// $content = '<main class="col col-12 p-0 m-0">'
	// 		 . '<article class="col col-12 p-0 m-0">'
	// 		 . '<div class="text-georgia-regular ' . $text_css . '">'
	// 		 . $content
	// 		 . '</div>'
	// 		 . '</article>'
	// 		 . '</main>'
	// 		 ;

	// /******************************************************************************/
	// // Render the content.
	// echo $content;

	/******************************************************************************/
	/******************************************************************************/
	/******************************************************************************/

	/******************************************************************************/
	// Get the current selected parent category ID and slug.
	$page_category_parent = get_category(get_query_var('cat'));

	// echo '<pre>';
	// echo $post_type . PHP_EOL;
	// print_r($page_category_parent->errors['invalid_term']);
	// echo '</pre>';

	$page_category_id = null;
	$page_category_slug = null;
	if (isset($page_category_parent->cat_ID)) {
		$page_category_id = $page_category_parent->cat_ID;
	} // if
	if (isset($page_category_parent->cat_ID)) {
		$page_category_slug = $page_category_parent->slug;
	} // if
	if (!empty($page_category_parent->parent)) {
		$page_category_parent = get_category($page_category_parent->parent);
		if (empty($page_category_parent->parent)) {
			$page_category_id = $page_category_parent->cat_ID;
			$page_category_slug = $page_category_parent->slug;
		} // if
		else {
			$page_category_grandparent = get_category($page_category_parent->parent);
			if (empty($page_category_grandparent->parent)) {
				$page_category_id = $page_category_grandparent->cat_ID;
				$page_category_slug = $page_category_grandparent->slug;
			} // if
		} // else	
	} // if

	/******************************************************************************/
	// Set the category.
	$page_category_child = get_the_category();

	// /******************************************************************************/
	// // Get the post type.
	// $post_type = get_post_type();

	// /******************************************************************************/
	// // Get the post type data.
	// $post_type_data = null;
	// if (!in_array($post_type, array('post'))) {
	//     $post_type_data = get_post_type_object( $post_type );
	// } // if

	/******************************************************************************/
	// Get the current selected child category ID and slug.
	$page_subcategory_id = null;
	$page_subcategory_slug = null;
	if (count($page_category_child) > 0) {
		$page_subcategory = array_shift($page_category_child);
		$page_subcategory_id = $page_subcategory->cat_ID;
		$page_subcategory_slug = $page_subcategory->slug;
	} // if

	/******************************************************************************/
	// Set what to exclude and to exlcude in the categories settings.
	$exclude = null;
	$include = null;
	if (get_query_var('cat') == $page_category_id) {
		$exclude = $page_category_id;
	} // if
	if (get_query_var('cat') == $page_subcategory_id) {
		$exclude = $page_category_id;
		$include = $page_subcategory_id;
	} // if

	/******************************************************************************/
	// Set the category array options.
	$category_args = array();
	$category_args['taxonomy'] = 'category';
	$category_args['type'] = 'post';
	$category_args['child_of'] = false;
	$category_args['parent'] = '';
	$category_args['orderby'] = 'name';
	$category_args['order'] = 'ASC';
	$category_args['hide_empty'] = true;
	$category_args['hierarchical'] = true;
	$category_args['exclude'] = $exclude;
	$category_args['include'] = $include;
	$category_args['number'] = false;
	$category_args['pad_counts'] = false;

	/******************************************************************************/
	// Get the categories.
	$categories = get_categories($category_args);

	/******************************************************************************/
	// If we have categories, do something.
	$category_details = array();
	foreach ($categories as $key => $value) {
		$category_details[$value->slug] = $value;
	} // foreach

	/******************************************************************************/
	// Set the globals.
	global $wp_query;

	/******************************************************************************/
	// Init variables.
	$content = array();
	$query_vars = $wp_query->query_vars;

	/******************************************************************************/
	// If we are on a 'tech' page, do this.
	if (in_array($page_category_slug, array('tech')) || in_array($post_type, array('tech'))) {

		/**************************************************************************/
		// Set the query variables, merge the content and roll through the category details.
		foreach ($category_details as $category_slug => $category_data) {
			// echo $category_slug . ' | ' . $category_data->cat_ID . '<br>';
			if (!isset($page_category_parent->errors['invalid_term'])) {
				$query_vars['category__in'] = $category_data->cat_ID;
			} // if
			$query_vars['orderby']['title'] = 'ASC';
			$archive_content = render_archive_items($query_vars);
			if (!empty($archive_content) && isset($archive_content[$category_slug])) {
				$content[$category_slug] = $archive_content[$category_slug];
			} // if
		} // foreach

	} // if
	else {

		/**************************************************************************/
		// Set the query variables and merge the content.
		$query_vars['orderby']['date'] = 'DESC';
		$query_vars['orderby']['title'] = 'ASC';
		$archive_content = render_archive_items($query_vars);
		if (!empty($archive_content)) {
			$content = array_replace($content, $archive_content);	
		} // if

	} // else

	/******************************************************************************/
	/******************************************************************************/
	/******************************************************************************/

	/******************************************************************************/
	// Init variables.
	$final = array();

	/******************************************************************************/
	// Display the parent content.
	foreach ($content as $parent_key => $parent_value) {

		/**************************************************************************/
		// Init variables.
		$temp = array();

		/**************************************************************************/
		// Display the child content.
		foreach ($parent_value as $child_key => $child_value) {

			/**********************************************************************/
			// Set different array values.
			$title = !empty($child_value['title']) ? $child_value['title'] : null;
			$title_attribute = !empty($child_value['title_attribute']) ? $child_value['title_attribute'] : null;
			$excerpt = !empty($child_value['excerpt']) ? $child_value['excerpt'] : null;
			$permalink = !empty($child_value['permalink']) ? $child_value['permalink'] : null;

			/**********************************************************************/
			// Set the title.
			if (!empty($permalink) && !empty($title) && !empty($title_attribute)) {
				$title =
					  '<div class="text-georgia-bold">'
					. '<a href="' . $permalink . '" rel="bookmark" title="Go to &ldquo;' . $title_attribute . '.&rdquo;" class="text-decoration-none text-dark">'
					. $title
					. '</a>'
					. '</div>'
					;
			} // if

			/**********************************************************************/
			// Link the excerpt.
			if (!empty($permalink) && !empty($excerpt) && !empty($title_attribute)) {
				$excerpt =
					  '<a href="' . $permalink . '" title="Go to &ldquo;' . $title_attribute . '.&rdquo;" class="text-decoration-none text-dark">'
					. $excerpt
					. '</a>'
					;
			} // if

			/**********************************************************************/
			// Wrap the excerpt.
			if (!empty($excerpt)) {
				$excerpt =
					  '<span class="text-georgia-regular small">'
					. $excerpt
					. '</span>'
					;
			} // if

			/**********************************************************************/
			// Set the date and time.
			$date = '<span class="text-georgia-regular">' . $child_value['date'] . '</span>';
			$time = '<span class="text-georgia-regular">' . $child_value['time'] . '</span>';

			/**********************************************************************/
			// Set the divider.
			$divider = null;
			// if (!empty($title) && !empty($excerpt)) {
			// 	$divider = '<span class="text-railroadgothic">: </span>';
			// } // if

			/**********************************************************************/
			// Set the final row.
			$temp[] = 
				  '<div class="d-inline-block col col-12 p-0 m-0 mb-2">'
				. $title
				. $divider
				. $excerpt
				. '</div>'
				;

		} // foreach

		/**************************************************************************/
		// Set a category name and category link.
		$category_name = null;
		$category_link = null;
		if ((count($content) > 1) && isset($category_details[$parent_key])) {
			$category_name = $category_details[$parent_key]->name;
			$category_link = get_category_link($category_details[$parent_key]->term_id);
		} // if

		/**************************************************************************/
		// Wrap the category block value.
		$category_block = implode('', $temp);
		// if (!empty($category_name)) {
		// 	$category_block  =
		// 	      '<div class="col col-12 p-0 m-0">'
		// 		. '<div class="h3 text-railroadgothic col col-12 p-0 m-0 mb-1">'
		// 		. '<a href="' . $category_link . '" title="Go to the &ldquo;' . $category_name . '&rdquo; category." class="text-decoration-none text-darkblue">'
		// 		. $category_name
		// 		. '</a>'
		// 		. '</div>'
		// 		. $category_block
		// 		. '</div>'
		// 		. '<hr class="p-0 m-0 mt-1 mb-2 border border-darkblue border-1 opacity-100">'
		// 		;
		// } // if

		/**************************************************************************/
		// Set the final array value.
		$final[] = $category_block;

	} // foreach

	/******************************************************************************/
	// Show the content.
	echo '<div class="archive_content p-0 m-0">';
	foreach ($final as $key => $value) {
		echo $value;
	} // foreach
	echo '</div>';

	/******************************************************************************/
	// Set the sidebar.
	get_sidebar();

	/******************************************************************************/
	// Set the footer.
	get_footer();

?>