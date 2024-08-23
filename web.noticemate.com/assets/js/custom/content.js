var content = {
  page : '',
  'notice' : function( id, type, page ) {
    this.page = page;
    this.active_board = id;
    if( type == 'notice' ) {
      if( is.isNumeric(page) ) {
        var url_to_go = baseUrl + '/app.php?mod=notice&bid=' + id + '&page=' + page;
      } else {
        var url_to_go = baseUrl + '/app.php?mod=notice&bid=' + id;
      }   
      loadGetData(url_to_go, content.getNotice);
    }
  },

  'mainContentPaste' : function(xmlhttp) {
    content.reloadTiny();
    document.getElementById('main').innerHTML = xmlhttp.responseText;
  },

  reloadTiny : function() {
    //tinymce update ajax loaded content
    tinyMCE.execCommand('mceRemoveEditor', false, 'mceTinyEditor');
    tinyMCE.execCommand('mceAddEditor', false, 'mceTinyEditor');
    window.setTimeout(function(){
      $('.mce-toolbar-grp').hide();
      $('#mceTinyEditor_ifr').css('height', '180px');
    }, 2000);
  },

  /*
  @single notice defines that only single notice will come
  @ and all the main panle will be replaced.
  */

  'getNotice' : function(xmlhttp, singleNotice) {
    if( content.page && singleNotice !== '1' ) {

      //content is requested by page
      document.getElementById('tmp_cont').innerHTML=xmlhttp.responseText;
      var appendable_content = $('#tmp_cont').find('#notice_grp').html();
      if(appendable_content.length < 100) {
        document.getElementById('load_more').innerHTML='';
        alert("No more content is available !");
      } else {
        var cur_page = $('#load_page').attr('page');
        var next_page = parseInt(cur_page) + 1;
        $('#load_page').attr('page', next_page);
        //$(".m_content_cont").mCustomScrollbar("scrollTo","-=200");
      }
      document.getElementById('tmp_cont').innerHTML='';
      $("#notice_grp").append(appendable_content);

    } else {

      if( is.isJson(xmlhttp.responseText) ) {
        var json_data = cm.parseJSON( xmlhttp.responseText );
        swal({ title:'Oops!', html: json_data.error });
      } else {
        document.getElementById('main').innerHTML = xmlhttp.responseText;
        content.reloadTiny();
        if( $("div").hasClass("notice_create_box") ) {
          document.getElementById('noticeWriteBox').innerHTML = data.noticeBox();
        } else {
          document.getElementById('noticeWriteBox').innerHTML = '';
        }
      }      
    }
    
    $('.modal').hide();
  },

  'noticeSend' : function() {
    var nt = document.forms["create_notice"]["notice_title"].value;
    //var nc = document.forms["create_notice"]['notice_content'].value;

    if( $('#mceTinyEditor').hasClass('sendHTML') ) {
      // Get the raw contents of the currently active editor
      var nc = tinyMCE.activeEditor.getContent({format : 'raw'});
    } else {
      var nc = tinyMCE.activeEditor.getContent();
    }
    
    nc = encodeURIComponent(nc);
    
    if( nt.length < 10 ) {
      swal( 'Not descriptive!',   "Notice title does't looks like descriptive" );
      return false;
    }
    if( nc.length < 30 ) {
      swal( 'Not descriptive!',   "Notice content does't looks like descriptive" );
      return false;
    }
    if( $("div").hasClass("notice_create_box") ) {
      var board_to_send = $('.notice_create_box').attr('board-id');
    } else {
      swal( 'Not Allowed!',   "You are not allowed to send notice to this board!" );
    }

    //check if file is attached
    if( fileAttachArr.length > 0 ) {
      var attachedFiles = fileAttachArr.join();
    } else var attachedFiles = '';
    this.sendNotice( nt, nc, board_to_send, attachedFiles );
    return false;
  },

  'sendNotice' : function(nt, nc, bid, af) {
    var query = 'mod=create_notice&notice_title=' + nt + '&notice_content=' + nc + '&bid=' + bid + '&fattaches=' + af;

    if( attendReplyType.noticeType ) {
      if( attendReplyType.noticeType == 'event' )
        query = query + '&notice_type=' + attendReplyType.noticeType;
    }
    loadPostData( appUrl, query, content.noticeSendStatus );
  },

  'noticeSendStatus' : function(xmlhttp) {
    var obj = JSON.parse(xmlhttp.responseText);
    var board_to_load = $('.notice_create_box').attr('board-id');
    if( obj.status == false ) {
      sweetAlert('Oops...', obj.error, 'error');
    } else {
      $('.modal').show();
      //make attahcment array to blank
      fileAttachArr = [];
      content.notice(board_to_load, 'notice');
    }
  },

  'noticeSeen' : function(ci, bi) {
    var query = 'mod=notice_seen&ci='+ci+'&bi='+bi;
    loadPostData( appUrl, query, content.getSeenStatus );
  },

  'getSeenStatus' : function(xmlhttp) {
    var obj = JSON.parse(xmlhttp.responseText);
    if( obj.status == false ) {
      sweetAlert('Oops...', obj.error, 'error');
    }
  },

  'noticeSeenBy' : function(xmlhttp, cbackparams) {
    var data = xmlhttp.responseText;
    if( is.isJson(data) == true ) {
      var obj = cm.parseJSON( data );
      if( obj.status == false ) {
        swal({ title : 'Oops!?',   html : 'You are not allowed to remove memeber!' });
        return ;
      }
    }
    document.getElementById('paste_here').innerHTML='';
    manageSection.right_side( '#dyn_rightside', '' );
    $('#r_s, #r_s').show("slide", { direction: "right" }, 500);
    rightBar.update( xmlhttp );
    $('#board-list .l_part_header h1').text(cbackparams.textToShowOnTop);
    $('.seen_list').show();
  },

  'noticeHide' : function(xmlhttp) {
    if( is.isJson( xmlhttp.responseText ) == true ) {
      var obj = cm.parseJSON( xmlhttp.responseText );
      if( obj.status == true ) {
        $('.' + obj.content_hides).html('');
        swal('Success !');
      } else if( obj.status == false ) {
        swal({ title : 'Oops!?',   html : obj.error });
      } else {

      }
    }
  },

  'forwardPopUp' : function(xmlhttp, cbackparams) {
    document.getElementById('fr_notice_list').innerHTML=xmlhttp.responseText;
    monkeyList3.reIndex();
    $('.fr_n_inner').find('#r_s').show();
    if( cbackparams ) {
      document.getElementById('fwd-title').innerHTML = cbackparams.textToShowOnTop;
    } else {
      document.getElementById('fwd-title').innerHTML = 'Forward Notice To';
    }
    $('#forward_notice_cont').show();
  },

  'fwdStatus' : function(xmlhttp) {
    if( is.isJson(xmlhttp.responseText) == true ) {

      var obj = cm.parseJSON( xmlhttp.responseText );
      if( obj.status == true ) {
        $('#forward_notice_cont').fadeOut('slow');
        swal({ title: 'Success!', html: 'Notice forwarding success!' });

      } else {
        swal({ title: 'Oops!', html: obj.error });
      }

    } else {
      swal({ title: 'Oops!', text: "Getting unknown error in forwarding notice !<br> Please reload the page try again !", type: 'error'});
    }
  }
}