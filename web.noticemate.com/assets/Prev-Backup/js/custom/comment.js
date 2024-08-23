var comment = {
  'currentSubReply' : '',

  'onType': function(e) {
    if( e.length > 0 ) {
        
    }
  },

  'submitReply': function() {
    var res = comment.currentSubReply.substring(0, 6);
    var content = $('.' + comment.currentSubReply).val();
    if( res == 'notice') {
      var notice_id = this.currentSubReply.replace('notice-', '');
      var reply_content = encodeURIComponent(content);
      var query = 'mod=do_reply&nid=' + notice_id + '&rep_content=' + reply_content;
      if( attend_reply_data ) {
        if( attend_reply_data == 'yes' || attend_reply_data || 'no' || attend_reply_data || 'not-conform' )
          query = query + '&attend_reply=' + attend_reply_data;
      }
      if( replyLocation.latitude && replyLocation.longitude ) {
        query = query + '&reploc=' + replyLocation.latitude + ',' + replyLocation.longitude;
      }
      loadPostData( appUrl, query, comment.doReplyStatus );
    } else {
      swal({title:'Oops!', html: 'We could\'t find this notice!<br>Please reload the page and try again!'});
    }
  },

  'doReplyStatus': function(xmlhttp) {

    if( is.isJson(xmlhttp.responseText) ) {
      var json_data = cm.parseJSON( xmlhttp.responseText );
      if( json_data.status == true ) {
        comment.insertReply(json_data);
      } else {
        swal({title:'Oops!', html:json_data.error});
      }
    } else {
      alert( xmlhttp.responseText );
    }
  },

  'insertReply': function(jd) {
    var afterInsert = $('.' + this.currentSubReply).closest('.gmn_comment');
    var reply_html = data.demoReply(jd);
    $(reply_html).insertAfter(afterInsert);
    $('.' + comment.currentSubReply).val('');

    replyLocation.emptyLocationVars();

    //also change previous attend reply data
    if( attend_reply_data ) {
      if( attend_reply_data == 'yes' || attend_reply_data || 'no' || attend_reply_data || 'not-conform' ) {
        var curNotice = $('.' + this.currentSubReply).closest('.gmn_comment_wrapper').find('#prev-attend-rep-data');
        curNotice.text(attend_reply_data.toUpperCase());
      }

    }
  },

  'getReplyStatus': function(xmlhttp) {

    if( is.isJson(xmlhttp.responseText) == true ) {
      var json_data = cm.parseJSON( xmlhttp.responseText );
    } else {
      $(comment.section_placer).html(xmlhttp.responseText);
      var current_page = $(comment.closest_container).find('#more_reply').attr('data-page');
      $(comment.closest_container).find('#more_reply').attr('data-page', parseInt(current_page)+1 );
      var showing_total_reply = $(comment.closest_container).find("div[class*='reply_data_container']").length;
      $(comment.closest_container).prev('.notice_event_section').find('#showing_replies').text(showing_total_reply);
    }
  },

  'commentAreatAdjust': function(o) {
    o.style.height = "1px";
    o.style.height = (2+o.scrollHeight)+"px";
  },

  'turnOffReply' : function(xmlhttp, clickedObj) {

    if( is.isJson(xmlhttp.responseText) == true ) {
      var json_data = cm.parseJSON( xmlhttp.responseText );
      if( json_data.status == true ) {
        swal('Success!');

        if( clickedObj.attr('id') == 'close-reply' ) {
          clickedObj.find('.l_text').text('Turn-on Reply');
          clickedObj.attr('id', 'turn-on-reply');
        } else if( clickedObj.attr('id') == 'turn-on-reply' ) {
          clickedObj.find('.l_text').text('Turn-off Reply');
          clickedObj.attr('id', 'close-reply');
          clickedObj.closest('#notices').find('#reply_section').show();
        }
      } else {
        swal({
          title: 'Oops...',
          html: json_data.error,
          type: 'error'
        });
      }
    } else {

      swal({
        title: 'Oops...',
        html: 'We could\'t found this notice! <br> Please try again Later!',
        type: 'error'
      });

    }

  }
}

