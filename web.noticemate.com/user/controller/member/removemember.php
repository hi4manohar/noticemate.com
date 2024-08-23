<?php

class ControllerMemberRemovemember extends Controller {

  public function index() {
    if( isset($this->request->post['ui']) && isset($this->request->post['bi']) ) {
      if( strlen($this->request->post['ui']) == 10 && $this->inputest->verifyBoard($this->request->post['ui']) ) {
        /*
        @load board model
        @execute removeMember method
        */
        $this->loader->model('board');
        $getboard_model = $this->registry->get('model_board');
        $remove_status = $getboard_model->removeBoardMember($this->request->post['ui'], $this->request->post['bi']);
        if( $remove_status == true ) {

          //load notification model for notification update
          $this->loader->model('notification');
          $notif_model = $this->registry->get('model_notification');
          $notif_model->userRemovalFromBoardNotif( $this->request->post['ui'], $this->request->post['bi'] );

          $output = array('status' => true);
        } else $output = array('status' => false, 'error' => 'You are not allowed to remove the user from this board!');
      } else $output = array('status' => false, 'error' => 'It seems like user and board is not exist');
    } else {
      $output = array('status' => false, 'error' => 'User and Board does\'t exist!');
    }
    echo json_encode($output);
  }
}

?>