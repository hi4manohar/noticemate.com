<?php if( isset($data) ): extract($data); ?>
<!DOCTYPE html>
<html>
<head>
  <noscript><meta http-equiv="refresh" content="0; URL=/errordoc/badbrowser"></noscript>
  <title><?php echo isset($datas['heading_title']) ? $datas['heading_title'] : "NoticeMate"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="format-detection" content="telephone=no"/>
  <meta name="google" content="notranslate">
  <meta http-equiv="Content-Language" content="en">
  <meta property="fb:app_id" content="">
  <meta property="og:url" content="http://web.noticemate.com">
  <meta property="og:site_name" content="NoticeMate">
  <meta property="og:title" content="Manage enterprise based community easily and smartly">
  <meta property="og:description" content="NoticeMate is a platform where enterprise manages his community and designations easily and smartly. Enterprises using NoticeMate for shaing notices, files, documents and much more with their community at real-time through his smartphone as well as computers from anywhere in the world.">
  <meta property="og:image" content="http://cdn.noticemate.com/files/images/static/logo/nm-social.jpg">
  <meta property="og:image:type" content="image/jpg">
  <meta property="og:image:width" content="500">
  <meta property="og:image:height" content="500">
  <meta property="twitter:site" content="Noticemate">
  <meta property="twitter:creator" content="Noticemate">
  <meta property="twitter:title" content="Noticemate">
  <meta property="twitter:description" content="NoticeMate is a platform where enterprise manages his community and designations easily and smartly. Enterprises using NoticeMate for shaing notices, files, documents and much more with their community at real-time through his smartphone as well as computers from anywhere in the world.">
  <meta property="twitter:image:src" content="http://cdn.noticemate.com/files/images/static/logo/nm-social.jpg">

  <!-- Sytlesheets -->
  <?php
  if( is_array($data['css_file']) ) {
    foreach ($data['css_file'] as $key => $value) {
      echo '
  <link rel="stylesheet" type="text/css" href="' . $value . '">'
      ;
    }
  }
  ?>

  <link rel="icon" href="<?php echo CSS_DOMAIN; ?>/assets/img/favicon.ico" type="image/x-icon">
  <script type="text/javascript">var baseUrl = 'http://web.noticemate.com'; var appUrl  = baseUrl + '/app.php'; var uploadUrl = '<?php echo IMG_DOMAIN; ?>'; var cdn_domain = "<?php echo CDN_DOMAIN; ?>"; var js_domain = "<?php echo JS_DOMAIN; ?>"; var css_domain = "<?php echo CSS_DOMAIN; ?>";</script>
  
</head>
<body>

  <div class="main_containner">
    <div class="main_containner_inner">
      <?php
      if( defined( 'LOADAPP' ) ) {
        if( isset($data['app']) ) {
          foreach ($data['app'] as $key => $value) {
            echo $value;
          }
        }
      } else {
        echo $data['login_page'];
      }
      ?>
    </div>
    <?php
      /*
      @load forward popups and rightleft highlighter
      */
      echo $data['f_popup'];
      echo $data['hightlighter'];
    ?>
  </div>

  <div id="modal"class="modal"></div>
  <div id="modal"class="left_modal"></div>
  <div id="modal"class="right_modal"></div>
  <div id="tmp_cont" style="display: none;"></div>

  <div class="map_main_cont" style="display: none;" id="map-data">
    <div class="map_popup_cont">
      <div class="map_inner_con">
        <h4>
          <sapn id="map-title" class="map-title">Map Title Exist here</sapn>
          <span id="map-hide" class="map_hide"style="float:right">X</span></h4>
        <div class="map">
          <div id="reply-map-location-popup"></div>
        </div>
        <p class="map_adress">
          <strong style="color:#F3F3F3">Adress : </strong>
          <span id="map-address">Map address could't be displayed!</span>
        </p>
      </div>
    </div>
  </div>

  <?php

    if( is_array( $data['js_file'] ) ) {
      foreach ($data['js_file'] as $key => $value) {
        echo '
        <script type="text/javascript" src="' . $value . '"></script>';
      }
    }

    //check if any external script is set
    extract($data);
    if( isset($js_script[0]) && is_array($js_script) ) {
      foreach ($js_script as $key => $value) {
        echo $value;
      }
    }
  ?>

</body>
</html>

<?php

exit();

endif;

?>