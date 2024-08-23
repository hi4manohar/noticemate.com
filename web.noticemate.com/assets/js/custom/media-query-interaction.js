$(document).ready(function() { 

  $(document).on('click', '#mhlb, #mhlcb', function(e) {
    $('#board-list').toggle("slide", { direction: "left" }, 300);
  });      
    

  $(window).resize(function(){
    if ($(window).width() <= 1024) {
      $(function() {
        $( "#board-list" ).draggable();
      });
    }
  });

  if ($(window).width() <= 1024) {
    $(function() {
      $( "#board-list" ).draggable();
    });
  }
});