<?php if( $data['notice_data'] == false ): ?>
<div class="notes_text">
  <div class="plan_info">
    <p class="plan_note"><strong>Note : </strong> No any <i>Notice</i> is available in this board.</p>
  </div>
</div>
<?php endif; ?>

<?php if( isset($data) && is_array($data) ): ?>
<div class="g_notice_cont">
  <!-- group notice part html-->
  <!-- Create Notice Box -->
  <?php
  /*
  * extracting all the data
  * allow notice creation if admin is showing board
  * data also contains all the name of admins if there are more than one
  * accessing using all_admins array variable
  * you need to explod the array because if admin is more than one then it is
  * in comman seperated
  */
  extract($data);
  $admins = explode(',', $board_detail['all_admins']);
  if( in_array($user->user_id, $admins) || $board_detail['board_admin'] == $user->user_id )
    echo $notice_create_box;
  ?>
  <!-- Create Notice Box End here -->
  <!-- group notice part html-->
  <div id="notice_grp">
    <?php
    if( is_array($data['notice_data']) ):
      $data = $data['notice_data'];
      foreach( $data as $key => $value ) {
        extract($data[$key]);
        $date = date_create($data[$key]['posted_on']);
        $date = date_format($date, "d-m-Y");
        $posted_time = date_create($data[$key]['posted_time']);
        $posted_time = date_format($posted_time, "H:i");
        date_default_timezone_set('Asia/Calcutta');
        $today_date = date("d-m-Y");
    ?>
    <div id="notices" class="notices">
      <?php if( $key == 0 || $data[$key]['posted_on'] !== $data[($key-1)]['posted_on'] ): ?>
      <div class="nt_dates">
        <div class="nt_dates_container">
          <div class="nt_dates_text">
            <span><?php echo ($date==$today_date) ? "Today" : $date ; ?></span>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php
      $cont_json = array(
        'board_id'  => $board_id,
        'content_id'  => $content_id,
        'posted_date' => $posted_on,
        'is_seen'     => $term_id,
        'total_reply' => $tr,
        'total_seen'  => $ts
        );
      ?>
      <div class="g_notice_wrapper">
        <span class="contentRow" style="display: none;"><?php echo json_encode($cont_json); ?></span>
        <div class="g_notice_time" style="<?php echo ($term_id) ? 'background-color:rgba(243,243,243,.85);' : ''; ?>">
          <div class="g_n_ti_wrapper fl_l">
            <div class="g_notice_title">
              <h3 class="g_n_t_text dotes"><?php echo $content_title; ?></h3>
            </div>
            <div class="g_n_time">
              <p class="g_n_time_text fl_l"><?php echo $posted_time; ?> &nbsp;|</p>
              <!-- notice-tms = notice-totalMemberSeen -->
              <p class="g_n_time_text fl_l"><?php if ($board_id !== 'noticemate') : ?>Seen By : <?php echo '<span id="notice-tms">' . $ts . '</span> member'; ?> <?php endif; ?></p>
            </div>
          </div>
          <div class="g_n_btn fl_r">
            <i class="fa fa-chevron-down f_show"></i>
          </div>

          <div class="pop_up noticepopup none">
            <ul>
              <?php
              extract($data);
              if($board_detail['board_admin'] == $user->user_id): ?>
              <a href="javascript:void(0);">
                <li id="notice-seen-by" conid="notice-<?php echo $content_id; ?>">
                  <i class="fa fa-eye create_g fl_l"></i>
                  <span class="l_text">Who's Seen</span>
                </li>
              </a>
              <a href="javascript:void(0);">
                <li id="<?php echo ($reply_allow == 1) ? $conf_text['reply_off_id'] : $conf_text['reply_on_id'] ?>" conid="notice-<?php echo $content_id; ?>">
                  <i class="fa fa-power-off create_g fl_l"></i>
                  <span class="l_text"><?php echo ($reply_allow == 1) ? $conf_text['reply_off_text'] : $conf_text['reply_on_text'] ?></span>
                </li>
              </a>
              <?php if( $content_type == 11 ): ?>
              <a href="javascript:void(0);">
                <li id="event-attend-detail" conid="notice-<?php echo $content_id; ?>">
                  <i class="fa fa-info create_g fl_l"></i>
                  <span class="l_text">Attend Detail</span>
                </li>
              </a>
              <?php endif; ?>
              <?php endif; ?>
              <a href="javascript:void(0);">
                <li id="forward_notice" conid="notice-<?php echo $content_id; ?>">
                  <i class="fa fa-forward create_g fl_l"></i>
                  <span class="l_text">Forward Notice</span>
                </li>
              </a>
              <a href="javascript:void(0);">
                <li id="hide_notice" conid="notice-<?php echo $content_id; ?>">
                  <i class="fa fa-eye-slash create_g fl_l"></i>
                  <span class="l_text">Hide Notice</span>
                </li>
              </a>
            </ul>
            <div class="arrow-up" style="display: block;">
              <div class="inn_arrow-up"></div>
            </div>
          </div>
        </div>
        <div class="g_main_not_con none">
          <div class="g_main_notice ">
            <div class="g_main_content cs" id="g_main_content"><?php //echo $content; ?></div>
            <div id="cont-<?php echo $content_id; ?>" style="display: none;">
              <?php echo $content; ?>
              <?php
              if( !empty($afname) && !is_null($afname) ) {
                $afilename          = explode('/', $afname);
                $aorigianl_filename = explode('/', $aofname);
                $afile_size         = explode('/', $afsize);
                $afext              = explode('/', $afext);
                $attach_id          = explode('/', $attach_id);
                if( sizeof($afilename) == sizeof($aorigianl_filename) ):
                  foreach ($afilename as $key => $value) {
                ?>
                <div class="sn_file_wrapper f_show_cont">
                  <?php if($key==0): ?><h4 class="atch_text">Attachments :</h4><?php endif; ?>
                  <a id="attachment_download" href="/app.php?mod=download&file=<?php echo $attach_id[$key]; ?>">
                    <div class="sn_f_wrapper_inner">
                      <i class="fa fa-file nt_file_icon"></i>
                      <p class="sn_file_title dotes fl_l at_file"><?php echo $aorigianl_filename[$key]; ?></p>
                      <span id="up_file_size" class="fl_r up_f_size"><?php echo $afile_size[$key]; ?> MB</span>
                    </div>
                  </a>
                </div>
                  <?php } ?>
                <?php endif; ?>
              <?php } ?>
            </div>
          </div>

          <div class="notice_event_section <?php echo ( $tr > 0 || $reply_allow == 1 ) ? 'block' : 'none'; ?>">
            <div class="nes_container">
              <div class="nes_boxes">
                <a class="nex_list fl_l" id="get_reply" conid="notice-<?php echo $content_id; ?>">
                  <i class="fa fa-reply list_icon"></i>
                  <span class="_list_text">Reply</span>
                </a>
                <i class="fa fa-chevron-down fl_l toggle_rep_button" id="toggle_reply" title="toggle reply"></i>
                <div class="nex_list fl_r">
                  <span class="_list_text "><span id="showing_replies">0</span> of <?php echo $tr; ?> Reply</span>
                </div>
              </div>
            </div>
          </div>

          <div id="reply_section" style="display: none;">
            <div class="gmn_comment_wrapper">

            <?php if( $reply_allow == 1 ): ?>
              <?php if( $content_type == 11 ): ?>

              <!-- Notice attendable response start -->
              <div class="res_notice_wrapper">
                <div class="res_notice">
                  <div class="res_yes fl_l" style="padding-top:1px;">
                    <span>Are you attending ?</span>
                  </div>
                  <div class="res_yes fl_l" id="attend-reply">
                    <i class="fa fa-circle-thin yes_checkbox fl_l"></i>
                    <span class="fl_l" id="rep-data" data-content="yes">Yes</span>
                  </div>
                  <div class="res_yes fl_l" id="attend-reply">
                    <i class="fa fa-circle-thin yes_checkbox fl_l"></i>
                    <span class="fl_l" id="rep-data" data-content="no">Not</span>
                  </div>
                  <div class="res_yes fl_l" id="attend-reply">
                    <i class="fa fa-circle-thin yes_checkbox fl_l"></i>
                    <span class="fl_l" id="rep-data" data-content="not-conform">Not Conform</span>
                  </div>
                  <a class="btn rboard-btn btn-small fl_r" id="submit-attend">Done</a>
                  <span class="reply_more_link hovernot fl_l at_rep_note none">If you are not attending in this event please provide reason in the reply section.</span>
                  <?php if( $attend_reply == 'yes' || $attend_reply == 'no' || $attend_reply == 'not-conform' ): ?>
                  <div class="clearfix"></div>
                  <span class="reply_more_link hovernot fl_l" id="prev-attend-reply">Your reply for attending in this event is : 
                    <b><span id="prev-attend-rep-data"><?php echo strtoupper($attend_reply); ?></span></b>
                  </span>
                  <?php endif; ?>
                </div>
              </div>
              <!-- Notice attendable response end -->
              <?php endif; ?>
            <?php endif; ?>

              <div class="gmn_comment">
              <?php
              /*
              @ check if reply allowed
              @ if reply not allowed then commnet section will be hidden
              */
              if( $reply_allow == 1 ):
              ?>
                <div class="gmn_c_img fl_l">
                  <?php
                  if( !@getimagesize(IMG_DOMAIN . '/uploades/small/' . $user->profile_img . '.jpg') )
                    $user_input_img = "/assets/img/default_user_45x45.jpg";
                  else $user_input_img = IMG_DOMAIN . '/uploades/small/' . $user->profile_img . '.jpg';
                  ?>
                  <img src="<?php echo $user_input_img; ?>">
                </div>
                <?php endif; ?>
                <div class="gmn_c_cont fl_l">
                  <div class="gmn_comment_text" title="there is nothing yours">
                  <!--
                    <p class="comment_input notice-<?php echo $content_id; ?>" id="comment_input" conid="notice-<?php echo $content_id; ?>" contenteditable="true" onkeyup="comment.onType(event);">Post a reply...</p>
                  -->
                  <?php if( $reply_allow == 1 ): ?>
                    <textarea onkeyup="comment.commentAreatAdjust(this)" class="comment_input notice-<?php echo $content_id; ?>" id="comment_input" dir="ltr" placeholder="Post a reply..." onkeyup="comment.onType(this.value);"></textarea>
                    <button class="reply_submit fl_l" data-action="reply-submit" conid="notice-<?php echo $content_id; ?>">Reply</button>
                    <?php else: ?>
                    <span class="reply_more_link fl_l hovernot">More reply is not allowed</span>
                    <?php endif; ?>
                    <a class="reply_more_link fl_r" id="more_reply" data-from="notice-<?php echo $content_id; ?>" data-page="0" data-current="" data-all="<?php echo $tr; ?>">view more reply..</a>
                    <a class="reply_more_link location-container fl_l dotes" id="location-container" title="">
                      <div class="loadersmall fl_l none"></div>
                    </a>

                    <?php if( $reply_allow == 1 ): ?>

                    <div class="location" id="share-location">
                      <a href="javascript:void(0);" title="Share your location"><i class="fa fa-map-marker l_icon"></i></a>
                    </div>

                    <?php endif; ?>

                  </div>
                </div>                    
              </div>
              <div id="replied_data"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <?php } endif; ?>
  </div>
  <!-- group notice part html-->
  <!-- </div> -->
  <!-- nm scroll ends here -->
  <?php extract($data);
  if( in_array($user->user_id, $admins) || $board_detail['board_admin'] == $user->user_id ): ?>
  <div class="notice_create_box" board-id="<?php echo $board_detail['board_id']; ?>">
    <style type="text/css">
      .m_content_cont {
        height: 75%;
      }
    </style>
  </div>
  <?php endif; ?>
  <!-- </div>-->

  <?php if( isset($total_notice) && $total_notice > 9 ): ?>

  <div class="nt_dates load_more" id="load_more" boardId="<?php echo $board_detail['board_id']; ?>">
    <div class="nt_dates_container">
      <div class="nt_dates_text">
        <span>Load More</span>
        <span id="load_page" style="display: none;" page="1"></span>
      </div>
    </div>
  </div>

  <?php endif; ?>

</div>

<?php endif; ?>