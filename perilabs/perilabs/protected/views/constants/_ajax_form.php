<?php 
if($model->constant_id == null) {
  $url = $this->createUrl("/constants/create?experiment_id=$experiment_id");
  $id = "create-constant-form";
  $subheading = "<h4>Create a New Constant</h4>";
  $callback = "function(data){
    $('#constants-list').append(data);
    $('#$id')[0].reset();
    return false;
  }";
} else {
  $url = $this->createUrl('/constants/update/'.$model->constant_id);
  $id = "constant-$model->constant_id";
  $subheading = "<h4>Edit Constant</h4>";
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
					<td><?php echo CHtml::activeTextField($model,'title',array('size'=>100,'maxlength'=>300)); ?></td>
				</tr>
		
				<tr>
					<td><?php echo CHtml::activelabelEx($model,'description'); ?></td>
					<td><?php echo CHtml::activetextArea($model,'description', array('rows'=>5, 'cols'=>45)); ?></td>
				</tr>
	
			</table>
		
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
				<button class="btn constant-form-cancel" data-toggle="collapse" data-target="#<?php echo $id ?>">Cancel</button>
		</div>
	</form>
