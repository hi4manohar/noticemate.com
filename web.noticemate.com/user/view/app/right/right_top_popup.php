<?php

function rightTopPopupData() {
  /*
    @ all popup data is defined here
    @ to add anything extra - add key and value with every list data
  */
  $rightTopPopup = array(
    'create_board' => array(
      'class'      => 'fa-user-plus',
      'link'       => 'javascript:void(0);',
      'link_text'  => 'Create Board',
      'id'         => 'create-board'
    ),
    'join_board'  => array(
      'class'     => 'fa-sign-in',
      'link'      => 'javascript:void(0);',
      'link_text' => 'Join Board',
      'id'        => 'join-board'
    ),
    /*
    'all_board'  => array(
      'class'     => 'fa-globe',
      'link'      => '/page.php?page=all_boards',
      'link_text' => 'All Board'
    ),
    */
    'my_profile' => array(
      'class'     => 'fa-user',
      'link'      => 'javascript:void(0);',
      'link_text' => 'My Profile',
      'id'        => 'member-profile'
    ),
    'boards_plans' => array(
      'class'     => 'fa-star-o',
      'link'      => 'javascript:void(0)',
      'link_text' => 'Your Plans',
      'id'        => 'membership-plan'
    ),
    'log_out'     => array(
      'class'     => 'fa-sign-out',
      'link'      => '/app.php?mod=logout',
      'link_text' => 'Logout'
    )
  );
  return $rightTopPopup;
}

function createdBoardPopupData() {
  $right_popup_data = array(
    'send_notice' => array(
      'class'      => 'fa-paper-plane',
      'link'       => 'javascript:void(0);',
      'link_text'  => 'Send Notice'
    ),
    'view_profile'  => array(
      'class'     => 'fa-user',
      'link'      => 'javascript:void(0);',
      'link_text' => 'View Profile',
      'id'        => 'foll_bo_prof'
    ),
    'all_members' => array(
      'class'      => 'fa-users',
      'link'       => '#',
      'link_text'  => 'All Members',
      'id'         => 'foll_bo_all_mem'
    ),
    'view_details' => array(
      'class'      => 'fa-info',
      'link'       => '#',
      'link_text'  => 'View Details',
      'id'         => ''
    )
  );
  return $right_popup_data;
}

/*
  @ Created Board Memeber popup Data
*/
function createdBMPData() {
  $memberPopupData = array(
    'remove_member' => array(
      'class'      => 'fa-paper-plane',
      'link'       => '',
      'link_text'  => 'Remove User'
    ),
    'view_profile'  => array(
      'class'     => 'fa-user',
      'link'      => 'javascript:void(0);',
      'link_text' => 'View Profile',
      'id'        => 'foll_bo_prof'
    )
  );

  return $memberPopupData;
}

?>