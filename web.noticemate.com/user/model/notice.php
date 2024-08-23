<?php

class notice extends Model{

  public $total_notice;

  public function getNotice( $bid, $limit = array() ) {

    if( !isset($limit['slimit']) ) {
      $slimit = 0;
      $elimit = 9;
    } else {
      $slimit = $limit['slimit'];
      $elimit = $limit['elimit'];
    }

    $user_id = $this->user->user_id;

    $notice_query = $this->db->query( "
      SELECT 
        bc.content_id,
        bc.posted_by,
        bc.posted_on,
        bc.posted_time,
        bc.board_id,
        bc.reply_allow,
        bc.content_type,
        IF( bc.content_type='11', (SELECT r.content FROM nm_replies as r WHERE r.replied_by='$user_id' AND r.content_id=bc.content_id AND r.reply_type='13'), '' ) attend_reply,
        IF( bc.is_forwarded='1', (SELECT nbc.content_title FROM nm_boardcont as nbc WHERE nbc.content_id=bc.content_title ), content_title ) content_title,
        IF( bc.is_forwarded='1', (SELECT nbc.content FROM nm_boardcont as nbc WHERE nbc.content_id=bc.content_title ), content ) content, 
        bc.is_forwarded, 
        tt.term_id, 
        (SELECT COUNT(*) FROM nm_term_taxonomy as tt WHERE tt.term_id='1' AND tt.data1=bc.content_id) as ts, 
        ( SELECT COUNT(*) FROM nm_replies WHERE bc.content_id=content_id AND reply_type='14' ) as tr,
        ( SELECT GROUP_CONCAT(na.attach_id SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as attach_id,
        ( SELECT GROUP_CONCAT(na.file_name SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as afname,
        ( SELECT GROUP_CONCAT(na.or_file_name SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as aofname,
        ( SELECT GROUP_CONCAT(na.file_size SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as afsize,
        ( SELECT GROUP_CONCAT(na.file_ext SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as afext
      FROM nm_boardcont as bc 
        LEFT JOIN nm_term_taxonomy as tt on 
          bc.content_id = tt.data1 AND 
          tt.taxonomy_id='$user_id' 
        WHERE 
          bc.board_id='$bid' AND 
          bc.content_id NOT IN 
            ( SELECT data1 FROM nm_term_taxonomy 
              WHERE term_id='4' AND 
              taxonomy_id='$user_id' AND 
              data2='$bid' 
            ) 
        ORDER BY posted_on DESC, posted_time DESC LIMIT $slimit, 10" );

    if( $notice_query->num_rows > 0 ) {
      $this->total_notice = $notice_query->num_rows;
      return $notice_query->rows;
    } else {
      return false;
    }
  }

  public function singleNoticeData( $notice_id, $bid ) {
    $user_id = $this->user->user_id;

    $notice_query = $this->db->query( "
      SELECT 
        bc.content_id,
        bc.posted_by,
        bc.posted_on,
        bc.posted_time,
        bc.board_id,
        bc.reply_allow,
        bc.content_type,
        IF( bc.content_type='11', (SELECT r.content FROM nm_replies as r WHERE r.replied_by='$user_id' AND r.content_id=bc.content_id AND r.reply_type='13'), '' ) attend_reply,
        IF( bc.is_forwarded='1', (SELECT nbc.content_title FROM nm_boardcont as nbc WHERE nbc.content_id=bc.content_title ), content_title ) content_title,
        IF( bc.is_forwarded='1', (SELECT nbc.content FROM nm_boardcont as nbc WHERE nbc.content_id=bc.content_title ), content ) content, 
        bc.is_forwarded, 
        tt.term_id, 
        (SELECT COUNT(*) FROM nm_term_taxonomy as tt WHERE tt.term_id='1' AND tt.data1=bc.content_id) as ts, 
        ( SELECT COUNT(*) FROM nm_replies WHERE bc.content_id=content_id AND reply_type='14' ) as tr,
        ( SELECT GROUP_CONCAT(na.attach_id SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as attach_id,
        ( SELECT GROUP_CONCAT(na.file_name SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as afname,
        ( SELECT GROUP_CONCAT(na.or_file_name SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as aofname,
        ( SELECT GROUP_CONCAT(na.file_size SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as afsize,
        ( SELECT GROUP_CONCAT(na.file_ext SEPARATOR '/') FROM `nm_attachments` as na WHERE na.notice_id=IF( bc.is_forwarded='1', bc.content_title, bc.content_id ) /* AND na.user_id=bc.posted_by */ ) as afext
      FROM nm_boardcont as bc 
        LEFT JOIN nm_term_taxonomy as tt on bc.content_id = tt.data1 and tt.taxonomy_id='$user_id' WHERE bc.content_id='$notice_id' AND bc.content_id NOT IN ( SELECT data1 FROM nm_term_taxonomy WHERE term_id='4' AND taxonomy_id='$user_id' AND data2='$bid' ) 
        ORDER BY posted_on DESC, posted_time DESC LIMIT 0, 10" );

    if( $notice_query->num_rows > 0 ) {
      $this->total_notice = $notice_query->num_rows;
      return $notice_query->rows;
    } else {
      return false;
    }
  }

  public function createNotice( $nt, $nc, $bid, $ctype='12' ) {

    $posted_by = $this->user->user_id;
    $datetime = date_create($this->db->dbDateTime());
    $posted_on = date_format($datetime, "Y-m-d");
    $posted_time = date_format( $datetime, "H:i:s" );


    $create_query = $this->db->query( "INSERT INTO `nm_boardcont`(`posted_by`, `posted_on`, `posted_time`, `board_id`, `content_title`, `content`, `content_type`) VALUES ('$posted_by', '$posted_on', '$posted_time', '$bid', '$nt', '$nc', '$ctype')" );

    return $this->db->getLastId();
  }

  public function updateFileAttach( $notice_id, $attach_id ) {

    $user_id = $this->user->user_id;

    $fileArr = explode(",", $attach_id);

    foreach ($fileArr as $key => $value) {
      $this->db->query("UPDATE `nm_attachments` SET `notice_id` = '$notice_id', is_active='1' WHERE `user_id` = '$user_id' AND `attach_id` = '$value' AND is_active='0'");
    }

  }

  public function insertNoticeSeen($ci, $bi) {

    $user_id = $this->user->user_id;

    //board user and content verification
    $verf_query = $this->db->query( "SELECT * FROM nm_board as b, nm_boarduser as bu WHERE b.board_id='$bi' AND bu.board_id=b.board_id AND bu.user_id='$user_id' AND bu.is_admin='1' AND b.is_active='1'" );

    if( $verf_query->num_rows == 0 ) {
      $verf_query = $this->db->query( "SELECT * FROM nm_boarduser WHERE user_id='$user_id' AND board_id='$bi'" );
    }

    if( $verf_query->num_rows > 0 ) {
      //Check if already seen
      $check_query = $this->db->query("SELECT * FROM nm_term_taxonomy as tt WHERE tt.term_id='1' AND tt.taxonomy_id='$user_id' AND tt.data1='$ci' AND tt.data2='$bi'");

      if( $check_query->num_rows == 0 ) {
        //insert seen
        $insert_query = $this->db->query("INSERT INTO `nm_term_taxonomy`(`term_id`, `taxonomy_id`, `data1`, `data2`) VALUES ('1', '$user_id', '$ci', '$bi')");
        return $this->db->getLastId();
      } else return false;
    } else return 'not-authorized';
  }

  public function isAdminofNotice( $user_id, $notice_id ) {
    $status_query = $this->db->query( "SELECT bc.content_id, b.board_id FROM nm_boardcont as bc, nm_board as b WHERE bc.content_id='" . $notice_id . "' AND b.board_id=bc.board_id AND bc.posted_by='$user_id'" );
    if( $status_query->num_rows == 1 ) {
      return $status_query->row;
    } else return false;
  }

  public function isViewerofNotice( $user_id, $notice_id ) {
    $status_query = $this->db->query( "SELECT bc.content_id, bu.board_id FROM nm_boardcont as bc, nm_boarduser as bu WHERE bc.content_id='" . $notice_id . "' AND bu.board_id=bc.board_id AND bu.user_id='$user_id'" );

    if( $status_query->num_rows == 1 ) {
      return $status_query->row;
    } else return false;
  }

  public function isMemberofNotice( $user_id, $notice_id ) {
    $status_query = $this->db->query( "SELECT bc.content_id, bu.board_id FROM nm_boardcont as bc, nm_boarduser as bu WHERE bc.content_id='" . $notice_id . "' AND bu.board_id=bc.board_id AND bu.user_id='$user_id'" );

    if( $status_query->num_rows == 1 ) {
      return $status_query->row;
    } else return false;
  }

  public function peopleSeen( $notice_id ) {
    $user_id = $this->user->user_id;
    if( $this->isAdminofNotice($user_id, $notice_id) !== false ) {

      $all_people_query = $this->db->query( "SELECT u.user_id, bu.is_admin, u.user_full_name, p.profile_img, tt.data2 as board_id FROM nm_user as u, nm_profile as p, nm_term_taxonomy as tt, nm_boarduser as bu WHERE tt.term_id='1' AND tt.data1='$notice_id' AND tt.taxonomy_id=u.user_id AND bu.board_id=tt.data2 AND bu.user_id=u.user_id AND p.user_id=u.user_id group by u.user_id" );

      if( $all_people_query->num_rows == 0 ) {
        return 'no-seen';
      } elseif( $all_people_query->num_rows > 0 ) {
        return $all_people_query->rows;
      } else return false;
    } else return 'not-authorized';
  }

  public function unSeenPeople( $notice_id ) {
    $user_id = $this->user->user_id;
    if( $this->isAdminofNotice($user_id, $notice_id) !== false ) {

      $all_people_query = $this->db->query( "" );

      if( $all_people_query->num_rows == 0 ) {
        return 'no-seen';
      } elseif( $all_people_query->num_rows > 0 ) {
        return $all_people_query->rows;
      } else return false;
    } else return 'not-authorized';
  }

  public function attendingEventMembers( $notice_id ) {
    $user_id = $this->user->user_id;
    if( $this->isAdminofNotice($user_id, $notice_id) !== false ) {

      $all_people_query = $this->db->query( "
        SELECT 
          u.user_id, 
          bu.is_admin, 
          u.user_full_name, 
          p.profile_img, 
          b.board_id as board_id 
        FROM 
          nm_user as u, 
          nm_profile as p, 
          nm_replies as r,
          nm_boardcont as bc,
          nm_board as b,
          nm_boarduser as bu
        WHERE 
          bc.content_id='$notice_id' AND
          r.content_id=bc.content_id AND
          r.reply_type='13' AND 
          bc.board_id = b.board_id AND
          b.is_active='1' AND
          r.content='yes' AND
          r.replied_by=u.user_id AND
          bu.board_id=b.board_id AND
          bu.user_id=u.user_id AND
          u.user_id=p.user_id
        group by u.user_id" );

      if( $all_people_query->num_rows == 0 ) {
        return 'no-seen';
      } elseif( $all_people_query->num_rows > 0 ) {
        return $all_people_query->rows;
      } else return false;
    } else return 'not-authorized';
  }

  public function notAttendingEventMembers( $notice_id ) {
    $user_id = $this->user->user_id;
    if( $this->isAdminofNotice($user_id, $notice_id) !== false ) {

      $all_people_query = $this->db->query( "
        SELECT 
          u.user_id, 
          bu.is_admin, 
          u.user_full_name, 
          p.profile_img, 
          b.board_id as board_id 
        FROM 
          nm_user as u, 
          nm_profile as p, 
          nm_replies as r,
          nm_boardcont as bc,
          nm_board as b,
          nm_boarduser as bu
        WHERE 
          bc.content_id='$notice_id' AND
          r.content_id=bc.content_id AND
          r.reply_type='13' AND 
          bc.board_id = b.board_id AND
          b.is_active='1' AND
          r.content='no' AND
          r.replied_by=u.user_id AND
          bu.board_id=b.board_id AND
          bu.user_id=u.user_id AND
          u.user_id=p.user_id
        group by u.user_id" );

      if( $all_people_query->num_rows == 0 ) {
        return 'no-seen';
      } elseif( $all_people_query->num_rows > 0 ) {
        return $all_people_query->rows;
      } else return false;
    } else return 'not-authorized';
  }

  public function notConformedEventMembers( $notice_id ) {
    $user_id = $this->user->user_id;
    if( $this->isAdminofNotice($user_id, $notice_id) !== false ) {

      $all_people_query = $this->db->query( "
        SELECT 
          u.user_id, 
          bu.is_admin, 
          u.user_full_name, 
          p.profile_img, 
          b.board_id as board_id 
        FROM 
          nm_user as u, 
          nm_profile as p, 
          nm_replies as r,
          nm_boardcont as bc,
          nm_board as b,
          nm_boarduser as bu
        WHERE 
          bc.content_id='$notice_id' AND
          r.content_id=bc.content_id AND
          r.reply_type='13' AND 
          bc.board_id = b.board_id AND
          b.is_active='1' AND
          r.content='not-conform' AND
          r.replied_by=u.user_id AND
          bu.board_id=b.board_id AND
          bu.user_id=u.user_id AND
          u.user_id=p.user_id
        group by u.user_id" );

      if( $all_people_query->num_rows == 0 ) {
        return 'no-seen';
      } elseif( $all_people_query->num_rows > 0 ) {
        return $all_people_query->rows;
      } else return false;
    } else return 'not-authorized';
  }

  public function hideNotice( $nid ) {

    //check if user is creator of notice or viewer of notice
    $user_id = $this->user->user_id;

    $data = $this->isAdminofNotice($user_id, $nid);
    if( $data == false ) $data = $this->isViewerofNotice($user_id, $nid);

    if( is_array($data) ) {

      //check if already inserted
      $exist_status = $this->db->query( "SELECT * FROM nm_term_taxonomy WHERE term_id='4' AND taxonomy_id='$user_id' AND data1='$nid', AND data2='" . $data['board_id'] . "'" );

      if( $exist_status->num_rows > 0 ) {
        return 'already-exist';
      }
      //hide notice
      $this->db->query( "INSERT INTO `nm_term_taxonomy`(`term_id`, `taxonomy_id`, `data1`, `data2`) VALUES ('4', '$user_id', '$nid', '" . $data['board_id'] . "')" );

      if( is_numeric($this->db->getLastId()) ) {
        return true;
      } else return false;
    } else return 'not-authorized';

  }

  public function forwardNotice( $nid, $bid ) {

    $user_id = $this->user->user_id;

    $data = $this->isAdminofNotice($user_id, $nid);
    if( $data == false ) $data = $this->isViewerofNotice($user_id, $nid);

    if( is_array($data) ) {

      //check if already forwarded
      /*
      @commented because we want to allow one notice can be forwarded more than one time in same board
      $exist_status = $this->db->query( "SELECT * FROM nm_boardcont WHERE posted_by='$user_id'AND board_id='$bid' AND content_title='$nid' AND content='$nid' AND is_forwarded='1'" );

      if( $exist_status->num_rows > 0 )
        return 'already-exist';
      */

      /*
      @check if what notice is going to be fowarded is that also forwarded or not
      @if that is also forwarded then pick content_id of that forwarded notice
      */

      $if_fwd_notice_status = $this->db->query( "SELECT * FROM nm_boardcont WHERE content_id='$nid' AND is_forwarded='1' " );
      if( $if_fwd_notice_status->num_rows > 0 ){
        $nid = $if_fwd_notice_status->row['content_title'];
      }

      $datetime = date_create($this->db->dbDateTime());
      $posted_on = date_format($datetime, "Y-m-d");
      $posted_time = date_format( $datetime, "H:i:s" );

      //insert forwarding
      $this->db->query( "INSERT INTO `nm_boardcont`(`posted_by`, `posted_on`, `posted_time`, `board_id`, `content_title`, `content`, `is_forwarded`) VALUES ('$user_id', '$posted_on', '$posted_time', '$bid', '$nid', '" . $data['board_id'] . "', '1')" );

      if( is_numeric( $this->db->getLastId() ) ) {
        return true;
      } else return false;
    } else return 'not-authorized';

  }

  public function replyAllowToNotice( $notice_id ) {
    $reply_status = $this->db->query("SELECT reply_allow FROM nm_boardcont WHERE content_id='" . $notice_id . "'");
    if( $reply_status->num_rows == 1 ) {
      if( $reply_status->row['reply_allow'] == 1 ) {
        return true;
      } else return false;
    } else 'not-found';
  }

  public function checkUserReplyExist( $data = array() ) {
    if( is_array($data) ) {

      $status = $this->db->query( "SELECT r.content_id FROM nm_replies as r WHERE r.content_id='" . $data['notice_id'] . "' AND r.replied_by='" . $data['user_id'] . "' AND r.reply_type='" . $data['reply_type'] . "'" );

      if( $status->num_rows == 1 ) {
        return true;
      } else return false;
    } else return false;
  }

  public function updateUserReplyExist( $data = array() ) {
    if( is_array($data) ) {

      $this->db->query( "UPDATE `nm_replies` SET `content`='". $data['rep_cont'] . "' WHERE content_id='" . $data['notice_id'] . "' AND replied_by='" . $data['user_id'] . "' AND reply_type='" . $data['reply_type'] . "'" );

      if( $this->db->countAffected() > 0 ) {
        return true;
      } else return false;
    } else return false;
  }

  public function insertReply( $nid, $rep_cont, $rep_location = false, $reply_type = 14 ) {
    $user_id = $this->user->user_id;
    $user_full_name = $this->user->username;

    if( $this->replyAllowToNotice($nid) === true ) {      

      $data = $this->isAdminofNotice($user_id, $nid);
      if( $data == false ) $data = $this->isViewerofNotice($user_id, $nid);

      if( is_array($data) ) {

        /*
        @ if reply type is 13 then it will check that 
        @ is user already replied this kind of reply on this notice
        */
        if( $reply_type == 13 ) {
          if( $this->checkUserReplyExist( array('user_id' => $user_id, 'notice_id' => $nid, 'reply_type' => $reply_type) ) === true ) {

            if( $this->updateUserReplyExist( array('user_id' => $user_id, 'notice_id' => $nid, 'reply_type' => $reply_type, 'rep_cont' => $rep_cont) ) === true ) {
              return true;
            } else return 'reply-exist';
          }
        }

        //insert reply
        $time = $this->db->dbDateTime();
        $datetime = date_create($time);

        $this->db->query( "INSERT INTO `nm_replies`(`content_id`, `replied_by`, `replied_on`, `content`, `reply_location`, `reply_type`) VALUES ('$nid','$user_id','$time','$rep_cont', '$rep_location', '$reply_type')" );

        if( is_numeric( $rep_id = $this->db->getLastId()) ) {

          /*
          @ if reply is default means 14 then reply out will return
          @ otherwise no any notification will be insert to db
          */
          if( $reply_type == 13 ) {
            return true;
          }

          /*
          @ if reply did successfully then insert notification
          @ also return current replied data
          */
          $current_replied_data = $this->insertNotificationRetunRepliedData( $nid, $rep_id, $time );
          if( is_array($current_replied_data) && $current_replied_data !== false ) {
            return $current_replied_data;
          } else return false;

        } else return false;

      } else return 'not-authorized';
    } else return 'not-allowed';
  }

  public function insertNotificationRetunRepliedData( $nid, $rep_id, $time ) {
    $curr_reply_data = $this->db->query( "
      SELECT 
        r.replied_by, 
        r.replied_on as date, 
        r.content as rep_content,
        r.reply_location, 
        u.user_full_name as name, 
        p.profile_img as img ,
        bc.posted_by
      FROM nm_replies as r, 
        nm_user as u, 
        nm_profile as p, 
        nm_boardcont as bc 
      WHERE 
        r.reply_id='$rep_id' AND 
        r.reply_type='14' AND 
        r.replied_by=u.user_id AND 
        p.user_id=r.replied_by AND 
        r.content_id=bc.content_id" );

    if( $curr_reply_data->num_rows > 0 ) {

        $sender_id = $curr_reply_data->rows[0]['replied_by'];
        $rcpt_id = $curr_reply_data->rows[0]['posted_by'];
        $ntf_type = 6;
        $is_board = 0;
        $url_for_notf = 'mod=single_notice&notice_id=' . $nid;

        if( $sender_id !== $rcpt_id ) {
          //insert reply notification
          $this->db->query("INSERT INTO `nm_notification`(`item_id`, `recepient_id`, `sender_id`, `is_read`, `created_on`, `url`, `notif_type`, `is_board`, `notice_id`) VALUES ('', '$rcpt_id', '$sender_id', '0', '$time', '$url_for_notf', '6', '0', '$nid')");
        }

        return $curr_reply_data->rows;
    } else return false;
  }

  public function getReply( $nid, $limit = array() ) {

    if( !isset($limit['slimit']) ) {
      $slimit = 0;
      $elimit = 5;
    } else {
      $slimit = $limit['slimit'];
      $elimit = $limit['elimit'];
    }

    $user_id = $this->user->user_id;

    $data = $this->isAdminofNotice($user_id, $nid);
    if( $data == false ) $data = $this->isViewerofNotice($user_id, $nid);

    if( is_array($data) ) {
      //get all replies detail
      $reply_data = $this->db->query( "
        SELECT 
          r.replied_on as date, 
          r.content as rep_content, 
          r.reply_location, 
          u.user_full_name as name, 
          p.profile_img as img 
        FROM 
          nm_replies as r, 
          nm_user as u, 
          nm_profile as p 
        WHERE 
          r.content_id='$nid' AND 
          r.reply_type='14' AND
          r.replied_by=u.user_id AND 
          p.user_id=r.replied_by 
        ORDER BY date DESC LIMIT $slimit, $elimit" );

      if( $reply_data->num_rows > 0 ) {
        return $reply_data->rows;
      } else return false;
    } else return 'not-authorized';

  }

  public function AttendNoticeDetail( $bid, $notice_id ) {

    $user_id = $this->user->user_id;

    $details = $this->db->query("
      SELECT 
        (SELECT COUNT(*) FROM nm_boarduser WHERE board_id='$bid') as am,
        (SELECT COUNT(*) FROM nm_term_taxonomy as tt WHERE tt.term_id='1' AND tt.data1=bc.content_id) as ts,
        (SELECT COUNT(*) FROM nm_replies as r WHERE r.content_id=bc.content_id AND r.content='yes' AND r.reply_type='13') as yReply,
        (SELECT COUNT(*) FROM nm_replies as r WHERE r.content_id=bc.content_id AND r.content='no' AND r.reply_type='13') as nReply,
        (SELECT COUNT(*) FROM nm_replies as r WHERE r.content_id=bc.content_id AND r.content='not-conform' AND r.reply_type='13') as ncReply
      FROM 
        nm_board as b,
        nm_boardcont as bc
      WHERE 
      bc.content_id = '$notice_id' AND 
      bc.board_id = '$bid' AND 
      b.board_id = bc.board_id AND
      b.is_active = '1' AND
      bc.posted_by = '$user_id'
      ");

    if( $details->num_rows == 1 ) {
      return $details->row;
    } else return false;
  }

}

?>