<?php

require( $_SERVER['DOCUMENT_ROOT'] . "/user/model/modules.php" );

/*
@ without cookie array index defined that this query is not required previous user data
*/
$core_action_controller = array(
  'postmod' => array(
    'do_login'              => 'app/login',
    'do_signup'             => 'app/signup',
    'forgotpass'            => 'app/forgotpass',
    'notice'                => 'notice/boardnotice',
    'profile'               => 'profile/userprofile',
    'all_members'           => 'board/allmembers',
    'download'              => 'download/filedownload',
    'logout'                => 'user/logout',
    'create_notice'         => 'notice/createnotice',
    'notice_seen'           => 'notice/noticeseen',
    'member_profile'        => 'profile/memberprofile',
    'my_profile'            => 'profile/myprofile',
    'generate_board'        => 'board/generateboard',
    'update_left_side'      => 'board/updateleftright',
    'update_right_side'     => 'board/updateleftright'
    ),
  'withoutcookie' => array(
    'do_login' , 'do_signup', 'forgotpass'
    )
  );

if( $_SERVER["REQUEST_METHOD"] == "POST" ) {

  //verify cookie data
  if( isset($request->post['mod']) && in_array($request->post['mod'], $core_action_controller['withoutcookie']) ) {

  } else {
    if( isset($request->post['cookie_val']) ) {
      $_COOKIE['id'] = $request->post['cookie_val'];
    } else {
      $output = array( 'status' => 401, 'error' => 'Unauthorized Access!' );
      echo json_encode($output);
      exit();
    }

    $loggedin_status = $user->isLogged();  
    if( $loggedin_status === true ) {

    } else {
      $output = array( 'status' => 401, 'error' => 'Unauthorized Access!' );
      echo json_encode($output);
      exit();
    }
  }

  header('Content-Type: application/json');  

  if( isset($request->post['mod']) && !is_null($request->post['mod']) ) {
    if( array_key_exists($request->post['mod'], $core_action_controller['postmod']) ) {
      $loader->controller( $core_action_controller['postmod'][ $request->post['mod'] ], array('dir'=>'androidapi') );
    }
  }
}
?>