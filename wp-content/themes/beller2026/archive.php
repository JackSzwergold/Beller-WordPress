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

	/******************************************************************************/
	/******************************************************************************/
	/******************************************************************************/

	/******************************************************************************/
	// Set the divider.
	$final_single_divider = '<hr class="p-0 m-0 mt-5 hr-dashed opacity-100">';

	/******************************************************************************/
	// Wrap the header.
	$final_single_content = null;	
	$final_single_content .=
	    '<header class="col col-12 p-0 m-0 pb-2">'
	  . $single_header
	  . '</header>'
	  ;

	/******************************************************************************/
	// Wrap the content.
	$final_single_content .=
		'<main class="col col-12 p-0 m-0 mb-5">'
	  . '<article class="col col-12 p-0 m-0">'
	  . '<div class="text-georgia-regular lh-base">'
	  . $single_content
	  . $final_single_divider
	  . '</div>'
	  . '</article>'
	  . '</main>'
	  ;

	/******************************************************************************/
	// Show the final content.
	echo $final_single_content;

	/******************************************************************************/
	// If we have a 'archives-content-1' widget, show the 'archives-content-1' widget.
	if (is_active_sidebar('archives-content-1')) {
		dynamic_sidebar('archives-content-1');
	} // if

	/******************************************************************************/
	// Set the sidebar.
	get_sidebar();

	/******************************************************************************/
	// Set the footer.
	get_footer();

?>