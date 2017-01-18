<?php
    $content = $this->renderPartial("_ajax_modal_form", array("model" => $model, "trial"=>$trial), true);
    $content = json_encode($content);
?>
//$('#result-<?php echo $model->result_id ?>').replaceWith(<?php echo $content ?>);
$("body").append(<?php echo $content ?>);
$("#result-edit-modal-<?php echo $model->result_id ?>").modal().on('hidden', function () {
	$('#result-edit-modal-<?php echo $model->result_id ?>').remove();
});
