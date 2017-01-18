<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div>
		<?php echo $form->label($model,'trial_id'); ?>
		<?php echo $form->textField($model,'trial_id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'experiment__id'); ?>
		<?php echo $form->textField($model,'experiment__id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div>
		<?php echo $form->label($model,'skip_f'); ?>
		<?php echo $form->checkBox($model,'skip_f'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'sequence_num'); ?>
		<?php echo $form->textField($model,'sequence_num'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'locked_f'); ?>
		<?php echo $form->textArea($model,'locked_f',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div>
		<?php echo CHtml::submitButton('Search', array('class'=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->