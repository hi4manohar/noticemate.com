<?php

class ControllerProfileMyprofile extends Controller {

  public function index() {
    $this->loader->model('profile');
    $getprofile_model = $this->registry->get('model_profile');
    $profile_detail = $getprofile_model->myProfile();

    if( $profile_detail !== false && is_array($profile_detail) ) {

      echo $this->loader->view('/right/member_profile.php', array(
        'profile_detail' => $profile_detail,
        'user' => $this->user
      ));

    } else {
      $output = array('status' => false, 'error' => 'Cannot access profile' );
      echo json_encode($output);
    }
  }
}

?>