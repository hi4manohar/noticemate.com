  <div id="profiles">
    <div class="data_replacer">
      <div class="accordion-section-title data_content" id="data-content">
        <div class="data_icon" id="data-icon" style="float:left;">
          <i class="fa fa-arrow-left"></i>
        </div>
        <div class="profile_data_text">
          <span class="dotes"><?php echo is_array($data) ? $data['board_detail']['board_name'] . ' profile' : 'Go to Back'; ?></span>
        </div>
      </div>

      <?php 
      if( is_array($data) ): 
        extract($data['board_detail']);
      ?>

      <?php if($board_admin == $data['user']->user_id): ?>

        <div class="b-more-option">
          <a class="btn green rboard-btn btn-small" id="show-board-profile">Profile</a>
          <a class="btn rboard-btn btn-small" id="show-board-privacy">Board Privacy</a>
        </div>

      <?php endif;
      if( $profile_img == "" ) {
        $pf_img_url = "/assets/img/default_user_200x200.jpg";
      } else {
        $pf_img_url = IMG_DOMAIN . '/uploades/medium/' . $profile_img . '.jpg';
        if( !@getimagesize($pf_img_url) )
          $pf_img_url = "/assets/img/default_user_200x200.jpg";
      }
      ?>
      <div id="board-details" style="display: block;">
        <div class="p_image" id="p_image">
          <!-- image-popup-no-margins class uses for opening image popup -->
          <a class="image-popup-no-margins" href="javascript:void(0);" data-mfp-img-src="<?php echo $pf_img_url; ?>">
            <img src="<?php echo $pf_img_url; ?>" alt="<?php echo $board_name; ?>" title="<?php echo $board_name; ?>">
          </a>
          <?php if($board_admin == $data['user']->user_id): ?>
          <form enctype="multipart/form-data" action="/upload_image.php" method="post" name="image_upload_form" id="image_upload_form">
            <div class="progressBar">
              <div class="bar"></div>
              <div class="percent">0%</div>
            </div>
            <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
            <div class="p_img_change">
              Change image
              <input type="hidden" name="update_to" value="bid-<?php echo $board_id; ?>" />
            </div>
          </form>
          <?php endif; ?>
        </div>
        <div class="p_status">
          <div class="main">
            <div class="accordion">
              <div class="accordion-section">
                <a class="accordion-section-title" href="javascript:void(0);">Board name</a>
                <?php if($board_admin == $data['user']->user_id): ?>
                <a class="edit_profile none editSugg" style="right:40px;">50</a>
                <a class="fa fa-pencil edit_profile" data-type="editProfile" editId="editSubject" id="editProfile" title="Edit"></a>
                <?php endif; ?>
                <div id="accordion-2" class="accordion-section-content block">
                  <p id="prev_name" style="display:none;"><?php echo $board_name; ?></p>
                  <p class="dotes" id="editSubject" mod="update_board_subject" update-to="<?php echo 'bid-' . $board_id; ?>"><?php echo $board_name; ?></p>
                </div><!--end .accordion-section-content-->
              </div><!--end .accordion-section-->
              <div class="accordion-section">
                <a class="accordion-section-title" href="javascript:void(0);">Board status</a>
                <?php if($board_admin == $data['user']->user_id): ?>
                <a class="edit_profile none editSugg" style="right:40px;">200</a>
                <a class="fa fa-pencil edit_profile" data-type="editProfile" editId="editStatus" id="editProfile" title="Edit"></a>
                <?php endif; ?>
                <div id="accordion-1" class="accordion-section-content block">
                  <p id="prev_name" style="display:none;"><?php echo $status; ?></p>
                  <p id="editStatus" mod="update_board_status" update-to="<?php echo 'bid-' . $board_id; ?>"><?php echo $status; ?></p>
                </div><!--end .accordion-section-content-->
              </div><!--end .accordion-section-->
              <div class="accordion-section">
                <a class="accordion-section-title" href="javascript:void(0);">Board created on</a>
                <div id="accordion-4" class="accordion-section-content block">
                  <p class="dotes"> <?php $date = date_create($created_on); echo "Date : " . date_format($date, "d-m-Y") . ", Time : " . date_format($date, "H:i"); ?></p>
                </div><!--end .accordion-section-content-->
              </div><!--end .accordion-section-->
              <div class="accordion-section">
                <a class="accordion-section-title" href="javascript:void(0);">Board Master</a>
                <div id="accordion-4" class="accordion-section-content block">
                  <p class="dotes"> <?php echo $user_full_name; ?></p>
                </div><!--end .accordion-section-content-->
              </div><!--end .accordion-section-->
              <?php if($board_admin == $data['user']->user_id): ?>
              <div class="accordion-section">
                <a class="accordion-section-title" href="javascript:void(0);">Board ID for Join</a>
                <div id="accordion-4" class="accordion-section-content block">
                  <p class="dotes"><?php echo $board_dist_id; ?></p>
                </div><!--end .accordion-section-content-->
              </div><!--end .accordion-section-->
              <?php endif; ?>
              <?php if( $board_id !== 'noticemate' ): ?>
              <div class="accordion-section">
                <a class="accordion-section-title" href="javascript:void(0);">All Members</a>
                <div id="accordion-4" class="accordion-section-content block">
                  <p class="dotes"> <?php echo $am; ?></p>
                </div><!--end .accordion-section-content-->
              </div><!--end .accordion-section-->
              <?php endif; ?>
            </div><!--end .accordion-->
          </div> 
        </div>
      </div>

      <?php if($board_admin == $data['user']->user_id): ?>
      <div id="board-privacy-container" style="display: none;" boardid="<?php echo $board_id; ?>">
        <div class="pri_div">
          <div class="pri_chek fl_l">
            <i class="fa fa-circle-thin check_cir fl_l" id="member-allow" value="<?php echo $join_more ?>">
              <i class="fa check <?php echo ($join_more) ? 'fa-check' : 'fa-times'; ?>" id="check"></i>
            </i>
            <span class="priv_name fl_l dotes">Allowed More Members to Join</span><br>
          </div>          
          <div class="board-p-changes fl_l">
            <a class="btn rboard-btn btn-small" id="privacy-save">Save Changes</a>
          </div>          
        </div>
      </div>
      <?php endif; ?>

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