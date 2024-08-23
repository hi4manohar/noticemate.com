<?php

/*

class leftBar extends Model{

  private $user_id;

  public function index() {

    $this->user_id = $this->registry->get('user')->user_id;

    $board_query = $this->db->query( "SELECT nu.board_id, b.board_name, b.created_on, p.profile_img, (SELECT COUNT(*) FROM nm_boarduser WHERE board_id=nu.board_id) as am, (SELECT GROUP_CONCAT(u.user_full_Name) FROM nm_boarduser as bu, nm_user as u WHERE bu.board_id=nu.board_id AND u.user_id=bu.user_id ) as ml, ( SELECT COUNT(*) FROM nm_boardcont WHERE board_id=b.board_id AND content_id NOT IN (SELECT data1 FROM nm_term_taxonomy WHERE taxonomy_id='$this->user_id' AND data2=b.board_id AND term_id='1' ) ) as tn FROM nm_boarduser as nu, nm_board as b, nm_profile as p WHERE nu.user_id='$this->user_id' AND b.board_id=nu.board_id AND b.is_active='1' AND p.user_id=b.board_id order by tn DESC" );
    if( $board_query->num_rows > 0 ) {
      return $board_query->rows;
    }

  }
}

*/
?>