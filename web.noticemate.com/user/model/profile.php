<?php

class profile extends Model{

  public function userProfile($ui, $bi) {
    $user_id = $this->user->user_id;

    /*
    @first check both the user is belong from the same board
    @if belongs then show profile otherwise return false;
    */

    if( $this->isBoardMemberOrAdmin($ui, $bi) === true && $this->isBoardMemberOrAdmin($user_id, $bi) == true ) {
      if( $this->isAdminOfBoard( $ui, $bi ) == true ) {
        $profile_detail = $this->db->query("
          SELECT 
            u.user_id, 
            u.user_full_name, 
            u.registered_on, 
            p.profile_img, 
            p.status, 
            bu.joined_on, 
            u.user_mobile, 
            u.user_email, 
            (SELECT COUNT(*) FROM nm_boarduser as bu, nm_board as b WHERE bu.user_id='$ui' and bu.board_id=b.board_id AND b.is_active='1' AND bu.is_admin='0') as tbji 
          FROM 
            nm_user as u, 
            nm_profile as p, 
            nm_boarduser as bu, 
            nm_board as b 
          WHERE 
            u.user_id='$ui' AND 
            p.user_id='$ui' AND 
            bu.board_id='$bi' AND 
            bu.user_id='$ui' AND 
            bu.is_admin='1' 
              group by u.user_id
          ");

        if( $profile_detail->num_rows == 1 ) {
          return $profile_detail->row;
        } else return false;
      } else {
        $profile_detail = $this->db->query("SELECT u.user_id, u.user_full_name, u.registered_on, p.profile_img, p.status, bu.joined_on, u.user_mobile, u.user_email, (SELECT COUNT(*) FROM nm_boarduser as bu, nm_board as b WHERE bu.user_id='$ui' and bu.board_id=b.board_id AND b.is_active='1' AND bu.is_admin='0') as tbji FROM nm_user as u, nm_profile as p, nm_boarduser as bu WHERE u.user_id='$ui' AND p.user_id='$ui' AND bu.board_id='$bi' AND bu.user_id='$ui'");

        if( $profile_detail->num_rows == 1 ) {
          return $profile_detail->row;
        } else return false;
      }
    }
  }

  public function myProfile() {
    $user_id = $this->user->user_id;
    $profile_detail = $this->db->query("SELECT u.user_id, u.user_full_name, u.registered_on, p.profile_img, p.status, u.user_mobile, u.user_email, (SELECT COUNT(*) FROM nm_boarduser as bu, nm_board as b WHERE bu.user_id='$user_id' and bu.board_id=b.board_id AND b.is_active='1' AND bu.is_admin='0') as tbji FROM nm_user as u, nm_profile as p WHERE u.user_id='$user_id' AND p.user_id='$user_id'");

    if( $profile_detail->num_rows == 1 ) {
      return $profile_detail->row;
    } else return false;
    
  }

  public function isAdminOfBoard( $uid, $bid ) {
    $is_admin = $this->db->query( "SELECT * FROM nm_boarduser as bu, nm_board as b WHERE bu.board_id='$bid' AND bu.user_id='$uid' AND bu.is_admin='1' AND b.board_id='$bid' AND b.is_active='1'" );
    if( $is_admin->num_rows == 1 ) {
      return true;
    } else return false;
  }

  public function isBoardMemberOrAdmin( $uid, $bid ) {
    $is_access = $this->db->query("SELECT user_id FROM nm_boarduser as bu WHERE bu.board_id='$bid' AND bu.user_id='$uid'");
    if( $is_access->num_rows == 1 )
      return true;
    else
      return false;
  }

  public function profileNameUpdate( $id, $cont ) {

    $user_id = $this->user->user_id;
    if( $user_id == $id ) {
      //update user content
      $this->db->query( "UPDATE `nm_user` SET `user_full_name`='$cont' WHERE user_id='$user_id'" );

      if( $this->db->countAffected() > 0 )
        return 'updated';
      else
        return 'not-allowed';      
    } else return 'not-allowed';

  }

  public function memberStatusUpdate( $id, $cont ) {
    $user_id = $this->user->user_id;
    if( $user_id == $id ) {
      $update_status = $this->db->query( "UPDATE `nm_profile` SET `status`='$cont' WHERE user_id='$user_id' AND is_board='0'" );

      if( $this->db->countAffected() > 0 ) {
        return 'updated';
      } else return 'not-allowed';
    } else return 'not-allowed';
  }

  public function updateImage( $to, $name ) {
    $this->db->query( "UPDATE `nm_profile` SET `profile_img`='$name' WHERE user_id='$to'" );

    if( $this->db->countAffected() > 0 ) {
      return true;
    }
  }

  public function getProfileImg( $user_id ) {
    $profile_data = $this->db->query( "SELECT `profile_img` FROM `nm_profile` WHERE `user_id` = '" . $user_id . "'" );
    if( $profile_data->num_rows == 1 ) {
      return $profile_data->row['profile_img'];
    } else {
      return false;
    }
  }

  public function profileExist( $user_id ) {

    $status = $this->db->query( "SELECT * FROM nm_profile WHERE user_id='$user_id'" );
    if( $status->num_rows > 0 ) {
      return true;
    } else return false;

  }
}

?>