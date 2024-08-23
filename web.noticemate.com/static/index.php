<?php

if( isset($_GET['e_type']) ) {
  require( $_SERVER['DOCUMENT_ROOT'] . "/user/model/modules.php" );

  ob_start("sanitize_output");

  if( $_GET['e_type'] == 'badbrowser' )
    require( 'badbrowser.tpl' );
  elseif( $_GET['e_type'] == '404' )
    require( '404.tpl' );
  else
    exit();

  $output = ob_get_contents();

  ob_end_clean();

  echo sanitize_output($output);
}
?>