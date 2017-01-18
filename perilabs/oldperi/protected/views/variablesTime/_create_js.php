<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>

$('#variable-<?php echo $model->variable__id ?> ul li:last-child').before(<?php echo $content ?>);
$("#create-variable-time-form form")[0].reset();
