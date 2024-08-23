<?php

class rightBar extends Model{

  private $user_id;
  private $user_full_name;

  public function index() {

    $this->user_id        = $this->user->user_id;
    $this->user_full_name = $this->user->user_full_name;

    $board_query = $this->db->query( "
      SELECT 
        b.board_name, 
        b.board_id, 
        b.created_on, 
        p.profile_img, 
        (SELECT COUNT(*) FROM nm_boarduser WHERE board_id=b.board_id) as am, 
        (SELECT GROUP_CONCAT(u.user_full_Name) FROM nm_boarduser as bu, nm_user as u WHERE bu.board_id=b.board_id AND u.user_id=bu.user_id AND bu.is_admin='0' ) as ml 
      FROM 
        nm_board as b, 
        nm_profile as p,
        nm_boarduser as nbu
      WHERE 
        nbu.user_id='$this->user_id' AND 
        nbu.is_admin = '1' AND
        b.board_id = nbu.board_id AND
        b.is_active='1' AND 
        p.user_id=b.board_id 
          group by b.board_id order by b.board_name
      " );
    if( $board_query->num_rows > 0 ) {

      $plan_type = $this->planType( $this->user_id );
      if( $plan_type !== false ) {
        $board_data = array(
          'boards' => $board_query->rows,
          'plan_type' => $plan_type
          );
        return $board_data;
      }
      return $board_query->rows;
    }

  }

  public function planType( $user_id ) {
    $plan_query = $this->db->query( "SELECT bc.allowed_board, bc.plan_type, bc.allowed_people, bc.expire_on, t.term_name, ( SELECT COUNT(*) FROM nm_board WHERE board_admin='$user_id' AND is_active='1' ) as tcb, ( SELECT COUNT(*) FROM nm_boarduser as nu, nm_board as b WHERE b.board_admin='$user_id' AND b.board_id=nu.board_id ) as tjm FROM nm_boardconf as bc, nm_term as t WHERE user_id='$user_id' AND plan_type='2' AND t.term_id='2'" );

    if( $plan_query->num_rows == 1 ) {
      return $plan_query->row;
    } else return false;
  }

  public function userTopData() {
    $data_query = $this->db->query( "SELECT DISTINCT p.profile_img, u.user_full_name FROM nm_profile as p, nm_user as u WHERE u.user_id='$this->user_id' AND p.user_id='$this->user_id'" );
    return $data_query->row;
  }
}

?>