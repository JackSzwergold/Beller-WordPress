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
			list($header, $content, $page_category_slug, $post_ID) = single_post();

			/**********************************************************************/
			// Set the text CSS.
			$text_css = null;
			// if (!empty($page_category_slug) && in_array($page_category_slug, array('notes'))) {
			// 	$text_css = 'fs-3 lh-base fst-italic';
			// } // if

			/**********************************************************************/
			// Wrap the header.
			$header = '<header class="col col-12 p-0 m-0 pb-2">'
					. $header
					. '<hr class="p-0 m-0 mt-2 border border-dark border-1 opacity-100">'
					. '</header>'
					;

			/**********************************************************************/
			// Render the header.
			echo $header;

			/**********************************************************************/
			// Wrap the content.
			$content = '<main class="col col-12 p-0 m-0">'
					 . '<article class="col col-12 p-0 m-0">'
					 . '<div class="text-georgia-regular ' . $text_css . '">'
					 . $content
					 . '</div>'
					 . '</article>'
					 . '</main>'
					 ;

			/**********************************************************************/
			// Render the content.
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