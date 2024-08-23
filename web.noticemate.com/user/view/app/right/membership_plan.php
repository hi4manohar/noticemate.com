<?php if( isset($plan_data) ): ?>
<div id="mem_plan">
  <div class="data_replacer">
    <div class="accordion-section-title data_content" id="data-content" style="margin-bottom: 0px;">
      <div class="data_icon" id="data-icon" style="float:left;">
        <i class="fa fa-arrow-left"></i>
      </div>
      <div class="profile_data_text">
        <span class="dotes">Membership Plan :</span>
      </div>
    </div>
    <div class="board_empty">
      <div class="board_note">
        <div class="board_note_text">
          <p>Membership plan details :</p>
        </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-section">
        <a class="accordion-section-title" href="javascript:void(0);">Membership Plan Name :</a>
        <div id="accordion-4" class="accordion-section-content block">
          <p class="dotes mfs"> <?php echo $plan_data['term_name']; ?></p>
        </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-section">
        <a class="accordion-section-title" href="javascript:void(0);">Allowed No. of Board :</a>
        <div id="accordion-4" class="accordion-section-content block">
          <p class="dotes mfs"> <?php echo $plan_data['allowed_board']; ?></p>
        </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-section">
        <a class="accordion-section-title" href="javascript:void(0);">Total Created Board :</a>
        <div id="accordion-4" class="accordion-section-content block">
          <p class="dotes mfs"> <?php echo $plan_data['tcb']; ?></p>
        </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-section">
        <a class="accordion-section-title" href="javascript:void(0);">Total Left Board :</a>
        <div id="accordion-4" class="accordion-section-content block">
          <p class="dotes mfs"> <?php echo $plan_data['allowed_board'] - $plan_data['tcb']; ?></p>
        </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-section">
        <a class="accordion-section-title" href="javascript:void(0);">Member can join in allowed board :</a>
        <div id="accordion-4" class="accordion-section-content block">
          <p class="dotes mfs"> <?php echo $plan_data['allowed_people']; ?></p>
        </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-section">
        <a class="accordion-section-title" href="javascript:void(0);">Total member joined :</a>
        <div id="accordion-4" class="accordion-section-content block">
          <p class="dotes mfs"> <?php echo $plan_data['tjm']; ?></p>
        </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-section">
        <a class="accordion-section-title" href="javascript:void(0);">Plan expired on :</a>
        <div id="accordion-4" class="accordion-section-content block">
          <p class="dotes mfs"> <?php $date = date_create($plan_data['expire_on']); echo date_format($date, "d-m-Y"); ?></p>
        </div>
      </div>
    </div>
    <div class="board_empty">
      <div class="board_note">
        <div class="board_note_text">
          <p><a href="">Upgrade membership plan.</a></p>
          <p><a href="">Read more about <b>board</b>.</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>