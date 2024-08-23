var board = {
  bid : '',
  'removeMember' : function(uid, bid) {
    this.bid = bid;
    if( uid.length == 10 && bid.length == 10 ) {
      var query = 'mod=remove_member&ui='+uid+'&bi='+bid;
      loadPostData( appUrl, query, board.removeMemberStatus );
    } else {
      swal( 'Oops!?',   'You are not allowed to remove memeber!' );
    }
  },
  'removeMemberStatus' : function(xmlhttp) {
    if( is.isJson(xmlhttp.responseText) ) {
      var json_data = cm.parseJSON(xmlhttp.responseText);
      if( json_data.status === false ) {
        swal( 'Oops!',   json_data.error );
      } else {
        swal( 'Deleted!', 'The member has been removed!', 'success' );
        rightDynamicData.allMembers(board.bid);
      }
    } else {
      alert(xmlhttp.responseText);
      swal( 'Oops!',  'It looks like there is something error in executing script!' );
    }
  },

  'exitBoard' : function(bid) {
    var query = 'mod=exit_board&bi='+bid;
    loadPostData( appUrl, query, board.exitMemberStatus );
  },

  'exitMemberStatus' : function(xmlhttp) {
    if( is.isJson(xmlhttp.responseText) ) {
      var json_data = cm.parseJSON(xmlhttp.responseText);
      if( json_data.status === false ) {
        swal( 'Oops!',   json_data.error );
      } else {
        swal( 'Moved!', json_data.msg, 'success' );
        leftBar.updateBoard();
      }
    } else {
      swal( 'Oops!',  'It looks like there is something error in executing script!' );
    }
  },

  'boardDistId' : function() {
    RN=Math.floor(Math.random()*9999999999999999);
    while (String(RN).length < 16) {
      RN='0'+RN;
    }
    return RN;
  },

  'createBoard' : function() {
    var bname = document.forms["create-board-form"]["bname"].value;
    var bdi = document.forms["create-board-form"]["bnameid"].value;
    if( bname.length > 5 ) {
      if( bdi.length == 16 ) {

        //submit form
        var query = 'mod=generate_board&bname='+bname+'&bdi='+bdi;
        $('.modal').fadeIn('slow');
        loadPostData( appUrl, query, board.cbStatus );

      } else swal( 'Oops!',  'Board Distrubution ID is not generated! Click GENERATE button to generate an ID' );
    } else swal( 'Oops!',  'Board must be greater than 5 character!' );
    return false;
  },

  'cbStatus' : function(xmlhttp) {
    if( is.isJson(xmlhttp.responseText) ) {
      var json_data = cm.parseJSON(xmlhttp.responseText);
      if( json_data.status === true ) {
        var bid = json_data.board_id;
        //swal( 'Success!', '' );
        notif.rightBottom('Your board has been created!');
        modal.rmShow();
        rightBar.updateBoard();
        modal.rmHide();
      } else {
        swal( 'Oops!', json_data.error );
      }
    } else alert("hi");
    $('.modal').fadeOut('slow');
    //board.cbStatusSuccess();
  },

  'cbStatusSuccess' : function() {
    var query = 'mod=create_board&type=created';
    loadPostData( appUrl, query, content.mainContentPaste );
  },

  'joinBoard' : function() {
    var bdi = document.forms["join-board-form"]["boad-dist-id"].value;
    var bname = document.forms["join-board-form"]["join-boad-name"].value;
    if( bdi.length == 16 ) {
      if( bname.length > 5 ) {
        var query = 'mod=join_board&bdi=' + bdi + '&bname=' + bname;
        loadPostData( appUrl, query, board.joinBoardStatus );
      } else {
        swal({ title: 'Oops!', html: 'It seems like <b>Board Name </b> is not correct!<br>Please enter verified Board Name.' });
      }
    } else {
      swal({ title: 'Oops!', html: 'It seems like <b>Board Distrubution ID </b> is not correct!<br>Please enter verified Board ID.' });
    }
    return false;
  },

  'joinBoardStatus' : function(xmlhttp) {
    if( is.isJson(xmlhttp.responseText) ) {
      var json_data = cm.parseJSON(xmlhttp.responseText);
      if( json_data.status === true ) {
        notif.rightBottom( 'You have Successfully joined in this board!' );
        leftBar.updateBoard();
      } else {
        swal({ title: 'Oops!', html: json_data.error });
      }
    } else {
      alert(xmlhttp.responseText);
      swal({ title: 'Oops!', html: 'You are not able to add in this board!' });
    }
  },

  'deleteBoard' : function(xmlhttp) {
    if( is.isJson(xmlhttp.responseText) ) {
      var json_data = cm.parseJSON(xmlhttp.responseText);
      if( json_data.status === true ) {
        notif.rightBottom( '<b>Board</b> has been Removed Successfully!' );
        rightBar.updateBoard();
      } else {
        swal({ title: 'Oops!', html: json_data.error });
      }
    } else {
      swal({ title: 'Oops!', html: 'Can\'t delete this <b>board</b>!' });
    }
  },

  'boardPrivacySave' : function(bid) {

    var prev_val = $('#member-allow').attr('value');

    if( $('#member-allow').find('#check').hasClass('fa-check') ) {
      var cur_val = 1;
    } else {
      var cur_val = 0;
    }

    if( prev_val == cur_val ) {
      swal({
        'title' : 'Saved!',
        'html' : 'Privacy changes for this board has been saved!'
      });      
    } else {
      var query = 'mod=board_privacy&member_allow=' + cur_val + '&board_id=' + bid;
      loadPostData( appUrl, query, board.boardPrivacySaveStatus, cur_val );
    }
  },

  'boardPrivacySaveStatus' : function(xmlhttp, cur_val) {
    if( xmlhttp.responseText ) {
      if( is.isJson(xmlhttp.responseText) === true ) {
        var obj = cm.parseJSON(xmlhttp.responseText);

        if( obj.status == true ) {

          if( cur_val == undefined )
            cur_val = 0;

          $('#member-allow').attr('value', cur_val );
          swal({
            'title' : 'Saved!',
            'html' : 'Privacy changes for this board has been saved!'
          });
        } else {
          swal({
            'title' : 'Oops!',
            'html' : obj.error
          });
        }
      } else {
        swal({
          'title' : 'Oops!',
          'html' : 'There is something error in processing your request!'
        });
      }
    }
  }
}