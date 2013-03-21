<?php 
  $content = $this->renderPartial("_list_view", array("model"=>$model), true);
  $content = json_encode($content);
?>

//$("#variable-<?php echo $model->variable__id ?> ul").prepend(<?php echo $content ?>);
$('#variable-<?php echo $model->variable__id ?> ul li:last-child').before(<?php echo $content ?>);
$("#create-variable-text-form form")[0].reset();
