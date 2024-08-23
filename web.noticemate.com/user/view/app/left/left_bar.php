<!-- left part html start -->
<?php
if( isset($data['load_only_left']) && $data['load_only_left'] === true ):
  echo $data['left_bar_members'];
else:
?>
<div class="l_part_containner fl_l" id="joined-board-list">
  <div class="l_part_logo_con" id="l_p_g">
    <div class="hide-left-bar" title="Hide board list and show followed board" id="mhlcb">
      <i class="fa fa-chevron-left"></i>
    </div>
    <div class="nm_options dot_menu imp">
      <i class="fa fa-bars fl_l n_m_menu"></i>
      <?php
        if( !function_exists('com_popup') )
          echo $data['left_popup'];
        menu_popup();
      ?>
    </div>
    <h1 class="logo fl_l">NoticeMate</h1>
  </div>
  <div class="l_part_header">
    <h1>YOUR FOLLOWED BOARD</h1>
  </div>
  <form class="l_part_search_con">
    <input class="form-control fuzzy-search" type="text" placeholder="Search...">
    <button class="s_button" type="submit">
      <i class="fa fa-search s_icon"></i>
    </button>
  </form>
  <div class="l_part_g_cont nm_scroll">
      <ul class="list" id="left_members">
        <?php echo $data['left_bar_members']; ?>
      </ul>
  </div>
</div>
<?php endif; ?>
<!--left part html end -->