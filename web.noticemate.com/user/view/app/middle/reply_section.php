            <div id="reply_section" style="display: none;">
              <div class="gmn_comment_wrapper">

                <?php if( isset($reply_allow) && $reply_allow == 1 ): ?>
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
                    if( isset($reply_allow) && $reply_allow == 1 ):
                    ?>
                    <div class="gmn_c_img fl_l">
                      <img src="<?php echo IMG_DOMAIN; ?>/uploades/small/<?php echo $user->profile_img; ?>.jpg">
                    </div>
                    <?php endif; ?>
                    <div class="gmn_c_cont fl_l">
                      <div class="gmn_comment_text" title="there is nothing yours">
                      <!--
                        <p class="comment_input notice-<?php echo isset($content_id) ? $content_id : ""; ?>" id="comment_input" conid="notice-<?php echo isset($content_id) ? $content_id : ""; ?>" contenteditable="true" onkeyup="comment.onType(event);">Post a reply...</p>
                      -->
                      <?php if( isset($reply_allow) && $reply_allow == 1 ): ?>
                        <textarea onkeyup="comment.commentAreatAdjust(this)" class="comment_input notice-<?php echo $content_id; ?>" id="comment_input" dir="ltr" placeholder="Post a reply..." onkeyup="comment.onType(this.value);"></textarea>
                        <button class="reply_submit fl_l" data-action="reply-submit" conid="notice-<?php echo $content_id; ?>">Reply</button>
                      <?php else: ?>
                        <span class="reply_more_link fl_l hovernot">More reply is not allowed</span>
                      <?php endif; ?>
                        <a class="reply_more_link fl_r" id="more_reply" data-from="notice-<?php echo isset($content_id) ? $content_id : ""; ?>" data-page="0" data-current="" data-all="<?php echo isset($tr) ? $tr : ""; ?>">view more reply..</a>
                        <a class="reply_more_link location-container fl_l dotes" id="location-container" title="">
                          <div class="loadersmall fl_l none"></div>
                        </a>

                        <?php if( isset($reply_allow) && $reply_allow == 1 ): ?>

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