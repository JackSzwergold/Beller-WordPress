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
    // Set the navigaton string.
    $nav_items_string = render_navigation_items();

  ?>

  <footer class="fixed-bottom p-0 m-0 pt-2 pb-3 bg-beige">
    <div class="col col-12 p-0 m-0">
      <div class="text-center p-0 m-0">
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