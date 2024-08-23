<?php

class ControllerBoardCreateBoard extends Controller {

  public function index() {
    if( isset($this->request->post['type']) && $this->request->post['type'] == 'created' ) {
      echo $this->loader->view('/middle/createboard.php', array(
        'is_created' => true
        ));
    } elseif ( isset($this->request->post['type']) && $this->request->post['type'] == 'join' ) {
      echo $this->loader->view('/middle/createboard.php', array(
        'is_join'   => true
        ));
    } else {
      echo $this->loader->view('/middle/createboard.php');
    }
  }
}

?>