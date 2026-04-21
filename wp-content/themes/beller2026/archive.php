<?php

	/******************************************************************************/
	// Set the header.
	get_header();

	/******************************************************************************/
	/******************************************************************************/
	/******************************************************************************/

	// /******************************************************************************/
	// // Get the archive page header.
	// $archive_page_header = archive_page_header();

	// /******************************************************************************/
	// // Get the archive page header.
	// echo $archive_page_header;

	/******************************************************************************/
	/******************************************************************************/
	/******************************************************************************/

	/******************************************************************************/
	// Get the single post content.
	list($single_header, $single_content, $page_category_slug, $post_ID) = single_post();

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
		$query_vars['post__not_in'] = array($post_ID);
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
					  '<div class="h5 text-helvetica-light p-0 m-0 mb-2">'
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
					  '<span class="text-georgia-regular lh-base small">'
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
	// Wrap the header.
	$single_header =
	    '<header class="col col-12 p-0 m-0 pb-2">'
	  . $single_header
	  . '</header>'
	  ;

	/******************************************************************************/
	// Set the divider.
	$single_divider = !empty($temp) ? '<hr class="p-0 m-0 mt-5 hr-dashed opacity-100">' : null;

	/******************************************************************************/
	// Wrap the content.
	$single_content =
		'<main class="col col-12 p-0 m-0 mb-5">'
	  . '<article class="col col-12 p-0 m-0">'
	  . '<div class="text-georgia-regular lh-base">'
	  . $single_content
	  . $single_divider
	  . '</div>'
	  . '</article>'
	  . '</main>'
	  ;

	/******************************************************************************/
	// Render the header and the content.
	echo $single_header;
	echo $single_content;

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