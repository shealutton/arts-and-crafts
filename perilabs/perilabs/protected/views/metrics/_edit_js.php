<?php
  $content = $this->renderPartial("_ajax_form", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#metric-<?php echo $model->metric_id ?>').replaceWith(<?php echo $content ?>);
$('#metric-<?php echo $model->metric_id ?>').collapse('show');
