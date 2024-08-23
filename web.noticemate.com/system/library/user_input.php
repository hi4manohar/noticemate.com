<?php

class userInput{

  public $emailErr = array();

  public function checkEmail( $email ) {

    //remove all illegal character
    $email = filter_var( $email, FILTER_SANITIZE_EMAIL );
    //validate email
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) === false ) {
      if( $this->checkEmailDomains( $email ) === true ) {
        return true;
      } else return $this->emailErr;
    } else {
      array_push($this->emailErr, "Email is not Valid! Please check your email!");
      return $this->emailErr;
    }
  }

  /*
  @ this function will check email domains only which we accept
  @ if error will found then return error
  @param is only for email
  */
  public function checkEmailDomains( $email ) {

    $emailTopDomain = substr($email, strrpos($email, '.') + 1);
    $emailDomain = substr($email, strrpos($email, '@') + 1);

    $domains = array ('aim.com','aol.com','att.net','bellsouth.net','btinternet.com',
            'charter.net','comcast.com', 'comcast.net','cox.net','earthlink.net',
            'gmail.com','googlemail.com', 'icloud.com','mac.com','me.com','msn.com',
            'optonline.net','optusnet.com.au', 'rocketmail.com','rogers.com','sbcglobal.net',
            'shaw.ca','sympatico.ca','telus.net','verizon.net','ymail.com', 'hotmail.com', 'rediffmail.com', 'yahoo.com', 'mail.com', 'outlook.ocm', 'noticemate.com');
    $topLevelDomains = array ('com', 'com.au', 'com.tw', 'ca', 'co.nz', 'co.uk', 'de',
            'fr', 'it', 'ru', 'net', 'org', 'edu', 'gov', 'jp', 'nl', 'kr', 'se', 'eu',
            'ie', 'co.il', 'us', 'at', 'be', 'dk', 'hk', 'es', 'gr', 'ch', 'no', 'cz',
            'in', 'net', 'net.au', 'info', 'biz', 'mil', 'co.jp', 'sg', 'hu');

    if( in_array($emailTopDomain, $topLevelDomains) && in_array($emailDomain, $domains) ) {
      
      return true;
    } else {
      array_push( $this->emailErr, "we are not accepting this domain of emails, please use another domain");
      return $this->emailErr;
    }
  }

  //trim titles
  public function trimTitle($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function verifyBoard( $bid ) {

    $bid = $this->trimTitle($bid);
    
    if( strlen($bid) == 10 && is_numeric($bid) ) {
      return true;
    } else return false;
  }
}

?>