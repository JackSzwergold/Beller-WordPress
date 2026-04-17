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

  /**************************************************************************************************/
  // Get the site URL.
  $site_url = get_site_url();

  /**************************************************************************************************/
  // Anchor links for the homepage and regular links for other pages.
  $site_url = is_front_page() ? $site_url . '#' : $site_url . '/';

  /**************************************************************************************************/
  // Set the footer array items.
  $footer_items_array = array();
  // $footer_items_array[] = '<a href="' . $site_url . '" title="Home" class="text-dark m-0 p-0"><span property="name" class="text-dark fa fa-home"></span></a>';
  $footer_items_array['books'] = '<a href="' . $site_url . 'books" title="Books" class="text-dark m-0 p-0">Books</a>';
  $footer_items_array['tour'] = '<a href="' . $site_url . 'events" title="Tour/Events" class="text-dark m-0 p-0">Tour/Events</a>';
  $footer_items_array['editoral'] = '<a href="' . $site_url . 'editoral" title="Editoral Services" class="text-dark m-0 p-0">Editoral Services</a>';
  $footer_items_array['articles'] = '<a href="' . $site_url . 'articles" title="Articles" class="text-dark m-0 p-0">Articles</a>';
  $footer_items_array['newsletter'] = '<a href="' . $site_url . 'newsletter" title="Newsletter" class="text-dark m-0 p-0">Newsletter</a>';

  /**************************************************************************************************/
  // Set the footer divider item.
  $footer_divider = '<span class="text-dark m-0 p-0 px-2">&bull;</span>';

  /**************************************************************************************************/
  // Set the footer array items.
  foreach ($footer_items_array as $key => $value) {
    $footer_items_array[$key] =
        '<li class="list-inline-item text-nowrap p-0 m-0">'
      . '<span class="d-none d-md-block h5 text-clashgrotesk-regular p-0 m-0">'
      . $value
      . '</span>'
      . '<span class="small d-md-none">'
      . $value
      . '</span>'
      . '</li>'
      ;
  } // foreach

  /**************************************************************************************************/
  // Set the footer string.
  $footer_items_string = implode($footer_divider, $footer_items_array);

?>

  <footer class="fixed-bottom p-0 m-0 px-3 bg-white">
    <div class="col col-12 p-0 m-0 px-2 py-3">
      <div class="h6 text-clashgrotesk-regular text-center p-0 m-0">
        <ul class="list-inline p-0 m-0">
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