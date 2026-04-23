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
          '<div class="upw-before m-0 p-0">'
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
        $excerpt = get_the_excerpt();
        $the_author = get_the_author();
        $the_author_url = get_author_posts_url(get_the_author_meta('ID'));

        $comments_link = get_comments_link();
        $comments_number = get_comments_number(__('No comments', 'upw'), __('One comment', 'upw'), __('% comments', 'upw'));

        $categories = get_the_term_list($post->ID, 'category', '', ', ');
        $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');

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
        // The article image stuff.
        $article_image = null;
        if ($instance['show_thumbnail']) {
          $article_image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), $instance['thumb_size']);     
        } // if

        /******************************************************************************/
        // Header stuff.
        $header = null;
        if (get_the_title() && $instance['show_title']) {
          $header .=
              '<div class="h4 text-helvetica-light p-0 m-0 mb-2" id="home_featured_' . $the_ID . '>'
            . '<a href="' . $permalink . '" rel="bookmark" title="' . $title . '" class="text-decoration-none text-dark">'
            . $title
            . '</a>'
            . '</div>'
            ;
        } // if

        /******************************************************************************/
        // Content stuff.
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
              '<a href="' . $permalink . '" rel="bookmark" title="' . $title . '" class="text-decoration-none text-dark">'
            . $excerpt . $excerpt_readmore
            . '</a>'
            ;
          $content =
              '<div class="text-georgia-regular lh-base small">'
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
            '<div class="col col-12 col-lg-4 m-0 p-0 pe-lg-3 pb-3">'
          . '<div class="container m-0 p-0">'
          . '<div class="' . implode(' ' , get_post_class($post_class))  . ' p-0 m-0">'
          . $header
          . $divider
          . $content
          . '</div>'
          . '</div>'
          . '</div>'
          ;

      } // while

    } // if
    else {

      $final[] =
          '<div class="upw-not-found m-0 p-0">'
        . wpautop($instance['custom_empty'])
        . '</div>'
        ;
 
    } // else
 
    /*********************************************************************************/
    // Set the after stuff.
    if ($instance['after_posts']) {
      $after =
          '<div class="upw-after m-0 p-0">'
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
          . $divider
          . '<div class="upw-posts hfeed row m-0 p-0">'
          . implode('', $final)
          . '</div>'
          . $after
          ;
    } // if

    /*********************************************************************************/
    // Output the final value.
    echo $ret;

?>
