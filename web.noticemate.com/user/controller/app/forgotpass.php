<?php

class ControllerAppForgotPass extends Controller{

  public function index() {
    $email = $this->inputest->trimTitle( $this->request->post['email'] );
    $cptch_response = isset($this->request->post['g-recaptcha-response']) ? $this->inputest->trimTitle($this->request->post['g-recaptcha-response']) : '';
    $email_ver = $this->inputest->checkEmail( $email );
    if( $email_ver === true ) {

      //captcha verify
      if( $this->user->verifyGoogleRecaptcha($cptch_response) === false ) {
        define( 'error', true );
        $error = array('Captcha is not correct. Please verify it !');
      }

      if( !isset($error) ) {

        //mail
        $this->registry->set('mail', new PHPMailer(true));

        /*
        @load signup model
        */
        $this->loader->model('signup');
        $signup_model = $this->registry->get('model_signup');

        $document = $this->document;

        $exist_status = $signup_model->fpMail($email);

        if( $exist_status !== false && is_array($exist_status) ) {
          //send forgot pass mail
          $signup_model->sendFpMail( $exist_status );
          // show confirmation of signup on load
          $js_script = array();
          array_push( $js_script, $document->customScripts( "swal(   'Success!',   'Please! Check your email for recover password!',   'success' )" ) );
          $this->loader->controller( "app/load/loadApp", array( 'js_script' => $js_script) );
        } else {
          define( 'error', true );
          $error = array("Email does't exist!");
        }
      }

    } else {
      define( 'error', true );
      $error = $email_ver;
    }

    if( isset($error) ) {
      $this->loader->controller( "app/load/loadApp", array( 'error' => $error) );
    }
  }
}

?>