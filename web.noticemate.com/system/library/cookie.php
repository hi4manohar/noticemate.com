<?php

class Cookie{

  private $cookie_value;
  private $cookie_key;

  public function __construct( $registry ) {
    $this->encryption = $registry->get('encp');
  }

  public function issetCookie( $key ) {
    if( isset( $_COOKIE[$key] )  && strelen( $_COOKIE[$key] ) > 5  ) {
      $this->cookie_id = $key;
      $this->cookie_value = $_COOKIE[$key];      
    } else return false;
  }

  public function dCookie() {
    $dCookieVal = $this->encryption->decode( $this->cookie_value );
    return $dCookieVal;
  }

  public function set( $cookie_name, $cookie_value ) {
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
  }

  public function firstTimeLogin( $key ) {
    if( isset($_COOKIE[$key]) ) {
      return true;
    } else return false;
  }
}

?>