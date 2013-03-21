<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#variables-list").append(<?php echo $content ?>);
$("#create-variable-form")[0].reset();
$("#create-variable-form").collapse('hide');
