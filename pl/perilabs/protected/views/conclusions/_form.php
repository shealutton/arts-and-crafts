<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'conclusions-form',
	'enableAjaxValidation'=>false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'description'); ?>

		<?php
			echo $form->hiddenField($model,'experiment__id', array('value'=>$experiment_id));
			echo $form->hiddenField($model,'return_to_experiment', array('value'=>true)); // controller should navigate back to experiment view
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); 
		?>

<?php $this->endWidget(); ?>

</div><!-- form -->
