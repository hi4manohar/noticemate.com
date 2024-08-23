<?php

class ControllerAppLogin extends Controller {

  public function index() {

    if( isset($this->request->post['email']) && isset($this->request->post['pass']) ) {
      $email = $this->request->post['email'];
      $pass  = $this->request->post['pass'];

      $email_ver = $this->inputest->checkEmail( $email );
      if( $email_ver  === true ) {
        $login_ver = $this->user->login( $email, $pass );
        if( $login_ver === true ) {
          //login success
          //Response
          if( isset($this->user->cookie_value) && strlen($this->user->cookie_value) ) {
            $output = array( 'status' => 200, 'cookieValue' => $this->user->cookie_value, 'userId' => $this->user->user_id, 'userFullName' => $this->user->user_full_name );
          } else $output = array( 'status' => 422, 'error' => 'could\'t set user value' );
        } else {
          $error = $login_ver;

          $output = array( 'status' => 401, 'error' => $error[0] );
        }
      } else {
        $error = $email_ver;
        $output = array( 'status' => 401, 'error' => $error[0] );
      } 
    } else $output = array( 'status' => 401, 'error' => 'Email and Password is Not Set!' );
    echo ( isset($output) ) ? json_encode($output) : '';
  }
}

?>