<?php

	/********************************************************************************/
	// Set the header.
	get_header();

?>
<div class="row p-0 m-0">
	<?php

		/****************************************************************************/
		// Begin the archive info area.
		echo '<div class="post_nav col col-12 p-0 m-0">';

		/****************************************************************************/
		// Header begins.
		echo '<div class="h2 text-windsorpro-bold p-0 m-0 fw-bold pb-1 mb-2 border-bottom border-dark">';
		echo 'Posts for ';
		if (is_archive()) {
			echo '&ldquo;';
			echo get_the_archive_title();
			echo '&rdquo;';
		} // if
		else if (is_category()) {
			echo '&ldquo;';
			single_cat_title();
			echo '.&rdquo;';
		} // else if
		else if (is_tag()) {
			echo '&ldquo;';
			echo single_tag_title();
			echo '.&rdquo;';
		} // else if
		else if (is_year()) {
			the_time('Y');
			echo '.';
		} // else if
		else if (is_month()) {
			the_time('F Y');
			echo '.';
		} // else if
		else if (is_day()) {
			the_time('l, F j, Y');
			echo '.';
		} // else if
		echo '</div>';

		/****************************************************************************/
		// Header ends
		echo '<p class="text-railroadgothic">';
		$category_description = category_description();
		if (!empty($category_description)) {
			echo strip_tags($category_description);
		} // if
		else {
			echo 'You are currently browsing posts about <strong>';
			if (is_category()) {
				echo '&ldquo;';
				single_cat_title();
				echo '.&rdquo;';
			} // if
			else if (is_tag()) {
				echo '&ldquo;';
				echo single_tag_title();
				echo '.&rdquo;';
			} // else if
			else if (is_year()) {
				the_time('Y');
				echo '.';
			} // else if
			else if (is_month()) {
				the_time('F Y');
				echo '.';
			} // else if
			else if (is_day()) {
				the_time('l, F j, Y');
				echo '.';
			} // else if
			echo '</strong>';
		} // else
		echo '</p>';

		/****************************************************************************/
		// End the archive info area.
		echo '</div>';

		/****************************************************************************/
		// Init variables.
		$content = array();

		/****************************************************************************/
		// If there are posts, do something with them.
		if (TRUE && have_posts()) {
			while (have_posts()) {

				/********************************************************************/
				// Get the post.
				the_post();

				/********************************************************************/
				// Set the temp array values.
				$temp = array();
				$temp['permalink'] = get_the_permalink();
				$temp['title'] = get_the_title();
				$temp['title_attribute'] = the_title_attribute(array('echo' => false));
				$temp['excerpt'] = get_the_excerpt();

				/********************************************************************/
				// Set the content array values.
				$content[] = $temp;

			} // while
		} // if
		else {

			/********************************************************************/
			// Set the temp array values.
			$temp = array();
			$temp['permalink'] = null;
			$temp['title'] = null;
			$temp['title_attribute'] = null;
			$temp['excerpt'] = 'Nothing was found.';

			/********************************************************************/
			// Set the content array values.
			$content[] = $temp;

		} // else

		/************************************************************************/
		// Display the content.
		foreach ($content as $value) {

			/********************************************************************/
			// Begin the container.
			echo '<div class="col col-12 col-xl-4 p-0 m-0 pe-3 pb-3">';

			/********************************************************************/
			// Show the title.
			if (!empty($value['permalink']) && !empty($value['title_attribute']) && !empty($value['title'])) {
				echo '<header class="col col-12 p-0 m-0">';
				echo '<div class="h5 p-0 m-0 text-windsorpro-bold">';
				echo '<a href="' . $value['permalink'] . '" rel="bookmark" title="Go to &ldquo;' . $value['title_attribute'] . '.&rdquo;" class="text-dark text-decoration-none">';
				echo $value['title'];
				echo '</a>';
				echo '</div>';
				echo '</header>';
			} // if

			/********************************************************************/
			// Show the excerpt.
			if (!empty($value['permalink']) && !empty($value['excerpt'])) {
				echo '<div class="text-georgia-regular small">';
				if (!empty($value['permalink'])) {
					echo '<a href="' . $value['permalink'] . '" title="Go to &ldquo;' . $value['title_attribute'] . '.&rdquo;" class="text-decoration-none text-dark">';
				} // if
				if (!empty($value['excerpt'])) {
					echo $value['excerpt'];
				} // if
				if (!empty($value['permalink'])) {
					echo '</a>';
				} // if
				echo '</div>';
			} // if

			/********************************************************************/
			// End the container.
			echo '</div>';

		} // foreach

	?>
</div>
<?php

	/**********************************************************************/
	// Set the sidebar.
	get_sidebar();

	/**********************************************************************/
	// Set the footer.
	get_footer();

?>