<?php

class ControllerProfileUserProfile extends Controller {

  public function index() {
    if( isset($this->request->get['bid']) && $this->inputest->verifyBoard($this->request->get['bid']) ) {

      //verify board
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $board_detail = $getboard_model->boardDetail( $this->request->get['bid'] );

      echo $this->loader->view('/right/' . $this->request->get['mod'] . '.php', array(
        'board_detail' => $board_detail,
        'user'         => $this->user
        ));
    } else {
      $output = array('status' => false, 'error' => 'Could\'t load profile!');
    }
    echo ( isset($output) ) ? json_encode($output) : '';
  }
}

?>