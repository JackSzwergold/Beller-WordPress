<?php

    /*********************************************************************************/
    // Init some variables.
    $ret = null;

    $before = null;
    $after = null;
    $final = array();

    $header = null;
    $divider = null;
    $content = null;

    /*********************************************************************************/
    // Set the before stuff.
    if ($instance['before_posts']) {
      $before =
          '<div class="upw-before">'
        . wpautop($instance['before_posts'])
        . '</div>'
        ;
    } // if

    /*********************************************************************************/
    // If there are posts, do something.
    if ($upw_query->have_posts()) {

      /*******************************************************************************/
      // Loop through the posts.
      while ($upw_query->have_posts()) {

        $upw_query->the_post();

        $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : '';

        /******************************************************************************/
        // Set the variables.
        $title = get_the_title();
        $post_class = get_post_class($current_post);
        $permalink = get_the_permalink();
        $the_ID = get_the_ID();
        $display_date = get_the_time($instance['date_format']);
        $iso_8601_date = get_the_time('c');

        /******************************************************************************/
        // Set the author related stuff.
        $the_author = get_the_author();
        $the_author_url = get_author_posts_url(get_the_author_meta('ID'));

        /******************************************************************************/
        // Set the excerpt.
        $excerpt = null;
        if ($instance['show_excerpt']) {
          $excerpt = get_the_excerpt();
        } // if

        /******************************************************************************/
        // Set the content.
        $content = null;
        if ($instance['show_content']) {
          $content = get_the_content();
        } // if

        /******************************************************************************/
        // Set the comments stuff.
        $comments_link = get_comments_link();
        $comments_number = get_comments_number(__('No comments', 'upw'), __('One comment', 'upw'), __('% comments', 'upw'));

        $categories = get_the_term_list($post->ID, 'category', '', ', ');
        $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');

        /******************************************************************************/
        // Get the custom ACF values.
        $book_isbn = get_field('isbn');
        $book_asin = get_field('asin');
        $book_author = get_field('author');
        $book_publisher = get_field('publisher');
        $book_publication_date = get_field('publication_date');

        /******************************************************************************/
        // Set the Amazon URL.
        $amazon_url = null;
        if (isset($book_asin) && !empty($book_asin)) {
          $amazon_url = 'https://www.amazon.com/dp/' . $book_asin;
        } // if

        /******************************************************************************/
        // Set the purchase link.
        $purchase_link = null;
        if (!empty($amazon_url)) {
          $purchase_link .=
              '<a href="' . $amazon_url . '" class="badge text-arial-bold bg-warning-subtle text-warning-emphasis p-0 m-0 px-2 py-1 mt-2 col col-12" target="_blank">'
            . 'Purchase'
            . '</a>'
            ;
        } // if

        /******************************************************************************/
        // Get the category.
        $category_object = get_the_category($post->ID);
        $category = null;
        $category_slug = null;
        $category_link = null;
        if (!empty($category_object)) {
          $category = array_shift($category_object);
          $category_slug = $category->slug;
          $category_link = get_category_link($category->term_id);
        } // if

        /******************************************************************************/
        // Set the permalink to the category page if we are on the front page.
        if (is_front_page() && !empty($category_link)) {
          $permalink = $category_link;
        } // if

        /******************************************************************************/
        // The post image stuff.
        $post_image = null;
        if ($instance['show_thumbnail']) {
          $post_image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), $instance['thumb_size']);     
        } // if
        if (isset($post_image) && !empty($post_image)) {
          $post_image =
              '<div class="col col-12 col-md-3 m-0 p-0 mb-2 ms-md-3 float-end">'
            . '<a href="' . $permalink . '" title="' . $title . ' (' . $book_isbn . ')" class="text-decoration-none text-dark">'
            . '<img src="' . $post_image . '" alt="' . $title . ' (' . $book_isbn . ')" class="img-fluid">'
            . '</a>'
            . $purchase_link
            . '</div>'
            ;
        } // if

        /******************************************************************************/
        // Header stuff.
        $header = null;
        if (get_the_title() && $instance['show_title']) {
          $header .=
              '<div class="h4 text-helvetica-light p-0 m-0 mb-2" id="home_featured_' . $the_ID . '">'
            . '<a href="' . $permalink . '" rel="bookmark" title="' . $title . ' (' . $book_isbn . ')" class="text-decoration-none text-dark">'
            . $title
            . '</a>'
            . '</div>'
            ;
        } // if

        /******************************************************************************/
        // Excerpt stuff.
        if ($instance['show_excerpt'] && !empty($excerpt)) {
          $content = null;
          if ($instance['show_readmore']) {
            $excerpt = substr($excerpt, 0, -3);
          } // if
          $excerpt_readmore = null;
          if ($instance['excerpt_readmore']) {
            $excerpt_readmore = '<span class="text-clashgrotesk-regular m-0 p-0 ms-1">' . $instance['excerpt_readmore'] . '</span>';
          } // if
          $content .=
              '<a href="' . $permalink . '" rel="bookmark" title="' . $title . ' (' . $book_isbn . ')" class="text-decoration-none text-dark">'
            . $excerpt . $excerpt_readmore
            . '</a>'
            ;
        } // if

        /******************************************************************************/
        // Content stuff.
        if ($instance['show_content'] && !empty($content)) {
          $content =
              '<div class="text-georgia-regular lh-base">'
            . $content
            . '</div>'
            ;
        } // if

        /******************************************************************************/
        // Set the divider.
        // $divider = null;
        // if (!empty($title) && !empty($excerpt)) {
        //   $divider = '<span class="text-georgia-regular">: </span>';
        // } // if

        /******************************************************************************/
        // Custom container begins.
        $final[] =
            '<div class="col col-12 col-lg-12 pb-3 ' . implode(' ' , get_post_class($post_class))  . '">'
          . $header
          . $divider
          . $post_image
          . $content
          . '</div>'
          ;

      } // while

    } // if
    else {

      $final[] =
          '<div class="upw-not-found">'
        . wpautop($instance['custom_empty'])
        . '</div>'
        ;
 
    } // else
 
    /*********************************************************************************/
    // Set the after stuff.
    if ($instance['after_posts']) {
      $after =
          '<div class="upw-after">'
        . wpautop($instance['after_posts'])
        . '</div>'
        ;
        } // if

    /*********************************************************************************/
    // Set the divider.
    $divider = '<hr class="p-0 m-0 mb-5 hr-dashed opacity-100">';

    /*********************************************************************************/
    // If we have stuff to output, set the final output value.
    if (!empty($before) || !empty($final) || !empty($after)) {
        $ret = 
            $before
          // . $divider
          . '<div class="upw-posts hfeed row gx-5">'
          . implode('', $final)
          . '</div>'
          . $after
          ;
    } // if

    /*********************************************************************************/
    // Output the final value.
    echo $ret;

?>
