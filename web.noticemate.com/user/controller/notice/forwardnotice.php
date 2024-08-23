<?php

class ControllerNoticeForwardNotice extends Controller {
  public function index() {

    if( isset($this->request->post['bid']) && isset($this->request->post['nid']) ) {
      $board_id = $this->request->post['bid'];
      $notice_id = (int)$this->request->post['nid'];
  
      if( strlen($board_id) && $notice_id !== 0 ) {
  
        $this->loader->model('notice');
        $getnotice_model = $this->registry->get('model_notice');
  
        $fwd_status = $getnotice_model->forwardNotice( $notice_id, $board_id );
  
        if( $fwd_status === 'already-exist' ):
          $output = array( 'status' => false, 'error' => 'You have already forwarded this notice! <br> We do not allow forwarding the same notice more than one time!' );
        elseif( $fwd_status === 'not-authorized' ):
          $output = array( 'status' => false, 'error' => 'Sorry! You are not authorized to forward this notice to this board!' );
        elseif( $fwd_status === false ):
          $output = array( 'status' => false, 'error' => 'Oops! We found some unknown error in forwarding your notice! <br>Please reload page and try again!' );
        elseif( $fwd_status === true ): {
          $output = array( 'status' => true );
        }
        endif;
  
        } else $output = array( 'status' => false, 'error' => 'We could\'t found this notice!' );
  
      echo json_encode($output);
    }
  }
}

?>