<?php
if($model->var_time_id == null) {
  $url = $this->createUrl("/variablesTime/create?variable_id=$variable_id");
  $id = "create-variable-time-form";
  $can_cancel = false;
} else {
  $url = $this->createUrl('/variablesTime/update/'.$model->var_time_id);
  $id = "variable-time-$model->var_time_id";
  $can_cancel = true;
}
?><li class="form" id="<?php echo $id ?>">
    <form action="<?php echo $url ?>" class="form-inline" method="post" data-remote="true">
        <input value="<?php echo $variable_id ?>" name="VariablesTime[variable__id]" id="VariablesTime_variable__id" type="hidden">
        <input size="32" maxlength="1024" placeholder="new value" name="VariablesTime[value]" id="VariablesTime_value" type="text" value="<?php echo $model->value ?>" />
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('class'=>'btn btn-small btn-info')); ?>
	<?php if ($can_cancel) echo "&nbsp;".CHtml::submitButton('Cancel', array('class'=>'btn btn-small btn-cancel')); ?>
    </form>
</li>
