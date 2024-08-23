  <?php if( is_array($data) ){ ?>
    <?php
    foreach( $data as $key => $value ) {
      extract($data[$key]);
      $board_json = array(
        'board_id'      => $board_id,
        'board_name'    => $board_name,
        'board_p_img'   => $profile_img,
        'total_member'  => $am,
        'all_memebers'  => $ml
        );
    ?>
    <li class="bid-<?php echo $board_id; ?>">
    <!--lpg = left part group -->
    <div class="l_p_g" id="l_p_g">
    
    <span class="foll_bo_row" style="display:none"><?php echo json_encode($board_json); ?></span>
      <div id="foll_bo_prof" boardId="<?php echo $board_id; ?>">
        <a href="javascript:void(0);" title="group profie image">
          <div class="l_p_g_img fl_l">
            <img src="<?php echo ($profile_img == "") ? "/assets/img/default_user_200x200.jpg" : IMG_DOMAIN . '/uploades/small/' . $profile_img . '.jpg'; ?>">
          </div>
        </a>
      </div>
      <div id="view_notice" boardId="<?php echo $board_id; ?>">
        <div class="l_p_g_detail fl_l">
          <a href="javascript:void(0);" title="<?php echo $board_name; ?>">
            <h2 class="l_p_g_name dotes name" id="board_name">
              <?php echo $board_name; ?>
            </h2>
            <p class="l_p_g_mem dotes" id="board_summary">
              <?php echo ($board_id !== 'noticemate') ? 'Members : ' . $am : 'online'; ?>
            </p>
          </a>
        </div>
      </div>      
      <a href="javascript:void(0);">
        <div class="f_g_notice fl_r <?php echo ( $tn > 0 ) ? 'block' : 'none'; ?>" id="tn-block">
          <span class="f_g_n_no" id="tn_notif"><?php echo $tn; ?></span>
        </div>
      </a>
      <div class="dot_menu fl_r">
        <img src="<?php echo CSS_DOMAIN; ?>/assets/img/dot_menu.png">
      </div>
      <?php
        if( !function_exists('com_popup') )
          echo $left_popup;
        left_popup( $board_id );
      ?>
    </div>
    </li>
    <?php } ?>
  <?php } else { ?>
  <div class="board_empty">
    <div class="board_note">
      <div class="board_note_text">
        <p>Note : You have not Joined in any board yet.</p>
        <p>To Join in a board you must have a <i>Verified</i> board id</p>
        <center><p><a href="javascript:void(0);" id="join-board">Click here to join a board</a></p></center>
      </div>
    </div>
  </div>
  <?php } ?>