function getReplyContent(thisObj, ident) {
    //@show comment container
    if( ident == 'get_reply' ) {
      var closest_container = thisObj.closest('.g_main_not_con').find('#reply_section');
    }
    else
      var closest_container = thisObj.closest('#reply_section');
    if( ident == 'get_reply' )
      $(closest_container).fadeIn();

    comment.closest_container = closest_container;

    //get where to place comment
    comment.section_placer = $(closest_container).find('#replied_data');

      //send data to server for getting comments
      if( ident == 'get_reply' )
        var get_reply_from = thisObj.attr('conid');
      else
        var get_reply_from = thisObj.attr('data-from');
      var res = get_reply_from.substring(0, 6);
      if( res == 'notice') {
        var notice_id = get_reply_from.replace('notice-', '');

        //check if all reply is zero
        var total_reply = parseInt( $(closest_container).find('#more_reply').attr('data-all') );
        var current_page = parseInt( $(closest_container).find('#more_reply').attr('data-page') );

        //check if more reply exist
        if( total_reply > 0 ) {

          if( current_page * 5 <= total_reply ) {

            if( ident == 'more_reply' ) {
              $(comment.section_placer).prepend('<span id="reply_more_comment"></span>');
              comment.section_placer = $(comment.section_placer).find('#reply_more_comment:first');
            }

            if( $(comment.section_placer).html().length == 0 ) {
              var query = 'mod=get_notice_reply&nid=' + notice_id + '&page=' + current_page;
              loadPostData( appUrl, query, comment.getReplyStatus );
            }
            
          } else {
            alert("No more reply exist");
          }
        }
        
      } else {
        swal({title:'Oops!', html:'We could\'t recognize correct notices!<br>Please refresh the page and try again!'});
      }
}

$(document).ready(function() {
  $(document).on('click', '#get_reply', function(e) {
    e.stopPropagation();
    getReplyContent($(this), 'get_reply');
  });

  $(document).on('click', '#more_reply', function(e) {
    e.stopPropagation();
    getReplyContent($(this), 'more_reply');
  })
  
  $(document).on('click', '.reply_submit', function(e) {
    e.stopPropagation();
    comment.currentSubReply = $(this).attr('conid');
    if( comment.currentSubReply ) {
      comment.submitReply();
    } else {
      swal({title:'Oops!', html:'It looks like that we could\'t find notice!<br>Please refresh the page and try again!'});
    }
    
  });

  $(document).on('click', '#toggle_reply', function(e) {
    e.stopPropagation();
    $(this).closest('.g_main_not_con').find('#reply_section').toggle();
    $(this).toggleClass('fa-chevron-down fa-chevron-up');
  });

  $(document).on('click', '#close-reply, #turn-on-reply', function(e) {
    var clickedObj = $(this);
    var notice_id = $(this).attr('conid');
    var res = notice_id.substring(0, 6);
    if( res == 'notice' ) {
      var notice_id = notice_id.replace('notice-', '');
      if( notice_id ) {

        if( clickedObj.attr('id') == 'close-reply' ) {
          var html_message = 'Do you really want to <b>Turn Off</b> getting Reply from this Notice!<br> You will also be able to <b>turn on</b> this later.';
          var btn_msg = 'Yes, Turn-off';
        } else if( clickedObj.attr('id') == 'turn-on-reply' ) {
          var html_message = 'Do you really want to <b>Turn On</b> getting Reply from this Notice!<br> You will also be able to <b>turn off</b> this later.';
          var btn_msg = 'Yes, Turn-on';
        } else {
          swal({
            title: 'Oops!',
            html: 'We could\'t found this notice! <br> Please refresh the page and try again !',
            type: 'error'
          });
        }

        swal({
          title: 'Are you sure?',
          html: html_message,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: btn_msg,
          closeOnConfirm: true
        },
        function(isConfirm) {
          if( isConfirm === true ) {

            if( clickedObj.attr('id') == 'close-reply' ) {
              var query = 'mod=replyoff&nid=' + notice_id;
            } else if( clickedObj.attr('id') == 'turn-on-reply' ) {
              var query = 'mod=replyon&nid=' + notice_id;
            }

            loadPostData( appUrl, query, comment.turnOffReply, clickedObj );
          } else if (isConfirm === false) {

          }
          
        });
      }
    }
  });

  $(document).on('click', '#share-location', function(e) {
    replyLocation.activeNotice = $(this);
    $(this).closest('.gmn_comment_text').find('#location-container').find('.loadersmall').show();
    if (navigator.geolocation) {
      //navigator.geolocation.getAccurateCurrentPosition(replyLocation.showPosition, replyLocation.showError, replyLocation.onProgress, {desiredAccuracy:20, maxWait:15000});
      navigator.geolocation.getCurrentPosition(replyLocation.showPosition, replyLocation.showError, {maximumAge:60000, timeout:5000, enableHighAccuracy:true});
    } else {
      alert( "Geolocation is not supported by this browser." );
    }
  });

  $(document).on('click', '.location_data', function(e) {
    var coords = $(this).attr('loc');

    var map_title = $(this).closest('#reply-text-data').find('#reply-sender').text();

    var cor = coords.split(',');

    $('#map-data').show();
    $('#map-title').text(map_title + ' Reply Address');

    //get map address and replace the address
    replyLocation.getLocationName(cor[0], cor[1], '', replyLocation.showMap);

  });

  $(document).on('click', '#map-hide', function(e) {
    $('#map-data').hide();
  });

});

