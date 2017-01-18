<?php
  $content = $this->renderPartial("_row_view", array("result" => $model, "metrics"=>$model->trial->experiment->metrics, 'experiment_id'=>$model->trial->experiment__id), true);
  $content = json_encode($content);
?>
$('#result-<?php echo $model->result_id ?>').replaceWith(<?php echo $content ?>);
$('#<?php echo "result-edit-modal-{$model->result_id}" ?>').modal('hide');
