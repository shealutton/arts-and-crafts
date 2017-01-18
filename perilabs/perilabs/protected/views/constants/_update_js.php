<?php
  $content = $this->renderPartial("_list_view", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#constant-<?php echo $model->constant_id ?>').replaceWith(<?php echo $content ?>);
console.log("Updated constant #<?php echo $model->constant_id ?>");
