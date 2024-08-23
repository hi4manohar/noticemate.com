<?php

// Error Reporting
error_reporting(E_ALL);

// Check Version
if (version_compare(phpversion(), '5.3.0', '<') == true) {
  exit('PHP5.3+ Required');
}

// Magic Quotes Fix
if (ini_get('magic_quotes_gpc')) {
  function clean($data) {
      if (is_array($data)) {
        foreach ($data as $key => $value) {
          $data[clean($key)] = clean($value);
        }
    } else {
        $data = stripslashes($data);
    }

    return $data;
  }

  $_GET = clean($_GET);
  $_POST = clean($_POST);
  $_COOKIE = clean($_COOKIE);
}

// Windows IIS Compatibility
if (!isset($_SERVER['DOCUMENT_ROOT'])) {
  if (isset($_SERVER['SCRIPT_FILENAME'])) {
    $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
  }
}

if (!isset($_SERVER['DOCUMENT_ROOT'])) {
  if (isset($_SERVER['PATH_TRANSLATED'])) {
    $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
  }
}

if (!isset($_SERVER['REQUEST_URI'])) {
  $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);

  if (isset($_SERVER['QUERY_STRING'])) {
    $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
  }
}

if (!isset($_SERVER['HTTP_HOST'])) {
  $_SERVER['HTTP_HOST'] = getenv('HTTP_HOST');
}

// Check if SSL
if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
  $_SERVER['HTTPS'] = true;
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
  $_SERVER['HTTPS'] = true;
} else {
  $_SERVER['HTTPS'] = false;
}

//DIR
define( 'ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] );
define( 'USER_DIR', ROOT_DIR . '/user' );
define( 'ADMIN_DIR', ROOT_DIR . '/admin' );
define( 'USER_VIEW_DIR', USER_DIR . '/view' );
define( 'USER_CONTR_DIR', USER_DIR . '/controller' );
define( 'USER_MOD_DIR', USER_DIR . '/model' );
define( 'SYSTEM_DIR', ROOT_DIR . '/system' );
define( 'APP_DIR', USER_VIEW_DIR . '/app' );
define( 'DIR_LANGUAGE', USER_DIR . '/language/' );

//define domains
function localDomains() {
  define( 'IMG_DOMAIN' , 'http://web.noticemate.com' );
  define( 'CDN_DOMAIN',  'http://uploades.noticemate.com' );
  define( 'JS_DOMAIN',   'http://web.noticemate.com' );
  define( 'CSS_DOMAIN',  'http://web.noticemate.com' );
}

//live domains
function liveDomain() {
  define( 'IMG_DOMAIN' , 'http://web.noticemate.com' );
  define( 'CDN_DOMAIN',  'http://uploades.noticemate.com' );
  define( 'JS_DOMAIN',   'http://web.noticemate.com' );
  define( 'CSS_DOMAIN',  'http://web.noticemate.com' );
}


//DBConst
function dbConst() {
  define( 'HOSTNAME', "localhost" );
  define( 'USERNAME', "root" );
  define( 'PASS', "" );
  define( 'DATABASE', "noticemate" );
}

//Live Db Const
function liveDbConst() {
  define( 'HOSTNAME', "localhost" );
  define( 'USERNAME', "user_noticemate" );
  define( 'PASS', "2/.&H96*g?=Cb9&;f-h?" );
  define( 'DATABASE', "noticemate" );
}

//Keys
function keys() {
  define( 'COOKIE', '7eu483jd983kd83ie98oke384k' );
}

// Autoloader
function library($class) {
  $file = SYSTEM_DIR . '/library/' . strtolower($class) . '.php';

  if (is_file($file)) {
    include_once($file);

    return true;
  } else {
    return false;
  }
}

spl_autoload_register('library');

// Engine
require_once( SYSTEM_DIR . '/engine/registry.php');
require_once( SYSTEM_DIR . '/engine/loader.php' );
require_once( SYSTEM_DIR . '/engine/model.php' );
require_once( SYSTEM_DIR . '/engine/controller.php' );

//library
require_once( SYSTEM_DIR . '/library/response.php' );
require_once( SYSTEM_DIR . '/library/db/mpdo.php' );
require_once( SYSTEM_DIR . '/library/cookie.php' );
require_once( SYSTEM_DIR . '/library/encryption.php' );
require_once( SYSTEM_DIR . '/library/user.php' );
require_once( SYSTEM_DIR . '/library/user_input.php' );
require_once( SYSTEM_DIR . '/library/request.php' );

// Helper
require_once( SYSTEM_DIR . '/helper/json.php' );
require_once( SYSTEM_DIR . '/helper/sanitizeop.php' );

?>