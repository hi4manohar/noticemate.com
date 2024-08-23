  <div class="middle_containner fl_l">
    <div class="m_header" id="m_header">
    <!--
      <div class="menu_toogle fl_l">
        <i class="fa fa-bars t_menu"></i>
      </div>
    -->
      <div class="l_p_g width lpg_shadow fl_l">
        <a href="javascript:void(0);" title="group profie image">
          <div class="l_p_g_img fl_l" id="top_header_src">
            <img src="<?php echo CSS_DOMAIN; ?>/assets/img/default_user_200x200.jpg" />
          </div>
        </a>
        <div class="l_p_g_detail fl_l">
          <a href="javascript:void(0);" title="group detail">
            <h2 class="l_p_g_name dotes" id="top_header_name"></h2>
            <p class="l_p_g_mem dotes" id="top_header_sum"></p>
          </a>
        </div>
      </div>
      <div class="notification fl_r" id="show_notification">
        <i class="fa fa-bell notification_icon"></i>
        <div class="no_notifi">
          <p class="no_noti" id="total_notif"><?php echo ( isset($data['total_notif']) && $data['total_notif'] > 0 ) ? $data['total_notif'] : ''; ?></p>
        </div>
      </div>
      <!-- notification part html-->
      <div class="not_wrapper pop_up none" id="notf_cont">
        <div class="n_w_header">
          <h3 class="fl_l">Notifications</h3>
        </div>
        <div class="n_w_main_con nm_scroll">
          <div id="notification_placer"><div class="loadersmall"></div></div>
          <div id="pagn-div" style="text-align: center;">
            <a class="btn btn-small" id="notif-pagn" page="1">Load More</a>
          </div>
        </div>
        <!--
        <div class="arrow-up n_w_up_arrow">
          <div class="inn_arrow-up m_arrow no_arrow"></div>
        </div>
        -->
      </div>
      <!-- notification part html-->
    </div>
    <style type="text/css">
    .home_cont_div{
      background-color: white;
      width: 90%;
      margin: 0 auto;
      margin-bottom: 10px;
      box-shadow: 0 2px 16px #ccc;
    }
    .n_board_name h1{
      margin-top: 10px;
      font: 300 31px/44px "Open Sans",arial,sans-serif;
    }
    .home_img_div img{
      width: 100%;
      margin-top: 10px;
      margin-bottom: 10px;
    }
    .home_img_div{
      width: 95%;
      margin: 0 auto;
      position: relative;
    }
    .text_img{
      position: absolute;
      top: 43px;
      color: #fff;
      right: 40px;
      line-height: 1.2;
      font-family: cursive;
    }
    </style>
    <div class="m_content_cont nm_scroll">
      <div id="goto_top"></div>
      <div id="main" content="middle_data">
        <div class="home_cont_div">
        <!--
          <div class="n_board_img">
            <img src="<?php echo CSS_DOMAIN; ?>/assets/img/photo.png">
          </div>
        -->
          <div class="n_board_name">
            <h1>Welcome to NoticeMate</h1>
          </div>
          <div class="n_board_detail">
            <p>Here we are send a notice in higher authority to lower authority in this web application we manage a lots of community and send information lots people simultaneously.</p>
          </div>
          <div class="btn_cont">
            <button class="know_more">How to use NM</button>
          </div>
        </div>
        <div class="home_cont_div">
          <div class="home_img_div">
            <img src="<?php echo CSS_DOMAIN; ?>/assets/img/ddd.jpg">
            <h2 class="text_img">Time Saving<br> Notice Delivery</h2>
          </div>
        </div>
      </div>
    </div>
    <div id="noticeWriteBox"></div>
  </div>