<?php
function com_popup( $data ) {
?>
<div class="pop_up none">
  <ul>
  <?php
  foreach ($data as $key => $value) {
  ?>  
    <a href="<?php echo $data[$key]['link']; ?>">
      <li id="<?php echo isset( $data[$key]['id'] ) ? $data[$key]['id'] : ""; ?>">
        <i class="fa <?php echo $data[$key]['class']; ?> create_g fl_l"></i>
        <span class="l_text"><?php echo $data[$key]['link_text']; ?></span>
      </li>
    </a>
  <?php } ?>
  </ul>
  <div class="arrow-up">
    <div class="inn_arrow-up"></div>
  </div>
</div>
<?php
}
?>


<?php
function left_popup($bid) {
?>
<div class="pop_up none">
  <ul>
    <a href="javascript:void(0);" boardId="<?php echo $bid; ?>">
      <li class="pop_row" id="view_notice" boardId="<?php echo $bid; ?>">
        <i class="fa fa-envelope create_g fl_l"></i>
        <span class="l_text">View Notice</span>
      </li>
    </a>
    <a href="javascript:void(0);">
      <li id="foll_bo_prof" class="pop_row" boardId="<?php echo $bid; ?>" >
        <i class="fa fa-user create_g fl_l"></i>
        <span class="l_text">Board Profile</span>
      </li>
    </a>
    <?php if( $bid !== 'noticemate' ): ?>
    <a href="javascript:void(0);">
      <li class="pop_row" id="foll_bo_all_mem" boardId="<?php echo $bid; ?>">
        <i class="fa fa-users create_g fl_l"></i>
        <span class="l_text">All Members</span>
      </li>
    </a>
    <a href="javascript:void(0);">
      <li class="pop_row" id="exit-board" boardId="<?php echo $bid; ?>">
        <i class="fa fa-times-circle create_g fl_l"></i>
        <span class="l_text">Exit Board</span>
      </li>
    </a>
    <?php endif; ?>
  </ul>
  <div class="arrow-up">
    <div class="inn_arrow-up"></div>
  </div>
</div>
<?php
}
?>

<?php
function menu_popup() {
?>
<div class="pop_up m_popup none">
  <ul>
    <a href="http://www.noticemate.com" title="home page">
      <li class="pop_row">
        <i class="fa fa-home create_g fl_l"></i>
        <span class="l_text">Home</span>
      </li>
    </a>
    <a href="http://www.noticemate.com/#about" class="open-ajax-page" data-mfp-url='/test-ajax.html'>
      <li class="pop_row">
        <i class="fa fa-envelope create_g fl_l"></i>
        <span class="l_text">About</span>
      </li>
    </a>
    <a href="javascript:void(0);">
      <li class="pop_row">
        <i class="fa fa-graduation-cap create_g fl_l"></i>
        <span class="l_text">Learn More</span>
      </li>
    </a>
    <a href="#">
      <li class="pop_row">
        <i class="fa fa-phone-square create_g fl_l"></i>
        <span class="l_text">Support</span>
      </li>
    </a>
  </ul>
  <div class="arrow-up">
    <div class="inn_arrow-up m_arrow"></div>
  </div>
</div>
<?php
}
?>