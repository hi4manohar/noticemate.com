<?php

class ControllerBoardDeleteBoard extends Controller {

  public function index() {
    if( isset($this->request->post['bid']) && strlen($this->request->post['bid']) ) {
      //load board model and check if user is created that board or not
      $bid = $this->request->post['bid'];
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $delete_status = $getboard_model->deleteBoard( $bid );

      if( $delete_status === true ) {
        $output = array( 'status' => true );
      } else $output = array( 'status' => false, 'You are not authorized to delete this <b>Board</b>' );
    } else $output = array( 'status' => false, 'error' => '<b>Board</b> could\'t be verified!' );
    echo json_encode($output);
  }
}

?>