<?php

class ControllerBoardPrivacy extends Controller {

  public function index() {

    //check if member_allow && boardid is set and correct
    if( isset($this->request->post['member_allow']) && isset($this->request->post['board_id']) ) {
      $member_allow = $this->inputest->trimTitle( $this->request->post['member_allow'] );
      $board_id_status = $this->inputest->verifyBoard( $this->request->post['board_id'] );

      if( $board_id_status !== false && ( $member_allow == 1 || $member_allow == 0 ) ) {

        $board_id = $this->request->post['board_id'];

        //check if logged in user is admin of that board
        $this->loader->model('board');
        $getboard_model = $this->registry->get('model_board');
        $board_admin_status = $getboard_model->isCreatorOfBoard( $this->user->user_id, $board_id );

        if( $board_admin_status === true ) {

          $board_privacy_change_status = $getboard_model->boardMoreMemberJoinUpdate( $board_id, $member_allow );

          if( $board_privacy_change_status === true ) {
            $output = array(
              'status' => true
              );
          } else {
            $output = array(
              'status' => false,
              'error' => 'Could\'t save your privacy settings!'
              );
          }
          
        } else {
          $output = array(
            'status' => false,
            'error' => 'You don\'t have the authority to change privacy of this board!'
            );
        }        

      } else {
        $output = array(
          'status' => false,
          'error'  => 'We could\'t found this board! <br> Please try again later!'
          );
      }
    } else {
      $output = array(
        'status' => false,
        'error'  => 'It seems like board is not exist! <br> Please check your board and try again!'
        );
    }

    echo isset($output) ? json_encode($output) : '';
  }

}

?>