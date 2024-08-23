<?php

class ControllerViewHtmlCssFiles extends Controller {

  public function css_file_in( $file ) {
    if( is_array($file) ) {
      foreach ($file as $key => $value) {
        echo '
        <link rel="stylesheet" type="text/css" href="' . $value . '">'
        ;
      }
    }
    
  }

  public function js_file_in( $file ) {
    if( is_array( $file ) ) {
      foreach ($file as $key => $value) {
        echo '
        <script type="text/javascript" src="' . $value . '"></script>';
      }
    }
  }

  public function css_file() {

    if( defined('localAccess') ) {
      $css_files = array(
        'minified_files'              => JS_DOMAIN . '/assets/nm.min.css'
        );
    } else {
      $css_files = array(
        'minified_files'              => CSS_DOMAIN . '/assets/nm.min.css'
        );
    }
    

    return $css_files;
  }

  public function js_file() {

    if( defined('localAccess') ) {
      $js_files = array(
        'tinymce.min.js'              => JS_DOMAIN . '/assets/js/lib/tinymce/tinymce.min.js',
        'minified_files'              => JS_DOMAIN . '/assets/nm.min.js',        
        'maps.js'                     => 'http://maps.googleapis.com/maps/api/js?key=AIzaSyD1T2VkVvYTeUbgZdIaMq5x1_d_O-eGvt0',
        'recaptcha.js'                => 'https://www.google.com/recaptcha/api.js'
        );
    } else {

      $js_files = array(
        'tinymce.min.js'              => JS_DOMAIN . '/assets/js/lib/tinymce/tinymce.min.js',
        'minified_files'              => JS_DOMAIN . '/assets/nm.min.js',
        'maps.js'                     => 'http://maps.googleapis.com/maps/api/js?key=AIzaSyD1T2VkVvYTeUbgZdIaMq5x1_d_O-eGvt0',
        'recaptcha.js'                => 'https://www.google.com/recaptcha/api.js'
        );      
    }

    return $js_files;

  }
}

?>