<?php

class ControllerProfileMyprofile extends Controller {

  public function index() {
    $this->loader->model('profile');
    $getprofile_model = $this->registry->get('model_profile');
    $profile_detail = $getprofile_model->myProfile();

    if( $profile_detail !== false && is_array($profile_detail) ) {

      $output = array(
        'status' => 200,
        'profile_detail' => $profile_detail,
        'loggedin_user' => $this->user->user_id
        );

    } else {
      $output = array('status' => 404, 'error' => 'Cannot access profile' );
    }

    echo isset($output) ? json_encode($output) : '';
  }
}

?>