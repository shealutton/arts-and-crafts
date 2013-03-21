<?php
  $content = $this->renderPartial("_ajax_form", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#conclusion-<?php echo $model->conclusion_id ?>').replaceWith(<?php echo $content ?>);
$('#conclusion-<?php echo $model->conclusion_id ?>').collapse('show');
