<?php

class ControllerBoardGenerateBoard extends Controller {

  public function index() {

    if( isset($this->request->post['bname']) && isset($this->request->post['bdi']) ) {
      $bname = $this->request->post['bname'];
      $bdi = $this->request->post['bdi'];

      if( strlen($bname) > 5 && strlen($bdi) == 16 ) {
        //load board module and exit user from board
        $this->loader->model('board');
        $getboard_model = $this->registry->get('model_board');
        $create_status = $getboard_model->createBoard( $bname, $bdi );

        if( $create_status !== false ) {
          if( $create_status == 'not-allowed' ) {
            $output = array('status' => false, 'error' => 'You cannot create new board more than allowed board!');
          } else {
            $output = array('status' => true, 'board_id' => $create_status);
          }          
        } else $output = array('status' => false, 'error' => 'Board Exist or Could\'t be created!');
      } else $output = array('status' => false, 'error' => 'Board name and distribution ID does\'t seems like like correct! Please review it!');

    } else $output = array('status' => false, 'error' => 'Board name is not set!');
    echo json_encode($output);
  }
}

?>