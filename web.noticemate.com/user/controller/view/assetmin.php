<?php

class ControllerViewAssetMin extends Controller {

  public function index() {

    if( isset($this->request->get['type']) && $this->request->get['type'] == 'css' ) {
      echo $this->minCss();
    }

    if( isset($this->request->get['type']) && $this->request->get['type'] == 'js' ) {
      echo $this->minJs();
    }

  }

  public function minJs() {
    $js_files = array(
      'jquery-1.9.1.min.js'                   => JS_DOMAIN . '/assets/js/lib/jquery-1.9.1/jquery-1.9.1.min.js',
      'jquery-ui-1.9.2.custom.min.js'         => JS_DOMAIN . '/assets/js/lib/jquery-1.9.2.custom/jquery-ui-1.9.2.custom.min.js',
      'jquery-form'                           => JS_DOMAIN . '/assets/js/lib/jquery-form/jquery.form.js',
      'jquery.mCustomScrollbar.concat.min.js' => JS_DOMAIN . '/assets/js/lib/mCustomScroll/jquery.mCustomScrollbar.concat.min.js',
      'wiselink'                              => JS_DOMAIN . '/assets/js/lib/wiselink/wiselinks-1.2.2.js',
      'scrollator.js'                         => JS_DOMAIN . '/assets/js/lib/scrollator/fm.scrollator.jquery.js',      
      'tinymceplaceholderjs'                  => JS_DOMAIN . '/assets/js/lib/tinymce/tinymceplaceholder.js',
      'list.js'                               => JS_DOMAIN . '/assets/js/lib/list.js/list.js',
      'foozysearch.js'                        => JS_DOMAIN . '/assets/js/lib/list.js/fuzzysearch.js',
      'sweetalert2.js'                        => JS_DOMAIN . '/assets/js/lib/sweetalert2/dist/sweetalert2.min.js',
      'magnific-popup.js'                     => JS_DOMAIN . '/assets/js/lib/magnific-popup/jquery.magnific-popup.js',
      'js-cookie.js'                          => JS_DOMAIN . '/assets/js/lib/js-cookie/js.cookie.js',
      //'chart.js'                              => JS_DOMAIN . '/assets/js/lib/chart.js/Chart.bundle.js',
      'data.js'                               => JS_DOMAIN . '/assets/js/custom/data.js',
      'common.js'                             => JS_DOMAIN . '/assets/js/custom/common.js',
      'interface.js'                          => JS_DOMAIN . '/assets/js/custom/interface.js',
      'tinymceCustom'                         => JS_DOMAIN . '/assets/js/custom/tinymceCustom.js',
      'ajax_request.js'                       => JS_DOMAIN . '/assets/js/custom/ajax_request.js',
      'content.js'                            => JS_DOMAIN . '/assets/js/custom/content.js',
      'board.js'                              => JS_DOMAIN . '/assets/js/custom/board.js',
      'user.js'                               => JS_DOMAIN . '/assets/js/custom/user.js',
      'profileEdit.js'                        => JS_DOMAIN . '/assets/js/custom/profileEdit.js',
      'login_signup.js'                       => JS_DOMAIN . '/assets/js/custom/login_signup.js',
      'comment.js'                            => JS_DOMAIN . '/assets/js/custom/comment.js',
      'magnific-popup-custom.js'              => JS_DOMAIN . '/assets/js/custom/magnefic-popup-custom.js',
      'bottom.js'                             => JS_DOMAIN . '/assets/js/custom/bottom.js',
      'fb_login.js'                           => JS_DOMAIN . '/assets/js/custom/fb_login.js',
      'media-query-interaction.js'            => JS_DOMAIN . '/assets/js/custom/media-query-interaction.js',
      'attend_comment.js'                     => JS_DOMAIN . '/assets/js/custom/attend_comment.js'
    );

    $buffer = "";
    foreach ($js_files as $key => $js_file) {
      $buffer .= "\n\n//$key\n\n" . file_get_contents($js_file);
    }
    
    // Enable caching
    header('Cache-Control: public');
        
    // Expire in one day
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
        
    // Set the correct MIME type, because Apache won't set it for us
    header("Content-type: text/js");

    return $buffer;
  }

  public function minCss() {
    /**
     * On-the-fly CSS Compression
     * Copyright (c) 2009 and onwards, Manas Tungare.
     * Creative Commons Attribution, Share-Alike.
     *
     * In order to minimize the number and size of HTTP requests for CSS content,
     * this script combines multiple CSS files into a single file and compresses
     * it on-the-fly.
     *
     * To use this in your HTML, link to it in the usual way:
     * <link rel="stylesheet" type="text/css" media="screen, print, projection" href="/css/compressed.css.php" />
     */
    
    /* Add your CSS files to this array (THESE ARE ONLY EXAMPLES) */
    $cssFiles = array(
      'demo.css'                    => CSS_DOMAIN . '/assets/css/lib/demo.css',
      'jquery.mCustomScrollbar.css' => CSS_DOMAIN . '/assets/css/lib/jquery.mCustomScrollbar.css',
      'magnefic-popup.css'          => CSS_DOMAIN . '/assets/js/lib/magnific-popup/magnific-popup.css',
      'font-awesome.min.css'        => CSS_DOMAIN . '/assets/css/lib/font-awesome-4.4.0/css/font-awesome.min.css',
      'web.css'                     => CSS_DOMAIN . '/assets/css/custom/web.css',
      'home.css'                    => CSS_DOMAIN . '/assets/css/custom/home.css',
      'sweetalert2.css'             => CSS_DOMAIN . '/assets/js/lib/sweetalert2/dist/sweetalert2.css',
      'scrollator.css'              => CSS_DOMAIN . '/assets/js/lib/scrollator/fm.scrollator.jquery.css',
      'showNotice.css'              => CSS_DOMAIN . '/assets/css/custom/showNotice.css',
      'comment.css'                 => CSS_DOMAIN . '/assets/css/custom/comment.css',
      'rightbar.css'                => CSS_DOMAIN . '/assets/css/custom/rightbar.css',
      'noticeType.css'              => CSS_DOMAIN . '/assets/css/custom/noticeTypeSystem.css',
      'lib_custom.css'              => CSS_DOMAIN . '/assets/css/custom/lib_custom.css',
      'media-query.css'             => CSS_DOMAIN . '/assets/css/custom/media-query.css'
    );
    
    /**
     * Ideally, you wouldn't need to change any code beyond this point.
     */
    $buffer = "";
    foreach ($cssFiles as $cssFile) {
      $buffer .= file_get_contents($cssFile);
    }
    
    // Remove comments
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    
    // Remove space after colons
    $buffer = str_replace(': ', ':', $buffer);
    
    // Remove whitespace
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    
    // Enable GZip encoding.
    ob_start("ob_gzhandler");
    
    // Enable caching
    header('Cache-Control: public');
    
    // Expire in one day
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
    
    // Set the correct MIME type, because Apache won't set it for us
    header("Content-type: text/css");
    
    // Write everything out
    return $buffer;
  }
}

?>