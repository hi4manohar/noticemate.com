$(document).on('click', '#editProfile', function(e) {
  e.stopPropagation();
  //show suggestions
  var editSugg = $(this).closest('.accordion-section').find('.editSugg');

  var closeEditableDiv = $(this).attr('editId');
  var prev_cont = $(this).closest('.accordion-section').find('#prev_name').html();

  //check current status of editable content
  if( $(this).hasClass('editableModeOn') ){
    $('#'+closeEditableDiv).removeClass('contentedit');
    $(this).removeClass('fa-check').addClass('fa-pencil');
    document.getElementById(closeEditableDiv).contentEditable='false';
    $(this).removeClass('editableModeOn');
    $(editSugg).hide();
    var updated_content = $('#'+closeEditableDiv).html();
    if( prev_cont !== updated_content ) {
      var mod = $('#'+closeEditableDiv).attr('mod');
      var update_to = $('#'+closeEditableDiv).attr('update-to');
      profile.update(updated_content, mod, update_to);
    }
    
  } else {

    //find editable content div
    var editableDiv = $(this).attr('editId');
    //add style in editable div
    $('#'+editableDiv).addClass('contentedit');
    //manipulate icons
    $(this).removeClass('fa-pencil').addClass('fa-check');

    //make it identifiable that content is editing
    $(this).addClass('editableModeOn');
    document.getElementById(editableDiv).contentEditable='true';
    $(editSugg).show();

    //check editable content dotes
    if( $('#'+editableDiv).hasClass('dotes') ){
      $('#'+editableDiv).removeClass('dotes');
    }
  }
})

//attachment download
  /*
  $(document).on('click', '#attachment_download', function(e) {
    var href = $(this).attr('urltogo');
    loadGetData(href, downloadResponse);
  });

  function downloadResponse(xmlhttp) {

    if( is.isJson( xmlhttp.responseText ) ) {
      obj = cm.parseJSON( xmlhttp.responseText );

      if( obj.status === true ) {

      } else {
        swal({
          title:'Oops!',
          html: obj.error
        });
      }
    }
  }
  */


//image upload
$(document).on('change', '#image_upload_file', function () {
  var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

  $('#image_upload_form').ajaxForm({
    beforeSend: function() {
      progressBar.fadeIn();
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function(html, statusText, xhr, $form) {
      if( is.isJson( html ) ) {
        obj = cm.parseJSON( html );
        if(obj.status){
          var percentVal = '100%';
          bar.width(percentVal)
          percent.html(percentVal);
          var image = uploadUrl + '/uploades/medium/'+obj.image_medium;
          var smimage = uploadUrl + '/uploades/small/'+obj.image_small;
          $('#p_image img').attr('src', image);
          $('#user_menu_p_img img').attr('src', smimage);
        }else{
          alert(obj.error);
        }
      } else {
        alert("File could't uploaded successfully! Please try again later!");
      }
    },
    complete: function(xhr) {
      progressBar.fadeOut();      
    } 
  }).submit();    

});

//image upload
$(document).on('change', '#notice_post_img', function () {
  var progressBar = $('#imgUploadBar'), bar = $('#imgUploadBar .bar'), percent = $('#imgUploadBar .percent');

  $('#notice_img_form').ajaxForm({
    beforeSend: function() {
      progressBar.fadeIn();
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function(html, statusText, xhr, $form) {
      obj = $.parseJSON(html);  
      if(obj.status){
        var percentVal = '100%';
        bar.width(percentVal)
        percent.html(percentVal);
        var image = obj.img_file;
        tinyMceCustom.insertImage('mceTinyEditor', image);
      }else{
        alert(obj.error);
      }
    },
    complete: function(xhr) {
      progressBar.fadeOut();
    } 
  }).submit();    

});

//notice attachment upload
$(document).on('change', '#notice_attachment', function (e) {

  if( this.files[0] ) {
    var filesize = Math.round( (this.files[0].size)/(1024*1024)  * 10 ) / 10;
    var fs = '( ' + filesize +  ' MB )';
    var filename = $('#notice_attachment').val().replace(/.*[\/\\]/, '');
    $('#f_u_cont').prepend(data.fileUploadContainer(filename, fs));

    var progressBar = $('#file_upload_bar:first'), bar = $('#file_upload_bar:first .sn_bar'), percent = $('#file_upload_bar:first .sn_percent');
  }

  $('#notice_attach_form').ajaxForm({
    beforeSubmit:function(arr, $form, options) {
      if( filesize < 5 ) {
        if( filename ) {
          // be submitted
          return true;
        } else {

          var error_to_show = "It looks like we coul't cautch the file! Please try again!"
          swal({
            title:'Oops!',
            html: error_to_show
          });
          return false;
        }
      } else {
        var error_to_show = "It looks like we coul't cautch the file!<br> You are not allowed to upload greater than 5 MB";

        swal({
          title:'Oops!',
          html: error_to_show
        });

        return false;
      }
    },
    beforeSend: function(e) {
      $('#file_upload_cont').fadeIn();
      progressBar.fadeIn();
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    success: function(html, statusText, xhr, $form) {

      if( is.isJson( html ) ) {

        obj = cm.parseJSON( html );

        if(obj.status){

          var percentVal = '100%';
          bar.width(percentVal)
          percent.html(percentVal);

          //getting previous file attached value and update with new and old
          fileAttachArr.push(obj.filename);

          $('#file_upload_cont:first').attr('filename', obj.filename);

        }else{
          var percentVal = 'X';
          percent.html(percentVal);
          bar.width('0%');
          var error_to_show = '';
          for(i = 0; i < obj.errors.length; i++) {
            error_to_show = error_to_show + obj.errors[i] + '<br>';
          }
          swal({
            title:'Oops!',
            html : error_to_show
          });
        }
      }
    },
    complete: function(xhr) {
      progressBar = '';
      //progressBar.fadeOut();      
    } 
  }).submit();

});
