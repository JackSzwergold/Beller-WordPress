           </div>
          </div>
        </div> 

      </div>
    </div>
  </div>
  <!-- Content Core END -->

  <!-- Footer Content BEGIN -->
  <div class="container mb-5 mb-md-3">
    <div class="row">
      <div class="col px-3 px-md-4 mx-3 mx-md-0 mb-5 bg-offwhite border border-2 border-darkblue rounded-3">

        <div class="container">
          <div class="row">
            <div class="col py-3 py-md-4">

              <div class="p-0 m-0 mx-0 rounded-0">
                <div class="categories list-group-item col col-12 m-0 p-0 mb-3 border-0">
                  <nav class="h5 p-0 m-0 mb-2 border-bottom border-darkblue border-2">
                    <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                      <button class="nav-link active text-decoration-none text-darkblue p-0 m-0 px-3 py-1 border border-2 border-bottom-0 border-darkblue" id="nav-categories-tab" data-bs-toggle="tab" data-bs-target="#nav-categories" type="button" role="tab" aria-controls="nav-categories" aria-selected="true">Categories</button>
                      <button class="nav-link text-decoration-none p-0 m-0 text-darkblue px-3 py-1 border border-2 border-bottom-0 border-darkblue ms-1" id="nav-archives-tab" data-bs-toggle="tab" data-bs-target="#nav-archives" type="button" role="tab" aria-controls="nav-archives" aria-selected="false">Archives</button>
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane show active" id="nav-categories" role="tabpanel" aria-labelledby="nav-categories-tab">
                    <?php

                      /******************************************************************************/
                      // Init variables.
                      $show_counts = TRUE;

                      /******************************************************************************/
                      // Set the category arguments.
                      $category_args = array();
                      $category_args['taxonomy'] = 'category';
                      $category_args['type'] = 'post';
                      $category_args['child_of'] = false;
                      $category_args['parent'] = '';
                      $category_args['orderby'] = 'name';
                      $category_args['order'] = 'ASC';
                      $category_args['hide_empty'] = true;
                      $category_args['hierarchical'] = true;
                      $category_args['exclude'] = '';
                      $category_args['include'] = '';
                      $category_args['number'] = false;
                      $category_args['pad_counts'] = false;

                      /******************************************************************************/
                      // Get the categories.
                      $categories_array = get_categories($category_args);

                      /******************************************************************************/
                      // If we have categories, do something.
                      $sorted_categories = array();
                      $parent_child_category_map = array();
                      if (!empty($categories_array)) {

                        /**************************************************************************/
                        // Sort the categories.
                        foreach ($categories_array as $key => $value) {
                          $sorted_categories[$value->term_id] = (array) $value;
                          $parent_child_category_map[$value->category_parent][$value->term_id] = $value->slug;
                        } // foreach

                        /**************************************************************************/
                        // Sort the categories some more.
                        $temp = array();
                        $catergories_final = array();
                        foreach ($parent_child_category_map as $parent_key => $parent_value) {

                          /**********************************************************************/
                          // Set the parent category link.
                          $parent_category_link = null;
                          if ($parent_key > 0) {
                            $parent_category_link = get_category_link($parent_key);
                          } // if

                          /**********************************************************************/
                          // Set various parent values. 
                          $parent_category_slug = isset($sorted_categories[$parent_key]['slug']) ? $sorted_categories[$parent_key]['slug'] : 'orphaned';
                          $parent_category_name = isset($sorted_categories[$parent_key]['name']) ? $sorted_categories[$parent_key]['name'] : 'Orphaned';
                          $parent_category_count = isset($sorted_categories[$parent_key]['count']) ? $sorted_categories[$parent_key]['count'] : 0;

                          /**********************************************************************/
                          // Stuff for the data array.
                          $parent_category_data = array();
                          $parent_category_data['link'] = $parent_category_link;
                          $parent_category_data['slug'] = $parent_category_slug;
                          $parent_category_data['name'] = $parent_category_name;
                          $parent_category_data['count'] = $parent_category_count;

                          /**********************************************************************/
                          // Set the parent stuff.
                          $catergories_final[$parent_category_slug]['parent'] = $parent_category_data;

                          /**********************************************************************/
                          // Set the child stuff.
                          foreach ($parent_value as $child_key => $child_value) {

                            /******************************************************************/
                            // Set the child category link.
                            $child_category_link = get_category_link($child_key);

                            /******************************************************************/
                            // Set various parent values. 
                            $child_category_slug = $sorted_categories[$child_key]['slug'];
                            $child_category_name = $sorted_categories[$child_key]['name'];
                            $child_category_count = $sorted_categories[$child_key]['count'];

                            /******************************************************************/
                            // Stuff for the data array.
                            $child_category_data = array();
                            $child_category_data['link'] = $child_category_link;
                            $child_category_data['slug'] = $child_category_slug;
                            $child_category_data['name'] = $child_category_name;
                            $child_category_data['count'] = $child_category_count;
                            
                            /******************************************************************/
                            // Set the child stuff.
                            $catergories_final[$parent_category_slug]['child'][$child_category_slug]['parent'] = $child_category_data;

                          } // foreach

                          /**********************************************************************/
                          // Key sort the final child categories array.
                          ksort($catergories_final[$parent_category_slug]['child']);

                        } // foreach

                      } // if

                      /******************************************************************************/
                      // Key sort the final categories array.
                      ksort($catergories_final);

                      /******************************************************************************/
                      // Merge the orphaned items with the final catecgories.
                      $orphaned = $catergories_final['orphaned']['child'];
                      unset($catergories_final['orphaned']);
                      $merged = array_replace($orphaned, $catergories_final);

                      /******************************************************************************/
                      // Key sort the final parent categories array.
                      ksort($merged);

                      /******************************************************************************/
                      // Finally, render the categories.
                      $parent_li_items_array = array();
                      foreach ($merged as $key => $value) {

                        /**************************************************************************/
                        // Set the parent stuff.
                        $parent_count = (isset($value['parent']['count']) && !empty($value['parent']['count']) ? ' (' . $value['parent']['count'] . ')' : null);
                        $parent_link = (isset($value['parent']['link']) ? $value['parent']['link'] : null);
                        $parent_slug = (isset($value['parent']['slug']) ? $value['parent']['slug'] : null);
                        $parent_name = (isset($value['parent']['name']) ? $value['parent']['name'] : null);
                        $parent_stuff = $parent_name . ($show_counts && !empty($child_count) ? $child_count : null);

                        /**************************************************************************/
                        // Set the parent stuff.
                        if (!empty($parent_link)) {
                          $parent_stuff = 
                              '<a href="' . $parent_link  .'" class="text-decoration-none text-darkblue text-georgia-bold">'
                            . $parent_stuff
                            . ($show_counts && !empty($parent_count) ? $parent_count : null)
                            . '</a>'
                            ;  
                        } // if

                        /*************************************************************************/
                        // Wrap it all up in LI tags.
                        $parent_stuff =
                            '<li class="list-group-item fw-bold col col-12 p-0 m-0 border-0">'
                          . $parent_stuff
                          . '</li>'
                          ;

                        /**************************************************************************/
                        // The child stuff.
                        $child_li_items_array = array();
                        if (isset($value['child'])) {
                          foreach ($value['child'] as $key => $value) {

                            /************************************************************************/
                            // Set the parent stuff.
                            $child_count = (isset($value['parent']['count']) && !empty($value['parent']['count']) ? ' (' . $value['parent']['count'] . ')' : null);
                            $child_link = (isset($value['parent']['link']) ? $value['parent']['link'] : null);
                            $child_slug = (isset($value['parent']['slug']) ? $value['parent']['slug'] : null);
                            $child_name = (isset($value['parent']['name']) ? $value['parent']['name'] : null);
                            $child_stuff = $child_name . ($show_counts && !empty($child_count) ? $child_count : null);

                            /************************************************************************/
                            // Set the parent stuff.
                            if (!empty($child_link)) {
                              $child_stuff = 
                                  '<a href="' . $child_link  .'" class="text-decoration-none text-darkblue text-georgia-regular">'
                                . $child_stuff
                                . '</a>'
                                ;  
                            } // if

                            /**********************************************************************/
                            // Wrap it all up in LI tags.
                            $child_stuff =
                                '<li class="list-group-item fw-regular col col-12 p-0 m-0 border-0">'
                              . $child_stuff
                              . '</li>'
                              ;

                            /**********************************************************************/
                            // Set the final child items array item.
                            $child_li_items_array[$parent_slug][] = $child_stuff;

                          } // foreach
                        } // if

                        /**************************************************************************/
                        // Wrap it all up in UL tags.
                        foreach ($child_li_items_array as $key => $value) {
                          $parent_stuff .=
                              '<ul class="list-group-off p-0 m-0 ms-3 rounded-0">'
                            . implode('', $value)
                            . '</ul>'
                            ;
                        } // foreach

                        /**************************************************************************/
                        // Wrap it all up in LI tags. 
                        $parent_final = $parent_stuff;

                        /**************************************************************************/
                        // Set the final parent items array item.
                        $parent_li_items_array[$parent_slug][] = $parent_final;

                      } // foreach

                      /******************************************************************************/
                      // Wrap it all up in UL tags.
                      if (!empty($parent_li_items_array)) {
                        $catergories = '<ul class="categories_sidebar small col col-12 list-group-off p-0 m-0 rounded-0">';
                        foreach ($parent_li_items_array as $key => $value) {
                          $catergories .= implode('', $value);
                        } // foreach
                        $catergories .= '</ul>';
                      } // if

                      /******************************************************************************/
                      // Render the archives.
                      echo $catergories;

                    ?>
                    </div>
                    <div class="tab-pane" id="nav-archives" role="tabpanel" aria-labelledby="nav-archives-tab">
                    <?php

                      /******************************************************************************/
                      // Set the category arguments.
                      $archive_args = array();
                      $archive_args['format'] = 'html';
                      $archive_args['show_post_count'] = false;
                      $archive_args['echo'] = false;
                      $archive_args['type'] = 'monthly';
                      // $archive_args['type'] = 'yearly';
                      // $archive_args['type'] = 'daily';
                      // $archive_args['year'] = 2024;
                      // $archive_args['monthnum'] = 07;
                      // $archive_args['day'] = 04;
                      // $archive_args['w'] = 01;

                      /******************************************************************************/
                      // Get the archives.
                      $archives = wp_get_archives($archive_args);

                      /******************************************************************************/
                      // Do stuff with the archives content.
                      $archives = str_replace('<li>', '<li class="list-group-item fw-bold text-nowrap col col-12 p-0 m-0 border-0">', $archives);
                      $archives = str_replace('<a href=', '<a class="text-decoration-none text-darkblue text-georgia-regular" href=', $archives);

                      /******************************************************************************/
                      // Wrap it all up in UL tags.
                      $archives = '<ul id="archives" class="archives_sidebar small list-group-off p-0 m-0 rounded-0">' . $archives . '</ul>';

                      /******************************************************************************/
                      // Render the archives.
                      echo $archives;

                    ?>
                    </div>
                  </div>
                </div>
              </div>

           </div>
          </div>
        </div> 

      </div>
    </div>
  </div>
  <!-- Footer Content END -->

