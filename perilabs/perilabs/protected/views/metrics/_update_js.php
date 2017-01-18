<?php
  $content = $this->renderPartial("_list_view", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#metric-<?php echo $model->metric_id ?>').replaceWith(<?php echo $content ?>);
console.log("Updated metric #<?php echo $model->metric_id ?>");
