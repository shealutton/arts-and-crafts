<?php 
if($model->variable_id == null) {
  $url = $this->createUrl("/variables/create?experiment_id=$experiment_id");
  $id = "create-variable-form";
  $subheading = "<h4>Create a New Variable</h4>";
  $callback = "function(data){
    $('#variables-list').append(data);
    $('#$id')[0].reset();
    return false;
  }";
} else {
  $url = $this->createUrl('/variables/update/'.$model->variable_id);
  $id = "variable-$model->variable_id";
  $subheading = "<h4>Edit Variable</h4>";
  $callback = "function(data){
    $('#$id').replaceWith(data);
    return false;
  }";
}

$data_types = Yii::app()->db2->createCommand()
	->select('*')
	->from('data_types')
	->order('title')
	->queryRow();
?>

	<form action="<?php echo $url ?>" class="form-inline collapse in" method="post" data-remote="true" id="<?php echo $id ?>" style="height: 0px">
		<div class="well">
			<?php echo $subheading ?>
			<!--<a class="close" data-toggle="collapse" data-target="#<?php echo $id ?>">&times;</a>-->
			<table style="border: none; width: 100%;">
                <tr>
                    <td><?php echo CHtml::activeLabelEx($model,'data_type__id'); ?></td>
                    <td><?php echo CHtml::activeDropDownList($model,'data_type__id', CHtml::listData(DataTypes::model()->findAll(), 'data_type_id', 'title')); ?></td>
                </tr>
				<tr>
					<td><?php echo CHtml::activeLabelEx($model,'title'); ?></td>
					<td><?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>100)); ?></td>
				</tr>
				<tr class="variable-field-min">
					<td><?php echo CHtml::activeLabelEx($model,'min'); ?></td>
					<td><?php echo CHtml::activeTextField($model,'min',array('size'=>60,'maxlength'=>100)); ?></td>
				</tr>
				<tr class="variable-field-max">
					<td><?php echo CHtml::activeLabelEx($model,'max'); ?></td>
					<td><?php echo CHtml::activeTextField($model,'max',array('size'=>60,'maxlength'=>100)); ?></td>
				</tr>
				<tr class="variable-field-increment">
					<td><?php echo CHtml::activeLabelEx($model,'increment'); ?></td>
					<td><?php echo CHtml::activeTextField($model,'increment',array('size'=>60,'maxlength'=>100)); ?></td>
				</tr>
                                <?php foreach($model->variablesTexts() as $text): ?>
				<tr class="variable-field-text">
                                        <td><label>Name or Value</label></td>
                                        <td>
                                                <input type="text" name="VariablesText[<?php echo $text->var_text_id ?>]" value="<?php echo $text->value ?>" />

                                                <a href="" class="toolbar-icon" onclick="addTextOption(<?php echo $model->variable_id ?>); return false;" title="Add Option">
                                                       <img src="<?php echo Yii::app()->baseUrl.'/images/add.png' ?>" alt="edit" />
                                                </a>
                                        </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="variable-field-text new-variable-field">
                                        <td><label>Name or Value</label></td>
                                        <td>
                                                <input type="text" name="VariablesText[]" />
                                                <a href="" class="toolbar-icon" onclick="addTextOption(<?php echo $model->variable_id ?>); return false;" title="Add Option">
                                                       <img src="<?php echo Yii::app()->baseUrl.'/images/add.png' ?>" alt="edit" />
                                                </a>
                                        </td>
                                </tr>

                                <?php foreach($model->variablesTimes() as $timestamp): ?>
                                <tr class="variable-field-timestamp">
                                        <td><label>Value</label></td>
                                        <td>
                                                <input type="text" name="VariablesTimestamp[<?php echo $timestamp->var_time_id ?>]" value="<?php echo $timestamp->value ?>" />
                                                <a href="" class="toolbar-icon" onclick="addTimestampOption(<?php echo $model->variable_id ?>); return false;" title="Add Option">
                                                        <img src="<?php echo Yii::app()->baseUrl.'/images/add.png' ?>" alt="edit" />
                                                </a>
                                        </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="vft new-variable-field">
                                        <td><label>Value</label></td>
                                        <td>
                                                <input type="text" name="VariablesTimestamp[]" />
                                                <a href="" class="toolbar-icon" onclick="addTimestampOption(<?php echo $model->variable_id ?>); return false;" title="Add Option">
                                                        <img src="<?php echo Yii::app()->baseUrl.'/images/add.png' ?>" alt="edit" />
                                                </a>
                                        </td>
                                </tr>
			</table>
		
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
<script type="text/javascript">
<?php if($model->isNewRecord) { ?>
       addTextOption(undefined);
       addTimestampOption(undefined);
<?php } ?>
</script>
				<button class="btn variable-form-cancel" data-toggle="collapse" data-target="#<?php echo $id ?>">Cancel</button>
		</div>
	</form>
