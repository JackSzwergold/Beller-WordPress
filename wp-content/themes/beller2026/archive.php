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