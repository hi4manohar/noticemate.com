<?php

class ControllerMemberMembershipPlan extends Controller {
  public function index() {
    //get plan detail from rightBar Module
    $this->loader->model('rightBar');
    $getboard_model = $this->registry->get('model_rightBar');
    $plan_data = $getboard_model->planType($this->user->user_id);

    if( is_array($plan_data) ) {
      echo $this->loader->view('/right/membership_plan.php', array(
        'plan_data' => $plan_data
      ));
    }
  }
}

?>