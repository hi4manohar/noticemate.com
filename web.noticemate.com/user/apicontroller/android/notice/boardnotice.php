<?php

class ControllerNoticeBoardNotice extends Controller {

  public function index() {

    if( isset( $this->request->post['bid'] ) && $this->inputest->verifyBoard($this->request->post['bid']) ) {

      //verify board
      $this->loader->model('board');
      $getboard_model = $this->registry->get('model_board');
      $board_detail = $getboard_model->boardDetail( $this->request->post['bid'] );

      //check if limit is set or not
      if( isset($this->request->post['page']) ) {
        $page = (int) $this->request->post['page'];
        if( $page == 0 ) {
          $limit = array(
            'slimit' => $page,
            'elimit' => 9
            );
        } else {
          $slimit = ($page-1) * 10;
          $elimit = $slimit + 9;
          $limit = array(
            'slimit' => $slimit,
            'elimit' => $elimit
            );
        }
      } else $limit = array('slimit' => 0, 'elimit' => 10 );

      if( $board_detail !== false ) {

        $data = $this->frontConfData();
        
        $this->loader->model('notice');
        $notice_model = $this->registry->get('model_notice');
        $notice_data = $notice_model->getNotice( $this->request->post['bid'], $limit );

        $total_notice = $notice_model->total_notice;

        $output = array(
          'status'        => 200,
          'notice_data'   => $notice_data,
          'board_detail'  => $board_detail,
          'total_notice'  => $total_notice,
          'conf_text'     => $data,
          'loggedin_user' => $this->user->user_id
          );

      } else $output = array( 'status' => 404, 'error' => 'Board Detail Could\'t found!' );
    } else $output = array( 'status' => 404, 'error' => 'Board Detail Could\'t found!' );

    echo isset($output) ? json_encode($output) : '';
  }

  public function frontConfData() {
    $data['reply_off_id']   = 'close-reply';
    $data['reply_on_id']    = 'turn-on-reply';
    $data['reply_off_text'] = 'Turn-off Reply';
    $data['reply_on_text']  = 'Turn-on Reply';

    return $data;
  }

  public function singleNoticeData() {

    if( !empty($this->request->post['notice_id']) ) {

      $notice_id = (int) $this->request->post['notice_id'];

      $this->loader->model('notice');
      $notice_model = $this->registry->get('model_notice');
      $notice_status = $notice_model->isMemberofNotice( $this->user->user_id, $notice_id  );

      if( is_array($notice_status) ) {

        //verify board
        $this->loader->model('board');
        $getboard_model = $this->registry->get('model_board');
        $board_detail = $getboard_model->boardDetail( $notice_status['board_id'] );

        if( $board_detail !== false ) {

          $data = $this->frontConfData();

          $notice_data = $notice_model->singleNoticeData( $notice_id, $board_detail['board_id'] );

          $total_notice = $notice_model->total_notice;

          if( $total_notice > 0 ) {

            //check if is notification then update notification to seen
            if( isset($this->request->post['notification_id']) ) {
              $notif_id = (int) $this->request->post['notification_id'];
              $this->loader->model('notification');
              $this->registry->get('model_notification')->updateNotifToSeen( $notif_id );
            }
            echo $this->loader->view('/middle/' . 'notice' . '.php', array(
              'notice_data'   => $notice_data,
              'board_detail'  => $board_detail,
              'user'          => $this->user,
              'total_notice'  => $total_notice,
              'conf_text'     => $data
            ));
          } else $output = array( 'status' => false, 'error' => 'Sorry! we could\'t found this notice!' );
        
        } else $output = array( 'status' => false, 'error' => 'This notice is not authorized to you!' );

      } else $output = array( 'status' => false, 'error' => 'This notice is not authorized to you!' );

      echo isset($output) ? json_encode($output) : '';
    }
  }
}

?>