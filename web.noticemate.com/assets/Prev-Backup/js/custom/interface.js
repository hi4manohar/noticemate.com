var fileAttachArr = [];
$(document).ready(function() {
  $(document).on('click', 'body', function() {
    $('.pop_up').hide();
  })

  $(document).on('click', '.dot_menu', function(e){
    e.stopPropagation();
    var curShowPop     = $(this).closest('#l_p_g').find(".pop_up");
    var popupArrow     = curShowPop.find('.arrow-up');
    $('.pop_up').not(curShowPop).hide();
    var popupHeight    = curShowPop.height();
    var distanceBottom = $(window).height() - $(this).offset().top - 100 ;
    if( distanceBottom < popupHeight ) {
      $(curShowPop).toggle();
      var topInPx      = -popupHeight-10+'px';
      $(curShowPop).css('top', topInPx);
      $(popupArrow).css('display', 'none');
    } else {
      $(curShowPop).toggle();
      $(curShowPop).css('top', '62px');
      $(popupArrow).css('display', 'block');
    }
  });

  $(document).on('click', '.f_show', function(e) {
    e.stopPropagation();
    var popdiv = $(this).closest('.g_n_btn').next();
    $(popdiv).toggle();
    $('.pop_up').not(popdiv).hide();

    var popdiv_height = $(popdiv).height();
    var pop_distance_bottom = $(this).offset().top - $('#noticeWriteBox').offset().top + 50;
    var popupArrow     = popdiv.find('.arrow-up');
    if( -pop_distance_bottom < popdiv_height ) {
      $(popdiv).css('top', '-130px');
      $(popupArrow).css('display', 'none');
    } else {
      $(popupArrow).css('display', 'block');
    }
  });

  // notice page script
  $(document).on('click', '.g_n_ti_wrapper', function(e) {
    var curSelector    = $(this).closest('.g_notice_time');
    var parentDiv      = $(this).closest('.g_notice_wrapper');
    /*
    @first get the content of 'cont-content_id' data and replace with .g_mian_content
    @check if .g_main_content contain data than show content
    @else replace data and then update to seen content to database
    */
    if( $(parentDiv).find('.g_main_content').html().length == 0 ) {
      var content_json   = parentDiv.find('.contentRow').html();
      var obj            = cm.parseJSON(content_json);
      var not_content    = $('#cont-'+obj.content_id+'').html();
      $(parentDiv).find('.g_main_content').html(not_content);
      if( obj.is_seen == null ) {
        content.noticeSeen(obj.content_id, obj.board_id);
        //update total member seen        
        $(this).find('#notice-tms').text(parseInt(obj.total_seen) + 1);

        //get currently how many notice is left in that board
        var board               = 'bid-' + obj.board_id;
        var left_notice         = $('.' + board).find('#tn_notif').text();
        var total_notice_block  = $('.' + board).find('#tn-block');
        left_notice = parseInt(left_notice);
        if( left_notice < 2 ) {
          total_notice_block.hide();
        }
      }
    }
    //toggle content of clicked notice
    $(parentDiv).find('.g_main_not_con').slideToggle(100);
    var curShowContent = $(parentDiv).find('.g_main_not_con');
    var curShowTitle = $(parentDiv).find('.g_notice_time');
    //$('.g_main_not_con').not(curShowContent).hide();
    //content chevron manipulation
    var curChevron     = $(parentDiv).find('.f_show');
    //$('.f_show').not(curChevron).removeClass('fa-chevron-up').addClass('fa-chevron-down');
    $(curChevron).toggleClass('fa-chevron-up fa-chevron-down');
    if( $(curChevron).hasClass('fa-chevron-up') ) {
      $(curSelector).css('background-color', '#fff');
      //$('.g_notice_time').not(curSelector).css('background-color', 'rgba(243,243,243,.85)');
    } else {
      $(curSelector).css('background-color', 'rgba(243,243,243,.85)');
    }

  });

  //send notice page script
  $(document).on('click', '.s_n_next_btn', function () {
    var value = $("#title_text").val();
    if (value.length <= 10 ) {
      $(".s_n_input_cont").addClass("none");
      swal( 'Not descriptive!',   "Notice title does't looks like descriptive" );
    } else{

      $(".s_n_input_cont").addClass("block");
      $(".s_n_input_title").val(value);
      $('#notice_title_text').html('Title : ' + value);
      
    }
    $(".m_content_cont").mCustomScrollbar("scrollTo", "#goto_top");
  })

  $(document).on('click', '#view_notice, #load_more', function(e) {
    e.stopPropagation();
    var board_id = $(this).attr('boardId');
    $('.pop_up').hide();
    if( board_id.length == 10 ) {
      $('.modal').show();
      if( $(this).hasClass('load_more') ) {
        var page = $(this).find('#load_page').attr('page');
        page = parseInt(page) + 1;
        content.notice(board_id, 'notice', page);
      } else {
        content.notice(board_id, 'notice');

        var board_name = $(this).find('#board_name').text().trim();
        var board_sum = $(this).find('#board_summary').text().trim();
        var img_src = $(this).prev('#foll_bo_prof').find('.l_p_g_img img').attr('src');
        var all_board_members = $(this).find('#all_board_members').text().replace(/,/g, ', ');

        if( all_board_members )
          board_sum = all_board_members;

        topHeader.uploadTopBar(board_name, board_sum, img_src);

        $(".m_content_cont").mCustomScrollbar("scrollTo", "#goto_top");
      }
      
    } else {
      sweetAlert('Oops...', "Cannot load Notice!", 'error');
    }
  });

  $(document).on('click', '#foll_bo_prof', function(e){
    e.stopPropagation();
    var board_id = $(this).attr("boardId");
    modal.rmShow(  );
    rightDynamicData.profiles( board_id, 'board' );
    manageSection.right_side( '#r_s, .pop_up', '#dyn_rightside' );
    modal.rmHide();
  })

  $(document).on('click', '#data-icon', function(){
    document.getElementById('paste_here').innerHTML='';
    rightBar.updateBoard();
    manageSection.right_side( '#dyn_rightside', '.pop_up, #r_s' );
  });

  $(document).on('click', '#foll_bo_all_mem', function(e) {
    e.stopPropagation();
    var board_id = $(this).attr("boardId");
    modal.rmShow();
    var status = rightDynamicData.allMembers(board_id);
    if( status !== false ) {
      document.getElementById('paste_here').innerHTML = '';
      manageSection.right_side( '.pop_up, #r_s', '#dyn_rightside' );
      modal.rmHide();
    } else {
      sweetAlert('Oops...', "Cannot load all member!", 'error');
    }
  });

  $(document).on('click', '#delete-board', function(e) {
    var board_id = $(this).attr('boardId');
    if( is.is_board(board_id) === true ) {
      var query = 'mod=delete_board&bid=' + board_id;

      swal({
        title: 'Are you sure?',
        html: 'Do you really want to remove this board!<br> You will not be able to recover this board after <b>delete</t> it.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: true
      },
      function() {
        loadPostData( appUrl, query, board.deleteBoard );
      });

    } else {
      swal({ title: 'Oops!', html: 'It looks like Board is <b>not verified</b>!' });
    }
  })

  //Rmeove member from board
  $(document).on('click', '#remove-member', function(e) {
    var bid = $(this).attr('board-id');
    var uid = $(this).attr('user-id');

    if( bid.length == 10 && uid.length == 10 ) {

      swal({
        title: 'Are you sure?',
        html: 'Do you really want to remove this member from your board!<br> This will not be able to see your further updates about notice from this <b>board</b> !',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Remove it!',
        closeOnConfirm: false 
      },
      function() {
        board.removeMember(uid, bid);
      });
    } else {
      swal( 'Oops!',  'It seems like that board and user is not verified!' );
    }
  });

  //exit from followed board
  $(document).on('click', '#exit-board', function(e) {
    var bid = $(this).attr('boardId');
    if( is.is_board(bid) === true ) {

      swal({
        title: 'Are you sure?',
        html: 'Do you really want to exit from this <b>board</b> ! You will not be able to see further notice from this <b>board</b> !',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, exit me!',
        closeOnConfirm: false
      },
      function() {
        board.exitBoard(bid);
      });
    } else {
      swal('Oops!', error.boardError);
    }
  })

  $(document).on('click', '#member-profile', function(e) {
    var bid = $(this).attr('board-id');
    var uid = $(this).attr('user-id');

    if( is.is_attr(bid) == true && is.is_attr(uid) == true ) {
      if( is.is_board(bid) == true && is.is_user(uid) == true ) {
        rightDynamicData.profiles( uid, 'user', bid );
        modal.rmHide();
        return ;
      }
    }

    var innerText = $(this).text().replace(/\W+/g,'');
    if( innerText == "MyProfile" ) {
      modal.rmShow();
      rightDynamicData.profiles( '', 'MyProfile' );
      return ;
    }

    swal({ title : 'Oops!', html : 'Board and user is not verified !' });

    
  });

  //onclick trigger member profile event
  $(document).on('click', '#user_menu_p_img', function(e) {
    $( "#member-profile" ).trigger( "click" );
  })

  //home text change
  setInterval(function() {
    $('.t_con_headt span').fadeOut(500, function() {
      var $this = $(this);
      $this.text($this.text() == 'You' ? 'Your Oraganization' : 'You');
      $this.toggleClass('first second');        
      $this.fadeIn(500);
    });
  }, 3000);

  //top right popups functionality
  $(document).on('click', '#create-board', function(e) {
    if( $('span').hasClass('user_row') ) {
      var user_data = document.getElementById('user_row').innerHTML;
      if( is.isJson( user_data ) === true && user_data ) {
        var user_json = cm.parseJSON(user_data);
        if( user_json.create_allow === true ) {
          var query = 'mod=create_board';
          modal.mmShow();
          loadPostData( appUrl, query, content.mainContentPaste );
        } else {
          swal({ title : 'Not Allowed !', html : '<span style="font-size:15px;color:#844646;"><p>Sorry! You can\'t create more than allowed board.</p><p>please upgrade your membership plan to use more !</p><span>' });
        }
      } else {
        alert('Looks like you are not a verified user !');
        user.logout();
        return ;
      }
    }
    modal.mmHide();
  });

  //join board
  $(document).on('click', '#join-board', function(e) {
    modal.mmShow();
    var query = 'mod=create_board&type=join';
    loadPostData( appUrl, query, content.mainContentPaste );
    modal.mmHide();
  })

  //generate id
  $(document).on('click', '#gndi', function(e) {
    var bdi = board.boardDistId();
    document.getElementById("bnameid").value = bdi;
  });

  //board plans
  $(document).on('click', '#membership-plan', function(e) {
    var query = 'mod=membership_detail';
    modal.rmShow();
    loadPostData( appUrl, query, rightDynamicData.membershipPlan );
  });

  //hide highlighter
  $(document).on('click', '#hide_highlighter', function() {
    $('.main_h_lighter').fadeOut('slow');
  });

  $(document).on('click', '#showTool', function() {
    $('.mce-toolbar-grp').toggle();
  });

  $(document).on('click', '#notice-seen-by', function(e) {
    var notice_id = $(this).attr('conid');
    var res = notice_id.substring(0, 6);
    if( res == 'notice' ) {
      var notice_id = notice_id.replace('notice-', '');
      if( notice_id ) {

        var query = 'mod=notice_see_list&nid=' + notice_id;

        //checking if it is used for notice-attend-type unseen people list
        var used_for_attr = $(this).attr('data-used');
        // For some browsers, `attr` is undefined; for others,
        // `attr` is false.  Check for both.
        if ( used_for_attr ) {
          query = query + '&used_for=' + used_for_attr;

          //params is used to show extrac data to show
          var params = {'used_for': used_for_attr};

          if( used_for_attr == 'attending-members-list' )
            params.textToShowOnTop = 'ATTENDING MEMBERS LIST';
          else if( used_for_attr == 'not-attending-members-list' )
            params.textToShowOnTop = 'NOT ATTENDING MEMBERS LIST';
          else if( used_for_attr == 'not-conformed-members-list' )
            params.textToShowOnTop = 'NOT CONFORMED MEMBERS';
          else if( used_for_attr == 'seen-members' )
            params.textToShowOnTop = 'SEEN TOTAL MEMBERS';

          loadPostData( appUrl, query, content.forwardPopUp, params );
        } else {
          var params = {'textToShowOnTop': 'SEEN BY LIST'};
          loadPostData( appUrl, query, content.noticeSeenBy, params );
        }
      }
    } else {
      alert('Can\'t access notice ! Please reload the Application !');
    }
    
  });

  $(document).on('click', '#hide_notice', function(e) {
    var notice_id = $(this).attr('conid');
    var res = notice_id.substring(0, 6);
    if( res == 'notice' ) {
      var notice_id = notice_id.replace('notice-', '');
      if( notice_id ) {

        swal({
          title: 'Are you sure ?',
          html : 'Do you really want to hide this notice !',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          closeOnConfirm: false,
          allowOutsideClick: false
        },
        function() {
          var query = 'mod=hide_notice&nid=' + notice_id;
          loadPostData( appUrl, query, content.noticeHide );
        })

        $(this).closest('.g_notice_wrapper').addClass('notice-' + notice_id + '');
      }
    } else {
      alert('Can\'t access notice ! Please reload the Application !');
    }
  });

  $(document).on('click', '#forward_notice', function(e) {

    var notice_id = $(this).attr('conid');
    var res = notice_id.substring(0, 6);
    if( res == 'notice' ) {
      var notice_id = notice_id.replace('notice-', '');
      if( notice_id ) {
        notice_to_fwd = notice_id;
      } else {
        alert("Could't found this notice!");
        return ;
      }
    } else {
      alert("Could't found this notice!");
      return ;
    }

    $('#forward_notice_cont').show();

    var query = 'mod=get_forward_data';
    loadPostData( appUrl, query, content.forwardPopUp );
  })

  $(document).on('click', '#hide_forward', function(e) {
    $('#forward_notice_cont').hide();
  });

  $(document).on('click', '.fwd_notice', function(e) {
    var board_id = $(this).attr('boardid');
    if( is.is_board(board_id) ) {

      if( notice_to_fwd ) {
        var query = 'mod=fwd_notice&bid=' + board_id + '&nid=' + notice_to_fwd;
        loadPostData( appUrl, query, content.fwdStatus );

      } else {
        swal({ title: 'Oops!', text: "Board does\'t seems like correct!", type: 'error'});
        return ;
      }
    } else swal({ title: 'Oops!', text: "Board does\'t seems like correct!", type: 'error'});
  });

  //magnefic popup image open requested by ajax
  $(document).on('click', '.image-popup-no-margins', function(e) {
    var img_src = $(this).attr('data-mfp-img-src');
    mgfp.open_img(img_src);
  })

  //magnefic popup page open requested by ajax
  $(document).on('click', '.open-ajax-page', function(e) {
    var url_src = $(this).attr('data-mfp-url');
    mgfp.openAjaxPage(url_src);
  });

  //hide delete file uploaded content at time of notice sharing
  $(document).on('click', '#up_file_hider', function(e) {

    var cl_cont_to_remove = $(this).closest('#file_upload_cont');
    var fname_val = cl_cont_to_remove.attr('filename');
    //remove attached file from the array
    if( fname_val ) {
      cm.removeArrayElement(fileAttachArr, fname_val);
    }
    cl_cont_to_remove.html('');

  });

  //get notification popup
  $(document).on('click', '#show_notification', function(e) {
    e.stopPropagation();
    if( document.getElementById('notification_placer').innerHTML.length > 50 ) {
      $(this).find('#total_notif').text('');
      $(this).find('.no_notifi').css('background-color', 'transparent');
      $(this).closest('#m_header').find('#notf_cont').toggle();
    } else {
      $(this).find('#total_notif').text('');
      $(this).find('.no_notifi').css('background-color', 'transparent');
      $(this).closest('#m_header').find('#notf_cont').toggle();
      notification.getNotif('');
    }
  });
  $(document).on('click', '#notf_cont', function(e) {
    e.stopPropagation();
  });

  //get notification detail
  $(document).on('click', '#single_ntf', function(e) {
    $( "#show_notification" ).trigger( "click" );
    var notif_id = $(this).attr('ntf-id');
    var query = $(this).attr('url-query');

    /*
    @ check if notification type is not clibale
    @ if true then it will not execute at backend
    @ otherwise go to backend
    */
    if( query.indexOf('mod=urfb') !== -1 || query.indexOf('mod=mjib') !== -1 || query.indexOf('mod=mefb') !== -1 ) {
      var bgColor = $(this).find('#ntf_row').css("background-color");
      if( bgColor == "rgb(255, 255, 255)" ) {
        return false;
      }
    }
    if( notif_id ) {
      query = query + '&notification_id=' + notif_id;
    }
    notification.single_notice(query);
    $(this).find('#ntf_row').css("background-color", "#fff");
  });

  //notification paginations
  $(document).on('click', '#notif-pagn', function(e) {
    var page = $(this).attr('page');
    if( page ) {
      page = parseInt(page) + 1;
      notification.getNotif(page);
    }
  })

  //interface for click on facebook login
  $(document).on('click', '#fblogin', function(e) {
    FBLogin();
  });

  //right board privacy and profile show
  $(document).on('click', '#show-board-profile', function(e) {

    if( ! $(this).hasClass('green') ) {
      $(this).addClass('green');
      $('#show-board-privacy').removeClass('green')
      $('#board-privacy-container').hide();
      $('#board-details').show();
    }
    
  });
  $(document).on('click', '#show-board-privacy', function(e) {

    if( ! $(this).hasClass('green') ) {
      $(this).addClass('green');
      $('#show-board-profile').removeClass('green');
      $('#board-details').hide();
      $('#board-privacy-container').show();
    }

  });
  $(document).on('click', '.check_cir', function() {
    $(this).find('.check').toggleClass('fa-check fa-times');
  });
  $(document).on('click', '#privacy-save', function(e) {
    var board_id = $('#board-privacy-container').attr('boardid');

    if( is.is_board(board_id) ) {
      board.boardPrivacySave( board_id );
    } else {
      swal({
        'title' : 'Oops!',
        'html' : 'We could\'t verify the board! <br> Please refresh the page and try again!'
      });
    }
    
  })
  
});

var modal = {
  'rmShow' : function() {
    $('.right_modal').fadeIn('slow');
  },
  'rmHide' : function() {
    $('.right_modal').fadeOut('slow');
  },
  lmShow : function() {
    $('.left_modal').show();
  },
  lmHide : function() {
    $('.left_modal').hide();
  },
  mmShow : function() {
    $('.modal').fadeIn('slow');
  },
  mmHide : function() {
    $('.modal').fadeOut('slow');
  }
}

var notif = {
  'rightBottom' : function(c) {
    document.getElementById('bottom_notif').innerHTML = c;
    $('.noti_con').fadeIn();
    $('.noti_con').delay(3000).fadeOut('slow');
  }
}

var manageSection = {
  'right_side' : function( hide, show ) {
    modal.rmShow();
    $(hide).hide();
    $(show).show();
    modal.rmHide();
  }
}

var tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};

function replaceTag(tag) {
    return tagsToReplace[tag] || tag;
}

function safe_tags_replace(str) {
    return str.replace(/[&<>]/g, replaceTag);
}