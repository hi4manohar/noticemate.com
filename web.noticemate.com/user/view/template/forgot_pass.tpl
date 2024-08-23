<div class="form_containner">
  <div class="p_title">
    <h3>Forgot Your Password?</h3>
  </div>
  <div class="fp_desc" style="text-align: center; font-size: 14px; margin-bottom: 30px;">
    Enter your email ID, we'll send you
    <br>
    your password reset link
  </div>
  <div class="form_containner_inner">
    <form method="POST" name="fpForm" action="" onsubmit="return signup.fp();">
      <input type="email" name="email" placeholder="Your Registered Email" style="font-size:14px;" required>      
      <?php if( defined("error") ): ?>
      <div class="login_error">
        <?php
        if( isset($data) ) {
          if( isset($data['error']) && is_array($data['error']) ):
            foreach( $data['error'] as $value ) {
              echo '<i class="fa fa-exclamation-circle" style="margin-right: 5px; float: left;"></i><p>' . $value . "</p>";
            }
          endif;
        }
        ?>
      </div>
      <?php endif; ?>
      <div class="g-recaptcha" data-callback="verifyGoogleRecaptcha" data-status="" data-sitekey="6LdxNx4TAAAAACKVkrPnbtPXKHY020Qtbf05Pdm2"></div>
      <input type="submit" value="Recover password" name="forgotpass">
    </form>
    <div class="form_link" style="margin-top:30px;">
      <div class="cr_account">
        <span>
          <a href="/login<?php echo isset($set_theme_query_string) ? "?ds=smpl" : ''; ?>" class="home_link">Login</a>
          <a href="/signup<?php echo isset($set_theme_query_string) ? "?ds=smpl" : ''; ?>" class="home_link fl_r">Create an account</a>
        </span>
      </div>
    </div>
  </div>
</div>