           </div>
          </div>
        </div> 

      </div>
    </div>
  </div>
  <!-- Content Core END -->

  <!-- Footer Content BEGIN -->
  <!-- <div class="container mb-5 mb-md-3">
    <div class="row">
      <div class="col px-3 px-md-4 mx-3 mx-md-0 mb-5 bg-offwhite border border-2 border-darkblue rounded-3">

        <div class="container">
          <div class="row">
            <div class="col py-3 py-md-4">

           </div>
          </div>
        </div> 

      </div>
    </div>
  </div> -->
  <!-- Footer Content END -->

<?php

  /**********************************************************************/
  // Get the current selected category info.
  // if (is_archive() || is_single()) {
  if (is_single()) {
    $page_category = get_the_category();
    $page_category_shifted = array();
    $page_category_parent_ID = null;
    $page_category_slug = null;
    $page_category_name = null;
    if (!empty($page_category)) {
      $page_category = array_shift($page_category);
      $page_category_parent_ID = isset($page_category->parent) ? $page_category->parent : null;
      $page_category_slug = isset($page_category->slug) ? $page_category->slug : null;
      $page_category_name = isset($page_category->name) ? $page_category->name : null;
    } // if
  } // if
  else {
    $page_category_ID = get_query_var('cat');
    $page_category = get_category($page_category_ID);
    $page_category_parent_ID = null;
    $page_category_slug = null;
    $page_category_name = null;
    if (!empty($page_category)) {
      $page_category_parent_ID = isset($page_category->parent) ? $page_category->parent : null;
      $page_category_slug = isset($page_category->slug) ? $page_category->slug : null;
      $page_category_name = isset($page_category->name) ? $page_category->name : null;
    } // if
  } // else

  /**************************************************************************************************/
  // Get the site URL.
  $site_url = get_site_url();

  /**************************************************************************************************/
  // Anchor links for the homepage and regular links for other pages.
  $site_url = is_front_page() ? $site_url . '#' : $site_url . '/';

  /**************************************************************************************************/
  // Set the navigaton array items.
  $nav_items_array = array();
  // $nav_items_array[] = '<a href="' . $site_url . '" title="Home" class="text-dark m-0 p-0"><span property="name" class="text-dark fa fa-home"></span></a>';
  $nav_items_array['books'] = '<a href="' . $site_url . 'books" title="Books" class="text-dark m-0 p-0">Books</a>';
  $nav_items_array['events'] = '<a href="' . $site_url . 'events" title="Tour/Events" class="text-dark m-0 p-0">Tour/Events</a>';
  $nav_items_array['editoral'] = '<a href="' . $site_url . 'editoral" title="Editoral Services" class="text-dark m-0 p-0">Editoral Services</a>';
  $nav_items_array['articles'] = '<a href="' . $site_url . 'articles" title="Articles" class="text-dark m-0 p-0">Articles</a>';
  $nav_items_array['newsletter'] = '<a href="' . $site_url . 'newsletter" title="Newsletter" class="text-dark m-0 p-0">Newsletter</a>';

  /**************************************************************************************************/
  // Set the navigaton divider item.
  $nav_item_divider = '<span class="text-dark m-0 p-0 px-2">&bull;</span>';

  /**************************************************************************************************/
  // Set the navigaton array items.
  foreach ($nav_items_array as $item_key => $item_value) {
    $css_font_weight = ($page_category_slug) == $item_key ? 'text-clashgrotesk-medium' : 'text-clashgrotesk-regular';
    $css_string = $item_key . ' ' . $css_font_weight;
    $nav_items_array[$item_key] =
        '<li class="list-inline-item text-nowrap p-0 m-0 ' . $css_string . '">'
      . '<span class="d-none d-md-block h5 p-0 m-0 ' . $css_string . '">'
      . $item_value
      . '</span>'
      . '<span class="small d-md-none">'
      . $item_value
      . '</span>'
      . '</li>'
      ;
  } // foreach

  /**************************************************************************************************/
  // Set the navigaton string.
  $nav_items_string = implode($nav_item_divider, $nav_items_array);

?>

  <footer class="fixed-bottom p-0 m-0 px-3 bg-white">
    <div class="col col-12 p-0 m-0 px-2 py-3">
      <div class="h6 text-clashgrotesk-regular text-center p-0 m-0">
        <ul class="list-inline p-0 m-0">
          <?php
            echo $nav_items_string;
          ?>
        </ul>
      </div>
    </div>
  </footer>

</body>

<?php

  /**************************************************************************************************/
  // This 'wp_footer' call sets all of the JavaScript and related stuff that WordPress needs to insert in the page.
  wp_footer();

?>
</body>
</html>