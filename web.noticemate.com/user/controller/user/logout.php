<?php

class ControllerUserLogout extends Controller {

  public function index() {
    if(!isset($_COOKIE['id'])) {
      echo "You are redirecting in a moment!";
    } else {
      $this->user->logoutFromDb( $_COOKIE['id'] );
      setcookie("id", "", time() - 3600);
    }

    $this->goToHome();
  }

  public function goToHome() {
    //Response
    $response = new Response();
    $response->redirect('/?ds=smpl&cfrom=logout');
  }

}

?>