<?php
  $content = $this->renderPartial("_list_view", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#variable-time-<?php echo $model->var_time_id ?>').replaceWith(<?php echo $content ?>);
