<div class="form_containner">
  <?php if( isset($data['passchange']) && $data['passchange'] == 'success' ): ?>
  <div class="fp_desc" style="text-align: center; font-size: 14px; margin-bottom: 30px;"> 
    Done. Now you can login with your
    <br>
    Newly created password.
  </div>
  <?php else: ?>
  <div class="p_title"><h3>Log in to NoticeMate</h3></div>
  <?php endif; ?>
  <button class="fblogin" id="fblogin">
    <i class="fa fa-facebook-official fbLoginLogo"></i>
    <span>Log in with Facebook</span>
  </button>  
  <div class="form_containner_inner">
    <form action="" method="POST" onsubmit="return login.loginData();" name="mainLoginForm">
      <input type="email" id="login_email" name="email" placeholder="Your Email" style="font-size:14px;" required>
      <input type="password" id="login_password" name="pass" placeholder="Your Password" style="font-size:14px;" required>
      <?php if( defined("error") ): ?>
      <div class="login_error">
        <p id="fbstatus"></p>
        <?php
        if( isset($data) && is_array($data) ) {
          extract($data);
          if( isset($error) && is_array($error) ):
            foreach( $error as $value ) {
              echo '<i class="fa fa-exclamation-circle" style="margin-right: 5px; float: left;"></i><p>' . $value . "</p>";
            }
          endif;
        }
        ?>
      </div>
      <?php endif; ?>
      <input type="submit" value="Login" name="do_login">
    </form>
    <div class="form_link" style="margin-top:30px;">
      <div class="cr_account">
        <span>
          <a href="/signup<?php echo isset($set_theme_query_string) ? "?ds=smpl" : ''; ?>" class="home_link">Create an Account</a>
          <a href="/fp<?php echo isset($set_theme_query_string) ? "?ds=smpl" : ''; ?>" class="home_link fl_r">Forgot Password</a>
        </span>
      </div>
    </div>
  </div>
</div>