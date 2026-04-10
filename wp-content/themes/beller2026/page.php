<?php

	/****************************************************************************************/
	// Set the header.
	get_header();

	/****************************************************************************************/
	// Set the post content if we have post content.
	if (have_posts()) {
		while (have_posts()) {

			/********************************************************************************/
			// Get the post.
			the_post();

			global $authordata;

			/********************************************************************************/
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

			/********************************************************************************/
			// Begin the header.
			echo '<header class="col col-12 p-0 m-0 pb-2">';

			/********************************************************************************/
			// Show the title.
			echo '<div class="h1 p-0 m-0 text-railroadgothic">';
			echo '<a href="' . $permalink . '" rel="bookmark" title="Go to &ldquo;' . $title_attribute . '.&rdquo;" class="text-darkblue text-decoration-none">';
			echo $title;
			echo '</a>';
			echo '</div>';

			/********************************************************************************/
			// Show the excerpt.    
			if (is_front_page() && !empty($excerpt)) {
				echo '<div class="h4 text-georgia-regular py-1">';
				echo $excerpt;
				echo '</div>';        
			} // if

			/********************************************************************************/
			// Show the divider.
			echo '<hr class="p-0 m-0 mt-2 mb-2 border border-darkblue border-1 opacity-100">';

			/********************************************************************************/
			// End the header.
			echo '</header>';

			/********************************************************************************/
			// Show the main area.
			echo '<main class="col col-12 p-0 m-0">';
			echo '<article class="col col-12 p-0 m-0">';
			echo '<div class="text-georgia-regular">';

			/********************************************************************************/
			// Show the content.
			the_content();

			/********************************************************************************/
			// End the header.
			echo '</div>';
			echo '</article>';

			/********************************************************************************/
			// If we are on the frontpage, show these widgets.
			if (is_front_page()) {

				/****************************************************************************/
				// Show the divider.
				echo '<hr class="p-0 m-0 mt-2 mb-2 border border-darkblue border-1 opacity-100">';

				/****************************************************************************/
				// Row BEGIN
				echo '<div class="row">';

				/****************************************************************************/
				// Home featured 1 stuff.
				if (is_active_sidebar('home-featured-1')) {
					echo '<div class="col col-12 col-md-6 m-0 p-0 mb-3">';
					echo '<div class="container">';
					echo '<div class="row">';
					dynamic_sidebar('home-featured-1');
					echo '</div>';
					echo '</div>';
					echo '</div>';
				} // if

				/****************************************************************************/
				// Home featured 2 stuff.
				if (is_active_sidebar('home-featured-2')) {
					echo '<div class="col col-12 col-md-6 m-0 p-0 mb-3">';
					echo '<div class="container">';
					echo '<div class="row">';
					dynamic_sidebar('home-featured-2');
					echo '</div>';
					echo '</div>';
					echo '</div>';
				} // if

				/****************************************************************************/
				// Blank space
				// echo '<div class="col col-12 col-md-4 m-0 p-0">';
				// echo '<div class="container">';
				// echo '<div class="row">';
				// echo '</div>';
				// echo '</div>';
				// echo '</div>';

				/****************************************************************************/
				// Row END
				echo '<div>';
			} // if

			echo '</main>';

		} // while

	} // if
	else {

		echo '<div>';
		echo "<p>Nothing.</p>";
		echo '</div>';

	} // else

	/****************************************************************************************/
	// Set the sidebar.
	// get_sidebar();

	/****************************************************************************************/
	// Set the footer.
	get_footer();

?>