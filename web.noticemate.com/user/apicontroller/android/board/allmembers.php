<?php

class ControllerBoardAllMembers extends Controller {

  public function index() {
    if( isset($this->request->post['bid']) && $this->inputest->verifyBoard($this->request->post['bid']) ) {

      //verify board
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $board_detail = $getboard_model->boardDetail( $this->request->post['bid'] );

      if( $board_detail !== false ) {
        //boarmembers
        $board_members = $getboard_model->boardMembers( $this->request->post['bid'] );

        $output = array(
          'status'        => 200,
          'board_members' => $board_members,
          'board_detail'  => $board_detail,
          'loggedin_user' => $this->user->user_id
          );
      } else $output = array('status' => 422, 'error' => 'We could\'t get the right board!');
    } else $output = array('status' => 422, 'error' => 'We could\'t get the right board!');
    echo isset($output) ? json_encode($output) : '';
  }
}

?>