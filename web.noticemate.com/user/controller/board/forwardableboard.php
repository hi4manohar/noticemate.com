<?php

class ControllerBoardForwardableBoard extends Controller {
  public function index() {
    //right bar data model
    $this->loader->model('rightBar');
    $rightBarModel = $this->registry->get('model_rightBar');
    $right_member = $rightBarModel->index();
      
    //right bar members list
    $right_bar_members = $this->loader->view('/right/right_bar_members.php', array(
      'right_member' => $right_member,
      'load_only_forward' => true
      ));
      
    //right top user info
    $right_top_user = $rightBarModel->userTopData();
      
    echo $this->loader->view('/right/right_bar.php', array(
      'right_bar_members' => $right_bar_members,
      'load_only_right'   => true,
      ));
  }
}

?>