<?php
  require( './blog/wp-load.php' );
  get_header();
  echo 'new content outside WordPress';
print_r(wp_get_current_user());
  get_footer();

