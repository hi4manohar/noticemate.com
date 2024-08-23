<?php

class ControllerNoticeEventAttendDetail extends Controller {

  public function index() {
    if( isset( $this->request->post['nid'] ) ) {

      $notice_id = (int) $this->request->post['nid'];

      //loade module
      $this->loader->model('notice');
      $getnotice_model = $this->registry->get('model_notice');

      //checking if logged in user is admin of the notice
      $is_admin_of_notice = $getnotice_model->isAdminofNotice( $this->user->user_id, $notice_id );
      if( is_array($is_admin_of_notice) && $is_admin_of_notice !== false ) {

        //get details
        $attend_detail = $getnotice_model->AttendNoticeDetail( $is_admin_of_notice['board_id'], $notice_id );

        if( is_array($attend_detail) && $attend_detail !== false ) {

          $event_detail = array(
            'board_id' => $is_admin_of_notice['board_id'],
            'notice_id' => $notice_id
            );

          //send data to view to get print htmls to the browser
          echo $this->loader->view('/right/attend_detail.php', array(
            'attend_detail' => $attend_detail,
            'event_detail'  => $event_detail
            ));

        } else $output = array( 'status' => false, 'error' => 'Can\'t found the details!' );

      } else $output = array( 'status' => false, 'error' => 'You are not authorized to view attend detail of this notice!' );
    } else $output = array( 'status' => false, 'error' => 'We could\'t found this notice!' );
    echo isset($output) ? json_encode($output) : '';
  }
}

?>