var user = {

  'logout' : function() {
    window.location.href = "/logout.php";
  },

  'reloadCurPage' : function() {
    location.reload();
  },

  'goToAppHome' : function() {
    window.location="http://web.noticemate.com";
  }
}

/*

window.setInterval(function(){
  var left_bar_board_update = new leftBar.updateBoard('get_only_unread');
  delete left_bar_board_update.ajaxObj;
}, 1000);

var w;

var webWorker = {

  'startWorker' : function() {
    if(typeof(Worker) !== "undefined") {
      if(typeof(w) == "undefined") {
        w = new Worker("/assets/js/custom/demo_workers.js");
      }
      w.onmessage = function(event) {
        alert(event.data);
      };
    } else {
      alert("Sorry! No Web Worker support.");
    }
  },

  'stopWorker' : function() {
    w.terminate();
    w = undefined;
  }
}

webWorker.startWorker();

*/

var serverEvents = {
  //new notice event
  newNoticeEvent : function() {
    if(typeof(EventSource) !== "undefined") {
      var url = appUrl + '?mod=get_left_update_notice';
      var source = new EventSource(url);
      source.onmessage = function(event) {
        event.responseText = event.data;
        leftBar.update(event);
      };
      source.onerror = function(event) {
        //alert(JSON.stringify(event));
      }
    } else {
      alert("Sorry, your browser does not support server-sent events...\n Please upgrade your browser to latest version.");
    }
  }
}

if( Cookies.get('id') !== undefined ) {
  if( Cookies.get('id') )
    serverEvents.newNoticeEvent();
}