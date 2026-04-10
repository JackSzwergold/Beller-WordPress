<?php

	$user_ID = get_current_user_id();

	// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
		die ('Please do not load this page directly. Thanks!');
	} // if

	if (post_password_required()) {
		echo '<p class="nocomments">This post is password protected. Enter the password to view comments.</p>';
		return;
	} // if

	if (have_comments()) {
		echo '<div class="h4 fw-bold">&sect; ';
		comments_number('No Responses', 'One Response', '% Responses' );
		echo ' to &#8220;';
		the_title();
		echo '&#8221;';
		echo '</div>';

		$wp_list_comments_settings = array();
		$wp_list_comments_settings ['style'] = 'ul';
		$wp_list_comments_settings ['format'] = 'html5';
		$wp_list_comments_settings ['avatar_size'] = 32;
		$wp_list_comments_settings ['short_ping'] = FALSE;
		$wp_list_comments_settings ['echo'] = FALSE;
		// $wp_list_comments_settings ['reverse_top_level'] = null;
		// $wp_list_comments_settings ['reverse_children'] = null;
		$wp_list_comments = wp_list_comments($wp_list_comments_settings);

		// NOTE: Reference.
		// <li class="recent_stories ">
		echo '<ul id="comments" class="commentlist list-group p-0 m-0 border-0 rounded-0">';
		$wp_list_comments = str_replace(' class="comment even', ' class="comment even list-group-item col col-12 p-0 m-0 border-0 bg-transparent', $wp_list_comments);
		$wp_list_comments = str_replace(' class="comment odd', ' class="comment odd list-group-item col col-12 p-0 m-0 border-0 bg-transparent', $wp_list_comments);
		$wp_list_comments = str_replace(' class="comment byuser', ' class="comment byuser list-group-item col col-12 p-0 m-0 border-0 bg-transparent', $wp_list_comments);
		$wp_list_comments = str_replace(' class="pingback even', ' class="pingback even list-group-item col col-12 p-0 m-0 border-0 bg-transparent', $wp_list_comments);
		$wp_list_comments = str_replace(' class="pingback odd', ' class="pingback odd list-group-item col col-12 p-0 m-0 border-0 bg-transparent', $wp_list_comments);
		// $wp_list_comments = str_replace(' class="comment-body', ' class="comment-body row', $wp_list_comments);
		$wp_list_comments = str_replace('<footer class="comment-meta', '<footer class="comment-meta col-12', $wp_list_comments);
		$wp_list_comments = str_replace(' class="comment-author', ' class="comment-author d-inline-block', $wp_list_comments);
		$wp_list_comments = str_replace(' class="comment-metadata', ' class="comment-metadata d-inline-block', $wp_list_comments);
		$wp_list_comments = str_replace(' class="comment-content', ' class="comment-content my-2 px-3 pt-3 pb-1 rounded bg-light', $wp_list_comments);
		$wp_list_comments = str_replace('<a href="', '<a class="text-dark" href="', $wp_list_comments);
		$wp_list_comments = str_replace('<b class="fn">', '<b class="fn text-capitalize">', $wp_list_comments);
		$wp_list_comments = str_replace('<article ', '<div ', $wp_list_comments);
		$wp_list_comments = str_replace('</article>', '</div>', $wp_list_comments);
		$wp_list_comments = str_replace("decoding='async'/>", "decoding='async'>", $wp_list_comments);

		echo $wp_list_comments;
		echo '</ul>';

		// NOTE: Is this even still needed?
		if (FALSE) {
			echo '<div class="navigation">';
			echo '<div class="alignleft">';
			previous_comments_link();
			echo '</div>';
			echo '<div class="alignright">';
			next_comments_link();
			echo '</div>';
			echo '</div>';
		} // if

	} // if
	else {
		// this is displayed if there are no comments so far
	} // else

	if ('open' == $post->comment_status) {
		echo '<!-- If comments are open, but there are no comments. -->';
	} // if
	else {
		echo '<p class="nocomments">Comments are closed.</p>';
	} // else

	// This stuff below is for the comment form itself.
	if ('open' == $post->comment_status) {

		echo '<div id="respond">';

		echo '<div class="h4 fw-bold">&sect; ';
		comment_form_title('Leave a Reply', 'Leave a Reply to %s');
		echo '</div>';

		// NOTE: Is this even still needed?
		echo '<div class="cancel-comment-reply">';
		echo '<small>';
		cancel_comment_reply_link();
		echo '</small>';
		echo '</div>';

		$site_url = get_option('siteurl');
		$permalink = get_permalink();
		$permalink = urlencode($permalink);

		if (get_option('comment_registration') && !$user_ID) {
			echo '<p>You must be <a href="' . $site_url  . '/wp-login.php?redirect_to=' . $permalink. '">logged in</a> to post a comment.</p>';
		} // if
		else {
			echo '<form action="' . $site_url . '/wp-comments-post.php" method="post" id="commentform">';

			if (isset($user_ID) && !empty($user_ID)) {

				echo '<p>Logged in as <a href="' . get_option('siteurl') . '/wp-admin/profile.php" class="text-dark">';
				echo $user_identity;
				echo '</a>. ';
				echo '<a href="'. wp_logout_url(get_permalink()) .'" title="Log out of this account" class="text-dark">Log out &raquo;</a></p>';

		} // if
		else {

			$aria_required = null;
			if ($req) { 
				$aria_required = "aria-required='true'";
				$required_text = "<small>(required)</small>";
			} // if

			echo '<div class="row mb-3">';
			echo '<div class="col col-12 col-xl-6">';
			echo '<input type="text" class="form-control border border-darkblue" id="author" name="author" value="' . $comment_author . '" ' . $aria_required . '>';
			echo '</div>';
			echo '<label for="author" class="col col-12 col-xl-5 px-xl-0 col-form-label small"><strong>Name</strong> ' . $required_text . '</label>';
			echo '</div>';

			echo '<div class="row mb-3">';
			echo '<div class="col col-12 col-xl-6">';
			echo '<input type="text" class="form-control border border-darkblue" id="email" name="email" value="' . $comment_author_email . '" ' . $aria_required . '>';
			echo '</div>';
			echo '<label for="email" class="col col-12 col-xl-5 px-xl-0 col-form-label small"><strong>Mail</strong> <small>(will not be published)</small> ' . $required_text . '</label>';
			echo '</div>';

			echo '<div class="row mb-3">';
			echo '<div class="col col-12 col-xl-6">';
			echo '<input type="text" class="form-control border border-darkblue" id="url" name="url" value="' . $comment_author_url . '">';
			echo '</div>';
			echo '<label for="url" class="col col-12 col-xl-5 px-xl-0 col-form-label small"><strong>Website</strong> </label>';
			echo '</div>';

		} // else

		// NOTE: Is this even still needed?
		// echo '<p><small><strong>XHTML:</strong> You can use these tags: <code>';
		// echo allowed_tags();
		// echo '</code></small></p>';

		echo '<div class="row mb-3">';
		echo '<div class="col col-12">';
		echo '<textarea class="form-control w-100 border border-darkblue" name="comment" id="comment" rows="10"></textarea>';
		echo '</div>';
		echo '</div>';

		echo '<div class=" mb-3">';
		echo '<button type="submit" id="submit" name="submit" class="btn btn-outline-dark bg-offwhite col col-12 col-xl-12">Submit Comment</button>';
		echo '</div>';

		comment_id_fields();
		echo do_action('comment_form', $post->ID);

		echo '</form>';

		echo '</div>';

	} // else

} // if

?>