<?php

  /**************************************************************************************************/
  // Set the footer array items.
  $footer_items_array = array();
  $footer_items_array[] = '<a href="/" title="Home" class="text-offwhite m-0 p-0"><span property="name" class="text-offwhite fa fa-home"></span></a>';
  $footer_items_array[] = '<a href="/about" title="About" class="text-offwhite m-0 p-0">About</a>';
  $footer_items_array[] = '<a href="/tech" title="Tech Notes" class="text-offwhite m-0 p-0">Tech Notes</a>';
  $footer_items_array[] = '<a href="/notes" title="Personal Notes" class="text-offwhite m-0 p-0">Personal Notes</a>';
  $footer_items_array[] = '<a href="/contact" title="Contact" class="text-offwhite m-0 p-0">Contact</a>';
  $footer_items_array[] = '<a href="/resume" title="Résumé" class="text-offwhite m-0 p-0">Résumé</a>';
  $footer_items_array[] = '<a href="/bookmarks" title="Bookmarks" class="text-offwhite m-0 p-0">Bookmarks</a>';
  // $footer_items_array[] = '<a href="#" title="top of page" class="text-offwhite m-0 p-0">Top of Page</a>';
  $footer_items_array[] = '<span class="text-offwhite m-0 p-0">Site design and contents &copy; ' . date('Y') . ' Jack Szwergold</span>';

  /**************************************************************************************************/
  // Set the footer divider item.
  $footer_divider = '<span class="text-offwhite m-0 p-0 px-2">&bull;</span>';

  /**************************************************************************************************/
  // Set the footer array items.
  foreach ($footer_items_array as $key => $value) {
    $footer_items_array[$key] =
        '<li class="list-inline-item text-nowrap p-0 m-0">'
      . '<span class="fst-italic d-none d-md-block">'
      . $value
      . '</span>'
      . '<span class="small fst-italic d-md-none">'
      . $value
      . '</span>'
      . '</li>'
      ;
  } // foreach

  /**************************************************************************************************/
  // Set the footer string.
  $footer_items_string = implode($footer_divider, $footer_items_array);

?>

  <footer class="footer fixed-bottom p-0 m-0 px-3 bg-darkblue">
    <div class="col col-12 p-0 m-0 px-2 py-3">
      <div class="h6 text-georgia-regular p-0 m-0">
        <ul id="footer_links" class="footer_links list-inline p-0 m-0">
          <?php
            echo $footer_items_string;
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