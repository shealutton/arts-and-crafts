<?php
  $content = $this->renderPartial("_list_view", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#variable-<?php echo $model->variable_id ?>').replaceWith(<?php echo $content ?>);
console.log("Updated variable #<?php echo $model->variable_id ?>");
