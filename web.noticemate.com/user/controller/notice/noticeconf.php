<?php

class ControllerNoticeNoticeConf extends Controller {

  public function turOffReply( $nid ) {

    //check if loggedin user is admin of the notice
    $user_id = $this->user->user_id;

    $this->loader->model('notice');
    $getnotice_model = $this->registry->get('model_notice');
    $notice_detail = $getnotice_model->isAdminofNotice( $user_id, $nid );

    if( is_array($notice_detail) && $notice_detail !== false ) {

      //update reply off
      $this->db->query( "UPDATE `nm_boardcont` SET `reply_allow`='0' WHERE `content_id` = '" . $nid . "' AND `posted_by` = '" . $user_id . "'" );

      if( $this->db->countAffected() == 1 ) {
        $output = array( 'status' => true );
      } else $output = array( 'status' => false, 'error' => 'Getting reply already turned off for this notice' );
      
    } else {
      $output = array( 'status' => false, 'error' => 'You are not allowed to reply this notice !' );
    }

    echo json_encode( isset($output) ? $output : '' );

  }

  public function turnOnReply( $nid ) {

    //check if loggedin user is admin of the notice
    $user_id = $this->user->user_id;

    $this->loader->model('notice');
    $getnotice_model = $this->registry->get('model_notice');
    $notice_detail = $getnotice_model->isAdminofNotice( $user_id, $nid );

    if( is_array($notice_detail) && $notice_detail !== false ) {

      //update reply off
      $this->db->query( "UPDATE `nm_boardcont` SET `reply_allow`='1' WHERE `content_id` = '" . $nid . "' AND `posted_by` = '" . $user_id . "'" );

      if( $this->db->countAffected() == 1 ) {
        $output = array( 'status' => true );
      } else $output = array( 'status' => false, 'error' => 'Getting reply already turned on for this notice' );
      
    } else {
      $output = array( 'status' => false, 'error' => 'You are not allowed to reply this notice !' );
    }

    echo json_encode( isset($output) ? $output : '' );

  }
}

?>