<?php
  $content = $this->renderPartial("_ajax_form", array("model" => $model), true);
  $content = json_encode($content);
?>
$('#variable-<?php echo $model->variable_id ?>').replaceWith(<?php echo $content ?>);
$('#variable-<?php echo $model->variable_id ?>').collapse('show');
setVariableFormFields();
$('#variable-<?php echo $model->variable_id ?> .variable-field-timestamp input').datetimepicker({
        showSecond: true,
        timeFormat: "hh:mm:ss-05",
        dateFormat: "yy-mm-dd"
});
