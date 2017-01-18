<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#conclusions-list").append(<?php echo $content ?>);
$("#create-conclusion-form")[0].reset();
$("#create-conclusion-form").collapse('hide');
