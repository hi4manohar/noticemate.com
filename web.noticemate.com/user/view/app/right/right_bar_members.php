  <?php 
  if( is_array($data) ){
    if( isset($data['load_only_forward']) ) {
      $lof = $data['load_only_forward'];
      $data = $data['right_member'];
    }
    if( isset($data['plan_type']) ) {
      $boards = $data['boards'];
      $plan_type = $data['plan_type'];
      $data = $boards;
      unset($boards);

      //user json row
      $create_allow = ( $plan_type['allowed_board'] - $plan_type['tcb'] > 0 ) ? true : false;
      $user_row = array(
        'board_allow'   => $plan_type['allowed_board'],
        'people_allow'  => $plan_type['allowed_people'],
        'board_created' => $plan_type['tcb'],
        'create_allow'  => $create_allow
        );
    }
  ?>
    <span class="user_row" id="user_row" style="display: none;"><?php echo (isset($user_row)) ? json_encode($user_row) : ''; ?></span>
    <?php foreach( $data as $key => $value ) { ?>
    <!--lpg = left part group -->
    <li>
    <div class="l_p_g  <?php echo ( isset($lof) ) ? 'fwd_notice' : ''; ?>" id="l_p_g" boardid="<?php echo $data[$key]['board_id']; ?>">
      <div id="<?php echo ( isset($lof) ) ? '' : 'foll_bo_prof'; ?>" boardid="<?php echo $data[$key]['board_id']; ?>">
        <a href="javascript:void(0);" title="group profie image">
          <div class="l_p_g_img fl_l">
            <?php
            if( $data[$key]['profile_img'] == "" ) {
              $img = "/assets/img/default_user_200x200.jpg";
            } else {
              $img = IMG_DOMAIN . '/uploades/small/' . $data[$key]['profile_img'] . '.jpg';
              if( !@getimagesize($img) ) {
                $img = "/assets/img/default_user_200x200.jpg";
              }
            }
            ?>
            <img src="<?php echo $img ?>" alt="">
          </div>
        </a>
      </div>
      <div id="<?php echo ( isset($lof) ) ? '' : 'view_notice'; ?>" boardid="<?php echo $data[$key]['board_id']; ?>" >
        <div class="l_p_g_detail fl_l">
          <a href="javascript:void(0);" title="<?php echo $data[$key]['board_name']; ?>">
            <h2 class="l_p_g_name dotes name" id="board_name">
              <?php echo $data[$key]['board_name']; ?>
            </h2>
            <p class="l_p_g_mem dotes" id="board_summary" title="<?php echo 'Members : ' . $data[$key]['am']; ?>">
              <?php echo 'Members : ' . $data[$key]['am']; ?>
            </p>
            <p class="none" id="all_board_members"><?php echo $data[$key]['ml']; ?></p>
          </a>
        </div>
      </div>

      <?php
      /*
      @check if data is accessing for only forward notice then it will hide
      */
      if( ! isset($lof) ):
      ?>
        <div class="dot_menu fl_r">
          <img src="<?php echo CSS_DOMAIN; ?>/assets/img/dot_menu.png">
        </div>

        <div class="pop_up none">
          <ul>
            <a href="javascript:void(0);">
              <li id="view_notice" boardId="<?php echo $data[$key]['board_id']; ?>">
                <i class="fa fa-paper-plane create_g fl_l"></i>
                <span class="l_text">Send Notice</span>
              </li>
            </a>
            <a href="javascript:void(0);">
              <li id="foll_bo_prof" boardid="<?php echo $data[$key]['board_id']; ?>">
                <i class="fa fa-user create_g fl_l"></i>
                <span class="l_text">View Profile</span>
              </li>
            </a>
            <a href="javascript:void(0);">
              <li id="foll_bo_all_mem" boardId="<?php echo $data[$key]['board_id']; ?>">
                <i class="fa fa-users create_g fl_l"></i>
                <span class="l_text">All Members</span>
              </li>
            </a>
            <a href="javascript:void(0);">
              <li id="delete-board" boardId="<?php echo $data[$key]['board_id']; ?>">
                <i class="fa fa-trash create_g fl_l"></i>
                <span class="l_text">Delete Board</span>
              </li>
            </a>
          </ul>
          <div class="arrow-up">
            <div class="inn_arrow-up"></div>
          </div>
        </div>

      <?php endif; ?>

    </div>
    </li>
    <?php } ?>
  <?php } else { ?>
      <span class="user_row" id="user_row" style="display: none;">{"create_allow" : true}</span>
      <div class="board_empty">
        <div class="board_note">
          <div class="board_note_text">
            <p>Note : You have not created any board yet.</p>
            <p>Currently you are allowed to create only <i>3 board</i> in demo plans.</p>
            <center><p><a href="javascript:void(0);" id="create-board">Click here to create a board</a></p></center>
          </div>
        </div>
      </div>
  <?php } ?>
  <?php
  /*
  check if data is accessing only for forwarding the notice
  */
  if( !isset($lof) ):
    if( isset($plan_type) ) {
      if( $plan_type['plan_type'] == 2 ):
  ?>
    <!-- commented because not want to show board plans here
      <div class="board_empty">
        <div class="board_note">
          <div class="board_note_text">
            <p>Plan type : <b>Demo Plans</b>.</p>
            <p>No. of Board Allowed : <b><?php echo $plan_type['allowed_board']; ?></b></p>
            <p>Total Member allowed : <b><?php echo $plan_type['allowed_people']; ?></b></p>
          </div>
        </div>
      </div>
    -->
      <div class="board_empty">
        <div class="board_note">
          <div class="board_note_text">
            <p><a href="">Upgrade your membership plan.</a></p>
            <p><a href="">Read more about <b>board</b>.</a></p>
          </div>
        </div>
      </div>
  <?php endif; } endif; ?>