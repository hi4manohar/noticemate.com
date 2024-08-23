<?php

class ControllerAppVerifySignupToken extends Controller {

  public function index() {
    $token = $this->request->get['token'];
    $email = $this->request->get['email'];
    $js_script = array();

    /*
    @load signup model
    */
    $this->loader->model('signup');
    $signup_model = $this->registry->get('model_signup');

    if( strlen($token) == 40 && $this->inputest->checkEmail($email) === true ) {

      $verification_status = $signup_model->verifyToken($token, $email);

      if( $verification_status !== false || $verification_status === 'profileBlank' ) {
        array_push( $js_script, $this->document->customScripts( "swal({ title: 'Verified!', html: 'Your account is verified.<br>Now you can login with your credientails to <i>NoticeMate.com</i>!' })" ) );
      } else array_push( $js_script, $this->document->customScripts( "swal({ title: 'Not Verified!', html: 'Your given account verification credientails is not <br><i>correct</i>!' })" ) );
    } else {
      array_push( $js_script, $this->document->customScripts( "swal({ title: 'Not Verified!', html: 'Your given account verification credientails is not <br><i>correct</i>!' })" ) );
    }

    if( isset($js_script) ) {
      $this->loader->controller( "app/load/loadApp", array( 'js_script' => $js_script) );
    }
  }
}

?>