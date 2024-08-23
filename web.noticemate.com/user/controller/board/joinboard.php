<?php

class ControllerBoardJoinBoard extends Controller {

  public function index() {
    if( isset($this->request->post['bdi']) && isset($this->request->post['bname']) ) {

      $bdi = $this->inputest->trimTitle($this->request->post['bdi']);
      $bname = $this->inputest->trimTitle($this->request->post['bname']);

      if( strlen($bdi) == 16 && strlen($bname) > 5 ) {
        //load board model and verify if both are correct add to board user
        $this->loader->model('board');
        $getboard_model = $this->registry->get('model_board');
        $add_status = $getboard_model->joinBoard( $bdi, $bname );

        if( is_array($add_status) && $add_status['status'] === true ) {

          /*
          @ if user is joined successfully in board then insert it's notification
          @ load notification model
          @ call userJoinedInBoardNotif Method
          */
          $this->loader->model( "notification" );
          $getnotif_model = $this->registry->get('model_notification');
          $notif_add_status = $getnotif_model->userJoinedInBoardNotif( $add_status['board_admin'], $add_status['board_id'] );

          if( $notif_add_status == false ) {

            $output = array( 'status' => false, 'error' => 'You have joined in board successfully! <br> But it seems like notification can\'t be reach to the admin.' );

          } else {
            $output = array( 'status' => true );
          }

        } elseif ( $add_status === 'joining-not-allowed' ) {
          $output = array( 'status' => false, 'error' => 'Joining more member to this board is not allowed!' );
        } elseif( $add_status === 'not-exist' ) {
          $output = array( 'status' => false, 'error' => 'Board is not exist! <br>That may be you are entering wrong Board Name and Board Distribution ID' );
        } elseif( $add_status === 'already-member' ) {
          $output = array( 'status' => false, 'error' => 'You are already a member of this board!' );
        } elseif ( $add_status === 'insert-error' ) {
          $output = array( 'status' => false, 'Found an error in creating this board member!' );
        }

      } else $output = array( 'status' => false, 'error' => '<b>Board</b> ID and Name is Incorrect!' );

    } else $output = array( 'status' => false, 'error' => '<b>Board</b> ID and Name is Incorrect!' );
    echo isset($output) ? json_encode($output) : '';
  }
}

?>