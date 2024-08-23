<?php

require( $_SERVER['DOCUMENT_ROOT'] . "/user/model/modules.php" );

//check if user is looged or not
$loggedin_status = $user->isLogged();
if( $loggedin_status === true ) {
  /*
  @load app if already logged in
  */
  define( 'LOADAPP', true );
  $loader->controller( "app/load/loadApp");
  exit();
} elseif ( $loggedin_status === 'logout' ) {

  $response = new Response();
  $response->redirect("/app.php?mod=logout");
} else {
  /*
  @using query handling file and app loading class
  */
  require( USER_CONTR_DIR . '/index_query_handle.php' );
  $loader->controller( "app/load/loadApp" );
  exit();
}

?>