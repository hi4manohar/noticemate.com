  <div class="middle_containner hper">
  <!-- header part -->
    <div class="heading_containner">
      <!-- Menu for second login theme -->
      <div class="heading_c_inn">
        <a href="http://web.noticemate.com" title="Go to NoticeMate App">
          <div class="h_lg fl_l">
              <div class="cir_logo fl_l">
                <img src="<?php echo CSS_DOMAIN; ?>/assets/img/logo/in_logo.png" alt="NoticeMate Logo">
              </div>
            <h1 class="fl_l">Noticemate</h1>
          </div>
        </a>
      </div>
      <!-- Menu for second login them end -->
      <ul class="h_menu fl_r">
        <li><a href="/" title="home" style="background-color: rgba(28,128,221,1); border-radius: 20px;">Home</a></li>
        <li><a href="http://www.noticemate.com/static/about.php" title="about us">About</a></li>
        <li><a href="/static/services.php" title="services">Fatures</a></li>
        <li><a href="#" title="our devlopers team">Plans</a></li>
        <li><a href="/static/team.php" title="may i help">Teem</a></li>
        <li><a href="/static/ask.php" title="frequently ask question">F&Q</a></li>
        <li><a href="/static/contact_us.php" title="contact us">Contact Us</a></li>
      </ul>
    </div>
    <!-- header part -->
    <div class="m_content_cont nm_scroll" id="nm_scroll">
    <!--
    <div class="t_containner">
      <h1 class="t_con_headf">
        We can setup 1k's of Notice Board
      </h1>
      <h1 class="t_con_heads">
        in less then 1 minute
      </h1>
      <h1 class="t_con_heads">
        Just For
      </h1>
      <h1 class="t_con_headt">
        <span>You</span>
      </h1>
    </div>
    -->
      <div class="content_containner_inn">
        <div class="nm_logo">
          <div class="nm_logo_text">
            <span><img src="<?php echo CSS_DOMAIN; ?>/assets/img/logo/nm_logo.png"></span>
          </div>
        </div>

        <style type="text/css">
        .nm_logo_text{
          text-align: center;
          font-size: 25px;
          font-family: corbel;
          color: #1F1F3C;
        }
        h1.fl_l:after {
          content: "Beta";
          font-size: 10px;
          top: 18px;
          position: absolute;
          margin-left: 5px;
        }
        .h_lg{
          background-color: inherit;
          margin-left: 17%;
        }
        .h_lg h1{
          color: #fff;
            font-size:27px;
            padding: 15px 0px;
        }
        .cir_logo{
          width: 40px;
          height: 40px;
          border-radius: 50%;
            background-color: #fff;
          overflow: hidden;
          margin: 10px 8px;
        }
        .cir_logo img{
          width: 40px;
        }
        .nm_logo_text img {
          display: none;
        }
        .main_containner_inner {
          width: 100%;
          background-color: inherit;
          background-image:url(<?php echo CSS_DOMAIN; ?>/assets/img/bg.jpg);
          background-repeat: no-repeat;
          background-size: 100% 100%;
          height: 100%;
          top: 0;
        }
        .middle_containner{
          background-color: inherit;
          height: auto;
        }
        .m_content_cont{
          background-color: inherit;
          height: auto;
        }
        .content_containner_inn{
          float: right;
          margin: 11% 10% 2% 0%;
        }
        .form_containner_inner a:hover {
          text-decoration: underline;
        }
        </style>
        <script type="text/javascript">
        document.getElementById("nm_scroll").className = "";
        </script>
        <?php
        if( isset($data['internal_file']) ){
          echo $data['internal_file'];
        }
        ?>
      </div>
    </div>
  </div> 
  <?php
  if( isset($data['fixedfooter']) ){
    echo $data['fixedfooter'];
  }
  ?>