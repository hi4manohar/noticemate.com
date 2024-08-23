<?php

class ControllerUploadUploadNoticeImage extends Controller {

  public function index() {

    $logged_in_user = $this->user->user_id;

    $allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );

    if ($_FILES['notice_post_img']["error"] > 0) {
      $output['error']= "Error in File";
    }
    elseif (!in_array($_FILES['notice_post_img']["type"], $allowedImageType)) {
      $output['error']= "You can only upload JPG, PNG and GIF file";
    }
    elseif (round($_FILES['notice_post_img']["size"] / 1024) > 4096) {
      $output['error']= "You can upload file size up to 4 MB";
    } else {
      /*create directory with 777 permission if not exist - start*/
      $dir = '/uploades/files/user-' . $logged_in_user;
      $user_dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
      $this->img->createDir($user_dir);
      /*create directory with 777 permission if not exist - end*/

      $path[0] = $_FILES['notice_post_img']['tmp_name'];
      $file = pathinfo($_FILES['notice_post_img']['name']);
      $fileType = $file["extension"];
      $desiredExt='jpg';
      $fileName = rand(333, 999) . time();
      $fileNameNew = $fileName . ".$desiredExt";
      $path[1] = $user_dir . "/" . $fileNameNew;

      list($imgwidth, $imgheight, $imgtype, $imgattr) = getimagesize($path[0]);

      if ($this->img->createThumb($path[0], $path[1], $fileType, $imgwidth, $imgheight)) {

        if( file_exists($user_dir . '/' . $fileNameNew) ) {
          $output['status']   = TRUE;
          $output['img_file'] = $dir . '/' . $fileNameNew;
        } else {
          $output['status'] = false;
          $output['error']  = "file could't found";
        }
        
      } else {
        $output['status'] = false;
        $output['error'] = 'cann\'t upload images';
      }
    }
    echo json_encode($output);
  }
}

?>