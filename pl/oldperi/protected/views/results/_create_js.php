<?php 
  $content = $this->renderPartial("_row_view", array("result"=>$model,'metrics'=>$model->trial->experiment->metrics, "experiment_id"=>$experiment_id), true);
  $content = json_encode($content);
?>
$("#results-list tbody").append(<?php echo $content ?>);
$("#create-result-form")[0].reset();
$("#inputfocus").focus()
/* $("#create-metric-form").collapse('hide'); */
