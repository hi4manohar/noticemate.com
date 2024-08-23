/*

* this file is used for ajax interaction

* Ajax main function is also defined here

* both get and post request can be fired

* all the common namespace is defined here like board, profile etc.

*/



function loadGetData(url, cfunc) {

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari

    xmlhttp=new XMLHttpRequest();

  } else {// code for IE6, IE5

    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

  }

  xmlhttp.onreadystatechange = function() {

    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

      cfunc(xmlhttp);

    }

  };

  xmlhttp.open("GET",url,true);

  xmlhttp.send();

}



function loadPostData(url,query,cfunc, cbackparams){

  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari

    xmlhttp=new XMLHttpRequest();

  } else {// code for IE6, IE5

    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

  }

  xmlhttp.onreadystatechange=function() {

    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {



      if( cbackparams ) {

        cfunc(xmlhttp, cbackparams);

      } else cfunc(xmlhttp);

    }

  };

  xmlhttp.open("POST",url,true);

  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

  xmlhttp.send(query);

}



function right(xmlhttp) {

  document.getElementById("paste_here").innerHTML = xmlhttp.responseText;

  monkeyList.reIndex();

}



var rightDynamicData = {

  'allMembers' : function( id ) {

    if( id.length == 10 ) {

      var url_to_go = baseUrl + '/app.php?mod=all_members&bid=' + id;

      loadGetData(url_to_go, right);

    } else return false;    

  },

  'profiles'   : function( id, type, bid ) {

    if( type == 'board' ) {

      var url_to_go = baseUrl + '/app.php?mod=profile&bid=' + id;

      loadGetData( url_to_go, right );

    } else if( type == 'user' ) {

      if( id.length == 10 && bid.length == 10 ) {

        var query = 'mod=member_profile&ui='+id+'&bi='+bid;

        loadPostData( appUrl, query, rightDynamicData.profileStatus );

      } else {

        swal( 'Oops!',   'You are not allowed to see member profile!' );

      }

    } else if( type == 'MyProfile' ) {

      var query = 'mod=my_profile';

      loadPostData( appUrl, query, rightDynamicData.profileStatus );

    } else {

      return false;

    }

  },



  'profileStatus' : function(xmlhttp) {

    var data = xmlhttp.responseText;

    if( is.isJson(data) === true ) {

      var json_data = cm.parseJSON(data);

      if( json_data.status === false ) {

        swal( 'Oops!',   json_data.error );

      }

    } else {

      document.getElementById('paste_here').innerHTML = '';

      manageSection.right_side( '#r_s, .pop_up', '#dyn_rightside' );

      right(xmlhttp);

    }

  },



  'membershipPlan' : function(xmlhttp, cfunc) {

    var data = xmlhttp.responseText;

    if( is.isJson(data) === true ) {

      var json_data = cm.parseJSON(data);

      if( json_data.status === false ) {

        swal({ title : 'Oops!',   html : json_data.error });

      }

    } else {

      document.getElementById('paste_here').innerHTML = '';

      manageSection.right_side( '#r_s, .pop_up', '#dyn_rightside' );

      right(xmlhttp);

    }

    if( typeof cfunc == 'function' )

      cfunc();

  }

}



var rightBar = {

  'updateBoard' : function() {

    var query = 'mod=update_right_side';

    loadPostData( appUrl, query, rightBar.update );

  },



  'update' : function(xmlhttp) {

    $('#board-list .l_part_header h1').text('YOUR CREATED BOARD');

    document.getElementById('right-cr-board').innerHTML = xmlhttp.responseText;

    monkeyList.reIndex();

  }

}



var leftBar = {

  'updateBoard' : function(data) {

    var query = 'mod=update_left_side';

    if( data ) {

      if( data == 'get_only_unread' )

        query = query + '&' + data + '=1';

    }

    var ajaxObj = new loadPostData(appUrl, query, leftBar.update);

  },



  'update' : function(xmlhttp) {

    //if response is json the we have to update only total notices

    if( xmlhttp.responseText ) {

      if( is.isJson(xmlhttp.responseText) == true ) {

        var json_data = cm.parseJSON(xmlhttp.responseText);

        for( var i = 0; i < json_data.length; i++ ) {

          var container = '#left_members .bid-' + json_data[i].board_id;

          $(container).find('#tn_notif').text(json_data[i].tn);

          $(container).prependTo("#left_members");

          $(container).find('#tn-block').show();

        }

        return;

      }

      document.getElementById('left_members').innerHTML = xmlhttp.responseText;

      monkeyList2.reIndex();

    }

  }

}



