<!-- Sidebar BEGIN -->
<?php

/**********************************************************************************************/
// If we have a widget sidebar, show the widget sidebar.
if (is_active_sidebar('widget-sidebar-1')) {
	echo '<div class="p-0 m-0 mx-0">';
	dynamic_sidebar('widget-sidebar-1');
	echo '</div>';
} // if

?>
<!-- Sidebar END -->