var replyLocation = {

  activeNotice : '',
  latitude : '',
  longitude : '',
  fetchedAddress : '',

  /*
  @ after successfull reply we do not contain location in js vars
  @ call this method and it will empty location vars
  */
  emptyLocationVars : function() {
    replyLocation.latitude = '';
    replyLocation.longitude = '';
  },

  showPosition : function(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    replyLocation.latitude = latitude;
    replyLocation.longitude = longitude;

    replyLocation.getLocationName(position.coords.latitude, position.coords.longitude, true, '');
  },

  getAddress : function(add) {
    if( add ) {

      var  value=add.split(",");
      var dataPlacer = replyLocation.activeNotice.closest('.gmn_comment_text').find('#location-container');
      dataPlacer.html(value);
      dataPlacer.attr('title', value);
      /*
      count=value.length;
      country=value[count-1];
      state=value[count-2];
      city=value[count-3];
      */
    }
  },

  'showError' : function(error) {
    switch(error.code) {
      case error.PERMISSION_DENIED:
        alert( "User denied the request for Geolocation." );
        break;
      case error.POSITION_UNAVAILABLE:
        alert( "Location information is unavailable." );
        break;
      case error.TIMEOUT:
        alert( "The request to get user location timed out." );
        break;
      case error.UNKNOWN_ERROR:
        alert( "An unknown error occurred." );
        break;
    }

    /*
    @ if error will occur then small loader will hide
    */
    replyLocation.activeNotice.closest('.gmn_comment_text').find('#location-container').find('.loadersmall').hide();
  },

  'onProgress' : function() {

  },

  'getLocationName' : function(latitude, longitude, callToGetAddress, callback) {
    var geocoder;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(latitude, longitude);
  
    geocoder.geocode(
      {'latLng': latlng}, 
      function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            var add= results[0].formatted_address ;

            //fetched address will be used for accessing showing map address
            replyLocation.fetchedAddress = add;

            if( callToGetAddress ) {
              replyLocation.getAddress(add);
            }

            if( callback ) {
              callback(latitude, longitude);
            }
            
          }
          else  {
            alert("address not found");
          }
        }
         else {
          alert("Geocoder failed due to: " + status);
        }
      }
    );
  },

  'showMapWithLatLot' : function(latitude, longitude) {
    latlon=new google.maps.LatLng(latitude, longitude);
    mapholder=document.getElementById('reply-map-location-popup')
    mapholder.style.height='450px';
    mapholder.style.width='450px';

    var myOptions={
      center:latlon,zoom:14,
      mapTypeId:google.maps.MapTypeId.ROADMAP,
      mapTypeControl:false,
      navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
    };

    var map=new google.maps.Map(document.getElementById("reply-map-location-popup"),myOptions);
    var marker=new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
  },

  'showMap' : function(latitude, longitude) {
    if( replyLocation.fetchedAddress ) {
      replyLocation.showMapWithLatLot(latitude, longitude);
      document.getElementById('map-address').innerHTML = replyLocation.fetchedAddress;
    }
  }

}