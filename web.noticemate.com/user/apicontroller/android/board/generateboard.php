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
          if( $create_status === 'not-allowed' ) {
            $output = array('status' => 401, 'error' => 'You cannot create new board more than allowed board!');
          } elseif( $create_status === "Mismatch-Board" ) {

            $output = array( 'status' => 403, 'error' => 'Mismatch boardId! Please try again later!' );

          } else {
            $output = array('status' => 200, 'board_id' => $create_status);
          }          
        } else $output = array('status' => 403, 'error' => 'Board Exist or Could\'t be created!');
      } else $output = array('status' => 400, 'error' => 'Board name and distribution ID does\'t seems like like correct! Please review it!');

    } else $output = array('status' => 403, 'error' => 'Board name is not set!');
    echo isset($output) ? json_encode($output) : '';
  }
}

?>