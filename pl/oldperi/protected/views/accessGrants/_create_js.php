<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#accessgrants-list").append(<?php echo $content ?>);
$("#create-accessgrant-form")[0].reset();

