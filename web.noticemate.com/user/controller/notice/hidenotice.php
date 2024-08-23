<?php

class ControllerNoticeHideNotice extends Controller {
  public function index() {
    if( isset($this->request->post['nid']) ) {
      $notice_id = (int)$this->request->post['nid'];

      $this->loader->model('notice');
      $getnotice_model = $this->registry->get('model_notice');

      $insert_status = $getnotice_model->hideNotice( $notice_id );

      if( $insert_status === 'not-authorized' ) {
        $output = array( 'status' => false, 'error' => 'You are not authorized to hide this notice !' );
      } elseif ( $insert_status === false ) {
        $output = array( 'status' => false, 'error' => 'There is something error in this notice ! <br> Refresh the page and try again !' );
      } elseif( $insert_status === 'already-exist' ) {
        $output = array( 'status' => false, 'error' => 'Content is already hidden !' );
      } elseif ( $insert_status === true ) {
        $output = array( 'status' => true, 'content_hides' => 'notice-' . $notice_id );
      }
    } else $output = array( 'status' => false, 'error' => 'No any <b>notice</b> is found !' );
    echo json_encode($output);
  }
}

?>