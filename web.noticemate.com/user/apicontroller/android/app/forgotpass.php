<?php

class ControllerAppForgotPass extends Controller{

  public function index() {

    if( isset($this->request->post['email']) ):

    $email = $this->inputest->trimTitle( $this->request->post['email'] );
    $email_ver = $this->inputest->checkEmail( $email );
    if( $email_ver === true ) {

      //mail
      $this->registry->set('mail', new PHPMailer(true));

      /*
      @load signup model
      */
      $this->loader->model('signup');
      $signup_model = $this->registry->get('model_signup');

      //document
      require( SYSTEM_DIR . '/library/document.php' );
      $document = $this->document;

      $exist_status = $signup_model->fpMail($email);

      if( $exist_status !== false && is_array($exist_status) ) {
        //send forgot pass mail
        $signup_model->sendFpMail( $exist_status );
        // show confirmation of signup on load
        $output = array( 'status' => 200, 'msg' => 'Please! Check your email for recover password!' );
      } else {
        $output = array( 'status' => 401, 'error' => 'Email does\'t exist!' );
      }

    } else {
      $output = array( 'status' => 400, 'error' => $email_ver[0] );
    }

    else:
      $output = array( 'status' => 401, 'Unauthorized Access!' );
    endif;

    echo isset($output) ? json_encode($output) : '';
  }
}

?>