var topHeader = {

  'uploadTopBar' : function( name, summary, img_src ) {

    document.getElementById('top_header_name').innerHTML=name;

    document.getElementById('top_header_sum').innerHTML=summary;

    $('#top_header_src img').attr('src', img_src);

  }

}



var notice = {

  showNoticeTextArea : function() {

    return false;

  }

}



var notification = {

  'getNotif' : function(page) {

    var query = 'mod=get_notification';

    //check if notification requestion by page

    if( page ) {

      query = query + '&page=' + parseInt(page);

      var data = { page: page };

    } else var data = { page: '' };

    loadPostData( appUrl, query, notification.data, data );

  },



  'data' : function(xmlhttp, data) {

    if( xmlhttp.responseText ) {

      if( is.isJson(xmlhttp.responseText) == true ) {

        var obj = cm.parseJSON( xmlhttp.responseText );



        if(obj.status == false) {

          if( data.page ) {

            document.getElementById('pagn-div').innerHTML = obj.error;

            return;

          } else {

            document.getElementById('notification_placer').innerHTML = obj.error;

            return;

          }

          

        }



      }



      if( data.page ) {

        $('#notification_placer').append(xmlhttp.responseText);

        $('#notif-pagn').attr('page', data.page);

        return;

      }

    }

    document.getElementById('notification_placer').innerHTML = xmlhttp.responseText;

  },



  'single_notice' : function(q) {

    if(q) {



      $('.modal').show();



      loadPostData( appUrl, q, notification.singleNoticeData );

    } else {

      swal({title:'Oops!', html:'Could\'t get notice!'});

    }

  },



  'singleNoticeData' : function(xmlhttp) {

    /*

    @ if notification is only for updatation then not to show single notice

    @ if data is single notice then update notice

    */

    if( xmlhttp.responseText ) {

      if( is.isJson(xmlhttp.responseText) ) {

        var json_data = cm.parseJSON(xmlhttp.responseText);

        if( json_data.status == false ) {

          swal({title:'Oops!', html: json_data.error});

        } else {

          $('.modal').hide();

          return;

        }

      }

      content.getNotice(xmlhttp, '1');

      //trigger to get reply and show content

      $('.g_n_ti_wrapper').trigger("click");

      $('#get_reply').trigger("click");

    }

  }

}



var profile = {

  'memberProfile' : function(uid, bid) {

    if( uid.length == 10 && bid.length == 10 ) {

      var query = 'mod=member_profile&ui='+ui+'&bi='+bi;

      loadPostData( appUrl, query, profile.profileStatus );

    } else {

      swal( 'Oops!?',   'You are not allowed to see member profile!' );

    }

  },



  'profileStatus' : function(xmlhttp) {

    var data = xmlhttp.responseText;

    if( is.isJson(data) === true ) {

      var json_data = cm.parseJSON(data);

      if( json_data.status === false ) {

        swal( 'Oops!',   json_data.error );

      } else {

        //updated

        notif.rightBottom('Subject updated!');

      }

    } else {

      //updated

      notif.rightBottom('Can\'t update subject!');

    }

  },



  'update' : function(uc, m, ut) {

    if( uc.length > 50 ) {

      swal( 'Oops!',   'Board name is not allowed more than 50 character!' );

      return false;

    }

    var res = ut.substring(0, 3);

    if( res == 'bid' || res == 'uid' ) {

      if( m ) {

        var id = ut.substring(4);

        var prepare_query = 'mod=' + m + '&' + res + '=' + id + '&content=' + uc;

        loadPostData( appUrl, prepare_query, profile.profileStatus );

      }

    } else {

      swal( 'Oops!',   'You are not able to update your subject!' );

      return false;

    }

  },



  'profileUpdateStatus' : function(query) {

  }

}