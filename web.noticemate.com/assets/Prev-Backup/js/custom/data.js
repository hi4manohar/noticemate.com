var data = {
  'noticeBox' : function() {
    var d = '<form method="post" action="" onsubmit="return notice.showNoticeTextArea();"><div class="s_n_list">\
      <div class="s_n_type_icon fl_l">\
        <i class="fa fa-pencil-square-o sn_t_icon"></i>\
      </div>\
      <div class="sn_title fl_l">\
        <input type="text" class="s_n_input_title sn_b" autofocus placeholder="What\'s about your notice is ?" maxlength="100" id="title_text">\
      </div>\
      <button class="s_n_next_btn fl_r">Next</button>\
    </div></form>';
    return d;
  },
  'notifBottom' : '<div class="noti_con">\
    <p class="noti_text">Your Request Has been done....</p>\
  </div>',

  'demoReply' : function(jd) {
    if( jd.rep_loc ){
      jd.rep_loc = jd.rep_loc;
      jd.rep_loc_text = 'Location';
    }
    else {
      jd.rep_loc = '';
      jd.rep_loc_text = '';
    }
    var reply_html = '<div class="gmn_comment reply_data_container">\
        <div class="gmn_c_img fl_l">\
          <img src="' + jd.img + '">\
        </div>\
        <div class="gmn_c_cont fl_l" id="reply-text-data">\
          <h3 class="g_n_t_text dotes gmn_c_cont_name_text fl_l" id="reply-sender">'+ jd.name + '</h3>\
          <span class="rep_time" title="">'+ jd.time +'</span>\
          <span class="location_data fl_r" loc="' + jd.rep_loc + '">' + jd.rep_loc_text + '</span>\
          <p class="comment_text" style="padding-top: 3px;">'+ jd.rep_content +'</p>\
        </div>\
      </div>';
      return reply_html;
  },

  'fileUploadContainer' : function(fname, fsize) {
    var html_data = '<div class="sn_file_wrapper" id="file_upload_cont" filename="">\
      <div class="sn_f_wrapper_inner">\
        <a href="javascript:void(0);">\
          <i class="fa fa-file nt_file_icon"></i>\
          <p class="sn_file_title dotes fl_l">'+fname+'</p>\
          <span id="up_file_size" class="fl_l up_f_size">'+fsize+'</span>\
        </a>\
        <div class="fl_l sn_progress_bar" id="file_upload_bar">\
          <div class="sn_bar"></div>\
          <div class="sn_percent">X</div>\
        </div>\
        <a href="javascript:void(0);">\
          <div class="sn_hide_btn fl_r" id="up_file_hider">\
            <i class="fa fa-times" style="font-size:12px;color:#8D92A0;"></i>\
          </div>\
        </a>\
      </div>\
    </div>';

    return html_data;
  }
}

var error = {
  boardError : 'The board is not verified!',
  userError : 'The user is not verified!',
  'scriptError' : 'An unknown error found in executing this script!'
}