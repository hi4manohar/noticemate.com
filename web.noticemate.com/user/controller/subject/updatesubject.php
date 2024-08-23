<?php

class ControllerSubjectUpdatesubject extends Controller {

  public function index() {
    $mod = $this->request->post['mod'];

    //type to update defines that what type of updation is
    $tou = ( isset($this->request->post['bid']) ) ? 'bid' : 'uid';

    if( isset($this->request->post[$tou])  && isset($this->request->post['content']) ) {

      $upd_conte = $this->request->post['content'];
      $len = ( $mod == 'update_board_subject' || $mod == 'update_member_subject' ) ? 50 : 200;

      if( strlen($this->request->post[$tou]) == 10 && strlen($upd_conte) < $len ) {

        $model_to_load = (  $mod == 'update_board_subject' || $mod == 'update_board_status' ) ? 'board' : 'profile';

        //load module and update content
        $this->loader->model($model_to_load);
        $getboard_model = $this->registry->get('model_' . $model_to_load);
        $method_to_call_array = array(
          'update_board_subject'  => 'boardName',
          'update_board_status'   => 'boardStatus',
          'update_member_subject' => 'profileNameUpdate',
          'update_member_status'  => 'memberStatusUpdate'
          );
        $method_to_call = $method_to_call_array[$mod];
        $update_status = $getboard_model->$method_to_call( $this->request->post[$tou], $upd_conte );

        if( $update_status == 'not-allowed' ):
          $output = array('status' => false, 'error' => 'You are not allowed to update the subject!');
        elseif( $update_status == 'exist' || $update_status == 'updated' ):
          $output = array('status' => true);
        endif;

      } else $output = array('status' => false, 'error' => 'Content lenght is too long!');
    } else $output = array('status' => false, 'error' => 'Board not found!' );
    echo json_encode($output);
  }
}

?>