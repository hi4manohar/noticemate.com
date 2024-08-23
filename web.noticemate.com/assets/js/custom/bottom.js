
//sorting
var monkeyList = new List('board-list', {
  valueNames: ['name'],
  plugins: [ ListFuzzySearch() ] 
});
var monkeyList2 = new List('joined-board-list', {
  valueNames: ['name'],
  plugins: [ ListFuzzySearch() ]
});
var monkeyList3 = new List('forward_notice_cont', {
  valueNames: ['name'],
  plugins: [ ListFuzzySearch() ]
});


$(document).ready(function(){

  //scroll part
  $(".nm_scroll").mCustomScrollbar({
    mouseWheelPixels: 100,
    scrollInertia: 100
  });
  //$('.nm_scroll').scrollator();

  window.wiselinks = new Wiselinks($('#main') );

  $(document).off('page:loading').on('page:loading', function(event, $target, render, url) {
    $('.modal').show();
  });
  $(document).off('page:redirected').on('page:redirected', function(event, $target, render, url) {
    $('.modal').fadeOut();
  });
  $(document).off('page:always').on('page:always', function(event, xhr, settings) {
    $('.modal').fadeOut();
  });
  $(document).off('page:done').on('page:done', function(event, $target, status, url, data) {
    $('.modal').fadeOut();
  })
  $(document).off('page:fail').on('page:fail', function(event, $target, status, url, error, code) {
    //alert("Sorry! Page could't be loaded");
  });
})