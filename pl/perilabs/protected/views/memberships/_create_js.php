<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#members-list").append(<?php echo $content ?>);
$("#create-membership-form")[0].reset();
