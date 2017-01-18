<?php 
if($model->conclusion_id == null) {
  $url = $this->createUrl("/conclusions/create?experiment_id=$experiment_id");
  $id = "create-conclusion-form";
  $subheading = "<h4>Create a New Conclusion</h4>";
  $callback = "function(data){
    $('#conclusions-list').append(data);
    $('#$id')[0].reset();
    return false;
  }";
} else {
  $url = $this->createUrl('/conclusions/update/'.$model->conclusion_id);
  $id = "conclusion-$model->conclusion_id";
  $subheading = "<h4>Edit Conclusion</h4>";
  $callback = "function(data){
    $('#$id').replaceWith(data);
    return false;
  }";
}

$data_types = Yii::app()->db2->createCommand()
	->select('*')
	->from('data_types')
	->queryRow();
?>

	<form action="<?php echo $url ?>" class="form-inline collapse in" method="post" data-remote="true" id="<?php echo $id ?>" style="height: 0px">
		<div class="well">
			<?php echo $subheading ?>
			<table style="border: none; width: 100%;">
				<tr>
					<td><?php echo CHtml::activelabelEx($model,'description'); ?></td>
					<td><?php echo CHtml::activetextArea($model,'description', array('rows'=>5, 'cols'=>45)); ?></td>
				</tr>
	
			</table>
		
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
				<button class="btn conclusion-form-cancel" data-toggle="collapse" data-target="#<?php echo $id ?>">Cancel</button>
		</div>
	</form>
