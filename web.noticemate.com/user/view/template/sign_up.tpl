<div class="form_containner">

  <div class="p_title">
    <h3>First Time On NoticeMate?</h3>
  </div>
  <div class="fp_desc" style="text-align: center; font-size: 14px; margin-bottom: 30px;"> 
    You are just one step ahead
    <br>
    to enter into NoticeMate
  </div>

  <button class="fblogin" id="fblogin">
    <i class="fa fa-facebook-official fbLoginLogo"></i>
    <span>Log in with Facebook</span>
  </button>  
  <!--
  <div class="p_title">
    <h3>Create Your Account</h3>
  </div>
  -->
  <div class="form_containner_inner">
    <form method="POST" name="singupForm" action="" onsubmit=" return signup.verify();">
      <input type="email" name="email" placeholder="Your Email" style="font-size:14px;" required>
      <input type="password" name="pass" placeholder="Your Password" style="font-size:14px;" required>
      <input type="password" name="conf_pass" placeholder="Conform Password" style="font-size:14px;" required>
      <?php if( defined("error") ): ?>
      <div class="login_error">
        <?php
        if( isset($data) ) {
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
      <input type="submit" value="Create account" name="do_signup">
    </form>
    <div class="form_link" style="margin-top:30px; margin-bottom: 20px;">
      <div class="cr_account">
        <span>
          <a href="/login<?php echo isset($set_theme_query_string) ? "?ds=smpl" : ''; ?>" class="home_link">Login</a>
          <a href="/fp<?php echo isset($set_theme_query_string) ? "?ds=smpl" : ''; ?>" class="home_link fl_r">Forgot Password</a>
        </span>
      </div>      
    </div>
    <span class="signup-inst" style="font-size:13px;">By clicking "Create Account", you agree to our <a href="javascript:void(0);">terms of service</a> and <a href="javascript:void(0);">privacy policy</a>. We'll occasionally send you account related emails.</span>
  </div>
</div>