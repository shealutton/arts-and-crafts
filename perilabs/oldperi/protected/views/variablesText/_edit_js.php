<?php
  $id_selector = "#variable-text-{$model->var_text_id}";
  $content = $this->renderPartial("_ajax_form", array("model" => $model, 'variable_id'=>$variable_id), true);
  $content = json_encode($content);

  $original_content = $this->renderPartial("_list_view", array("model" => $model), true);
  $original_content = json_encode($original_content);

?>
$('#variable-text-<?php echo $model->var_text_id ?>').replaceWith(<?php echo $content ?>);
$('#variable-text-<?php echo $model->var_text_id ?> .btn-cancel').on("click", function(event){
    event.preventDefault();
	$('#variable-text-<?php echo $model->var_text_id ?>').replaceWith(<?php echo $original_content ?>);
});