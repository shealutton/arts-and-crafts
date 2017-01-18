<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#constants-list").append(<?php echo $content ?>);
$("#create-constant-form")[0].reset();
$("#create-constant-form").collapse('hide');
