<?php
  $content = $this->renderPartial("_list_view", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#conclusion-<?php echo $model->conclusion_id ?>').replaceWith(<?php echo $content ?>);
console.log("Updated conclusion #<?php echo $model->conclusion_id ?>");
