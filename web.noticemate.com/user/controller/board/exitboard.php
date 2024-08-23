<?php

class ControllerBoardExitboard extends Controller {

  public function index() {
    if( isset($this->request->post['bi']) && $this->inputest->verifyBoard($this->request->post['bi']) ) {

      $bid = $this->request->post['bi'];

      //load board module and exit user from board
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $exit_status = $getboard_model->exitFromBoard( $bid );
      if( is_array($exit_status) && $exit_status !== false ) {

        /*
        @ if user is exited successfully from the board then
        @ a notification will be shooted in the board admin notification box
        */
        $this->loader->model( "notification" );
        $getnotif_model = $this->registry->get('model_notification');
        $notif_add_status = $getnotif_model->userExitedFromBoard( $exit_status['board_admin'], $exit_status['board_id'] );

        if( $notif_add_status === true ) {
          $output = array( 'status' => true, 'msg' => 'You are now moved from this board!' );
        } else {
          $output = array( 'status' => false, 'error' => 'Notification could\'t be reached to the admin!' );
        }

      } else $output = array('status' => false, 'error' => 'You are not a member of this board!');
    } else $output = array('status' => false, 'error' => 'Board is not verified!');
    echo json_encode($output);
  }
}

?>