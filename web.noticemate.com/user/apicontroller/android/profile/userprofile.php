<?php

class ControllerProfileUserProfile extends Controller {

  public function index() {
    if( isset($this->request->post['bid']) && $this->inputest->verifyBoard($this->request->post['bid']) ) {

      //verify board
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $board_detail = $getboard_model->boardDetail( $this->request->post['bid'] );

      $output = array(
        'status' => 200,
        'board_detail' => $board_detail,
        'loggedin_user'  => $this->user->user_id
        );
    } else {
      $output = array('status' => 404, 'error' => 'Could\'t load profile!');
    }
    echo ( isset($output) ) ? json_encode($output) : '';
  }
}

?>