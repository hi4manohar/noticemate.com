<?php if( isset($data['attend_detail']) ): extract($data['attend_detail']); ?>
<!-- attend details part html start -->
<div class="data_replacer">
  <div class="accordion-section-title data_content" id="data-content" style="margin-bottom: 10px;">
    <div class="data_icon" id="data-icon" style="float:left;">
      <i class="fa fa-arrow-left"></i>
    </div>
    <div class="profile_data_text">
      <span class="dotes">Member Attending in Event :</span>
    </div>
  </div>
  <div class="pri_div"style="overflow:hidden;padding:6px;">
    <span class="row-members-json json" id="attend-detail-json" style="display: none">
      <?php
      $members_data = array(
        'all_members'           => $am,
        'seen_members'          => $ts,
        'not_seen_members'      => $am - $ts,
        'attending_members'     => $yReply,
        'not_attending_members' => $nReply,
        'not-conformed_members' => $ncReply
        );
      echo json_encode($members_data);
      ?>
    </span>
    <ul>
      <li class="attend_row">
        <span class="fl_l">Total Members</span>
        <p class="fl_l"><?php echo $am; ?></p>
        <a href="javascript:void(0);" class="fl_r" title="List of Total Members" id="foll_bo_all_mem" boardid="<?php echo $event_detail['board_id']; ?>">
          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </a>
      </li>
      <li class="attend_row">
        <span class="fl_l">Seen Total Memebrs</span>
        <p class="fl_l"style="color:#15FBB2;"><?php echo $ts; ?></p>
        <a href="javascript:void(0);" class="fl_r" title="List of Seen Total Members" id="notice-seen-by" conid="notice-<?php echo $event_detail['notice_id']; ?>" data-used="seen-members">
          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </a>
      </li>
      <li class="attend_row">
        <span class="fl_l">Not Seen Memebrs</span>
        <p class="fl_l"style="color:#15FBB2;"><?php echo $am - $ts; ?></p>
        <a href="javascript:void(0);" class="fl_r" title="List of Not Seen Members" id="notice-seen-by" conid="notice-<?php echo $event_detail['notice_id']; ?>" data-used="not-seen-member">
          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </a>
      </li>
      <li class="attend_row">
        <span class="fl_l">Attending Members</span>
        <p class="fl_l"style="color: #FFEB3B;"><?php echo $yReply; ?></p>
        <a href="javascript:void(0);" class="fl_r" title="List of Attending Members" id="notice-seen-by" conid="notice-<?php echo $event_detail['notice_id']; ?>" data-used="attending-members-list">
          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </a>
      </li>
      <li class="attend_row">
        <span class="fl_l">Not Attending Members</span>
        <p class="fl_l"style="color:#F44336;"><?php echo $nReply; ?></p>
        <a href="javascript:void(0);" class="fl_r" title="List of Not Attending Members" id="notice-seen-by" conid="notice-<?php echo $event_detail['notice_id']; ?>" data-used="not-attending-members-list">
          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </a>
      </li>
      <li class="attend_row">
        <span class="fl_l">Not-Conformed Members</span>
        <p class="fl_l"style="color:#F44336;"><?php echo $ncReply; ?></p>
        <a href="javascript:void(0);" class="fl_r" title="List of Not-Conformed Members" id="notice-seen-by" conid="notice-<?php echo $event_detail['notice_id']; ?>" data-used="not-conformed-members-list">
          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </a>
      </li>  
    </ul>
  </div>
  <!--
  <div id="canvas-holder" style="width:50%">
    <canvas id="chart-area" width="300" height="300" />
  </div>
  -->
</div>
<?php endif; ?>
  <!-- attedn details part html end -->