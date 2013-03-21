<?php
  $content = $this->renderPartial("_update_form", array("model" => $model, "user"=>$user), true);
  $content = json_encode($content);
?>
$('#accessgrant-<?php echo $model->access_grant_id ?>').replaceWith(<?php echo $content ?>);
