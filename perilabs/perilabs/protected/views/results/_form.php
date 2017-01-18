<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'results-form',
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'title'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php $this->renderPartial('//results/_form_fields', array('trial'=>$trial, 'model'=>$model)); ?>
	</div>

	<div>
		<?php
			echo $form->hiddenField($model,'trial__id', array('value'=>$trial_id));
			echo $form->hiddenField($model,'return_to_parent', array('value'=>true)); // controller should navigate back to trial view
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-info'));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
