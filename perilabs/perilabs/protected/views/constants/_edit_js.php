<?php
  $content = $this->renderPartial("_ajax_form", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#constant-<?php echo $model->constant_id ?>').replaceWith(<?php echo $content ?>);
$('#constant-<?php echo $model->constant_id ?>').collapse('show');
