<?php

class ControllerUploadUploadProfile extends Controller {

  public function index() {
    /*
    @check if image is uploading for user or board
    @image name will be board id or user id
    @if image is for user imagename = u else b
    */
    $update_pre = substr($this->request->post['update_to'], 0, 3);
    $update_to  = substr($this->request->post['update_to'], 4);
    ($update_pre == 'uid' || $update_pre == 'bid') ? "" : exit();
    $logged_in_user = $this->user->user_id;

    //check if profile exist and logged in user has the access for changing of images
    $this->loader->model('profile');
    $getprofile_model = $this->registry->get('model_profile');
    $is_p_exist = $getprofile_model->profileExist( $update_to );
    ( $is_p_exist === true ) ? '' : exit();


    if( $update_pre == 'uid' && $logged_in_user == $update_to ) {

    } elseif( $update_pre == 'bid' ){
      $is_admin = $getprofile_model->isAdminOfBoard( $logged_in_user, $update_to );
      ( $is_admin === true ) ? '' : exit();
    }

    $output['status']=FALSE;
    set_time_limit(0);
    $allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );
    
    if ($_FILES['image_upload_file']["error"] > 0) {
      $output['error']= "Error in File";
    }
    elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
      $output['error']= "You can only upload JPG, PNG and GIF file";
    }
    elseif (round($_FILES['image_upload_file']["size"] / 1024) > 4096) {
      $output['error']= "You can upload file size up to 4 MB";
    } else {
      /*create directory with 777 permission if not exist - start*/
      $this->img->createDir(IMAGE_SMALL_DIR);
      $this->img->createDir(IMAGE_MEDIUM_DIR);
      /*create directory with 777 permission if not exist - end*/
      $path[0] = $_FILES['image_upload_file']['tmp_name'];
      $file = pathinfo($_FILES['image_upload_file']['name']);
      $fileType = $file["extension"];
      $desiredExt='jpg';
      $fileName = rand(333, 999) . time();
      $fileNameNew = $fileName . ".$desiredExt";
      $path[1] = IMAGE_MEDIUM_DIR . $fileNameNew;
      $path[2] = IMAGE_SMALL_DIR . $fileNameNew;
    
      if ($this->img->createThumb($path[0], $path[1], $fileType, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE,IMAGE_MEDIUM_SIZE)) {
      
        if ($this->img->createThumb($path[1], $path[2],"$desiredExt", IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE,IMAGE_SMALL_SIZE)) {
          $output['status']=TRUE;
          $output['image_medium']= $fileNameNew;
          $output['image_small']= $fileNameNew;

          $previous_img_file = $getprofile_model->getProfileImg( $update_to );
          if( $previous_img_file == '' || strlen($previous_img_file) > 5 ) {

            if( $previous_img_file !== '' ) {
              //deleting previous image files
              if( !unlink(IMAGE_MEDIUM_DIR . $previous_img_file . ".$desiredExt") ){}
              if( !unlink(IMAGE_SMALL_DIR . $previous_img_file . ".$desiredExt") ){}
            }            

            $profile_detail = $getprofile_model->updateImage( $update_to, $fileName );
            if( !$profile_detail === true ) {
              $output['status'] = FALSE;
              $output['error'] = 'can\'t update image';
            }
            
          } else {
            $output = array('status' => FALSE, 'Cannot found your profile Images');
          }

        } else $output = array('status' => FALSE, 'cannot create thumbnails');
      } else $output = array('status' => FALSE, 'cannot create thumbnails');
    }
    echo json_encode($output);
  }

}

?>