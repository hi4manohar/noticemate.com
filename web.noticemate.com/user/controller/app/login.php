<?php

class ControllerAppLogin extends Controller {

  public function index() {
    $email = $this->request->post['email'];
    $pass  = $this->request->post['pass'];

    $email_ver = $this->inputest->checkEmail( $email );
    if( $email_ver  === true ) {
      $login_ver = $this->user->login( $email, $pass );
      if( $login_ver === true ) {
        //login success
        //Response      
        $this->response->redirect('/');
      } else {
        define( 'error', true );
        $error = $login_ver;

        $this->loader->controller( "app/load/loadApp", array( 'error' => $error) );
        exit();
      }
    } else {
      define( 'error', true );
      $error = $email_ver;
      $this->loader->controller( "app/load/loadApp", array( 'error' => $error) );
    }
  }

  public function fbLogin() {

    /*
    @ check if fb email and id means password is correct
    @ if correct then login successfully and set cookie
    @ if not correct then signup with facebook will excure
    @ after successfully signup cookie will be set and allow them to loggedin
    @ if facebook email already exist with us then show them error
    */

    if( isset($this->request->post['email']) && isset($this->request->post['name']) && isset($this->request->post['id']) ) {
      $email = $this->request->post['email'];
      $name = $this->request->post['name'];
      $id = $this->request->post['id'];

      if( !empty($email) && !empty($name) && !empty($id) ) {

        //check if email is correct
        $email_ver = $this->inputest->checkEmail( $email );

        if( $email_ver === true ) {

          //check id length
          if( strlen($id) > 14 && strlen($id) < 20 ) {

            $login_ver = $this->user->login( $email, $id, true );
            if( $login_ver === true ) {
              //$this->response->redirect('/');
              $output = array( 'status' => true );

            } elseif( $login_ver === 'do_signup' ) {
              /*
              @ signup with facebook
              */
              $signup_data = $this->fbSignup( array('email' => $email, 'name' => $name, 'id' => $id) );
              if( $signup_data == true ) {
                $output = array( 'status' => true );
              } elseif ( $signup_data === 'token-error' ) {

                $output = array( 'status' => false, 'error' => 'We could\'t verify your token! <br> Please refresh the page and try again!' );

              } else {
                $output = array( 'status' => false, 'error' => $output[0] );
              }
            } elseif ( $login_ver === 'id_error' ) {

              $output = array( 'status' => false, 'error' => 'It looks like this email is alreay registered with us! <br> Please login with that email and password!' );
            } 

          } else {
            $output = array( 'status' => false, 'error' => 'You facebook id does\'t looks like correct!' );
          }

        } else {
          $output = array( 'status' => false, 'error' => $email_ver[0] );
        }
      } else {
        $output = array( 'status' => false, 'error' => 'Not Authorized to Login!' );
      }
    } else {
      $output = array( 'status' => false, 'error' => 'Not Authorized to Login!' );
    }

    echo isset($output) ? json_encode($output) : '';
  }

  public function fbSignup( $data = array() ) {
    /*
    @ signup user with fb data where password will be fb id
    @ load signup modal and call do signup method
    @ if doSignup method return array then it is error else it will return user id
    */
    $this->loader->model('signup');
    $signup_model = $this->registry->get('model_signup');
    $signup_status = $signup_model->doSignup( $data['email'], $data['id'], array('name' => $data['name']) );

    if( is_array($signup_status) ) {
      return $signup_status;
    } else {
      $token_status = $signup_model->verifyToken( $signup_status, $data['email'] );

      if( $token_status !== false || $token_status === 'profileBlank' ) {

        $this->user->setLoginCookie( $token_status );
        
        return true;
      } else {
        return 'token-error';
      }
    }
  }

  public function ApiLogin() {
    $email = $this->request->get['email'];
    $pass  = $this->request->get['pass'];

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
    } else $output = array( 'status' => 401, 'error' => $error[0] );

    echo ( isset($output) ) ? json_encode($output) : '';
  }
}

?>