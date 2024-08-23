<?php

class Cookie{

  private $encryption;

  public function __construct( $encryption ) {
    $this->encryption = $encryption;
  }

  public function setCookie( $cookie_name, $cookie_value ) {
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
  }

  public function checkCookie( $name, $cookie_value ) {
    if( isset($_COOKIE[$name]) ) {
      return true;
    } else return false;
  }
}

?>