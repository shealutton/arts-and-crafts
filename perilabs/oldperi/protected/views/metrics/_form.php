<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'metrics-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>

		<?php echo $form->labelEx($model,'data_type__id'); ?>
		<?php echo $form->dropDownList($model,'data_type__id', CHtml::listData(DataTypes::model()->findAll(), 'data_type_id', 'title')); ?>
		<?php echo $form->error($model,'data_type__id'); ?>

		<?php 
			echo $form->hiddenField($model,'experiment__id', array('value'=>$experiment_id));
			echo $form->hiddenField($model,'return_to_experiment', array('value'=>true));
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		?>

<?php $this->endWidget(); ?>

</div><!-- form -->
