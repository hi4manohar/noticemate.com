<?php

class ControllerNoticeNoticeReplyOff extends Controller {
  public function index() {
    if( isset($this->request->post['nid']) ) {
      $notice_id = (int) $this->request->post['nid'];

      if( $this->request->post['mod'] == 'replyoff' )
        $this->loader->controller("notice/noticeconf/turOffReply", $notice_id);
      else
        $this->loader->controller("notice/noticeconf/turnOnReply", $notice_id);
    }
  }
}

?>