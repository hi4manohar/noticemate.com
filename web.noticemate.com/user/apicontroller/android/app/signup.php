<?php

class ControllerAppSignup extends Controller {

  public function index() {

    if( isset($this->request->post['email']) && isset($this->request->post['pass']) && isset($this->request->post['conf_pass']) ):

    //mail
    $this->registry->set('mail', new PHPMailer(true));

    $email      = $this->inputest->trimTitle( $this->request->post['email'] );
    $pass       = $this->request->post['pass'];
    $conf_pass  = $this->request->post['conf_pass'];

    $email_ver = $this->inputest->checkEmail( $email );
    if( $email_ver === true ) {
      if( $pass == $conf_pass ) {

        /*
        @load signup model
        */
        $this->loader->model('signup');
        $signup_model = $this->registry->get('model_signup');

        //get signup
        $in_id = $signup_model->doSignup( $email, $pass );
        if( is_array($in_id) ) {
          define('error', true);
          $error = $in_id;
        } else {
          //signup success
          //show confirmation of signup on load
          $js_script = array();
          array_push( $js_script, 'Congratulations! Check your email for successfully activate your Account!' );
        }
      } else {
        define('error', true);
        $error = array( "Passwords does't match" );
      }
    } else {
      define('error', true);
      $error = $email_ver;
    }

    if( isset($error) ) {
      $output = array( 'status' => 401, 'error' => $error[0] );
    } else {
      $output = array( 'status' => 200, 'msg' => $js_script[0] );
    }

    else:
      $output = array( 'status' => 400, 'error' => 'Bad Request Requested!' );
    endif;

    echo isset($output) ? json_encode($output) : '';

  }
}

?>