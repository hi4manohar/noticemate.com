<?php

class Signup {

  private $db;

  public function __construct($registry) {
    $this->db   = $registry->get('db');
    $this->mail = $registry->get('mail');
    $this->user = $registry->get('user');
  }

  public function getUserByEmail( $email ) {
    $user_query = $this->db->query( "SELECT * FROM nm_user WHERE user_email='$email'" );
    if( $user_query->num_rows > 0 ) {
      return $user_query->row;
    } else return false;
  }

  public function updateFpToken( $token, $email, $pass, $user_id ) {

    $pass = md5($user_id . $pass);

    $this->db->query( "UPDATE `nm_user` SET `fp_code`='', `user_pass` = '$pass' WHERE user_email='$email'" );

    if( $this->db->countAffected() > 0 ) {
      return true;
    } else return false;
  }

  public function doSignup( $email, $pass, $fb_signup = false ) {
    $rm_id = $this->signupRandomId();
    $salt = $rm_id;
    $time = $this->db->dbDateTime();
    $ver_id = $this->verId(40);

    if( is_array($fb_signup) && $fb_signup !== false ) {
      $user_name = $fb_signup['name'];
      $pass = $pass;
      $is_fb = 1;
    } else {
      $user_name = $this->getNameFromEmail($email);
      $pass = md5($salt . $pass);
      $is_fb = 0;
    }

    //check if user is exist
    $user_query = $this->db->query( "SELECT * FROM nm_user WHERE user_email='$email'" );
    if( $user_query->num_rows > 0 ) {
      $s_error = array('Email already exist! Please use another email id!');
      return $s_error;
    }

    $this->db->query( "INSERT INTO `nm_user`(`user_id`, `user_full_name`, `user_email`, `registered_on`, `user_pass`, `ver_code`, `is_active`, `is_fb`) VALUES ('$rm_id', '$user_name', '" . $this->db->escape($email) . "', '$time', '" . $this->db->escape($pass) . "', '$ver_id', '0', '$is_fb')" );

    $user_id = $this->db->getLastId();
    /*
    @ after success signup email will be send to user email id
    @ if signup is through facebook them email will not be sent
    */
    if( $fb_signup === false ) {
      $mail_data = array(
        'email'   => $email,
        'name'    => $user_name,
        'ver_id'  => $ver_id,
        'subject' => 'NoticeMate Signup',
        'file'    => 'signup_email.php'
        );
      $this->signupMail( $mail_data );
      return $user_id;
    } else {

      /*
      @ return verification id because nee to set profiles and board conf
      */
      return $ver_id;
    }
  }

  public function signupRandomId() {
    return $id = rand(1111111111,mt_getrandmax());
  }

  public function getNameFromEmail($email) {
    $parts = explode("@", "$email");
    return $parts[0];
  }

  public function verId( $length = 10 ) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function fpMail( $email ) {
    $user_query = $this->db->query( "SELECT * FROM nm_user WHERE user_email='$email' AND is_fb='0'" );
    if( $user_query->num_rows > 0 ) {

      $ver_id = $this->verId(40);
      $this->db->query( "UPDATE `nm_user` SET `fp_code`='$ver_id' WHERE user_email='" . $email . "'" );
      if( $this->db->countAffected() > 0 ) {
        $user_query = $this->db->query( "SELECT * FROM nm_user WHERE user_email='$email'" );
        return $user_query->row;
      }
      else return false;

    } else return false;
  }

  public function sendFpMail( $data = array() ) {

    $mail_data = array(
      'email' => $data['user_email'],
      'name'  => $data['user_full_name'],
      'ver_code' => $data['fp_code'],
      'subject' => 'Password Reset',
      'file' => 'forgot_pass_email.php'
      );
    $this->signupMail( $mail_data );
  }

  public function signupMail( $data = array() ) {
    try {
      $this->mail->AddReplyTo('info@noticemate.com', 'NoticeMate');
      $this->mail->AddAddress($data['email'], $data['name']);
      $this->mail->SetFrom('info@noticemate.com', 'NoticeMate');
      $this->mail->Subject = $data['subject'];
      $this->mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

      ob_start();
      require(USER_VIEW_DIR . '/template/' . $data['file']);
      $output = ob_get_contents();
      ob_end_clean();

      $this->mail->MsgHTML( $output );
      $this->mail->Send();
    } catch (phpmailerException $e) {
      echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
      echo $e->getMessage(); //Boring error messages from anything else!
    }
  }

  public function verifyToken( $token, $email ) {
    /*
    @token is used to uniquely identify the user
    @after verification of token and email update his token to blank and status to 1
    */
    $check_token = $this->db->query( "SELECT * FROM nm_user WHERE user_email='" . $this->db->escape($email) . "' AND ver_code='" . $this->db->escape($token) . "' " );
    if( $check_token->num_rows == 1 ) {

      $update_status = $this->db->query( "UPDATE `nm_user` SET `ver_code`='',`is_active`=1 WHERE user_email='" . $this->db->escape($email) . "' " );
      if( $this->db->countAffected() == 1 ) {

        /*
        @if first time user account is verified then create his profile also
        */

        $user_id = $check_token->row['user_id'];

        $this->db->query( "INSERT INTO `nm_profile`(`user_id`, `status`, `profile_img`, `is_board`) VALUES ('$user_id', 'No Status', '', 0)" );

        if( $this->db->countAffected() == 1 ) {

          $time = $this->db->dbDateTime();

          //insert default board
          //$this->db->query( "INSERT INTO `nm_boarduser`(`board_id`, `user_id`, `joined_on`) VALUES ('noticemate', '$user_id', '$time')" );

          //insert default plan type
          $this->db->query( "INSERT INTO `nm_boardconf`(`user_id`, `allowed_board`, `allowed_people`, `is_admin`, `plan_type`, `expire_on`) VALUES ($user_id, '5', '100', '0', '2', '$time')" );

          return $user_id;
        } else return 'profileBlank';
        
      } else return false;
    } return false;
  }

}

?>