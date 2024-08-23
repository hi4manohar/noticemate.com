<?php

class ControllerDownloadFileDownload extends Controller {

  public function index() {

    $file = $this->inputest->trimTitle( preg_replace( '#[^-\w]#', '', $this->request->get['file'] ) );

    //get board id from file name
    $this->loader->model('board');
    $getboard_model = $this->registry->get('model_board');

    $download_allowed = $getboard_model->checkDownloadAllowed($file);

    if( is_array($download_allowed) ) {
      $this->allowDownload( $download_allowed );
    } else {
      $output = array('status' => false, 'error' => 'File is not allowed to download to you!');
      echo json_encode($output);
    }

  }

  public function allowDownload( $data ) {

    $user_id = $data['user_id'];

    $download_path = ROOT_DIR . '/uploades/files/user-' . $user_id . '/';

    $file = $data['file_name'];
    $file_rename = $data['or_file_name'];
    
    $args = array(
        'download_path'   =>  $download_path,
        'file'            =>  $file,    
        'extension_check' =>  FALSE,
        'referrer_check'  =>  FALSE,
        'referrer'        =>  NULL,
        'file_rename'     =>  $file_rename
        );
    $download = new chip_download( $args );
    
    /*
    |-----------------
    | Pre Download Hook
    |------------------
    */
    
    $download_hook = $download->get_download_hook();
    //$download->chip_print($download_hook);
    //exit;
    
    /*
    |-----------------
    | Download
    |------------------
    */
    
    if( $download_hook['download'] == TRUE ) {
    
      /* You can write your logic before proceeding to download */
      
      /* Let's download file */
      $download->get_download();
    
    } else {
      $output = array('status' => false, 'error' => 'We could\'t found file!');
      echo json_encode($output);
    }
  }

}

?>