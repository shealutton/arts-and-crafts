<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>
$("#metrics-list").append(<?php echo $content ?>);
$("#create-metric-form")[0].reset();
$("#create-metric-form").collapse('hide');
