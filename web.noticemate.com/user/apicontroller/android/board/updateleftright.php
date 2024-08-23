<?php

class ControllerBoardUpdateleftright extends Controller {

  public function index() {

    if( $this->request->post['mod'] == 'update_left_side' ):
      //load left sidebar model to get the data
      $this->loader->model('board');
      $left_member = $this->registry->get('model_board')->follBoard();
      /*
      @ loading complete template
      @ 1st param is file and 2nd param is data which will render in that file
      */

      $output = array(
        'status' => 200,
        'left_bar_members' => $left_member
        );

    elseif( $this->request->post['mod'] == 'update_right_side' ):

      //right bar data model
      $this->loader->model('rightBar');
      $rightBarModel = $this->registry->get('model_rightBar');
      $right_member = $rightBarModel->index();

      //right top user info
      $right_top_user = $rightBarModel->userTopData();

      $output = array(
        'status' => 200,
        'right_bar_members' => $right_member
        );
    endif;

    echo isset($output) ? json_encode($output) : '';
  }
}

?>