<?php

	/******************************************************************************/
	// Set the header.
	get_header();

	/******************************************************************************/
	// Set the post content if we have post content.
	if (have_posts()) {
		while (have_posts()) {

			/******************************************************************************/
			// Get the single post content.
			list($single_header, $single_content, $page_category_slug, $post_ID) = single_post();

			/******************************************************************************/
			// Wrap the header.
			$single_header =
			    '<header class="col col-12 p-0 m-0 pb-2">'
			  . $single_header
			  . '</header>'
			  ;

			/******************************************************************************/
			// Set the divider.
			$single_divider = !empty($temp) ? '<hr class="p-0 m-0 mt-5 border border-dark border-1 opacity-100">' : null;

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