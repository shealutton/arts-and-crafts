<?php 
if($model->metric_id == null) {
  $url = $this->createUrl("/metrics/create?experiment_id=$experiment_id");
  $id = "create-metric-form";
  $subheading = "<h4>Create a New Metric</h4>";
  $callback = "function(data){
    $('#metrics-list').append(data);
    $('#$id')[0].reset();
    return false;
  }";
} else {
  $url = $this->createUrl('/metrics/update/'.$model->metric_id);
  $id = "metric-$model->metric_id";
  $subheading = "<h4>Edit Metric</h4>";
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
					<td><?php echo CHtml::activeLabelEx($model,'title'); ?></td>
					<td><?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>100)); ?></td>
				</tr>
				<tr>
					<td><?php echo CHtml::activeLabelEx($model,'data_type__id'); ?></td>
					<td><?php echo CHtml::activeDropDownList($model,'data_type__id', CHtml::listData(DataTypes::model()->findAll(), 'data_type_id', 'title')); ?></td>
				</tr>

			</table>

				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
				<button class="btn metric-form-cancel" data-toggle="collapse" data-target="#<?php echo $id ?>">Cancel</button>
		</div>
	</form>
