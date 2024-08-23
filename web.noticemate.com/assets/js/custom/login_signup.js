var login = {
  'loginData' : function() {
    var e = document.forms["mainLoginForm"]["login_email"].value;
    var p = document.forms["mainLoginForm"]["login_password"].value;

    if( this.checkEmail(e) === true && this.checkPass(p) === true ) {
      return true;
    } else return false;
  },

  'checkEmail' : function( e ) {
    if( e == null || e == "" ) {
      sweetAlert('Oops...', "Email can't be blank!", 'error');
      return false;
    }
    var atpos = e.indexOf("@");
    var dotpos = e.lastIndexOf(".");
    if ( atpos<1 || dotpos<atpos+2 || dotpos+2>=e.length || e.length < 4 ) {
      sweetAlert('Oops...', "Email does't looks like correct!", 'error');
      return false;
    }
    return true;
  },

  'checkPass' : function(p) {
    if( p.length < 6 ) {
      sweetAlert('Oops...', "Password must be at least 6 character!", 'error');
      return false;
    }
    return true;
  }

}

var signup = {
  'verify' : function() {
    var e   = document.forms['singupForm']['email'].value;
    var p   = document.forms['singupForm']['pass'].value;
    var c_p = document.forms['singupForm']['conf_pass'].value;

    if( login.checkEmail(e) == true ) {
      if( this.match(p, c_p) == true ) {
        if( login.checkPass(p) == true ) {
          return true;
        } else return false;
      } else {
        sweetAlert('Oops...', "Passwords doesn't match!", 'error');
        return false;
      }
    } else return false;
  },

  'match' : function( f, s ) {
    if( f == s ) {
      return true;
    } else return false;
  },

  'fp' : function() {
    var e = document.forms['fpForm']['email'].value;
    if( !login.checkEmail(e) === true ) {
      return false;
    }

    if( !signup.verifyGoogleRecaptcha() === true ) {
      sweetAlert('Oops...', "Captcha is not verified !", 'error');
      swal({
        type: 'error',
        title: 'Oops...',
        html: '<strong>Captcha</strong> is not verified, Please Veify it !'
      });
      return false;
    }
    return true;
  },

  'cp' : function() {

    var pass      = document.forms['changePass']['pass'].value;
    var conf_pass = document.forms['changePass']['conf_pass'].value;

    if( !signup.verifyGoogleRecaptcha() === true ) {
      sweetAlert('Oops...', "Captcha is not verified !", 'error');
      swal({
        type: 'error',
        title: 'Oops...',
        html: '<strong>Captcha</strong> is not verified, Please Veify it !'
      });
      return false;
    }

    if( login.checkPass(pass) ) {
      if( signup.match(pass, conf_pass) ) {
        return true;
      } else {
        swal({
          type: 'error',
          title: 'Oops...',
          html: '<strong>Passwords</strong> does\'t match!'
        });
        return false;
      }
    } else return false;

  },

  'verifyGoogleRecaptcha' : function() {
    var recapResponse = $('.g-recaptcha').attr('data-status');
    if( recapResponse === 'success' ) {
      return true;
    } else return false;
  }
}

function verifyGoogleRecaptcha() {
  $('.g-recaptcha').attr('data-status', 'success');
}