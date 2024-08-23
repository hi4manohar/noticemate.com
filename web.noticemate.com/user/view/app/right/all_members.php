  <?php if( !isset($data['notice_seen_list']) ): ?>
  <div class="data_replacer" id="all_mem_search">
    <div class="accordion-section-title data_content" id="data-content">
      <div class="data_icon" id="data-icon" style="float:left;">
        <i class="fa fa-arrow-left"></i>
      </div>
      <div class="profile_data_text">
        <span class="dotes">All Members</span>
      </div>
    </div>
    <form class="l_part_search_con" id="r_s" style="display: block;">
      <input class="form-control fuzzy-search" type="text" placeholder="Search..." style="line-height: 2.5;">
      <button class="s_button" type="submit">
        <i class="fa fa-search s_icon"></i>
      </button>
    </form>
    <div class="main">
      <div class="l_part_g_cont nm_scroll" id="r_s">
      <ul class="list">
  <?php endif; ?>
  <?php 
    if( isset( $data['board_members'] ) && is_array($data['board_members']) ):
      foreach( $data['board_members'] as $key => $value ) {
        extract($data['board_members'][$key]);
        if( isset($data['notice_seen_list']) ) {
          $data['board_detail']['board_admin'] = '';
          $data['board_detail']['board_id'] = $board_id;
        }
  ?>
        <li id="<?php echo (isset($data['attending_popup']) && $data['attending_popup'] === true ) ? 'hide_forward' : ''; ?>">
          <!--lpg = left part group -->
          <div class="l_p_g" id="l_p_g">
            <a href="javascript:void(0);" title="<?php echo $user_full_name; ?>">
              <div class="l_p_g_img fl_l" id="member-profile" user-id="<?php echo $user_id; ?>" board-id="<?php echo $data['board_detail']['board_id']; ?>">
                <?php
                if( $profile_img == "" ) {
                  $pf_img_url = "/assets/img/default_user_200x200.jpg";
                } else {
                  $pf_img_url = IMG_DOMAIN . '/uploades/small/' . $profile_img . '.jpg';
                  if( !@getimagesize($pf_img_url) )
                    $pf_img_url = "/assets/img/default_user_45x45.jpg";
                }
                ?>
                <img src="<?php echo $pf_img_url; ?>">
              </div>
            </a>
            <div class="l_p_g_detail fl_l">
              <a href="javascript:void(0);" title="<?php echo $user_full_name; ?>">
                <h2 class="l_p_g_name dotes name">
                  <?php echo $user_full_name; ?>
                </h2>
                <p class="l_p_g_mem dotes">
                  <?php echo (isset($is_admin) && $is_admin==1) ? 'admin' : 'user'; ?>
                </p>
              </a>
            </div>
            <div class="dot_menu fl_r">
              <img src="<?php echo CSS_DOMAIN; ?>/assets/img/dot_menu.png">
            </div>
            <div class="pop_up none">
              <ul>
                <?php if($data['board_detail']['board_admin'] == $data['user']->user_id): ?>
                <a href="javascript:void(0);">
                  <li id="remove-member" user-id="<?php echo $user_id; ?>" board-id="<?php echo $data['board_detail']['board_id']; ?>">
                    <i class="fa fa-paper-plane create_g fl_l"></i>
                    <span class="l_text">Remove User</span>
                  </li>
                </a>
                <?php endif; ?>
                <a href="javascript:void(0);">
                  <li id="member-profile" user-id="<?php echo $user_id; ?>" board-id="<?php echo $data['board_detail']['board_id']; ?>">
                    <i class="fa fa-user create_g fl_l"></i>
                    <span class="l_text">View Profile</span>
                  </li>
                </a>
              </ul>
              <div class="arrow-up">
                <div class="inn_arrow-up"></div>
              </div>
            </div>
          </div>
        </li>
        <?php } ?>
        <?php else: ?>
          <div class="board_empty">
          <div class="board_note">
            <div class="board_note_text">
              <p>Note : No any member is available.</p>
              <p></p>
              <!--<center><p><a href="">Click here to add a member</a></p></center> -->
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if( !isset($data['notice_seen_list']) ): ?>
      </ul>
      </div>
    </div> 
  </div>

  <?php endif; ?>