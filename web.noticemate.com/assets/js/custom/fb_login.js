// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
  if (response.status === 'connected') {
    // Logged into your app and Facebook.
    // we need to hide FB login button
    $('#fblogin').hide();
    //fetch data from facebook
    getUserInfo();
  } else if (response.status === 'not_authorized') {
    // The person is logged into Facebook, but not your app.
    $('#fbstatus').html('Please log into this app.');
  } else {
    // The person is not logged into Facebook, so we're not sure if
    // they are logged into this app or not.
    $('#fbstatus').html('Please log into facebook');
  }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

window.fbAsyncInit = function() {
  FB.init({
    appId      : '245980949083692',
    cookie     : false,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.3' // use version 2.3
  });
};

// Now that we've initialized the JavaScript SDK, we call 
// FB.getLoginStatus().  This function gets the state of the
// person visiting this page and can return one of three states to
// the callback you provide.  They can be:
//
// 1. Logged into your app ('connected')
// 2. Logged into Facebook, but not your app ('not_authorized')
// 3. Not logged into Facebook and can't tell if they are logged into
//    your app or not.
//
// These three cases are handled in the callback function.

// Load the SDK asynchronously
//do the job for fb comments integration
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


var fbLoginStatus = {
  'loginStatus' : function(xmlhttp) {
    if( xmlhttp.responseText ) {
      if( is.isJson(xmlhttp.responseText) == true ) {
        var obj = cm.parseJSON( xmlhttp.responseText );
        if( obj.status === false ) {
          swal({
            title: 'Oops!',
            html: obj.error
          });
          FBLogout();
        } else {
          user.goToAppHome();
        }
      } else {
        swal({
          title: 'Oops!',
          html: 'We found some error in login you with facebook!'
        });
      }
    } else {
      swal({
        title: 'Oops!',
        html: 'We found some error in login you with facebook!'
      });
    }
    modal.mmHide();
  }
}


function getUserInfo() {
  modal.mmShow();
  FB.api('/me?fields=name,email', function(response) {
    var query = 'mod=fb_login&name=' + response.name + '&email=' + response.email + '&id=' + response.id;
    loadPostData( appUrl, query, fbLoginStatus.loginStatus );
  });
}

function FBLogout() {
  FB.logout(function(response) {
    $('#fblogin').show();
    $('#fbstatus').hide();
  });
}

function FBLogin() {
  FB.login(function(response) {
    if (response.authResponse) {
      getUserInfo(); //Get User Information.
    } else {
      swal({title: 'Oops!', html: 'Authorization Failed!'});
    }
  }, {scope: 'public_profile,email'}
  );
}