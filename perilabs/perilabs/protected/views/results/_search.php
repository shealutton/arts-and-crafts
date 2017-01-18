<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div>
		<?php echo $form->label($model,'result_id'); ?>
		<?php echo $form->textField($model,'result_id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'trial__id'); ?>
		<?php echo $form->textField($model,'trial__id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textArea($model,'title',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div>
		<?php echo CHtml::submitButton('Search', array('class'=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->