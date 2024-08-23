<?php if( isset($data['reply_data']) && is_array($data['reply_data']) ): ?>

  <?php foreach ($data['reply_data'] as $key => $value) {
    extract($data['reply_data'][$key]);
    $date = date_create( $date );
    $datetime = date_format($date, 'F d \a\t g:i a');

    $img = IMG_DOMAIN . '/uploades/small/' . $img . '.jpg';
    if( ! @getimagesize($img) ) {
      $img = '/assets/img/default_user_45x45.jpg';
    }
  ?>

  <?php if( !isset($data['show_json']) ): ?>

    <div class="gmn_comment reply_data_container">
      <div class="gmn_c_img fl_l">
        <img src="<?php echo $img; ?>">
      </div>
      <div class="gmn_c_cont fl_l" id="reply-text-data">
        <h3 class="g_n_t_text dotes gmn_c_cont_name_text fl_l" id="reply-sender"><?php echo $name; ?></h3>
        <span class="rep_time" title=""><?php echo $datetime; ?></span>
        <?php if( strlen($reply_location) > 5 ): ?>
        <span class="location_data fl_r" loc="<?php echo $reply_location; ?>">Location</span>
        <?php endif; ?>
        <p class="comment_text" style="padding-top: 3px;"><?php echo $rep_content; ?></p>
      </div>
    </div>

  <?php
  else:
    $data = array(
      'img' => $img,
      'name' => $name,
      'time' => $datetime,
      'rep_content' => $rep_content,
      'status' => true,
      'rep_loc' => $reply_location
    );
    echo json_encode($data);
  ?>
  <?php endif; ?>

  <?php } ?>


<?php endif; ?>