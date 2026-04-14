<?php

	/******************************************************************************/
	// Set the header.
	get_header();

	/******************************************************************************/
	// Set the post content if we have post content.
	if (have_posts()) {
		while (have_posts()) {

			/**********************************************************************/
			// Get the single post content.
			list($header, $content) = single_post();

			/**********************************************************************/
			// Render the single post content.
			echo $header;
			echo $content;

		} // while

	} // if
	else {

		echo '<div>';
		echo "<p>Nothing was found.</p>";
		echo '</div>';

	} // else

	/******************************************************************************/
	// Set the sidebar.
	// get_sidebar();

	/******************************************************************************/
	// Set the footer.
	get_footer();

?>