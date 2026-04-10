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

    if ($upw_query->have_posts()) {

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
        // The article image stuff.
        $article_image = null;
        if ($instance['show_thumbnail']) {
          $article_image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), $instance['thumb_size']);     
        } // if

        /******************************************************************************/
        // Header stuff.
        if (get_the_title() && $instance['show_title']) {
          $header =
              '<span class="text-railroadgothic" id="home_featured_' . $the_ID . '">'
            . '<a href="' . $permalink . '" rel="bookmark" title="' . $title . '" class="text-decoration-none text-darkblue">'
            . $title
            . '</a>'
            . '</span>'
            ;
        } // if

        /******************************************************************************/
        // Content stuff.
        if ($instance['show_excerpt'] && !empty($excerpt)) {
          $content = null;
          if ($instance['show_readmore']) {
            $excerpt = substr($excerpt, 0, -3);
          } // if
          $content .=
              '<a href="' . $permalink . '" rel="bookmark" title="' . $title . '" class="text-decoration-none text-darkblue">'
            . $excerpt
            . '</a>'
            ;
          $content =
              '<span class="text-georgia-regular small">'
            . $content
            . '</span>'
            ;
        } // if

        /******************************************************************************/
        // Set the divider.
        $divider = null;
        if (!empty($title) && !empty($excerpt)) {
          $divider = '<span class="text-railroadgothic">: </span>';
        } // if

        /******************************************************************************/
        // Custom cointainer begins.
        $final[] =
            '<div class="col col-12 m-0 p-0 pe-md-3 pe-xl-0">'
          . '<div class="' . implode(' ' , get_post_class($post_class))  . ' p-0 m-0">'
          . $header
          . $divider
          . $content
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
    // If we hvae stuff to output, set the final output value.
    if (!empty($before) || !empty($final) || !empty($after)) {
        $ret = 
            $before
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
