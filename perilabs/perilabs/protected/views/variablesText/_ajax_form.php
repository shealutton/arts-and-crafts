<?php
if($model->var_text_id == null) {
  $url = $this->createUrl("/variablesText/create?variable_id=$variable_id");
  $id = "create-variable-text-form";
  $can_cancel = false;
} else {
  $url = $this->createUrl('/variablesText/update/'.$model->var_text_id);
  $id = "variable-text-$model->var_text_id";
  $can_cancel = true;
}
?><li class="form" id="<?php echo $id ?>">
    <form action="<?php echo $url ?>" class="form-inline" method="post" data-remote="true">
        <input value="<?php echo $variable_id ?>" name="VariablesText[variable__id]" id="VariablesText_variable__id" type="hidden">
        <input size="32" maxlength="1024" placeholder="new value" name="VariablesText[value]" id="VariablesText_value" type="text" value="<?php echo $model->value ?>" />
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('class'=>'btn btn-small btn-info')); ?>
	<?php if ($can_cancel) echo "&nbsp;".CHtml::submitButton('Cancel', array('class'=>'btn btn-small btn-cancel')); ?>
    </form>
</li>
