<?php

class ControllerNoticeNoticeReply extends Controller {
  public function index() {

    if( isset($this->request->post['nid']) && isset($this->request->post['rep_content']) ) {
      $rep_content = $this->request->post['rep_content'];
      $notice_id = (int)$this->request->post['nid'];

      if( strlen($rep_content) > 0 && $notice_id !== 0 ) {

        $raw_content = rawurldecode( $rep_content );
        $reply_content = $this->db->escape( $raw_content );

        $this->loader->model('notice');
        $getnotice_model = $this->registry->get('model_notice');

        /*
        @ if reply location is set then send reply location to module
        @ otherwise send false to module
        */
        if( isset($this->request->post['reploc']) ) {
          $reploc = $this->inputest->trimTitle( $this->request->post['reploc'] );
          if( !empty($reploc) ) {
            $loc_arr = explode(',', $reploc);
            if( is_array($loc_arr) && sizeof($loc_arr) == 2 ) {
              $reply_location = $reploc;
            } else $reply_location = false;
          } else $reply_location = false;
        } else $reply_location = false;

        /*
        @ check if attend notice reply is set
        @ if that is set then first insert that notice
        @ if attending reply insert throw error then it will stop execution further inserting
        */
        if( isset($this->request->post['attend_reply']) ) {
          $attend_reply = $this->inputest->trimTitle( $this->request->post['attend_reply'] );
          if( $attend_reply == 'yes' || $attend_reply == 'no' || $attend_reply == 'not-conform' ) {
            $attend_insert_status = $getnotice_model->insertReply( $notice_id, $attend_reply, false, 13 );
            if( $attend_insert_status === false ) {
              $output = array('status' => false, 'error' => 'Cautch something error in doing your reply! <br>Please reload the page and try again !');
              echo json_encode($output);
              exit();
            }
          }
        }

        $insert_status = $getnotice_model->insertReply( $notice_id, $reply_content, $reply_location );

        if( is_array($insert_status) ) {
          echo $this->loader->view('/middle/comment.php', array(
            'reply_data' => $insert_status,
            'show_json' => true
          ));
        } elseif( $insert_status === 'not-authorized' ) {
          $output = array('status' => false, 'error' => 'Cautch something error in doing your reply! <br>Please reload the page and try again !');
        } elseif( $insert_status === 'not-allowed' ) {
          $output = array('status' => false, 'error' => 'Doing Reply for this notice is not <b>allowed</b> !');
        }

      } else $output = array('status' => false, 'error' => 'We could\'t found this notice!<br> Please refresh the page and try again!' );
      echo (isset($output)) ? json_encode($output) : '';
    }
  }
}

?>