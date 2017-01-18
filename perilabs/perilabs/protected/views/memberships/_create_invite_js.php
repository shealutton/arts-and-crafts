<?php 
  $content = $this->renderPartial("/invitations/_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#organization-invitations-list").append(<?php echo $content ?>);
$("#create-membership-form")[0].reset();

