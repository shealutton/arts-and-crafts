<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div>
		<?php echo $form->label($model,'dataset_id'); ?>
		<?php echo $form->textField($model,'dataset_id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'result__id'); ?>
		<?php echo $form->textField($model,'result__id'); ?>
	</div>

	<div>
		<?php echo CHtml::submitButton('Search', array('class'=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->