var i = 0;

function timedCount() {
  var left_bar_board_update = new leftBar.updateBoard('get_only_unread');
  delete left_bar_board_update.ajaxObj;
    i = i + 1;
    postMessage(i);
    setTimeout("timedCount()",500);
}

//timedCount();