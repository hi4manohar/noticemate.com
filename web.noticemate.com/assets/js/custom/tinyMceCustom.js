/*
* file used for tinyMce customized
* Any user interface operation for tinyMCE customized through here
*/

tinymce.init({
  selector: '#mceTinyEditor',
  theme: 'modern',
  mode : 'none',
  height: '180',
  plugins: [
    'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
    'save table contextmenu directionality emoticons template paste textcolor code placeholder'
  ],
  toolbar: 'insertfile undo redo | styleselect | fontsizeselect | bold italic | MyButton | code | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
  setup: function (editor) {
    editor.addButton('MyButton', {
      text: 'Send HTML',
      icon: false,
      onclick: function () {
        swal({
          title: 'Are you sure?',
          html: "We also allow you to send <b>HTML template</b> in Notice. <br>Click <b><code>(<>)</code></b> Button and Paste there your HTML code.  <br>Do you really want to send this Notice as <b>HTMLIZED</b> ",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, I want!',
          closeOnConfirm: true
        },
        function() {
          $('#mceTinyEditor').addClass('sendHTML');
        })
      }
    });
  },
  content_css : css_domain + '/assets/css/lib/tinyMce/tinyMce.css',
  menubar : false
});

var tinyMceCustom = {
  insertImage : function(eid, isrc) {
    /*
    @ eid defines editor id and isrc defines image src
    */
    var ed = tinyMCE.get(eid);                // get editor instance
    var range = ed.selection.getRng();                  // get range
    var newNode = ed.getDoc().createElement ( "img" );  // create img node
    newNode.src= uploadUrl + isrc;                           // add src attribute
    newNode.setAttribute("class", "image-popup-no-margins content-image");
    newNode.setAttribute("data-mfp-img-src", uploadUrl + isrc);
    range.insertNode(newNode);
  }
}