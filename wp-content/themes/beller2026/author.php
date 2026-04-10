<?php
  get_header();
?>
<!-- Content Core BEGIN -->
<div class="container m-0 p-0">
  <div class="row m-0 p-0">
    <div class="col col-12 col-lg-9 p-0 m-0 mb-3">

      <div class="row p-0 m-0 mx-3">
            <?php

                /********************************************************************************/
                // Set the author information.
                if (isset($_GET['author_name'])) {
                    $author = get_userdatabylogin($author_name);
                } // if
                else {
                    $author = get_userdata(intval($author));
                } // else

                /********************************************************************************/
                // Set the opening header depending on if we have books or not.
                if (function_exists('has_books') && has_books($author->ID)) {
                    echo '<div class="col col-12 col-xl-9 p-0 m-0 pe-3">';
                } // if
                else {
                    echo '<div class="col col-12 m-0 p-0">';
                } // else

                /********************************************************************************/
                // If we have an author ID, do something.
                if ($author->ID != 0) { 

                    $query_posts_settings = array();
                    $query_posts_settings['posts_per_page'] = 500;
                    $query_posts_settings['author'] = $author->ID;
                    query_posts($query_posts_settings);

                    echo '<div class="h4 p-0 m-0 fw-bold mb-2">';
                    echo $author->display_name;
                    echo '</div>';

                    if (isset($author->user_description) && !empty($author->user_description)) {
                        echo '<div class="h4 p-0 m-0 pb-1 mb-2 border-bottom border-dark">';
                        echo 'Bio';
                        echo '</div>';
                        echo '<div class="author_bio">';
                        echo wpautop($author->user_description);
                        echo '</div>';
                    } // if
                    else {
                        global $current_user;
                        wp_get_current_user();
                        if ($current_user->ID == $author->ID) {
                            echo '<div class="h4 p-0 m-0 pb-1 mb-2 border-bottom border-dark">';
                            echo 'Bio';
                            echo '</div>';
                            echo '<div class="author_bio">';
                            echo '<p>';
                            echo '<a class="text-dark" href="/wp-admin/profile.php">';
                            echo 'Add your bio here!';
                            echo '</a>';
                            echo '</p>';
                            echo '</div>';
                        } // if
                    } // else

                    if ($author->user_url != '' ) {
                        echo '<div class="h4 p-0 m-0 pb-1 mb-2 border-bottom border-dark">';
                        echo 'Website';
                        echo '</div>';
                        echo '<p>';
                        echo '<a href="' . $author->user_url . '">';
                        echo $author->user_url;
                        echo '</a>';
                        echo '</p>';
                    } // if

                    if (have_posts()) {

                        echo '<div class="h4 p-0 m-0 pb-1 mb-2 border-bottom border-dark">';
                        echo 'Stories';
                        echo '</div>';

                        echo '<ul class="list-group p-0 m-0 rounded-0">';

                        while (have_posts()) {

                            the_post();

                            global $post;
                            global $authordata;

                            echo '<li class="list-group-item col col-12 p-0 m-0 mb-3 border-0">';

                            /********************************************************************************/
                            // Set the blog post info valiables.
                            $story_author_id = $post->post_author;  //  important for sidebar!
                            $permalink = get_the_permalink();
                            $title = get_the_title();
                            $title_attribute = the_title_attribute(array('echo' => false));
                            $the_author = get_the_author();
                            $the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));

                            echo '<div class="h5 p-0 m-0 fw-bold">';
                            echo '<a href="' . $permalink . '" title="Permanent Link to ' . $title_attribute . '" class="text-decoration-none text-dark">';
                            echo $title;
                            echo '</a>';
                            echo '</div>';

                            echo '<div class="text-secondary p-0 m-0">';
                            echo 'Published on: ';
                            echo get_the_time('F j, Y');
                            echo '</div>';

                            // Set the categories array.
                            $categories_array = array();
                            $categories = get_the_category();
                            foreach ($categories AS $value) {
                                if ($value->slug == 'featured') {
                                    continue;
                                } // if
                                $category_link = get_category_link($value->term_id);
                                $categories_array[] =
                                        '<a href="' . $category_link . '" title="View all the stories from ' . $value->name . '" class="text-secondary">' 
                                    . $value->name
                                    . '</a>'
                                    ;
                            } // foreach

                            echo '<div class="text-secondary p-0 m-0">';
                            echo get_post_meta($post->ID, 'address', true);
                            echo '</div>';
                            echo '<div class="text-secondary">';
                            echo 'From ';
                            echo implode(', ', $categories_array);


                            ob_start();
                            the_tags(' about ');
                            $the_tags = ob_get_contents();
                            ob_end_clean();
                            $the_tags = str_replace('<a href=', '<a class="text-secondary" href=', $the_tags);
                            echo $the_tags;
                            echo '</div>';

                            // NOTE: Is this even used for anything? Seems like it was never used.
                            // $excerpt = explode(' ', get_the_content(), 10);
                            // array_pop($excerpt);
                            // $excerpt = implode(' ', $excerpt) . ' [...]';

                            echo '</li>';

                        } // while

                        echo '</ul>';

                    } // if
                    else {
                        echo '<p>';
                        _e('No stories by this author.');
                        echo '</p>';
                    } // else

            ?>

        </div>

            <?php

                    if (function_exists('has_books') && has_books($author->ID)) {
                        echo '<div class="col col-12 col-xl-3 m-0 p-0">';
                        echo '<div class="profile-right">';
                        echo '<div class="h5 p-0 m-0 fw-bold">';
                        echo 'Books';
                        echo '</div>';
                        echo '<p>';
                        $books_settings = array();
                        $books_settings['user'] = $author->ID;
                        $books_settings['size'] = 3;
                        books($books_settings);
                        echo '</p>';
                        echo '</div>';
                        echo '</div>';
                    } // if

                } // if

            ?>

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