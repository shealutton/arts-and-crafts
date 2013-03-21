<?php 
  $content = $this->renderPartial("/invitations/_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#invitations-list").append(<?php echo $content ?>);
$("#create-accessgrant-form")[0].reset();

