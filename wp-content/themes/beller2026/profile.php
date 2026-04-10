<?php
  get_header();
?>
<!-- Content Core BEGIN -->
<div class="container m-0 p-0">
  <div class="row m-0 p-0">
    <div class="col col-12 col-lg-9 p-0 m-0 mb-3">

      <div class="row p-0 m-0 mx-3">
        <div class="col col-12 m-0 p-0">

          	<?php
              if (have_posts()) {
                while (have_posts()) {

                  /******************************************************************************/
                  // Get the post.
                  the_post();

                  // Why is this here? Who knows.
                  if (is_home()) {
                    if (function_exists('wp_list_comments')) {
                      echo '<div ';
                      post_class();
                      echo '>';
                    } // if
                  } // if

                  /******************************************************************************/
                  // Set the variables.
                  // $the_title_attribute = get_the_title_attribute();
                  $permalink = get_the_permalink();
                  $title = get_the_title();

                  echo '<header class="p-0 m-0">';
                  echo '<div class="p-0 m-0">';
                  echo '<div class="container p-0 m-0 pb-2 mb-2 border-bottom border-dark">';
                  echo '<div class="h4 p-0 m-0 fw-bold">';
                  echo '<a href="' . $permalink . '" rel="bookmark" title="Permanent Link to ' . $title . '" class="text-dark text-decoration-none">';
                  the_title();
                  echo '</a>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                  echo '</header>';


                  // This seems like a bad idead. Commenting it out.
                  // echo '<p>';
                  // edit_post_link('Edit', '', '');
                  // echo '</p>';

                  /******************************************************************************/
                  // Here is where the magic happens.
                  the_content();

            	    global $current_user;

                  wp_get_current_user();

            	    if ($current_user->ID != 0) { 

                    /******************************************************************************/
                    // Account information.
                    echo '<div class="h4">';
                    echo 'Account information.';
                    echo '</div>';
                    echo '<ul class="list-group p-0 m-0 rounded-0">';
                    echo '<li class="list-group-item col col-12 p-0 m-0 mb-1 border-0 bg-transparent"><strong>Name:</strong>  ' . $current_user->display_name . '</li>';
                    echo '<li class="list-group-item col col-12 p-0 m-0 mb-1 border-0 bg-transparent"><strong>Website:</strong>  ' . $current_user->user_url . '</li>';
                    echo '<li class="list-group-item col col-12 p-0 m-0 mb-1 border-0 bg-transparent"><strong>Email:</strong> ' . $current_user->user_email . '</li>';
                    echo '<li class="list-group-item col col-12 p-0 m-0 mb-1 border-0 bg-transparent"><strong>Bio:</strong> ';
                    if (isset($current_user->description) && !empty($current_user->description)) {
                      // echo wpautop($current_user->description);
                      echo $current_user->description;
                    } // if
                    else {
                      echo '<a href="/wp-admin/profile.php" class="text-danger">Add your bio here!</a>';
                    } // else
                    echo '</li>';               
                    echo '</ul>';
                    echo '<p>';
                    echo '<a href="/wp-admin/profile.php" class="text-dark">Change your profile details</a>';
                    echo '</p>';

                    /******************************************************************************/
                    // Ratings.
                    get_user_ratings($current_user->ID);
                    if (count($ratings) > 0) {
                      echo '<div class="h4">';
                      echo 'Your ratings.';
                      echo'</div>';
                      echo '<div class="p-0 m-0 mt-1 col col-12 container-fluid table-responsive border border-bottom-0 bg-offwhite">';
                      echo '<table class="p-0 m-0 col col-12 table table-sm table-hover">';
                      echo '<thead>';
                      echo '<tr>';
                      echo '<th scope="col"><span class="text-nowrap">Post Title</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Your Rating</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Total Rating</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Date / Time</span></th>';	
                      echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';
                    	foreach ($ratings AS $value) {
                        echo '<tr>';
                        echo '<td>';
                        echo '<span class="fw-bold">';
                        echo '<a href="' . get_permalink($value->rating_postid) . '" class="text-decoration-none text-dark">';
                        echo $value->rating_posttitle;
                        echo '</a>';
                        echo '</td>';
                        echo '<td>' . get_ratings_images('', intval(get_option('postratings_max')), $value->rating_rating, get_option('postratings_image'), '', '', '') . '</td>';
                        echo '<td>' . the_ratings_results($value->rating_postid) . '</td>';
                        echo '<td>' . mysql2date(sprintf(__('%s, %s', 'wp-postratings'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $value->rating_timestamp)) . '</td>';
                        echo '</tr>';
                    	} // foreach
                      echo '</tbody>';
                      echo '</table>';
                      echo '</div>';
                      echo '<p>';
                      echo '<strong>Ratings total</strong>: ';
                      echo get_user_ratings_count($current_user->ID);
                      echo '</p>';
                    } // if
                    else {
                      echo '<div class="h4">';
                      echo "You didn't make any ratings yet.";
                      echo'</div>';
                    } // else

                    /******************************************************************************/
            		    // Pending stories.
                    get_user_pending_stories($current_user->ID);
                    if (count($stories_pending) > 0) {
                      echo '<div class="h4">';
                      echo "Your pending stories.";
                      echo'</div>';
                      echo '<div class="p-0 m-0 mt-1 col col-12 container-fluid table-responsive border border-bottom-0 bg-offwhite">';
                      echo '<table class="p-0 m-0 col col-12 table table-sm table-hover">';
                      echo '<thead>';
                      echo '<tr>';
                      echo '<th scope="col"><span class="text-nowrap">Date</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Where</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">When</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Excerpt</span></th>';
                      echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';
                      foreach ($stories_pending as $value) {
                        // $excerpt = explode(' ', $story->post_content, 10);
                        $excerpt = strip_tags($value->post_content);
                        $excerpt = mb_substr($excerpt, 0, 300) . ' [...]';
                        echo '<tr>';
                        echo '<td>' . $value->post_date . '</td>';
                        echo '<td>' . get_post_meta($value->ID, 'where', true) . '</td>';
                        echo '<td>' . get_post_meta($value->ID, 'when', true) . '</td>';
                        echo '<td>' . $excerpt . '</td>';
                        echo '</tr>';
                      } // foreach
                      echo '</tbody>';
                      echo '</table>';
                      echo '</div>';

                    } // if
                    else {
                      echo '<div class="h4">';
                      echo "You don't have any pending stories.";
                      echo'</div>';
                    } // else

                    /******************************************************************************/
                    // Published Stories
                    get_user_stories($current_user->ID);
                    if (count($stories) > 0) {

                      /****************************************************************************/
                      // Set the categories array.
                      // NOTE: Doesn't seem to work.
                      $categories_array = array();
                      $categories = get_the_category();
                      foreach ($categories AS $value) {
                        if ($value->slug == 'featured') {
                          continue;
                        } // if
                        $category_link = get_category_link($value->term_id);
                        $categories_array[] =
                            '<a href="' . $category_link . '" title="View all the stories from ' . $value->name . '" class="text-dark">' 
                          . $value->name
                          . '</a>'
                          ;
                      } // foreach

                      echo '<div class="h4">';
                      echo "Your published stories.";
                      echo'</div>';
                      echo '<div class="p-0 m-0 mt-1 col col-12 container-fluid table-responsive border border-bottom-0 bg-offwhite">';
                      echo '<table class="p-0 m-0 col col-12 table table-sm table-hover">';
                      echo '<thead>';
                      echo '<tr>';
                      echo '<th scope="col"><span class="text-nowrap">Post Title</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Total Rating</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Date / Time</span></th>';
                      // echo '<th scope="col"><span class="text-nowrap">Neighborhood</span></th>';
                      // echo '<th scope="col"><span class="text-nowrap">Where</span></th>';
                      // echo '<thscope="col"><span class="text-nowrap">When</span></th>';
                      echo '<th scope="col"><span class="text-nowrap">Excerpt</span></th>';
                      echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';
                      foreach ($stories AS $value) {
                        // $excerpt = explode(' ', $story->post_content, 10);
                        $excerpt = strip_tags($value->post_content);
                        $excerpt = mb_substr($excerpt, 0, 300) . ' [...]';
                        echo '<tr>';
                        echo '<td>';
                        echo '<span class="fw-bold">';
                        echo '<a href="' . get_permalink($value) . '" class="text-decoration-none text-dark">';
                        echo $value->post_title;
                        echo '</a>';
                        echo '</span>';
                        echo '</td>';
                        echo '<td>' . the_ratings_results($value->ID) . '</td>';
                        echo '<td>' . date('F j, Y', strtotime($value->post_date)) . '</td>';
                        // echo '<td>';
                        // echo implode(', ', $categories_array);
                        // echo '</td>';
                        // echo '<td>' . get_post_meta($value->ID, 'where', true) . '</td>';
                        // echo '<td>' . get_post_meta($value->ID, 'when', true) . '</td>';
                        echo '<td>' . $excerpt . '</td>';
                        echo '</tr>';

                      } // foreach
                      echo '</tbody>';
                      echo '</table>';
                      echo '</div>';

                    } // if
                    else {
                      echo '<div class="h4">';
                      echo "You don't have any published stories yet.";
                      echo'</div>';
                      echo '<p>';
                      echo '<a href="/tell-mr-beller-a-story" class="text-dark">Tell Mr. Beller a Story</a>';
                      echo '</p>';
                    } // else
                  } // if
            	    else {
                    echo '<p><a href="/login">Login here</a> to view your profile.</p>';
                  } // else

                  /******************************************************************************/
                  // Why is this here? Who knows.
                  if (is_home()) {
                    if (function_exists('wp_list_comments')) {
                      echo '</div>';
                    } // if
                  } // if

                } // while
              } // if

            ?>
        </div>
      </div>

    </div>
    <div class="col col-12 col-lg-3 ms-auto m-0 p-0">

      <?php
        get_sidebar();
      ?>

    </div>
  </div>
</div>
<!-- Content Core END -->
<?php
  get_footer();
?>