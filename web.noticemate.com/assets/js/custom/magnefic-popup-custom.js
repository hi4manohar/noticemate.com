var mgfp = {

  'open_img' : function(img) {
    if( img ) {
      $.magnificPopup.open({
        items: {
          src: img
        },
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true
      });
    } else {
      alert('broken_img');
    }    

  },

  'openAjaxPage' : function(url) {
    $.magnificPopup.open({
      items: {
        src: url
      },
      type: 'ajax',
      closeOnContentClick: false,
      alignTop: true,
      overflowY: 'scroll' // as we know that popup content is tall we set scroll overflow by default to avoid jump
    });
  }
}