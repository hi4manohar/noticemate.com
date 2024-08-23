<?php

class ControllerBoardUpdateleftright extends Controller {

  public function index() {

    if( $this->request->post['mod'] == 'update_left_side' ):
      //left sidebar popus
      $left_popup = $this->loader->view('/left/pop_up.php');
      //load left sidebar model to get the data
      $this->loader->model('board');

      /*
      @ check if requesting only board and remained notice
      @ if requesting only update board getted notice
      */
      if( isset($this->request->post['get_only_unread']) ) {
        $left_data = $this->registry->get('model_board')->getFollBoardTotalNoticeAtReal();
        if( is_array($left_data) && $left_data !== false ) {
          echo json_encode($left_data);
        } else echo '';
        exit();
      }

      $left_member = $this->registry->get('model_board')->follBoard();
      //load left sidebar members template
      $left_bar_members = $this->loader->view('/left/left_bar_members.php', $left_member);
      
      /*
      @ loading complete template
      @ 1st param is file and 2nd param is data which will render in that file
      */
      echo $this->loader->view('/left/left_bar.php', array(
        'left_popup' => $left_popup,
        'left_bar_members' => $left_bar_members,
        'load_only_left' => true
        ));

    elseif( $this->request->post['mod'] == 'update_right_side' ):

      //right bar data model
      $this->loader->model('rightBar');
      $rightBarModel = $this->registry->get('model_rightBar');
      $right_member = $rightBarModel->index();
      
      //right bar members list
      $right_bar_members = $this->loader->view('/right/right_bar_members.php', $right_member);
      
      //right top user info
      $right_top_user = $rightBarModel->userTopData();
      
      echo $this->loader->view('/right/right_bar.php', array(
        'right_bar_members' => $right_bar_members,
        'load_only_right'   => true
        ));
    endif;
  }

  public function follUpdatedNotice() {
    /*
     * here header type event-stream is used for Server Sent events
     * This method is also defined for post method
    */
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    /*
    @ check if requesting only board and remained notice
    @ if requesting only update board getted notice
    */
    if( isset($this->request->get['mod']) && $this->request->get['mod'] == 'get_left_update_notice' ) {
      $this->loader->model('board');
      $left_data = $this->registry->get('model_board')->getFollBoardTotalNoticeAtReal();
      if( is_array($left_data) && $left_data !== false ) {
        echo 'data:' . json_encode($left_data) . "\n\n";
      } else echo '';
      flush();
    }
  }
}

?>