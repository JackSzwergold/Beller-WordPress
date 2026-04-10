<?php

	/******************************************************************************/
	// Set the header.
	get_header();

	/******************************************************************************/
	// Set the post content if we have post content.
	if (have_posts()) {
		while (have_posts()) {

			/**********************************************************************/
			// Get the post.
			the_post();

			global $authordata;

			/**********************************************************************/
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

			/**********************************************************************/
			// Get the current selected category slug.
			$page_category = get_the_category();
			$page_category_shifted = null;
			$page_category_slug = null;
			if (!empty($page_category)) {
				$page_category_shifted = array_shift($page_category);
				$page_category_slug = $page_category_shifted->slug;				
			} // if

			/**********************************************************************/
			// Set the text CSS.
			$text_css = null;
			if (!empty($page_category_slug) && in_array($page_category_slug, array('notes'))) {
				$text_css = 'fs-3 lh-base fst-italic';
			} // if

			/**********************************************************************/
			// Begin the header.
			echo '<header class="col col-12 p-0 m-0 pb-2">';

			/**********************************************************************/
			// Show the title.
			echo '<div class="h1 p-0 m-0 text-railroadgothic">';
			echo '<a href="' . $permalink . '" rel="bookmark" title="Go to &ldquo;' . $title_attribute . '.&rdquo;" class="text-darkblue text-decoration-none">';
			echo $title;
			echo '</a>';
			echo '</div>';

			/**********************************************************************/
			// Show the author, date and time.
			if (!empty($the_author)) {
				echo '<div class="h5 p-0 m-0 text-georgia-regular">';
				echo 'By ' . $the_author;
				echo '</div>';
				if (!empty($update_date)) {
					echo '<div class="h6 p-0 m-0 mt-1 text-georgia-regular">';
					echo '<span class="me-2 fa fa-calendar"></span>';
					echo $update_date;
					// if (!empty($update_time)) {
					// 	echo ' at ' . $update_time;
					// } // if
					echo '</div>';
				} // if
			} // if

			echo '<hr class="p-0 m-0 my-2 border border-darkblue border-1 opacity-100">';

			/**********************************************************************/
			// End the header.
			echo '</header>';

			/**********************************************************************/
			// Show the main area.
			echo '<main class="col col-12 p-0 m-0">';
			echo '<article class="col col-12 p-0 m-0">';
			echo '<div class="text-georgia-regular ' . $text_css . '">';

			/**********************************************************************/
			// Show the content.
			the_content();

			/**********************************************************************/
			// End the header.
			echo '</div>';
			echo '</article>';
			echo '</main>';

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