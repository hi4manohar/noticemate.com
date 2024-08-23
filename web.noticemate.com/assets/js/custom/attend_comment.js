var attend_reply_data;
$(document).ready(function() {

  $(document).on('click', '#attend-reply', function(e) {
    var curElem = $(this).find('.yes_checkbox');
    curElem.toggleClass('fa-circle-thin fa-check');
    $('.yes_checkbox').not(curElem).removeClass('fa-check').addClass('fa-circle-thin');

    var data_content = $(this).find('#rep-data').attr('data-content');
    if( data_content == 'yes' ) {
      if( curElem.hasClass('fa-check') )
        attend_reply_data = data_content;
      else attend_reply_data = '';
      $(this).closest('.res_notice').find('#submit-attend').show();
      $(this).closest('.res_notice').find('.at_rep_note').hide();
    } else {
      if( curElem.hasClass('fa-check') )
        attend_reply_data = data_content;
      else
        attend_reply_data = '';
      $(this).closest('.res_notice').find('#submit-attend').hide();
      $(this).closest('.res_notice').find('.at_rep_note').show();
    }
  });

  $(document).on('click', '#submit-attend', function(e) {
    
    if( attend_reply_data == 'yes' ) {
      var content_json = $(this).closest('#notices').find('.contentRow').html();
      if( is.isJson(content_json) === true ) {
        var json_data = cm.parseJSON(content_json);

        if( json_data.content_id ) {
          //submit reply
          var query = 'mod=attend-reply&notice_id=' + json_data.content_id + '&repcont=' + attend_reply_data;
          loadPostData( appUrl, query, attendReplyType.onSubmitGetData, $(this) );
        } else {
          swal({
            title : 'Oops!',
            html : 'We could\'t found this notice correct! <br> Please refresh the page and try again!'
          });
        }
        
      } else {
        swal({
          title: 'Oops!',
          html : 'It seems like you are attemting reply to Incorrect Notice!'
        });
      }
      
    } else {
      swal({
        title:'Oops!',
        'html' : 'Please choose any option! <br>Are you attending in event or not!<br> If you are not attending please provide reason in reply box!'
      });
    }
  });

  $(document).on('click', '#event-attend-detail', function(e) {
    var notice_id = $(this).attr('conid');
    var res = notice_id.substring(0, 6);
    if( res == 'notice' ) {
      var notice_id = notice_id.replace('notice-', '');
      if( notice_id ) {
        var query = 'mod=get_event_attend_detail&nid=' + notice_id;
        loadPostData( appUrl, query, attendReplyType.getAttendDetail );
      } else {
        swal({title: 'Oops!', html: 'We could\'t found this notice! <br> Please refresh the page and try again!'});
      }
    }
  })

});

var attendReplyType = {

  noticeType : '',

  onSubmitGetData : function(xmlhttp, curNoticeEvent) {
    if( is.isJson(xmlhttp.responseText) ) {
      var json_data = cm.parseJSON(xmlhttp.responseText);

      if( json_data.status == true ) {
        curNoticeEvent.closest('.res_notice').find('#prev-attend-rep-data').text('YES')
        swal({ title : 'success' });
      } else {
        swal({ title : 'Oops!', html : json_data.error });
      }
    } else {
      alert(xmlhttp.responseText);
    }
  },

  getAttendDetail : function(xmlhttp) {
    if( is.isJson(xmlhttp.responseText) ) {
      alert(xmlhttp.responseText);
    } else {
      /*
      @ here callback is used for getting chart data
      @ chart data will show members data in chart format
      */
      rightDynamicData.membershipPlan(xmlhttp, attendReplyType.getChartData);
    }
  },

  getChartData : function() {
    var chartJson = $('#attend-detail-json').text();
    chartJson = chartJson.trim();
    if( is.isJson(chartJson) === true ) {
      var json_data = cm.parseJSON(chartJson);
    }
  },

  showchartFormat : function() {

  },

  noticeTypeSelect : function(e) {
    if( e.value ) {
      if( e.value == 'event' )
        attendReplyType.noticeType = e.value;
    }
  }

}