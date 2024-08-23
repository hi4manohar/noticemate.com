<?php

class Board extends Model {

  public function follBoard() {

    $this->user_id = $this->user->user_id;
    
    $board_query = $this->db->query( "
      SELECT 
        nu.board_id, 
        b.board_name, 
        b.created_on, 
        p.profile_img, 
        (SELECT COUNT(*) FROM nm_boarduser WHERE board_id=nu.board_id) as am, 
        (SELECT GROUP_CONCAT(u.user_full_Name) FROM nm_boarduser as bu, nm_user as u WHERE bu.board_id=nu.board_id AND u.user_id=bu.user_id ) as ml, 
        ( SELECT COUNT(*) FROM nm_boardcont WHERE board_id=b.board_id AND content_id NOT IN (SELECT data1 FROM nm_term_taxonomy WHERE taxonomy_id='$this->user_id' AND data2=b.board_id AND term_id='1' ) ) as tn FROM nm_boarduser as nu, nm_board as b, nm_profile as p WHERE nu.user_id='$this->user_id' AND b.board_id=nu.board_id AND b.is_active='1' AND p.user_id=b.board_id AND nu.is_admin='0' order by tn DESC" );
    if( $board_query->num_rows > 0 ) {
      return $board_query->rows;
    }
  }

  public function getFollBoardTotalNoticeAtReal() {
    $user_id = $this->user->user_id;
    $total_notice = $this->db->query("
      SELECT 
        nu.board_id, 
          ( SELECT 
            COUNT(*) 
           FROM 
            nm_boardcont 
           WHERE 
            board_id=b.board_id AND 
            content_id NOT IN 
            (SELECT data1 
               FROM 
                nm_term_taxonomy 
               WHERE 
                taxonomy_id='$user_id' AND 
                data2=b.board_id AND 
                term_id='1' 
              )
          ) as tn
      FROM 
        nm_boarduser as nu, 
          nm_board as b 
      WHERE 
        nu.user_id='$user_id' AND 
          b.board_id=nu.board_id AND 
          b.is_active='1' AND 
          nu.is_admin='0' Having tn > 0
          order by tn DESC
      ");

    if( $total_notice->num_rows > 0 )
      return $total_notice->rows;
    else return false;
  }

  public function boardDetail( $bid ) {

    $board_query = $this->db->query( "
      SELECT 
        b.board_id, 
        b.board_name, 
        b.board_admin,
        b.join_more,
        (SELECT GROUP_CONCAT(bu.user_id) FROM nm_boarduser as bu, nm_user as u WHERE bu.board_id=b.board_id AND u.user_id=bu.user_id AND bu.is_admin='1' ) as all_admins,
        b.created_on, 
        b.board_dist_id, 
        p.status, 
        p.profile_img, 
        u.user_full_name, 
        (SELECT COUNT(*) FROM nm_boarduser WHERE board_id='$bid') as am 
      FROM 
        nm_board as b, 
        nm_profile as p, 
        nm_user as u
      WHERE 
        b.board_id='$bid' AND 
        b.is_active='1' AND 
        p.user_id='$bid' AND 
        p.is_board='1' AND 
        u.user_id=b.board_admin
      " );
    if( $board_query->num_rows == 1 ) {
      return $board_query->row;
    } else return false;
  }

  public function boardMembers( $bid ) {
    $member_query = $this->db->query( "SELECT u.user_id, u.user_full_name, p.profile_img, bu.is_admin FROM nm_boarduser as bu, nm_user as u, nm_profile as p WHERE bu.board_id='$bid' AND u.user_id=bu.user_id AND p.user_id=u.user_id ORDER BY user_full_name ASC" );

    if( $member_query->num_rows > 0 ) {
      return $member_query->rows;
    } else return false;
  }

  public function isAdminOfBoard( $uid, $bid ) {
    $is_admin = $this->db->query( "SELECT * FROM nm_boarduser as bu, nm_board as b WHERE bu.board_id='$bid' AND bu.user_id='$uid' AND bu.is_admin='1' AND b.board_id='$bid' AND b.is_active='1'" );
    if( $is_admin->num_rows == 1 ) {
      return true;
    } else return false;
  }

  public function isCreatorOfBoard( $uid, $bid ) {
    $is_creator = $this->db->query( "SELECT b.board_name FROM nm_board as b WHERE b.board_id='$bid' AND b.board_admin='$uid' AND b.is_active='1'" );

    if( $is_creator->num_rows == 1 ) {
      return true;
    } else return false;
  }

  public function isMemberOfBoard( $uid, $bid ) {
    $is_member = $this->db->query( "SELECT * FROM nm_boarduser as bu, nm_board as b WHERE bu.board_id='$bid' AND bu.user_id='$uid' AND bu.is_admin='0' AND b.board_id='$bid' AND b.is_active='1'" );
    if( $is_admin->num_rows == 1 ) {
      return true;
    } else return false;
  }

  public function boardStatus( $bid, $status ) {

    $user_id = $this->user->user_id;

    $check_admin = $this->db->query( "SELECT * FROM nm_board as b, nm_profile as p, nm_boarduser as bu WHERE b.board_id='$bid' AND bu.board_id=b.board_id AND bu.user_id='$user_id' AND bu.is_admin='1' AND b.is_active='1' AND p.user_id='$bid' AND p.is_board='1'" );

    if( $check_admin->num_rows == 1 ) {
      if( $status == $check_admin->row['status'] ) {
        return 'exist';
      } else {

        $this->db->query( "UPDATE `nm_profile` SET `status`='$status' WHERE `user_id`='$bid' AND `is_board`='1'" );
        return 'updated';
      }      
    } else return 'not-allowed';

  }

  public function boardName( $bid, $name ) {

    $user_id = $this->user->user_id;
    $check_admin = $this->db->query( "SELECT * FROM nm_board as b, nm_boarduser as bu WHERE b.board_id='$bid' AND bu.board_id=b.board_id AND bu.user_id='$user_id' AND bu.is_admin='1' AND b.is_active='1'" );
    if( $check_admin->num_rows == 1 ) {
      if( $name == $check_admin->row['board_name'] ) {
        return 'exist';
      } else {

        $this->db->query( "UPDATE `nm_board` SET `board_name`='$name' WHERE `board_id`='$bid' AND is_active='1'" );
        return 'updated';
      }      
    } else return 'not-allowed';

  }

  public function removeBoardMember($uid, $bid) {
    $user_id = $this->user->user_id;

    /*
    @ if logged in user is creator of the board then he can remove any of the of member
    */

    if( $uid !== $user_id ) {

      $board_member_status = $this->db->query( "SELECT * FROM nm_board as b, nm_boarduser as u WHERE b.board_id='$bid' AND b.board_admin='$user_id' AND b.is_active='1' AND u.board_id='$bid' AND u.user_id='$uid'" );

      if( $board_member_status->num_rows == 1 ) {
        $this->db->query( "DELETE FROM `nm_boarduser` WHERE board_id='$bid' AND user_id='$uid'" );

        return true;

      } else return false;
    } else return false;
  }

  public function exitFromBoard( $bid ) {
    $user_id = $this->user->user_id;
    $exit_status = $this->db->query( "SELECT b.board_admin, b.board_id FROM nm_boarduser as bu, nm_board as b WHERE bu.board_id='$bid' AND bu.user_id='$user_id' AND bu.is_admin='0' AND b.board_id=bu.board_id" );
    if( $exit_status->num_rows == 1 ) {
      $this->db->query( "DELETE FROM `nm_boarduser` WHERE board_id='$bid' AND user_id='$user_id' AND is_admin='0'" );

      return $exit_status->row;
      
    } else return false;
  }

  public function isBoardExist( $where , $val ) {
    $status = $this->db->query( "SELECT * FROM nm_board WHERE $where='$val'" );
    if( $status->num_rows == 0 ) {
      return true;
    } else return false;
  }

  //taken from rightBar model
  public function isCreationAllowed( $user_id ) {
    $plan_query = $this->db->query( "SELECT allowed_board, plan_type, allowed_people, ( SELECT COUNT(*) FROM nm_board WHERE board_admin='$user_id' AND is_active='1' ) as tcb FROM nm_boardconf WHERE user_id='$user_id' AND plan_type='2'" );
    if( $plan_query->num_rows == 1 ) {
      $row = $plan_query->row;
      if( ($row['allowed_board'] - $row['tcb']) > 0 ) {
        return true;
      } else return false;
    } else return false;
  }

  /*
  @ this method will check board id is different from userid or not
  @ because board id and user id should not be the same
  */
  public function isBoardIdIsUserId( $bid ) {
    $data_row = $this->db->query( "SELECT user_id FROM nm_user WHERE user_id='$bid'" );

    if( $data_row->num_rows > 0 )
      return true;
    else return false;
  }

  public function createBoard( $bname, $bdi ) {
    if( $this->isBoardExist('board_dist_id', $bdi) == true ) {

      $bid = rand(1111111111,mt_getrandmax());
      $datetime = $this->db->dbDateTime();
      $user_id = $this->user->user_id;

      $number_of_while_tried = 1;
      while ( $this->isBoardIdIsUserId( $bid ) === true ) {
        $bid = rand(1111111111,mt_getrandmax());
        $number_of_while_tried = $number_of_while_tried + 1;
        if( $number_of_while_tried > 4 ) {
          return "Mismatch-Board";
          break;
        }
      }

      if( $this->isCreationAllowed( $user_id ) ) {

        $this->db->query( "INSERT INTO `nm_board`(`board_id`, `board_name`, `created_on`, `board_admin`, `board_dist_id`, `is_active`) VALUES ('$bid', '$bname', '$datetime', '$user_id', '$bdi', '1')" );

        $this->db->query( "INSERT INTO `nm_profile`(`user_id`, `status`, `profile_img`, `is_board`) VALUES ('$bid', 'No Status!', '', '1')" );

        $this->db->query( "INSERT INTO `nm_boarduser`(`board_id`, `user_id`, `joined_on`, `is_admin`) VALUES ('$bid', '$user_id', '$datetime', '1')" );

        if( $this->db->getLastId() > 0 ) {
          return $bid;
        } else return false;
      } else return 'not-allowed';
    } else return false;
  }

  public function deleteBoard( $bid ) {
    $user_id = $this->user->user_id;

    $this->db->query( "UPDATE `nm_board` SET `is_active`=0 WHERE board_id='$bid' AND board_admin='$user_id'" );

    if( $this->db->countAffected() > 0 ) {
      return true;
    } else return false;
  }

  public function joinBoard( $bdi, $bname ) {

    $user_id = $this->user->user_id;

    //get board id from board distribution for joining in board
    $is_exist = $this->db->query( "SELECT * FROM nm_board WHERE board_dist_id='$bdi' AND board_name='$bname' AND board_admin != '$user_id'" );

    if( $is_exist->num_rows == 1 ) {

      if( $is_exist->row['join_more'] == 0 ) {
        return 'joining-not-allowed';
      }

      $bid = $is_exist->row['board_id'];
      $board_admin = $is_exist->row['board_admin'];

      //check if already is member
      $is_in_user = $this->db->query( "SELECT * FROM nm_boarduser WHERE board_id='$bid' AND user_id='$user_id'" );

      if( $is_in_user->num_rows == 0 ) {
        //insert user
        $datetime = $this->db->dbDateTime();
        $this->db->query( "INSERT INTO `nm_boarduser`(`board_id`, `user_id`, `joined_on`, `is_admin`) VALUES ($bid, $user_id, '$datetime', '0')" );

        if( $this->db->countAffected() == 1 ) {

          $data = array( 'status' => true, 'board_id' => $bid, 'board_admin' => $board_admin );
          return $data;

        } else return 'insert-error';
      } else 'already-member';

    } else 'not-exist';
  }

  public function checkDownloadAllowed($attach_id) {

    $user_id = $this->user->user_id;

    $board_id = $this->db->query("SELECT at.file_name, at.or_file_name, at.file_ext, at.user_id FROM nm_attachments as at, nm_boardcont as bt, nm_boarduser as bu WHERE at.attach_id='$attach_id' AND at.notice_id=bt.content_id AND bt.board_id=bu.board_id AND bu.user_id='$user_id' AND at.is_active='1'");

    if( $board_id->num_rows == 1 ) {
      return $board_id->row;
    } else return false;
  }

  public function boardMoreMemberJoinUpdate( $bid, $value ) {

    $this->db->query( "UPDATE `nm_board` SET `join_more`='$value' WHERE board_id='$bid'" );

    if( $this->db->countAffected() == 1 ) {
      return true;
    } else return false;
  }

}

?>