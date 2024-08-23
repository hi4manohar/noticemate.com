<?php

class ControllerNoticeAttendReply extends Controller {
  public function index() {
    if( isset($this->request->post['notice_id']) && is_numeric($this->request->post['notice_id']) ){
      if( isset($this->request->post['repcont']) ) {

        $notice_id = $this->request->post['notice_id'];
        $attend_reply = $this->request->post['repcont'];

        if( $attend_reply == 'yes' ) {

          $user_id = $this->user->user_id;

          $attend_reply_status = $this->doAttendReply( $notice_id, $attend_reply );

          if( $attend_reply_status === true ) {

            $output = array( 'status' => true );

          } elseif( $attend_reply_status === 'reply-exist' ) {
            $output = array( 'status' => false, 'error' => 'Oh! You already replied to this event for attending!' );
          } else{
            $output = array( 'status' => false, 'error' => 'You are not authorized to submit attend reply!' );
          }

        } else $output = array( 'status' => false, 'error' => 'Reply data is not correct!' );
      } else $output = array( 'status' => false, 'error' => 'Reply data is not correct!' );
    } else $output = array( 'status' => false, 'error' => 'We could\'t found this notice! <br> Please refresh the page and try again!' );

    echo isset($output) ? json_encode($output) : '';
  }

  public function doAttendReply( $notice_id, $attend_reply ) {

    $this->loader->model('notice');
    $getnotice_model = $this->registry->get('model_notice');

    $insert_status = $getnotice_model->insertReply( $notice_id, $attend_reply, false, 13 );

    return $insert_status;

  }
}

?>