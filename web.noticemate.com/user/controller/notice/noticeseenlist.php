<?php

class ControllerNoticeNoticeSeenList extends Controller {

  public function index() {
    if( isset( $this->request->post['nid'] ) ) {

      $notice_id = (int) $this->request->post['nid'];

      //loade module
      $this->loader->model('notice');
      $getnotice_model = $this->registry->get('model_notice');

      if( isset($this->request->post['used_for']) ) {
        if( $this->request->post['used_for'] == 'not-seen-member' )
          $people_data = $getnotice_model->unSeenPeople( $notice_id );
        elseif( $this->request->post['used_for'] == 'attending-members-list' )
          $people_data = $getnotice_model->attendingEventMembers( $notice_id );
        elseif( $this->request->post['used_for'] == 'not-attending-members-list' )
          $people_data = $getnotice_model->notAttendingEventMembers( $notice_id );
        elseif( $this->request->post['used_for'] == 'not-conformed-members-list' )
          $people_data = $getnotice_model->notConformedEventMembers( $notice_id );
        else
          $people_data = $getnotice_model->peopleSeen( $notice_id );

        //attending popup defines that data is going on popup
        //where an id will be attached to every list
        //onlick list the popup will be hide
        $attending_popup = true;
      } else {
        $people_data = $getnotice_model->peopleSeen( $notice_id );
        $attending_popup = false;
      }

      if( $people_data !== false || $people_data !== 'no-seen' || $people_data !== 'not-authorized' ) {
        echo $this->loader->view('/right/all_members.php', array(
          'board_members' => $people_data,
          'user'        => $this->user,
          'notice_seen_list' => true,
          'attending_popup' => $attending_popup
          ));
      } else $output = array( 'status' => false, 'error' => 'No any <b>member</b> is available !' );
    } else $output = array( 'status' => false, 'error' => 'No any <b>notice</b> is found !' );
    echo (isset($output)) ? json_encode($output) : '';
  }
}

?>