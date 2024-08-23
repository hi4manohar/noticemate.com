<?php

class ControllerProfileMemberprofile extends Controller {

  public function index() {
    if( isset($this->request->post['ui']) && isset($this->request->post['bi']) ) {
      if( strlen($this->request->post['ui']) && $this->inputest->verifyBoard($this->request->post['bi']) ) {

        $this->loader->model('profile');
        $getprofile_model = $this->registry->get('model_profile');
        $profile_detail = $getprofile_model->userProfile( $this->request->post['ui'], $this->request->post['bi'] );
        if( $profile_detail !== false && is_array($profile_detail) ) {

          $output = array(
            'status'        => 200,
            'profile_detail' => $profile_detail,
            'loggedin_user' => $this->user->user_id
            );
          
        } else $output = array('status' => 404, 'error' => 'Could\'t get profile!');
      } else $output = array('status' => 401, 'error' => 'You are not allowed to see member profile!');
    } else $output = array('status' => 401, 'error' => 'You are not allowed to see member profile!');
    echo (isset($output)) ? json_encode($output) : '';
  }
}

?>