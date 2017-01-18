<?php
  $content = $this->renderPartial("_list_view", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#accessgrant-<?php echo $model->access_grant_id ?>').replaceWith(<?php echo $content ?>); 
