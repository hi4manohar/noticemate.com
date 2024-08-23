<?php

require( $_SERVER['DOCUMENT_ROOT'] . "/user/model/modules.php" );

function getVerifiedRequest( $user, $response ) {
  //check if user is looged or not
  if( ! $user->isLogged() === true ) {
    $response = new Response();
    $response->redirect("/");
    exit();
  }
}

$core_action_get = array( 'notice', 'profile', 'all_members', 'download', 'logout', 'get_left_update_notice' );

$core_action_post = array(
  'mod' => array( 'create_notice', 'notice_seen', 'remove_member', 'member_profile', 'update_board_subject', 'update_board_status', 'exit_board', 'update_member_subject', 'update_member_status', 'update_left_side', 'create_board', 'generate_board', 'update_right_side', 'delete_board', 'join_board', 'membership_detail', 'my_profile', 'notice_see_list', 'fwd_notice', 'hide_notice', 'get_forward_data', 'do_reply', 'get_notice_reply', 'replyoff', 'get_notification', 'single_notice', 'urfb', 'mjib', 'fb_login', 'board_privacy', 'attend-reply', 'get_event_attend_detail', 'replyon', 'mefb' )
  );

$core_action_controller = array(
  'getmod' => array(
    'notice'                  => 'notice/boardnotice',
    'profile'                 => 'profile/userprofile',
    'all_members'             => 'board/allmembers',
    'download'                => 'download/filedownload',
    'logout'                  => 'user/logout',
    'get_left_update_notice'  => 'board/updateleftright/follUpdatedNotice'
    ),
  'postmod' => array(
    'create_notice'           => 'notice/createnotice',
    'notice_seen'             => 'notice/noticeseen',
    'remove_member'           => 'member/removemember',
    'member_profile'          => 'profile/memberprofile',
    'my_profile'              => 'profile/myprofile',
    'update_board_subject'    => 'subject/updatesubject',
    'update_board_status'     => 'subject/updatesubject',
    'update_member_subject'   => 'subject/updatesubject',
    'update_member_status'    => 'subject/updatesubject',
    'exit_board'              => 'board/exitboard',
    'update_left_side'        => 'board/updateleftright',
    'update_right_side'       => 'board/updateleftright',
    'create_board'            => 'board/createboard',
    'generate_board'          => 'board/generateboard',
    'delete_board'            => 'board/deleteboard',
    'join_board'              => 'board/joinboard',
    'membership_detail'       => 'member/membershipplan',
    'notice_see_list'         => 'notice/noticeseenlist',
    'hide_notice'             => 'notice/hidenotice',
    'get_forward_data'        => 'board/forwardableboard',
    'fwd_notice'              => 'notice/forwardnotice',
    'do_reply'                => 'notice/noticereply',
    'get_notice_reply'        => 'notice/getnoticereply',
    'replyoff'                => 'notice/noticereplyoff',
    'replyon'                 => 'notice/noticereplyoff',
    'get_notification'        => 'user/usernotification',
    'single_notice'           => 'notice/boardnotice/singlenoticedata',
    'urfb'                    => 'user/usernotification/updateNotifSeen',
    'mjib'                    => 'user/usernotification/updateNotifSeen',
    'mefb'                    => 'user/usernotification/updateNotifSeen',    
    'board_privacy'           => 'board/privacy',
    'attend-reply'            => 'notice/attendreply',
    'get_event_attend_detail' => 'notice/eventattenddetail',
    ),
  'withoutLogin' => array(
    'get_min_asset'   => 'view/assetmin',
    'fb_login'        => 'app/login/fbLogin'
    )
  );

if( $_SERVER["REQUEST_METHOD"] == "GET" ) {
    
  if( isset($request->get['mod']) && !is_null($request->get['mod']) ) {

    $module = $request->get['mod'];
    
    if( array_key_exists($module, $core_action_controller['getmod']) ) {
      getVerifiedRequest($user, $response);
      $loader->controller( $core_action_controller['getmod'][ $module ] );
    }

    //check if request is for without login
    if( array_key_exists($module, $core_action_controller['withoutLogin']) ) {
      $loader->controller( $core_action_controller['withoutLogin'][ $module ] );
    }
  }

}

if( $_SERVER["REQUEST_METHOD"] == "POST" ) {

  if( isset($request->post['mod']) && !empty($request->post['mod']) ) {

    $module = $request->post['mod'];

    if( array_key_exists($module, $core_action_controller['postmod']) ) {
      getVerifiedRequest($user, $response);
      $loader->controller( $core_action_controller['postmod'][ $module ] );
    }

    //check if request is for without login
    if( array_key_exists($module, $core_action_controller['withoutLogin']) ) {
      $loader->controller( $core_action_controller['withoutLogin'][ $module ] );
    }
  }

}

?>