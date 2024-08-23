<div class="notice_create">
  <div class="s_n_input_cont none" id="notice-create-container">
    <form class="notice_content" method="POST" onsubmit="return content.noticeSend();" name="create_notice" id="notice-create-form">
      <div class="notce_info">
        <span class="notice_info_text">
          <h3 id="notice_title_text">Describe your notice here!</h3><i title="Toggle toolbar" class="fa fa-bars" id="showTool"></i>
        </span>
      </div>
      <input type="text" class="s_n_input_title" placeholder="What's about your notice is ?" maxlength="100" disabled="" name="notice_title" />
      <textarea id="mceTinyEditor" name="notice_content" class="s_n_input" type="text_area" placeholder="Describe Your Notice Here ...." active-board='' autofocus></textarea>
      <!-- html of sn_file uploading -->
      <div class="f_u_cont" id="f_u_cont"></div>
      <input type="hidden" name="fattach" value="" id="fattach" />
      <!-- html of sn_file uploading -->
    </form>
    <div class="s_n_attach_con">
      <div class="progressBar" id="imgUploadBar">
        <div class="bar"></div>
        <div class="percent">0%</div>
      </div>
      <form enctype="multipart/form-data" action="/upload_image.php" method="post" name="notice_img_form" id="notice_img_form">
        <a href="javascript:void(0);" title="Inline Image" class="image_upload">
          <i class="fa fa-camera s_n_img fl_l" style="position:relative;" >
          <input type="file" accept="image/*" name="notice_post_img" class="block" id="notice_post_img" />
          <input type="hidden" name="notice_img_upload" value="upload" />
          </i>
        </a>
      </form>
      <form enctype="multipart/form-data" action="/upload_image.php" method="post" name="notice_attach_form" id="notice_attach_form">
        <a href="javascript:void(0);" title="attach pdf">
          <i class="fa fa-file-pdf-o s_n_pdf fl_l" style="position: relative;">
            <input type="file" name="attachment" class="block notice_attachment" id="notice_attachment" />               
          </i>
        </a>
      </form>
      <a href="javascript:void(0);" title="send notice" onclick="$(this).closest('#notice-create-container').find('#notice-create-form').submit();">
        <button class="s_n_btn fl_r" type="submit">Done</button>
      </a>
      <a href="javascript:void(0);" id="select_ntype" title="select notice type">
        <span class="fl_r" style="padding-right:25px; font-size:15px;line-height:35px;">
          <select style="padding: 5px;" onchange="attendReplyType.noticeTypeSelect(this);">
            <option title="Select your notice type">Notice Type</option>
            <option value="regular" title="Normal Notice Type">Regular</option>
            <option value="event" title="Notice is for event">Event Notice</option>
          </select>
        </span>
      </a>
    </div>
  </div>
</div>