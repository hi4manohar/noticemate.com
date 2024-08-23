<?php

class ControllerAppPassReset extends Controller {

  public function index() {
    $email = $this->inputest->trimTitle( $this->request->get['email'] );
    $email_ver = $this->inputest->checkEmail( $email );
    $token = $this->inputest->trimTitle( $this->request->get['token'] );

    $document = $this->document;
    $js_script = array();

    if( $email_ver === true ) {

      /*
      @load signup model
      */
      $this->loader->model('signup');
      $signup_model = $this->registry->get('model_signup');

      //get user
      $user_data = $signup_model->getUserByEmail( $email );

      if( $user_data === false ) {
        array_push( $js_script, $document->customScripts( "swal({title: 'Oops!',html: 'Sorry! We could\'t found your account.',   type:'error'})" ) );
      }

      if( is_array($user_data) ) {
        extract($user_data);
        if( strlen($fp_code) > 5 ) {

          if( $fp_code == $token ) {
            //now open pass resed fields
            array_push( $js_script, $document->customScripts( "swal({title: 'Success!',html: 'Please enter your new passwords!',   type:'success'})" ) );
            $open_pass_reset_field = true;
          } else {
            //now open pass resed fields
            array_push( $js_script, $document->customScripts( "swal({title: 'Oops!',html: 'We could\'t found this token. <br> Please recheck your email and try again with correct token.',   type:'error'})" ) );
            $open_pass_reset_field = false;
          }

        } else {
          array_push( $js_script, $document->customScripts( "swal({title: 'Oops!',html: 'You have not requested for forgot password. <br> Please first request us!',   type:'error'})" ) );
        }
      }

    } else {
      array_push( $js_script, $document->customScripts( "swal({title: 'Error!',html: 'Oops! We could\'t verify email address! <br>Please try with correct email address! ',   type:'error'})" ) );
    }

    if( count($js_script) > 0 ) {
      if( isset($open_pass_reset_field) ) {
        if( $open_pass_reset_field === true ) {
          $this->loader->controller( "app/load/loadApp", array( 
            'js_script'               => $js_script,
            'open_pass_reset_field'   => true,
            'token'                   => $token,
            'email'                   => $email
            ) );
        } else {
          $this->loader->controller( "app/load/loadApp", array( 
            'js_script' => $js_script
            ) );
        }
      } else {
        $this->loader->controller( "app/load/loadApp", array( 
          'js_script' => $js_script
          ) );
      }
    }
  }

  public function resetforgotpass() {

    /*
    @ check if conform password is getting for reset
    */
    $email      = $this->inputest->trimTitle( $this->request->post['email'] );
    $email_ver  = $this->inputest->checkEmail( $email );
    $token      = $this->inputest->trimTitle( $this->request->post['token'] );
    $pass       = $this->request->post['pass'];
    $conf_pass  = $this->request->post['conf_pass'];

    if( $email_ver !== true ) {
      define( 'error', true );
      $error = $email_ver;
    }

    if( !isset($error) && $pass !== $conf_pass ) {
      define( 'error', true );
      $error = array("Passwords does't match");
    }

    if( !isset($error) && strlen($pass) < 6 ) {
      define( 'error', true );
      $error = array("Password must be atleast 6 character.");
    }

    if( !isset($error) && strlen($token) < 10 ) {
      define( 'error', true );
      $error = array("Token does't looks like correct.");
    }

    if( !isset($error) ) {
      /*
      @load signup model
      */
      $this->loader->model('signup');
      $signup_model = $this->registry->get('model_signup');

      //get user
      $user_data = $signup_model->getUserByEmail( $email );

      if( $user_data === false ) {
        define( 'error', true );
        $error = array("We could't found your account");
      }

      if( !isset($error) && is_array($user_data) ) {
        if( $user_data['fp_code'] !== $token ) {
          define( 'error', true );
          $error = array("We could't found your account");
        }

        if( !isset($error) ) {
          $update_status = $signup_model->updateFpToken( $token, $email, $pass, $user_data['user_id'] );

          if( $update_status === false ) {
            define( 'error', true );
            $error = array("Sorry! could not update your password.");
          }

        }
      }
    }

    if( !isset($error) ) {
      $response = new Response();
      $response->redirect("/cp?passchange=success");
    } else {
      $this->loader->controller( "app/load/loadApp", array( 
        'error'               => $error,
        'open_pass_reset_field'   => true,
        'token'                   => $token,
        'email'                   => $email
        ) );
    }

  }
}

?>