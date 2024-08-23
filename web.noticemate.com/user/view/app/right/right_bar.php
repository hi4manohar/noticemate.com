<?php
if( isset($data['load_only_right']) && $data['load_only_right'] === true ):
  echo $data['right_bar_members'];
else:
?>
<!-- right part html start -->
<div class="l_part_containner fl_r" id="board-list">
  <!-- right top user info -->
  <div class="r_part_user">
    <div class="hide-left-bar" title="Hide board list and show followed board" id="mhlb">
      <i class="fa fa-chevron-left"></i>
    </div>
    <div class="l_p_g top-user-row" id="l_p_g" style="background:none;">
      <a href="javascript:void(0);" title="Board profie image">
        <div class="l_p_g_img fl_l" id="user_menu_p_img">
          <?php
          if( $data['right_top_user']['profile_img'] == "" ) {
            $img = "/assets/img/default_user_45x45.jpg";
          } else {
            $img = IMG_DOMAIN . '/uploades/small/' . $data['right_top_user']['profile_img'] . '.jpg';
            if( !@getimagesize($img) )
              $img = "/assets/img/default_user_45x45.jpg";
          }
          ?>
          <img src="<?php echo $img; ?>">
        </div>
      </a>
      <div class="l_p_g_detail fl_l" id="membership-plan">
        <a href="javascript:void(0);" title="<?php echo $data['right_top_user']['user_full_name']; ?>">
          <h2 class="l_p_g_name dotes">
            <?php echo $data['right_top_user']['user_full_name']; ?>
          </h2>
          <p class="l_p_g_mem dotes">
            Online
          </p>
        </a>
      </div>
      <div class="dot_menu fl_r">
        <img src="<?php echo CSS_DOMAIN; ?>/assets/img/dot_menu.png">
      </div>
      <?php
        if( !function_exists('com_popup') )
          echo $data['left_popup'];
        echo $data['right_top_popup'];
        com_popup( $rightTopPopup = rightTopPopupData() );
      ?>
    </div>
  </div>
  <!-- right top user info end -->
  <div class="l_part_header" id="r_s">
    <h1>YOUR CREATED BOARD</h1>
    <div class="data_icon seen_list" id="data-icon" style="float:left;position: absolute;top: 80px;left: 20px;color: #E0D4D4; display: none;">
      <i class="fa fa-arrow-left"></i>
    </div>
  </div>
  <form class="l_part_search_con" id="r_s">
    <input class="form-control fuzzy-search" type="text" placeholder="Search...">
    <button class="s_button" type="submit">
      <i class="fa fa-search s_icon"></i>
    </button>
  </form>
  <div class="l_part_g_cont nm_scroll" id="r_s">
    <div class="scroll-bottom-pad">
      <!-- ul added for foozyseach with id -->
      <ul class="list" id="right-cr-board">
        <?php echo $data['right_bar_members']; ?>
      </ul>
    </div>
  </div>
  <div class="profiles nm_scroll none" id="dyn_rightside">
    <div id="paste_here"></div>
  </div>
  <div class="noti_con none">
    <p class="noti_text" id="bottom_notif"></p>
  </div>
</div>
<?php endif; ?>
<!-- right part html end -->