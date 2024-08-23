<?php

class ControllerNoticeCreateNotice extends Controller {
  public function index() {
    if( isset($this->request->post['bid']) && !empty($this->request->post['bid']) && strlen($this->request->post['bid']) == 10 ) {
      /*
      @check if logged in user is the admin of board which he wants to share notice
      */

      $board_id = $this->request->post['bid'];
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $board_detail = $getboard_model->boardDetail( $board_id );

      if( $board_detail !== false ) {
        $admins = explode(',', $board_detail['all_admins']);
        if( $board_detail['board_admin'] == $this->user->user_id || in_array($this->user->user_id, $admins) ) {
          // create notice
          $this->loader->model('notice');
          $getnotice_model = $this->registry->get('model_notice');

          $raw_content = rawurldecode( $_POST['notice_content'] );

          $notice_title =  $this->db->escape( $this->request->post['notice_title'] );
          $notice_cont = $this->db->escape( $raw_content );

          if( strlen($notice_title) > 5 && strlen($notice_cont) > 5 ) {

          } else {
            $output = array( 'status' => 304, 'error' => 'Notice title and content is not described! Please describe it more.' );
          }

          //check if notice type is set
          if( isset($this->request->post['notice_type']) ) {
            if( $this->request->post['notice_type'] === 'event' ) {
              $ntype = '11';
            } else {
              $ntype = '12';
            }
          } else $ntype = '12';

          if( !isset($output) ) {
            $notice_cr_status = $getnotice_model->createNotice( $notice_title, $notice_cont, $board_detail['board_id'], $ntype );
          }

          if( !isset($output) ) {

            if( is_numeric($notice_cr_status) ) {
              if( isset($this->request->post['fattaches']) && !empty($this->request->post['fattaches']) ) {

                $attachment_files = $this->request->post['fattaches'];
                $getnotice_model->updateFileAttach( $notice_cr_status, $attachment_files);
              }
              $output = array( 'status' => 200, 'msg' => 'Notice created!' );
            } else {
              $output = array( 'status' => 304, 'error' => 'Can\'t create notice!' );
            }
          }

        } else $output = array( 'status' => 401, 'error' => 'Unauthorized notice creation!' );
      } else {
        $output = array( 'status' => 422, 'error' => 'It seems like you have selected Incorrect board' );
      }
    } else {
      $output = array( 'status' => 401, 'error' => 'You are not allowed to send notice to this board' );
    } echo isset($output) ? json_encode($output) : '';
  }
}

?>