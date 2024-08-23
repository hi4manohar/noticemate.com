<?php

class Notification extends Model{

  public function userNotifications( $user_id, $limit = array() ) {

    if( !isset($limit['slimit']) ) {
      $slimit = 0;
      $elimit = 9;
    } else {
      $slimit = $limit['slimit'];
      $elimit = $limit['elimit'];
    }

    $notif_query = $this->db->query("
          SELECT 
              nn.item_id,
              nn.notif_type,
              nn.recepient_id, 
              nn.sender_id,
              nn.is_read, 
              nn.created_on, 
              nn.url, 
              t.term_description, 
              p.profile_img,
              u.user_full_name as user_name,
              ( CASE
                  WHEN nn.notice_id IS NULL THEN NULL
                  WHEN bc.is_forwarded='1' THEN (SELECT nbc.content_title FROM nm_boardcont as nbc WHERE nbc.content_id=bc.content_title )
                  ELSE (SELECT nbc.content_title FROM nm_boardcont as nbc WHERE nbc.content_id=nn.notice_id )
                END
              ) AS notice_title,
              IF( nn.board_id IS NULL, 'NULL', (SELECT b.board_name FROM nm_board as b WHERE b.board_id=nn.board_id) ) board_name
          FROM
              nm_profile as p, 
              nm_notification as nn, 
              nm_term as t,
              nm_user as u,
              nm_boardcont as bc,
              nm_board as b
          WHERE 
              nn.recepient_id = '$user_id' AND
              nn.notif_type = t.term_id AND
              u.user_id = nn.sender_id AND
              ( nn.board_id=b.board_id OR nn.notice_id = bc.content_id AND bc.board_id=b.board_id AND b.is_active='1' ) AND
              p.user_id = nn.sender_id AND
              nn.notif_type = t.term_id
          GROUP BY nn.item_id ORDER BY nn.created_on DESC LIMIT $slimit, 10
      ");

    if( $notif_query->num_rows > 0 ) {
      //print_r($notif_query->rows);
      foreach ($notif_query->rows as $key => $value) {
        extract($value);
        $search = array('$user_name', '$notice_title', '$board_name');
        $replace = array('<b>' . $user_name . '</b>', '<b>' . $notice_title . '</b>', '<b>' . $board_name . '</b>');
        $notification['title'][] = str_replace($search, $replace, $term_description);
        $notification['p_img'][] = $profile_img;
        $notification['sender'][] = $sender_id;
        $notification['url'][] = $url;
        $notification['is_read'][] = $is_read;
        $notification['ntf_id'][] = $item_id;

        $date = date_create( $created_on );

        $notification['time'][] = $this->time_elapsed_string( $created_on );
      }

      return $notification;

    } else {
      return false;
    }

  }

  public function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime( $this->db->dbDateTime() );
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
      if ($diff->$k) {
          $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
          unset($string[$k]);
      }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }

  public function allNotif() {
    $user_id = $this->user->user_id;
    $total_notif = $this->db->query("
          SELECT 
              nn.item_id
          FROM
              nm_profile as p, 
              nm_notification as nn, 
              nm_term as t,
              nm_user as u,
              nm_boardcont as bc,
              nm_board as b
          WHERE 
              nn.recepient_id = '$user_id' AND
              nn.notif_type = t.term_id AND
              u.user_id = nn.sender_id AND
              ( nn.board_id=b.board_id OR nn.notice_id = bc.content_id AND bc.board_id=b.board_id AND b.is_active='1' ) AND
              p.user_id = nn.sender_id AND
              nn.is_read = '0'
          GROUP BY nn.item_id ORDER BY nn.created_on DESC LIMIT 0, 10
      ");
    if( $total_notif->num_rows > 0 ) {
      return $total_notif->num_rows;
    } else return '0';
  }

  public function updateNotifToSeen( $notif_id ) {
    $this->db->query("UPDATE `nm_notification` SET `is_read`='1' WHERE `item_id` = '$notif_id'");
    if( is_numeric($this->db->countAffected()) ) {
      return true;
    } else return false;
  }

  /*
  * method used when admin will remove a user from board
  * then notification will reach to user that admin has removed you
  */
  public function userRemovalFromBoardNotif( $rcpt_id, $bid ) {

    $sender_id = $this->user->user_id;
    $time = $this->db->dbDateTime();
    $url_for_notf = "mod=urfb&board_id=" . $bid;

    $this->db->query("INSERT INTO `nm_notification`(`item_id`, `recepient_id`, `sender_id`, `is_read`, `created_on`, `url`, `notif_type`, `is_board`, `notice_id`, `board_id`) VALUES ('', '$rcpt_id', '$sender_id', '0', '$time', '$url_for_notf', '7', '0', NULL, '$bid')");

    if( is_numeric($this->db->getLastId()) ) {
      return true;
    } else return false;
  }

  /*
  @ method will be called when a user is joined in a board
  @ then notification will be reach to board admin
  */
  public function userJoinedInBoardNotif( $rcpt_id, $bid ) {
    $sender_id = $this->user->user_id;
    $time = $this->db->dbDateTime();
    $url_for_notf = "mod=mjib&board_id=" . $bid;

    $this->db->query("INSERT INTO `nm_notification`(`item_id`, `recepient_id`, `sender_id`, `is_read`, `created_on`, `url`, `notif_type`, `is_board`, `notice_id`, `board_id`) VALUES ('', '$rcpt_id', '$sender_id', '0', '$time', '$url_for_notf', '9', '0', NULL, '$bid')");

    if( is_numeric($this->db->getLastId()) ) {
      return true;
    } else return false;
  }

  /*
  @ method will be called when a member will be exited from board
  @ then notification will be reach to board admin
  */
  public function userExitedFromBoard( $rcpt_id, $bid ) {
    $sender_id = $this->user->user_id;
    $time = $this->db->dbDateTime();
    $url_for_notf = "mod=mefb&board_id=" . $bid;

    $this->db->query("INSERT INTO `nm_notification`(`item_id`, `recepient_id`, `sender_id`, `is_read`, `created_on`, `url`, `notif_type`, `is_board`, `notice_id`, `board_id`) VALUES ('', '$rcpt_id', '$sender_id', '0', '$time', '$url_for_notf', '10', '0', NULL, '$bid')");

    if( is_numeric($this->db->getLastId()) ) {
      return true;
    } else return false;
  }

  /*
  * method will check if user is admin of the notification
  */
  public function checkAdminOfNotif( $user_id, $notif_id ) {
    $get_row = $this->db->query( "SELECT item_id FROM nm_notification WHERE `item_id` = '$notif_id' AND `recepient_id` = '$user_id'" );
    if( $get_row->num_rows == 1 ) {
      return $get_row->row;
    } else return false;
  }
}

?>