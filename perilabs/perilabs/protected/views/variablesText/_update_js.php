<?php
  $content = $this->renderPartial("_list_view", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#variable-text-<?php echo $model->var_text_id ?>').replaceWith(<?php echo $content ?>);
