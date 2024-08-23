<?php

require( $_SERVER['DOCUMENT_ROOT'] . "/user/model/modules.php" );

if( $user->isLogged() === true ) {

} else exit();

//image
$registry->set('img', new Image());

/*defined settings - start*/
ini_set("memory_limit", "99M");
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);
define('IMAGE_SMALL_DIR', $_SERVER['DOCUMENT_ROOT'] . '/uploades/small/');
define('IMAGE_SMALL_SIZE', 50);
define('IMAGE_MEDIUM_DIR', $_SERVER['DOCUMENT_ROOT'] . '/uploades/medium/');
define('IMAGE_MEDIUM_SIZE', 250);
/*defined settings - end*/

if( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {

  if( isset($_FILES['image_upload_file']) && isset($request->post['update_to']) && strlen($request->post['update_to']) == 14 ){
    $loader->controller("upload/uploadprofile");
  }
  
  if( isset($_FILES['notice_post_img']) && $request->post['notice_img_upload'] && $request->post['notice_img_upload'] == 'upload' ) {
    $loader->controller("upload/uploadnoticeimage");
  }

  if( !empty($_FILES['attachment']) ) {
    $loader->controller("upload/uploadattachment");
  }

} else {
  $output['status'] = false;
  $output['error'] = 'Oops! It looks like that file is not selected correctly!';
}


?>