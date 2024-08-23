<?php

class ControllerUserUserNotification extends Controller{

  public function index() {

    $this->loader->model('notification');
    $notif_model = $this->registry->get('model_notification');

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

    $notifications = $notif_model->userNotifications( $this->user->user_id, $limit );

    if( is_array($notifications) ) {
      echo $this->loader->view('/middle/notification.php', array(
        'notifications' => $notifications
      ));
    } else {
      $output = array('status' => false, 'error' => 'No notifications!');
      echo json_encode($output);
    }

  }

  public function updateNotifSeen() {
    //check if is notification then update notification to seen
    if( isset($this->request->post['notification_id']) ) {

      $user_id = $this->user->user_id;

      //check if requested user is the admin of notice
      $notif_id = (int) $this->request->post['notification_id'];
      $this->loader->model('notification');
      $notif_model = $this->registry->get('model_notification');
      if( is_array( $notif_model->checkAdminOfNotif($user_id, $notif_id) ) ) {
        if( $notif_model->updateNotifToSeen( $notif_id ) ) {
          $output = array( 'status' => true );
        } else $output = array( 'status' => false, 'error' => 'Got Error in updating notification!' );
      } else {
        $output = array( 'status' => false, 'error' => 'You are not allowed update this notification!' );
      }
    } else {
      $output = array( 'status' => false, 'error' => "Could't get notification!" );
    }
    echo isset($output) ? json_encode($output) : '';
  }
}

?>