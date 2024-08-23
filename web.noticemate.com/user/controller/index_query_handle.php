<?php

/*
@ it will be used with login form will be submitted
*/
if( isset( $request->post['do_login'] ) && $request->post['do_login'] === "Login" ) {
  $loader->controller( "app/login" );
}

/*
@ it will be used with signup form is submitted
*/
if( isset($request->post['do_signup']) && $request->post['do_signup'] == 'Create account' ) {
  $loader->controller( "app/signup" );
}

if( isset($request->get['token']) && isset($request->get['email']) && isset($request->get['mod']) && $request->get['mod'] == 'conf_reg' ) {
  $loader->controller( "app/verifysignuptoken" );
}

//forgot password functionality
if( isset($request->post['forgotpass']) && $request->post['forgotpass'] == 'Recover password' ) {
  $loader->controller( "app/forgotpass" );
}

//password reset functionality
if( isset($request->get['mod']) && $request->get['mod'] == 'pass_reset' ) {
  if( isset($request->get['token']) && isset($request->get['email']) ) {
    $loader->controller( "app/passreset" );
  }
}

//password changed functionality
if( isset($request->post['changepass']) && $request->post['changepass'] == "Change Password" ) {
  if( isset($request->post['pass']) && isset($request->post['conf_pass']) ) {
    if( isset($request->post['token']) && isset($request->post['email']) ) {
      $loader->controller( "app/passreset/resetforgotpass" );
    }
  }
}

?>