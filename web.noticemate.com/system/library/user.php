<?php

class User{

  public $user_id;
  public $user_full_name;
  public $request;
  public $username;
  public $profile_img;
  public $cookie_value;
  
  public function __construct( $registry ) {
    $this->db = $registry->get('db');
    $this->encryption = $registry->get('encp');
    $this->cookie = $registry->get('cookie');
    $this->request = $registry->get('request');
    $this->inputest = $registry->get('inputest');


    if( $this->isLogged() === true ) {
      $user_query = $this->db->query( "SELECT u.user_id, u.user_full_name, p.profile_img FROM nm_user as u, nm_profile as p WHERE u.user_id='$this->user_id' AND p.user_id=u.user_id" );
      if( $user_query->num_rows == 1 ) {
        $this->username = $user_query->row['user_full_name'];
        $this->profile_img = $user_query->row['profile_img'];
      }

      //check is it first time login
      if( $this->cookie->firstTimeLogin('flogin') === false ) {
        $this->cookie->set( 'flogin', 'filled' );
        define( 'show_highlighter', true );
      } else {
        
      }
    }
  }

  public function verifyUserId( $user_id ) {
    if( strlen( $user_id ) == 10 ) {
      $user_query = $this->db->query( "SELECT * FROM nm_user WHERE user_id='$user_id'" );
      if( $user_query->num_rows == 1 ) {
        return true;
      } else return false;
    } else return false;
  }

  public function getUserIdFromLoginKey( $loggedin_key ) {
    if( strlen($loggedin_key) > 16 ) {
      $user_query = $this->db->query( "SELECT * FROM nm_user WHERE `loggedin_key`='$loggedin_key'" );
      if( $user_query->num_rows == 1 ) {
        return $user_query->row;
      } elseif( $user_query->num_rows > 1 ) {
        //logout all the user

        $this->db->query( "UPDATE `nm_user` SET `loggedin_key`='0' WHERE `loggedin_key` = '$loggedin_key'" );

        return false;

      } else return 'mismatch';
    } else return false;
  }

  public function isLogged() {

    if( isset($_COOKIE['id']) && strlen($_COOKIE['id']) > 5 ) {

      $login_key = $this->inputest->trimTitle( $_COOKIE['id'] );
      $result = $this->getUserIdFromLoginKey( $login_key );

      if( is_array($result) && $result !== false ) {
        $this->user_id = $result['user_id'];

        return true;

      } elseif( $result === 'mismatch' ) {
        return 'logout';
      } else return false;
    }

    /*

    if( isset($_COOKIE['id']) && strlen($_COOKIE['id']) > 5 ) {
      $user_id = $this->encryption->decode( $_COOKIE['id'] );
      if( $this->verifyUserId( $user_id ) === true ) {
        $this->user_id = $user_id;
        $this->profile_img = 'hello';
        return true;
      } else return false;
    } else return false;

    */

  }

  public function login( $email, $password, $fb_login = false ) {

    $user_query = $this->db->query( "SELECT * FROM nm_user WHERE user_email='" . $this->db->escape($email) . "'" );

    if( $user_query->num_rows == 1 ) {

      $user_id = $user_query->row['user_id'];

      if( $fb_login === true )
        $dec_pass = $password;
      else
        $dec_pass = md5($user_id . $this->db->escape($password));
      $db_pass = $user_query->row['user_pass'];

      if( $db_pass === $dec_pass ) {

        if( $fb_login === false ):

          //check user status and email activation
          if( strlen($user_query->row['ver_code']) > 10 ) {
            $login_error = array( 'Your Account is not activated!' );
            array_push($login_error, 'Check your email to activate your account!');
            array_push($login_error, 'We have already sent confirmation email to your registered email id!');
            return $login_error;
          }

        endif;
      } elseif ($fb_login === true) {
        return 'id_error';
      } else {
        $login_error = array('Email and password is Incorrect!');
        return $login_error;
      }

      $this->user_id = $user_query->row['user_id'];
      $this->user_full_name = $user_query->row['user_full_name'];

      /*
      @ get loogged in key if user is already logged
      @ if user is already logged then cookie will be set same as previous logged cookie
      */
      $prev_logged_key = $user_query->row['loggedin_key'];
      if( strlen($prev_logged_key) && $prev_logged_key !== 0 ){
        $this->setLoginCookie( $this->user_id, $prev_logged_key );
      } else {
        $this->setLoginCookie( $this->user_id );
      }
      
      return true;
    } elseif ($fb_login === true) {
      return 'do_signup';
    } else {
      $login_error = array('Email and password is Incorrect!');
      return $login_error;
    }
  }

  /*
  @ method will be used when cookie to be set after successfully login
  */

  public function setLoginCookie( $uid, $prev_logged_key = false ) {

    if( $prev_logged_key == false ) {
      $login_cookie_val = $this->encryption->encode( $uid );
      $loggedin_key = md5( time() . $login_cookie_val );
    } else {
      $loggedin_key = $prev_logged_key;
    }
    

    $this->cookie->set( 'id', $loggedin_key );

    //set cookie value for api to set users value
    $this->cookie_value = $loggedin_key;

    $login_time = $this->db->dbDateTime();

    //set ip
    $this->db->query("UPDATE nm_user SET login_ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `last_login_on`='" . $login_time . "', `loggedin_key` = '$loggedin_key' WHERE user_id = '" . $uid . "'");
  }

  public function logout() {
    $this->cookie->set('id', '');
  }

  public function logoutFromDb( $loggedin_key ) {
    if( is_array($this->getUserIdFromLoginKey( $loggedin_key )) ) {
      $this->db->query( "UPDATE `nm_user` SET `loggedin_key`='0' WHERE `loggedin_key` = '$loggedin_key'" );
    }
  }

  public function verifyGoogleRecaptcha( $cptch_response ) {
    $cptch_url = "https://www.google.com/recaptcha/api/siteverify";
    $cptch_secret = "6LdxNx4TAAAAAJ0jc0bbhaSafgdmYhIYUi9M1yt3";
    $request_response = file_get_contents($cptch_url . '?response=' . $cptch_response . '&secret=' . $cptch_secret);
    $ret_response = json_decode($request_response, true);
    if( $ret_response['success'] == false ) {
      return false;
    } else {
      return true;
    }
  }

}

?>