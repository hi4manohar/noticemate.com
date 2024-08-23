<?php

class ControllerUploadUploadAttachment extends Controller {
  public function index() {

    $user_id = $this->user->user_id;
    $up_dir = '/uploades/files/user-' . $user_id;

    $upload = new FileUpload($up_dir);
    $upload->file($_FILES['attachment']);
  
    $validation = new validation();
  
    $upload->callbacks($validation, array('check_name_length'));

    //set max. file size (in mb)
    $upload->set_max_file_size(5);

    //set allowed mime types
    $upload->set_allowed_mime_types(array('image/jpeg', 'image/png', '  image/psd', 'image/gif', 'application/pdf', 'application/zip', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template', 'application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12', 'application/vnd.ms-excel.addin.macroEnabled.12', 'application/vnd.ms-excel.sheet.binary.macroEnabled.12', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.addin.macroEnabled.12', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.ms-powerpoint.template.macroEnabled.12', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12'));
  
    $results = $upload->upload();

    //unset unnecessary data
    unset($results['destination'], $results['post_data'], $results['full_path'], $results['path']);

    if( $results['status'] === true ) {
      $results = $this->updateAttachDetail( $results );
      echo json_encode($results);
    } else {
      echo json_encode($results);
    }
  }

  public function updateAttachDetail($data) {

    $user_id = $this->user->user_id;

    $file_name    = $data['filename'];
    $org_filename = $data['original_filename'];
    $file_size    = $data['size_in_mb'];
    $file_ext     = pathinfo($org_filename, PATHINFO_EXTENSION);

    //insert file to db
    $insert_data = $this->db->query("INSERT INTO `nm_attachments`(`attach_id`, `user_id`, `notice_id`, `file_name`, `or_file_name`, `file_size`, `file_ext`, `is_active`) VALUES ('', '$user_id', '', '$file_name', '$org_filename', '$file_size', '$file_ext', '0')");

    if( !$this->db->getLastId() ) {

      $data['status'] = false;

      return $data;

    } else {
      $data['filename'] = $this->db->getLastId();
      return $data;
    }


  }
}

?>