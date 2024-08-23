<?php

class ControllerBoardAllMembers extends Controller {

  public function index() {
    if( isset($this->request->get['bid']) && $this->inputest->verifyBoard($this->request->get['bid']) ) {

      //verify board
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $board_detail = $getboard_model->boardDetail( $this->request->get['bid'] );

      if( $board_detail !== false ) {
        //boarmembers
        $board_members = $getboard_model->boardMembers( $this->request->get['bid'] );
        
        $data['board_members'] = $board_members;
        $data['board_detail']  = $board_detail;
        $data['user']          = $this->user;

        echo $this->loader->view('/right/' . $this->request->get['mod'] . '.php', $data);

      } else $output = array('status' => false, 'error' => 'We could\'t get the right board!');
    } else $output = array('status' => false, 'error' => 'We could\'t get the right board!');
    echo isset($output) ? json_encode($output) : '';
  }
}

?>