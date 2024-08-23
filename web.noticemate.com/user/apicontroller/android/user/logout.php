<?php

class ControllerUserLogout extends Controller {

  public function index() {
    if(!isset($_COOKIE['id'])) {
      $output = array( 'status' => 400, 'error' => 'Cannot loggedout user!' );
    } else {
      $this->user->logoutFromDb( $_COOKIE['id'] );
      $output = array( 'status' => 200, 'msg' => 'Loggedout Successfully!' );
    }

    echo isset($output) ? json_encode($output) : '';

  }

}

?>