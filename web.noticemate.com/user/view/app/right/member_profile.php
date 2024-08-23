  <div id="profiles">
    <div class="data_replacer">
      <div class="accordion-section-title data_content" id="data-content">
        <div class="data_icon" id="data-icon" style="float:left;">
          <i class="fa fa-arrow-left"></i>
        </div>
        <div class="profile_data_text">
          <span class="dotes"><?php echo is_array($data) ? $data['profile_detail']['user_full_name'] . ' profile' : 'Go to Back'; ?></span>
        </div>
      </div>
      <?php 
      if( is_array($data) ): 
        extract($data['profile_detail']);
      $mem_replacer = ($user_id == $data['user']->user_id) ? 'Your' : 'Member';
      ?>
      <div class="p_image" id="p_image">
      <?php
      if( $profile_detail['profile_img'] == "" ) {
        $pf_img_url = "/assets/img/default_user_200x200.jpg";
      } else {
        $pf_img_url = IMG_DOMAIN . '/uploades/medium/' . $profile_detail['profile_img'] . '.jpg';
        if( !@getimagesize($pf_img_url) )
          $pf_img_url = "/assets/img/default_user_200x200.jpg";
      }
      ?>
        <a class="image-popup-no-margins" href="javascript:void(0);" data-mfp-img-src="<?php echo $pf_img_url; ?>">
          <img src="<?php echo $pf_img_url; ?>" alt="<?php echo $user_full_name; ?>" title="<?php echo $user_full_name; ?>"/>
        </a>
        <?php if($user_id == $data['user']->user_id): ?>
        <form enctype="multipart/form-data" action="/upload_image.php" method="post" name="image_upload_form" id="image_upload_form">
          <div class="progressBar">
            <div class="bar"></div>
            <div class="percent">0%</div>
          </div>
          <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
          <div class="p_img_change">
            Change image
            <input type="hidden" name="update_to" value="uid-<?php echo $user_id; ?>"></input>
          </div>
        </form>
        <?php endif; ?>

      </div>
      <div class="p_status">
        <div class="main">
          <div class="accordion">
            <div class="accordion-section">
              <a class="accordion-section-title" href="javascript:void(0);"><?php echo $mem_replacer; ?> name</a>
              <?php if($user_id == $data['user']->user_id): ?>
              <a class="edit_profile none editSugg" style="right:40px;">50</a>
              <a class="fa fa-pencil edit_profile" data-type="editProfile" editId="editSubject" id="editProfile" title="Edit"></a>
              <?php endif; ?>
              <div id="accordion-2" class="accordion-section-content block">
                <p id="prev_name" style="display:none;"><?php echo $user_full_name; ?></p>
                <p class="dotes" id="editSubject" mod="update_member_subject" update-to="<?php echo 'uid-' . $user_id; ?>"><?php echo $user_full_name; ?></p>
              </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
              <a class="accordion-section-title" href="javascript:void(0);"><?php echo $mem_replacer; ?> status</a>
              <?php if($user_id == $data['user']->user_id): ?>
              <a class="edit_profile none editSugg" style="right:40px;">200</a>
              <a class="fa fa-pencil edit_profile" data-type="editProfile" editId="editStatus" id="editProfile" title="Edit"></a>
              <?php endif; ?>
              <div id="accordion-1" class="accordion-section-content block">
                <p id="prev_name" style="display:none;"><?php echo $status; ?></p>
                <p id="editStatus" mod="update_member_status" update-to="<?php echo 'uid-' . $user_id; ?>"><?php echo $status; ?></p>
              </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
              <?php if (isset($joined_on)): ?>
              <a class="accordion-section-title" href="javascript:void(0);">Member Joined on</a>
              <div id="accordion-4" class="accordion-section-content block">
                <p class="dotes"> <?php $date = date_create($joined_on); echo "Date : " . date_format($date, "d-m-Y") . ", Time : " . date_format($date, "H:i"); ?></p>
              </div>
              <?php else : ?>
              <a class="accordion-section-title" href="javascript:void(0);">Registered on</a>
              <div id="accordion-4" class="accordion-section-content block">
                <p class="dotes"> <?php $date = date_create($registered_on); echo "Date : " . date_format($date, "d-m-Y") . ", Time : " . date_format($date, "H:i"); ?></p>
              </div>
              <?php endif; ?>
            </div><!--end .accordion-section-->
            <div class="accordion-section">
              <a class="accordion-section-title" href="javascript:void(0);">Total Board Joined in</a>
              <div id="accordion-4" class="accordion-section-content block">
                <p class="dotes"> <?php echo $tbji; ?></p>
              </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
          </div><!--end .accordion-->
        </div> 
      </div>
      <?php else: ?>
      <div class="board_empty">
        <div class="board_note">
          <div class="board_note_text">
            <p>Note : Profile cannot be loaded.</p>
          </div>
        </div>
      </div>
    <?php endif; ?>
    </div>
  </div>