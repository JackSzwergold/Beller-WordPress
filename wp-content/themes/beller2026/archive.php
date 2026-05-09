<?php

	/******************************************************************************/
	// Set the header.
	get_header();


	// /******************************************************************************/
	// // Get the archive page header.
	// $archive_page_header = archive_page_header();

	// /******************************************************************************/
	// // Get the archive page header.
	// echo $archive_page_header;

	/******************************************************************************/
	// If we have a 'archives-featured-1' widget, show the 'archives-featured-1' widget.
	if (is_active_sidebar('archives-featured-1')) {
		dynamic_sidebar('archives-featured-1');
	} // if

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