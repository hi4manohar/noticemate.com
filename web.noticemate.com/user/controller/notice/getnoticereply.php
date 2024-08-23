<?php

class ControllerNoticeGetNoticeReply extends Controller {
  public function index() {
    if( isset($this->request->post['nid']) ) {
      $notice_id = $this->request->post['nid'];

      //check if limit is set or not
      if( isset($this->request->post['page']) ) {
        $page = (int) $this->request->post['page'];
        if( $page == 0 ) {
          $limit = array(
            'slimit' => $page,
            'elimit' => 5
            );
        } else {
          $slimit = ($page) * 5;
          $elimit = 5;
          $limit = array(
            'slimit' => $slimit,
            'elimit' => $elimit
            );
        }
      } else $limit = array('slimit' => 0, 'elimit' => 9 );

      $this->loader->model('notice');
      $getnotice_model = $this->registry->get('model_notice');

      $get_reply_status = $getnotice_model->getReply( $notice_id, $limit );

      if( is_array($get_reply_status) ) {

        echo $this->loader->view('/middle/comment.php', array(
          'reply_data' => $get_reply_status
        ));

      } else $output = array('status' => false, 'error' => 'No any reply exist!');

      echo (isset($output)) ? json_encode($output) : '';
    }
  }
}

?>