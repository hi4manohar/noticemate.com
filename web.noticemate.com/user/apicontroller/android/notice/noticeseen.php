<?php

class ControllerNoticeNoticeseen extends Controller {

  public function index() {
    if( isset($this->request->post['ci']) && isset($this->request->post['bi']) && strlen($this->request->post['bi']) == 10 ) {
      $this->loader->model('notice');
      $getnotice_model = $this->registry->get('model_notice');
      $insertStatus = $getnotice_model->insertNoticeSeen($this->request->post['ci'], $this->request->post['bi']);
      if( is_numeric($insertStatus) ) {
        $output = array('status' => 200, 'msg' => 'Sucssfully Seen!');
      } elseif ( $insertStatus == 'not-authorized' ) {
        $output = array( 'status' => 401, 'error' => 'Not authorized to update seen!' );
      } else {
        $output = array('status' => 200, 'error' => 'Already Seen!');
      }
    } else {
      $output = array('status' => 400, 'error' => 'Wrong board selected!');
    }
    echo isset($output) ? json_encode($output) : '';
  }
}

?>