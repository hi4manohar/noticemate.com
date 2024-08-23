<?php 
if( isset($data['notifications']) ):
  extract($data);
  foreach ($notifications['title'] as $key => $value) {
    extract($notifications);
?>

    <a href="javascript:void(0);" url-query = '<?php echo $url[$key]; ?>' id="single_ntf" ntf-id="<?php echo $ntf_id[$key]; ?>">
      <div class="n_w_board" id="ntf_row" style="background-color: <?php echo ($is_read[$key] == 1) ? '#fff' : ''; ?>">
        <div class="n_w_pimg fl_l">
          <?php
          $img_src = IMG_DOMAIN . '/uploades/small/' . $p_img[$key] . '.jpg';
          if( ! @getimagesize($img_src) ) {
            $img_src = '/assets/img/default_user_45x45.jpg';
          }
          ?>
          <img src="<?php echo $img_src; ?>">
        </div>
        <div class="n_w_bname_cont fl_l">
          <div class="n_w_bname">
            <span style="color:#707070;"><?php echo $title[$key]; ?></span>
          </div>
          <p class="n_w_time"><?php echo $time[$key]; ?></p>
        </div>
      </div>
    </a>

  <?php } ?>

<?php endif; ?>